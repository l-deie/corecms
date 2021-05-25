<?php
class loginMod extends Action {
	public function index(){		
		$this->display();
	}
	public function do_login(){
		$db = model('member');
		$where['username']=$_POST['username'];		
		$member = $db->where($where)->find();
		if($member['password']==md5(md5($_POST['password']).$member['salt'])){
			unset($member['salt']);			
			$member['user_agent']=user_agent();//防止用户盗用cookie
			$cookie = cp_encode($member,cpConfig::get('authkey'));			
			cookie('member',$cookie);
			
			$this->success('登录成功',url('index/index'));							
		}else{
			$this->error('登录失败，请重新登录',url('login/index'));
		}
	}
	public function logout(){
		cookie('member',null);		
		$this->success('退出成功！快去休息休息吧',__APP__);
	}
}