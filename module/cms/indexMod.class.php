<?php
class indexMod extends base{
	public function index() {
		/*
		$db_anli = model('sheji');
		$anli = $db_anli->limit('0,8')->order('id desc')->select();
		$db_sj = model('shejishi');
		$shejishi = $db_sj->limit('0,5')->order('id desc')->select();
		$db_banner = model('banner');
		$banner = $db_banner->select();
		
		$array = array(
		'anli'=>$anli,
		'shejishi'=>$shejishi,
		'banner'=>$banner,
		);
		$this->assign($array);
		*/
		$this->display('index');
	}
	public function install(){
		$db = model();
		$ins=new Install();//实例化数据库安装类
		$sql_array=$ins->mysql('db.sql','cp_','cp_');

		//执行数据库操作
		foreach($sql_array as $sql)
		{
			$db->query($sql);//安装数据
		}
		$this->success('安装成功');
	}
}