<?php
//框架默认配置
class cpConfig{
	static public $config=array(		
		//应用配置
		'APP' => array(
				//日志和错误调试配置
				'DEBUG' => true,	//是否开启调试模式，true开启，false关闭
				'LOG_ON' => false,//是否开启出错信息保存到文件，true开启，false不开启
				'LOG_PATH' => './data/log/',//出错信息存放的目录，出错信息以天为单位存放，一般不需要修改
				'ERROR_URL' => '',//出错信息重定向页面，为空采用默认的出错页面，一般不需要修改
				'TPL_PUBLIC_PATH'=>'./public/',//静态文件公共目录名称
				
				//时间设置，设置默认时区
				'DATE_TIMEZONE'=>'Asia/Shanghai',
				
				/* Cookie设置 */
				'COOKIE_EXPIRE'         => 0,    // Coodie有效期
				'COOKIE_DOMAIN'         => '',      // Cookie有效域名
				'COOKIE_PATH'           => '/',     // Cookie路径
				'COOKIE_PREFIX'         => '',      // Cookie前缀 避免冲突
				
				//网址配置
				/*
				URL_REWRITE_ON 是否开启重写，偶数带有执行文件 奇数因此执行文件
				0 index.php/group/module/action  
				1 /group/module/action 
				2 index.php?g=group&m=module&a=action 
				3 ?g=group&m=module&a=action 
				4 index.php?r=/group/module/action 
				5 ?r=/group/module/action
				*/
				'URL_REWRITE_ON' => 0,
				'URL_GMA_VAR'=>'g,m,a',//url变量，URL_REWRITE_ON为2 3时生成原生地址时使用，默认是'g,m,a' 生成地址为 'g=group&m=module&a=action'
				'URL_R_VAR'=>'r',//url变量，URL_REWRITE_ON为4 5时生成原生地址时使用，默认是'r' 生成地址为 r=/group/module/action 
				'URL_GROUP_DEPR'=>'/',//组分隔符，一般不需要修改					
				'URL_MODULE_DEPR' => '/',//模块分隔符，一般不需要修改
				'URL_ACTION_DEPR' => '-',//操作分隔符，一般不需要修改
				'URL_PARAM_DEPR' => '-',//参数分隔符，一般不需要修改
				'URL_HTML_SUFFIX' => '.html',//伪静态后缀设置，例如 .html ，一般不需要修改
				'URL_HTTP_HOST' => '', //设置网址域名
				
				
				//分组配置
				'GROUP_DEFAULT'=>'',//默认分组，设置默认分组后表示开启分组功能
				'GROUP_DOMAIN'=>array(
					//'home'=>'example.com',					
				),		
				
				//模块配置
				'MODULE_PATH' => './module/',//模块存放目录，一般不需要修改
				'MODULE_SUFFIX' => 'Mod.class.php',//模块后缀，一般不需要修改
				'MODULE_ACTION_SUFFIX' => '',//方法后缀，一般不需要修改
				'MODULE_INIT' => 'init.php',//初始程序，一般不需要修改
				'MODULE_DEFAULT' => 'index',//默认模块，一般不需要修改
				'MODULE_EMPTY' => 'empty',//空模块	，一般不需要修改	
						
				//操作配置
				'ACTION_DEFAULT' => 'index',//默认操作，一般不需要修改
				'ACTION_EMPTY' => '_empty',//空操作，一般不需要修改

				//模型配置
				'MODEL_PATH' => './model/',//模型存放目录，一般不需要修改
				'MODEL_SUFFIX' => 'Model.class.php',//模型后缀，一般不需要修改
				
				//表单令牌
				'TOKEN_NAME'=>'',//为空时不进行令牌验证，设置后为令牌的name属性进行验证
								
				//静态页面缓存
				'HTML_CACHE_ON' => false,//是否开启静态页面缓存，true开启.false关闭
				'HTML_CACHE_PATH' => './data/html_cache/',//静态页面缓存目录，一般不需要修改
				'HTML_CACHE_SUFFIX' => '.html',//静态页面缓存后缀，一般不需要修改
				'HTML_CACHE_RULE' => array(
											'index'=>array('index'=>1000,),//缓存时间,单位：秒
										 ),//静态页面缓存规则 array('模块名'=>array('方法名'=>缓存时间,))
				
				'AUTOLOAD_DIR' => array(),	//自动加载扩展目录，
				),
		
		//数据库配置
		'DB'  => array(								
				'DB_TYPE' => 'mysql',//数据库类型，一般不需要修改
				'DB_HOST' => 'localhost',//数据库主机，一般不需要修改
				'DB_USER' => 'root',//数据库用户名
				'DB_PWD' => '',//数据库密码
				'DB_PORT' => 3306,//数据库端口，mysql默认是3306，一般不需要修改
				'DB_NAME' => 'cp',//数据库名
				'DB_CHARSET' => 'utf8',//数据库编码，一般不需要修改
				'DB_PREFIX' => 'cp_',//数据库前缀
				
				'DB_CACHE_ON' => false,//是否开启数据库缓存，true开启，false不开启
				'DB_CACHE_TYPE' => 'FileCache',//缓存类型，FileCache或Memcache或SaeMemcache，
				'DB_CACHE_TIME' => 600,//缓存时间,0不缓存，-1永久缓存,单位：秒
				
				//文件缓存配置
				'DB_CACHE_PATH' => './data/db_cache/',//数据库查询内容缓存目录，地址相对于入口文件，一般不需要修改
				'DB_CACHE_CHECK' => false,//是否对缓存进行校验，一般不需要修改
				'DB_CACHE_FILE' => 'cachedata',//缓存的数据文件名
				'DB_CACHE_SIZE' => '15M',//预设的缓存大小，最小为10M，最大为1G
				'DB_CACHE_FLOCK' => true,///是否存在文件锁，设置为false，将模拟文件锁,，一般不需要修改
				
				//memcache配置，可配置多台memcache服务器，
				'MEM_SERVER' => array( array('127.0.0.1', 11211),  array('localhost', 11211) ),
				'MEM_GROUP' => 'db',
				
				//SaeMemcache配置，
				'SAE_MEM_GROUP' => 'db',
				
				//数据库主从配置，
				'DB_SLAVE' => array(),//数据库从机配置，
				/* 数据库主从配置示例，可以配置多台从机，如果用户名、密码等跟主机相同，可不设置
				'DB_SLAVE' => array(
									array(
											'DB_HOST' => '127.0.0.1',
											'DB_USER' => 'root',
											'DB_PWD' => '',
										),
									array(
											'DB_HOST' => '127.0.0.2',
											'DB_USER' => 'root',
											'DB_PWD' => '',
										),
								),
				*/
				
				),
		
		//模板配置			
		'TPL' => array(				
				'TPL_TEMPLATE_PATH'=>'./template/',//模板目录，一般不需要修改
				'TPL_TEMPLATE_SUFFIX'=>'.html',//模板后缀，一般不需要修改
				'TPL_CACHE_ON'=>false,//是否开启模板缓存，true开启,false不开启
				'TPL_CACHE_TYPE'=>'',//数据缓存类型，为空或Memcache或SaeMemcache，其中为空为普通文件缓存，
				'TPL_TEMPLATE_CACHETIME'=>0,//二级缓存是否开启，0为关闭，大于0是开启
				//模板左右标记
				'TPL_TEMPLATE_LEFT'=>'{',
				'TPL_TEMPLATE_RIGHT'=>'}',
				//普通文件缓存
				'TPL_CACHE_PATH'=>'./data/tpl_cache/',//模板缓存目录，一般不需要修改
				'TPL_CACHE_SUFFIX'=>'.php',//模板缓存后缀,一般不需要修改
				//指定成功页面和错误页面模板
				'TPL_ACTION_SUCCESS'=>'',//成功页面模板
				'TPL_ACTION_ERROR'=>'',//错误页面模板
				
				//memcache配置，
				'MEM_SERVER' => array( array('127.0.0.1', 11211),  array('localhost', 11211)),
				'MEM_GROUP' => 'tpl',
				
				//SaeMemcache配置，
				'SAE_MEM_GROUP' => 'tpl',
				
				),
	);
	
	//获取默认配置
	static public function get( $name = '' ) {
		if(isset(self::$config[$name])) {
			return self::$config[$name];
		} else if(isset(self::$config['APP'][$name])) {
			return self::$config['APP'][$name];
		} else if(isset(self::$config['DB'][$name])) {
			return self::$config['DB'][$name];			
		} else if(isset(self::$config['TPL'][$name])) {
			return self::$config['TPL'][$name];
		} else {
			return false;
		}
	}
	
	//设置参数
	static public function set($name, $value = array()) {
		return self::$config[$name] = $value;
	}
}