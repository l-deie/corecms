<?php
class groupMod extends base{
	public function index(){
		$group = model('group');
		$group_list = $group->select();
		$this->assign('group_list',$group_list);
		$this->display();
	}
	/**
	 * 添加用户组页面
	 *
	 */
	public function add_group(){
		if ($_POST) {
			$this->do_add_group();
			exit;
		}
		$this->display();
	}
	/**
	 * 添加用户组执行页面
	 *
	 */
	public function do_add_group(){
		$db = model('group');
		$data = $db->checkData();		
		$error = $db->getError();
		if ($error) {
			$this->error($error);
		}
		$insert_id = $db->data($data)->insert();
		if ($insert_id) {
			$this->success('添加成功',url('group/index'));
		}else {
			$this->error('添加失败请重试');
		}		
	}
	/**
	 * 编辑用户组
	 *
	 */
	public function edit_group(){
		if ($_POST) {
			$this->do_edit_group();
			exit;
		}
		$id = intval($_GET['id']);
		$db = model('group');
		$group = $db->where("id=".$id)->find();
		$this->assign('group',$group);
		$this->display();
	}
	/**
	 * 保存编辑用户组
	 *
	 */
	public function do_edit_group(){
		$db = model('group');
		$old = $db->where($_POST)->find();
		if ($old) {
			$this->success('更新成功',url('group/index'));
			exit;
		}
		$data = $db->checkData();
		$error = $db->getError();
		if ($error) {
			$this->error($error);
		}
		
		$id = intval($data['id']);
		unset($data['id']);
		
		$success = $db->data($data)->where('id='.$id)->update();
		
		$this->success('更新成功',url('group/index'));
	}
	/**
	 * 功能节点列表
	 *
	 */
	public function node(){
		$db = model('node');
		$nodes = $db->order('sort asc,id asc')->select();
		$cat = new Category(array('id','pid','title','show_title'));
		$format_nodes = $cat->getTree($nodes);//获取分类数据树结构
		$this->assign('nodes',$format_nodes);
		$this->display();
	}
	
	/**
	 * 添加功能节点
	 *
	 */
	public function add_node(){
		if ($_POST) {
			$this->do_add_node();
			exit; 
		}
		$db = model('node');
		$nodes = $db->select();
		$cat = new Category(array('id','pid','title','show_title'));
		$format_nodes = $cat->getTree($nodes);//获取分类数据树结构
		$this->assign('nodes',$format_nodes);
		$this->display();
	}
	
	/**
	 * 执行添加功能节点操作
	 *
	 */
	public function do_add_node(){
		$db = model('node');
		$rule = array(
		array('name','require','请填写模块标示'),		
		array('title','require','请填写模块名称'),
		);
		$node_data = $db->validate($rule)->checkData();		
		$error = $db->getError();
		if ($error) {
			$this->error($error);
		}
		$insert_id = $db->data($node_data)->insert();
		if ($insert_id) {
			$this->success('添加成功',url('group/node'));
		}else {
			$this->error('添加失败请重试');
		}
	}
	/**
	 * 编辑节点
	 *
	 */
	public function edit_node(){
		if ($_POST) {
			$this->do_edit_node();
			exit;
		}
		$id = intval($_GET['id']);
		$db = model('node');
		$edit_node = $db->where('id='.$id)->find();
		
		$nodes = $db->select();
		
		$cat = new Category(array('id','pid','title','show_title'));
		$format_nodes = $cat->getTree($nodes);//获取分类数据树结构
		
		$this->assign('edit_node',$edit_node);
		$this->assign('nodes',$format_nodes);
		
		$this->display();
	}
	/**
	 * 保存编辑
	 *
	 */
	public function do_edit_node(){
		$db = model('node');
		$rule = array(
		array('name','require','请填写模块标示'),		
		array('title','require','请填写模块名称'),
		);
		$node_data = $db->validate($rule)->checkData();		
		$error = $db->getError();
		if ($error) {
			$this->error($error);
		}
		if ($node_data['pid']==$node_data['id']) {
			$this->error('父节点不能是自己');
		}
		$id = intval($node_data['id']);
		unset($node_data['id']);
		
		$success = $db->data($node_data)->where('id='.$id)->update();
		
		$this->success('更新成功',url('group/node'));
		
	}
	/**
	 * 删除功能节点
	 *
	 */
	public function del_node(){
		$this->error('禁止删除现有功能');
		$id = intval($_GET['id']);
		$success = model('node')->where('id='.$id)->delete();
		if ($success) {
			$this->success('删除成功');
		}else{
			$this->error('删除失败，请重试');
		}
	}
	/**
	 * 权限设置
	 *
	 */
	public function auth(){
		if($_POST){
			$this->do_auth();
			exit;
		}
		$group_id = intval($_GET['id']);
		$db = model('node');
		$node = $db->select();
		$node = list_to_tree($node);		
		
		$config['AUTH_GROUP']=$group_id;		
		RBAC::init($config);
		
		$access = RBAC::getAccess();
	
		if ($access) {
			foreach ($access as $key=>$val){
				$check[] = $val['node_id'];
			}
		}
		
		$this->assign('check',$check);
		$this->assign('node',$node);
		$this->assign('group_id',$group_id);
		$this->display();
	}
	public function do_auth(){
		$db = model('access');
		$group = intval($_POST['user_group_id']);
		$auth = $_POST['auth'];
		$db->where("user_group_id=".$group)->delete();//删除旧数据
		if(!empty($auth)){
			foreach ($auth as $val){
				$insert['node_id'] = intval($val);
				$insert['user_group_id']=$group;
				$db->data($insert)->insert();				
			}
		}		
		$this->success('用户组权限更新成功',url('group/index'));
		
	}
	
	public function del_group(){
		$group_id = intval($_GET['id']);
		$db = model('group');
		$db->where('id='.$group_id)->delete();
		
		$this->success('删除用户组成功');

		$group_id = intval($_POST['group_id']);

		
	}
	
}