<?php
//数据库安装类,用于导入mysql数据库文件
class Install{

    /*
		参数：
		$sql_path:sql文件路径；
		$old_prefix:原表前缀；
		$new_prefix:新表前缀；
		$separator:分隔符 参数可为";\n"或";\r\n"或";\r"
	*/    
    static public function mysql($sql_path,$old_prefix="",$new_prefix="",$separator=";\n") 
    {
        $commenter = array('#','--');
		  //判断文件是否存在
        if(!file_exists($sql_path))
            return false;
        
        $content = file_get_contents($sql_path);   //读取sql文件
        $content = str_replace(array($old_prefix, "\r"), array($new_prefix, "\n"), $content);//替换前缀
		
        //通过sql语法的语句分割符进行分割
        $segment = explode($separator,trim($content)); 

        //去掉注释和多余的空行
		$data=array();
        foreach($segment as  $statement)
        {
            $sentence = explode("\n",$statement);         
            $newStatement = array();
            foreach($sentence as $subSentence)
            {
                if('' != trim($subSentence))
                {
                    //判断是会否是注释
                    $isComment = false;
                    foreach($commenter as $comer)
                    {
                        if(preg_match("/^(".$comer.")/is",trim($subSentence)))
                        {
                            $isComment = true;
                            break;
                        }
                    }
                    //如果不是注释，则认为是sql语句
                    if(!$isComment)
                        $newStatement[] = $subSentence;                    
                }
            }           
     	    $data[] = $newStatement;		 	
        }

        //组合sql语句
        foreach($data as  $statement)
        {
            $newStmt = '';
            foreach($statement as $sentence)
            {
                $newStmt = $newStmt.trim($sentence)."\n";
            }    
			if(!empty($newStmt))            
          	{ 
				 $result[] = $newStmt;
			}
        }	
		return $result;
    }
    
    /**
     * 创建框架所需目录
     *
     */
    static public function create_dir(){
    	FS::s_mkdir(cpConfig::get('LOG_PATH'));//日志目录
    	FS::s_mkdir(cpConfig::get('MODULE_PATH'));//模块目录
    	FS::s_mkdir(cpConfig::get('MODEL_PATH'));//模型目录
    	FS::s_mkdir(cpConfig::get('HTML_CACHE_PATH'));//静态页面缓存目录
    	FS::s_mkdir(cpConfig::get('DB_CACHE_PATH'));//数据缓存目录
    	FS::s_mkdir(cpConfig::get('TPL_TEMPLATE_PATH'));//模板目录
    	FS::s_mkdir(cpConfig::get('TPL_CACHE_PATH'));//模板缓存目录 
    	FS::s_mkdir(cpConfig::get('TPL_PUBLIC_PATH'));//静态文件公共目录    	 	
    }
}
?>