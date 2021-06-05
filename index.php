<?php
//定义框架目录
define('CP_PATH',dirname(__FILE__).'/CorePHP/');//注意目录后面加“/”
require(CP_PATH.'core/cpApp.class.php');//加载应用控制类
$config = dirname(__FILE__)."/config/";
$app=new cpApp($config);//实例化单一入口应用控制类
//执行项目
$app->run();

?>