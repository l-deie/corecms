<?php
/*
 * 单例模式初始化模型，创建数据库连接
 * example 
   $config['DB_TYPE']='mysql';//数据库类型，一般不需要修改
   $config['DB_HOST']='localhost';//数据库主机，一般不需要修改
   $config['DB_USER']='root';//数据库用户名
   $config['DB_PWD']='root';//数据库密码
   $config['DB_PORT']=3306;//数据库端口，mysql默认是3306，一般不需要修改
   $config['DB_NAME']='qibo';//数据库名
   $config['DB_CHARSET']='utf8';//数据库编码，一般不需要修改
   $config['DB_PREFIX']='cp_';//数据库前缀
   $config['DB_PCONNECT']=false;//true表示使用永久连接，false表示不适用永久连接，一般不使用永久连接
   $db=cpDb::instance($config);
 */
class cpDb {
	private static $obj = NUL;
	//私有构造方法
	private function __construct() {}
	//私有克隆方法
	private function __clone() {}
	public static function instance($config) {
		if(!is_object(self::$obj)){		
			$dbDriver = 'cp' . ucfirst( $config['DB_TYPE'] );
			require_once( dirname(__FILE__) . '/db/' . $dbDriver . '.class.php' );
			self::$obj = new $dbDriver( $config );	//实例化数据库驱动类
			//self::$obj = new cpModel($config);			
		}
		return self::$obj;
	}
}