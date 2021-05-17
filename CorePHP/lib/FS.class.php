<?php
/**
 * FS--FileSystem
 * 文件及文件夹操作类
 *
 * @author shooke <QQ:82523829>
 */
class FS {
	/**
	 * 格式化大小函数
	 * @int $size 字节大小
	 * FS::s_formatsize($size);
	 */	
	public static function s_formatsize($size) {
		$prec=3;
		$size = round(abs($size));
		$units = array(0=>" B ", 1=>" KB", 2=>" MB", 3=>" GB", 4=>" TB");
		if ($size==0) return str_repeat(" ", $prec)."$units[0]";
		$unit = min(4, floor(log($size)/log(2)/10));
		$size = $size * pow(2, -10*$unit);
		$digi = $prec - 1 - floor(log($size)/log(10));
		$size = round($size * pow(10, $digi)) * pow(10, -$digi);
		return $size.$units[$unit];
	}
		
	/**
	 * 获取文件内容 读取文件
	 * 
	 * FS::s_read($filename);
	 */
	public static function s_read($filename) {
		$content = '';
		if(function_exists('file_get_contents')) {
			@$content = file_get_contents($filename);
		} else {
			if(@$fp = fopen($filename, 'r')) {
				@$content = fread($fp, filesize($filename));
				@fclose($fp);
			}
		}
		return $content;
	}
	
	/**
	 * 写入文件
	 *
	 * FS::s_write($filename, $writetext);
	 */
	public static function s_write($filename, $writetext, $openmod='w') {
		if(@$fp = fopen($filename, $openmod)) {
			flock($fp, 2);
			fwrite($fp, $writetext);
			fclose($fp);
			return true;
		} else {	
			return false;
		}
	}
	/**
	 * 连续建目录 遍历创建目录
	 * string $dir 目录字符串
	 * int $mode   权限数字
	 * 返回：顺利创建或者全部已建返回true，其它方式返回false
	 *
	 * FS::s_mkdir($dir);
	 */
	public static function s_mkdir( $dir, $mode = 0777 ) {
		if( ! $dir ) return 0;
		$dir = str_replace( "\\", "/", $dir );
	
		$mdir = "";
		foreach( explode( "/", $dir ) as $val ) {
			$mdir .= $val."/";
			if( $val == ".." || $val == "." || trim( $val ) == "" ) continue;
	
			if( ! file_exists( $mdir ) ) {
				if(!@mkdir( $mdir, $mode )){
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * 遍历删除目录和目录下所有文件
	 * $root true删除指定目录 false删除指定目录下所有内容但不删除指定目录
	 * FS::s_rmdir($dir);
	 */
	public static function s_rmdir($dir,$root=true)
	{
		if (!is_dir($dir))
		{
			return false;
		}
		$handle = opendir($dir);
		while (($file = readdir($handle)) !== false)
		{
			if ($file != "." && $file != "..")
			{
				is_dir("$dir/$file") ? self::s_rmdir("$dir/$file") : @unlink("$dir/$file");
			}
		}
		if (readdir($handle) == false)
		{
			closedir($handle);
			$root && @rmdir($dir);
		}
	}
	
	/**
	 * 递归取得目录下所有图片
	 * 
	 * FS::s_getimg($path);
	 */
	public static function s_getimg($path, &$files = array()){
		if (!is_dir($path)) return;
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				$path2 = $path . '/' . $file;
				if (is_dir($path2)) {
					self::s_getimg($path2, $files);
				} else {
					if (preg_match("/\.(gif|jpeg|jpg|png|bmp)$/i", $file)) {
						$files[] = $path2;
					}
				}
	
			}
		}
		return $files;
	}
	/**
	 * 取得目录的目录大小、文件数、目录数
	 *
	 * @param unknown_type $path
	 * @return unknown
	 * 
	 * $path="/home/www/htdocs";
	   $ar=getDirectorySize($path);	 
	   echo "<h4>路径 : $path</h4>";
	   echo "目录大小 : ".sizeFormat($ar['size'])."<br>";
	   echo "文件数 : ".$ar['count']."<br>";
	   echo "目录术 : ".$ar['dircount']."<br>";
	 */
	public static function s_dirsize($path){
	  $totalsize = 0;
	  $totalcount = 0;
	  $dircount = 0;
	  if ($handle = opendir ($path)){
		while (false !== ($file = readdir($handle))){
		  $nextpath = $path . '/' . $file;
		  if ($file != '.' && $file != '..' && !is_link ($nextpath)){
			if (is_dir ($nextpath)){
			  $dircount++;
			  $result = self::s_dirsize($nextpath);
			  $totalsize += $result['size'];
			  $totalcount += $result['count'];
			  $dircount += $result['dircount'];
			} elseif (is_file ($nextpath)){
			  $totalsize += filesize ($nextpath);
			  $totalcount++;
			}
		  }//if end
		}//while end
	  }
	  closedir ($handle);
	  $total['size'] = $totalsize;
	  $total['count'] = $totalcount;
	  $total['dircount'] = $dircount;
	  return $total;
	}
}
?>