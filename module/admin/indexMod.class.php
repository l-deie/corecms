<?php
class indexMod extends base{
	public function index() {
		$this->display ();
	}
	public function left() {	
		$list = module('cat')->get_cat();
		foreach ($list as $key => $val){
			$list[$key]['url'] = url("{$val['model']}/lists",array('cid'=>$val['id']));
		}
		$this->assign('list',$list);		
		$this->display ();
	}
	public function top() {
		$this->display ();
	}	
	//权限管理
	public function group() {
		$list = array(
			 array(	'id' => 1, 'title' => '用户组', 'parentid' => 0, 'url'=>url('group/index')),
			 array(	'id' => 2, 'title' => '功能模块', 'parentid' => 0, 'url'=>url('group/node')),
		);
		
		$this->assign('list',$list);	

		$this->display ('index/left');
	}
	public function main(){
		$db = model();
		$serverinfo = PHP_OS.' / PHP v'.PHP_VERSION;
		$serverinfo .= @ini_get('safe_mode') ? ' Safe Mode' : NULL;
		$serversoft = $_SERVER['SERVER_SOFTWARE'];
		
		$domain = $_SERVER['SERVER_NAME'].'('.$_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'] .')';
		
		$dbsize = 0;
		$query = $db->db->query("SHOW TABLE STATUS ");		
		while($table = $db->db->fetch_array($query)) {			
			$dbsize += $table['Data_length'] + $table['Index_length'];
		}
		$dbsize = FS::s_formatsize($dbsize);

		$attachments = FS::s_dirsize('./upload');
		$attachments = FS::s_formatsize($attachments['size']);
		
		$siteinfo = array(
			'domain'     =>$domain,
			'server'     =>$serverinfo,
			'addr'       =>$_SERVER['REMOTE_ADDR'],			
			'serversoft' =>$_SERVER['SERVER_SOFTWARE'],
			'mysql'      =>mysql_get_server_info(),
			'upload'     =>ini_get('upload_max_filesize'),
			'dbsize'     =>$dbsize,
			'attachments'=>$attachments		
		);
		$this->assign('siteinfo',$siteinfo);
		$this->display();
	}
	
}