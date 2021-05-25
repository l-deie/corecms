<?php
class memberMod extends base{
	/**
	 * 列表页
	 *
	 */
	public function index(){
		$username = $_GET['username'];
		$name = $_GET['name'];
		$company = $_GET['company'];
		$db = model();
		$table = array(
		'member'=>'member',
		'member_field'=>'field'
		);
		$where = "member.uid=field.uid";
		
		$username && $where .= " and member.username like '%{$username}%'";
		$name && $where .= " and field.name like '%{$name}%'";
		$company && $where .= " and field.company like '%{$company}%'";
		
		$array = array(
		'list'=>$db->table($table)->where($where)->select(),
		);
		$this->assign($array);

		$this->display();
	}
	/**
	 * 添加用户界面
	 *
	 */
	public function add(){		
		if ($_POST) {
			$this->do_add();
			exit;
		}
		$db = model('group');
		$this->assign('groups',$db->select());
		$this->display();
	}
	/**
	 * 添加用户操作
	 *
	 */
	public function do_add(){
		//用户表模型
		$member = model('member');			
		$member_data = $member->checkData();		
		$error = $member->getError();
		
		
		if ($error) {
			$this->error($error);
		}
		//用户资料模型
		$field = model('member_field');
		$field_data = $field->checkData();
		$error = $field->getError();
		if ($error) {
			$this->error($error);
		}
		
		//添加数据
		$member_data['regip'] = cpApp::$HttpRequest->getClientIp();		
		$member_data['lastloginip'] = cpApp::$HttpRequest->getClientIp();
		$member_data['salt'] = random();
		$member_data['password']=md5(md5($member_data['password']).$member_data['salt']);
		$uid = $member->data($member_data)->insert();
		if ($uid) {
			$field_data['uid'] = $uid;
			$field->data($field_data)->insert();
			$this->success('添加成功');
		}else {
			$this->error('添加用户失败，请重新添加');
		}	
	}
	/**
	 * 删除用户
	 *
	 */
	public function del(){		
		$uid = intval($_GET['uid']);
		if ($uid==1) {
			$this->error('创始人账号不可删除');
		}
		$db = model();
		$table = array('member'=>'member','member_field'=>'field');
		$where = 'member.uid=field.uid and member.uid='.$uid;
		$success = $db->table($table)->where($where)->delete('member,field');
		if ($success) {
			$this->success('删除成功');
		}else {
			$this->error('删除失败');
		}		
	}
	public function password(){
		if($_POST){
			$this->do_password();
			exit;
		}
		$id = $this->_G['member']['usergroup']==1 ? intval($_GET['uid']):$this->_G['member']['uid'];
		$db = model('member');
		$member = $db->where("uid=".$id)->find();
		$this->assign('member',$member);
		$this->display();
	}
	public function do_password(){
		$uid = $this->_G['member']['usergroup']==1 ? intval($_POST['uid']):$this->_G['member']['uid'];
		if ($_POST['password'] != $_POST['password2']) {
			$this->error('重复密码错误');
		}
		$update['salt'] = random();
		$update['password']=md5(md5($_POST['password']).$update['salt']);
		$db = model('member');
		$db->where('uid='.$uid)->data($update)->update();
		$this->success('密码更新成功');
	}
	public function edit(){
		if ($_POST) {
			$this->do_edit();
			exit;
		}
		$uid = $this->_G['member']['usergroup']==1 ? intval($_GET['uid']):$this->_G['member']['uid'];
		$db = model();
		$table = array('member'=>'member','member_field'=>'field');
		$where = 'member.uid=field.uid and member.uid='.$uid;
		$member = $db->table($table)->where($where)->find();		
		$this->assign('member',$member);		
		$groups = $db->table('group')->select();		
		$this->assign('groups',$groups);
		$this->display();
	}
	public function user_do_edit(){
		$uid = $this->_G['member']['uid'];
		//用户表模型
		$member = model('member');			
		$rule = array();
		$auto = array();
		$member_data = $member->need('email')->validate($rule)->auto($auto)->checkData();			
		
		//用户资料模型
		$field = model('member_field');
		$field_data = $field->checkData();
		$error = $field->getError();
		if ($error) {
			$this->error($error,url( 'manage/member/edit',array('uid'=>$uid) ));
		}
		
		//更新数据		
		$success = $member->where("uid=".$uid)->data($member_data)->update();
		$success = $field->where("uid=".$uid)->data($field_data)->update();
		
		$this->success('修改成功',url('estate/index',array('type'=>1)));
	}
	public function do_edit(){
		$uid = $this->_G['member']['usergroup']==1 ? intval($_POST['uid']):$this->_G['member']['uid'];
		//非管理员执行个人编辑
		if ($this->_G['member']['usergroup']!=1) {
			$this->user_do_edit();
			exit;
		}
		//用户表模型
		$member = model('member');			
		$rule = array(
		array('username','require','请填写用户名'),
		);
		$auto = array();
		$member_data = $member->validate($rule)->auto($auto)->checkData();		
		$error = $member->getError();
		//检测用户名是否被注册
		$where=array(
		'username'=>$member_data['username']
		);
		$have = $member->where($where)->find();		
		if ($have && ($have['uid'] != $uid)) {
			$error = "用户名{$member_data['username']},已被注册";
		}
		
		if ($error) {
			$this->error($error,url( 'manage/member/edit',array('uid'=>$uid) ));
		}
		//用户资料模型
		$field = model('member_field');
		$field_data = $field->checkData();
		$error = $field->getError();
		if ($error) {
			$this->error($error,url( 'manage/member/edit',array('uid'=>$uid) ));
		}
		
		//更新数据		
		$success = $member->where("uid=".$uid)->data($member_data)->update();
		$success = $field->where("uid=".$uid)->data($field_data)->update();
		
		$this->success('修改成功',url('member/index'));
		
	}
	
	
}