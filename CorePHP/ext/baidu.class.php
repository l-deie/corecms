<?php
class baidu{  	
	/*百度迷你编辑器
	//百度编辑器图片路径转换 转为相对路径
	static function relative($str=''){
		$root = 'http://'.$_SERVER['HTTP_HOST'].'/'.basename(dirname($_SERVER["SCRIPT_NAME"])).'/';
		$pattern_src = "'<(img|IMG)(.*?)src=[\'|\"]".$root."(.*?(?:[\.gif|\.jpg|\.png|\.jpeg]))[\'|\"](.*?)[\/]?>'"; //图片正则
		return preg_replace($pattern_src,'<\\1\\2src="\\3" \\4 />',$str);//绝对地址转换为相对地址		
	}
	//百度编辑器图片路径转换 转为绝对路径
	static function absolute($str=''){	
		$root = 'http://'.$_SERVER['HTTP_HOST'].'/'.basename(dirname($_SERVER["SCRIPT_NAME"])).'/';	
		$pattern_src = "'<(img|IMG)(.*?)src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png|\.jpeg]))[\'|\"](.*?)[\/]?>'"; //图片正则
		return preg_replace($pattern_src,'<\\1\\2src="'.$root.'\\3" \\4 />',$str);//相对地址转为绝对地址		
	}
	*/
	
	//百度编辑器图片路径转换 转为相对路径
	static function relative($str=''){
		$root = '/'.basename(dirname($_SERVER["SCRIPT_NAME"])).'/';
		$pattern_src = "'<(img|IMG)(.*?)src=[\'|\"]".$root."(.*?(?:[\.gif|\.jpg|\.png|\.jpeg]))[\'|\"](.*?)[\/]?>'"; //图片正则
		return preg_replace($pattern_src,'<\\1\\2src="\\3" \\4 />',$str);//绝对地址转换为相对地址		
	}
	//百度编辑器图片路径转换 转为绝对路径
	static function absolute($str=''){	
		$root = '/'.basename(dirname($_SERVER["SCRIPT_NAME"])).'/';	
		$pattern_src = "'<(img|IMG)(.*?)src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png|\.jpeg]))[\'|\"](.*?)[\/]?>'"; //图片正则
		return preg_replace($pattern_src,'<\\1\\2src="'.$root.'\\3" \\4 />',$str);//相对地址转为绝对地址		
	}
	
	
} 
?>