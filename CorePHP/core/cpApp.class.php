<?php
//应用控制类(完成网址解析、单一入口控制、静态页面缓存功能)
class cpApp {
	static public $group;//模块名称
	static public $module;//模块名称
	static public $action;//操作名称
	static public $HttpRequest;//http请求对象，通过new HttpRequest();
	private $status = array('group'=>0,'module'=>0,'action'=>0);//参数获取状态 初始0
	private $server=array();
	private $appconfig_path; //配置文件所在目录
	private $appConfig = array(); //配置
	public function __construct( $config_path="./config/" ) {

		define('CP_VER', '1.3.2013.0806');//框架版本号,后两段表示发布日期
		define('CP_CORE_PATH', dirname(__FILE__) );//当前文件所在的目录
		$this->appconfig_path = $config_path; //赋值配置目录，用于检测分组
		$config = require( $this->appconfig_path . "config.php" );//载入app全局配置
		require( CP_CORE_PATH . '/cpConfig.class.php' );//加载默认配置
		$this->appConfig = array_merge(cpConfig::get('APP'), $config);//参数配置
		
		//初始化时区
		date_default_timezone_set($this->appConfig['DATE_TIMEZONE']);
		
		//对http请求进行处理
		require( CP_CORE_PATH . '/cpHttpRequest.class.php' );//加载请求处理类
		self::$HttpRequest = new cpHttpRequest();		
		$this->server['SCRIPT_NAME'] = self::$HttpRequest->getScriptUrl();
		$this->server['REQUEST_URI'] = self::$HttpRequest->getRequestUri();
		//网址解析				
		if(function_exists('url_parse_ext')) {
			url_parse_ext();//自定义网址解析
		} else {
			
			if ($this->appConfig['URL_REWRITE_ON']==2 || $this->appConfig['URL_REWRITE_ON']==3) {//采用原生url方式				
				$this->_gmaUrl();
			}else{//采用pathinfo方式
				$this->_parseUrl();//解析模块和操作
			}			
		}
		if(!empty(self::$group)){
			$group_config_file = $config_path . self::$group . '.php';
			$group_config = array();//初始化变量防止E_NOTICE报错
			file_exists($group_config_file) && $group_config = require($group_config_file);
			!empty($group_config) && $this->appConfig = array_merge($this->appConfig, $group_config);//参数配置
		}

		$this->appConfig['CONFIG_PATH'] = $config_path;//保存配置文件路径，调用模块时使用

		cpConfig::set('APP', $this->appConfig );//参数配置保存到cpConfig
		defined('DEBUG') or define('DEBUG', cpConfig::get('DEBUG'));

		if ( $this->appConfig['DEBUG'] ) {
			ini_set("display_errors", 1);
			error_reporting( E_ALL ^ E_NOTICE );//除了notice提示，其他类型的错误都报告
		} else {
			ini_set("display_errors", 0);
			error_reporting(0);//把错误报告，全部屏蔽
		}

		//文件魔术引号关闭
		function_exists('set_magic_quotes_runtime') ?  @set_magic_quotes_runtime(0) : @ini_set('magic_quotes_runtime',0);

		spl_autoload_register( array($this, 'autoload') );	 //注册类的自动加载

		require(CP_CORE_PATH . '/cpError.class.php');	//加载错误处理类

		//加载常用函数库
		if ( is_file(CP_CORE_PATH . '/../lib/common.function.php') ) {
			require(CP_CORE_PATH . '/../lib/common.function.php');
		}

		//加载扩展函数库
		if ( is_file(CP_CORE_PATH . '/../ext/extend.php') ) {
			require(CP_CORE_PATH . '/../ext/extend.php');
		}
	}

	//执行模块，单一入口控制核心
	public function run() {
		try{
			//如果存在初始程序，则先加载初始程序
			if ( file_exists( $this->appConfig['MODULE_PATH'] . $this->appConfig['MODULE_INIT']) ) {
				require( $this->appConfig['MODULE_PATH'] . $this->appConfig['MODULE_INIT'] );
			}

			$this->_define();//常量定义

			//检查指定模块是否存在
			if( preg_match("#^[a-z0-9_]+$#i",self::$module) && $this->_checkModuleExists(self::$module) ) {
				$module = self::$module;
			} else if ( $this->_checkModuleExists( $this->appConfig['MODULE_EMPTY'] ) ) {//如果指定模块不存在，则检查是否存在空模块
				$module = $this->appConfig['MODULE_EMPTY'];
			} else {
				$error = $this->appConfig['GROUP_DEFAULT'] ? '分组'.self::$group : '';//分组提示
				throw new Exception($error.' ' . self::$module . "模块不存在");//指定模块和空模块都不存在，则显示出错信息，并退出程序。
			}

			//如果开启静态页面缓存，则尝试读取静态缓存
			if ( false == $this->_readHtmlCache($module, self::$action) ) {
				//静态缓存读取失败，执行模块操作
				$this->_execute($module);
			}

			//如果存在回调函数cp_app_end，则在即将结束前调用
			if ( function_exists('cp_app_end') ) {
				cp_app_end();
			}
		} catch( Exception $e){
			cpError::show( $e->getMessage() );
		}
	}

	//网址解析
	private function _parseUrl(){

		$script_name = $this->server['SCRIPT_NAME'];//获取当前文件的路径
		if ($this->appConfig['URL_REWRITE_ON']<2) {	//当url模式是 0 1时	
			
			$url = $this->server['REQUEST_URI'];//获取完整的路径，包含"?"之后的字符串		
			//去除url包含的当前文件的路径信息
			if ( $url && @strpos($url,$script_name,0) !== false ){
				$url = substr($url, strlen($script_name));
			} else {
				$script_name = str_replace(basename($this->server['SCRIPT_NAME']), '', $this->server['SCRIPT_NAME']);
				if ( $url && @strpos($url, $script_name, 0) !== false ){
					$url = substr($url, strlen($script_name));
				}
			}
			
		}else { //当url模式是4 5时
			$url = isset($_GET[$this->appConfig['URL_R_VAR']]) ? $_GET[$this->appConfig['URL_R_VAR']] : '/';
		}

		//第一个字符是'/'，则去掉
		if ($url[0] == '/') {
			$url = substr($url, 1);
		}

		//去除问号后面的查询字符串
		if ( $url && false !== ($pos = @strrpos($url, '?')) ) {
			$url = substr($url,0,$pos);
		}

		//去除后缀
		if ($url&&($pos = strrpos($url,$this->appConfig['URL_HTML_SUFFIX'])) > 0) {
			$url = substr($url,0,$pos);
		}

		$url = $this->_getGroup($url);//获取分组名称
		$url = $this->_getModule($url);//获取模块名称
		$url = $this->_getAction($url);//获取操作方法名称

		//解析参数
		if($this->status['action']) {
			$param = explode($this->appConfig['URL_PARAM_DEPR'], $url);
			$param_count = count($param);
			for($i=0; $i<$param_count; $i=$i+2) {
				$_GET[$i] = $param[$i];
				if(isset($param[$i+1])) {
					if( !is_numeric($param[$i]) ){
						$_GET[$param[$i]] = $param[$i+1];
					}
					$_GET[$i+1] = $param[$i+1];
				}
			}
		}
	}

	//常量定义
	private function _define() {
		$root = $this->appConfig['URL_HTTP_HOST'] . str_replace(basename($this->server['SCRIPT_NAME']), '', $this->server['SCRIPT_NAME']);
		//__ROOT__和__PUBLIC__常用于图片，css，js定位，__APP__和__URL__常用于网址定位

		define('__ROOT__', substr($root, 0, -1));//当前入口所在的目录，后面不带 "/"
		define('__PUBLIC__', __ROOT__ . '/' . basename($this->appConfig['TPL_PUBLIC_PATH']) );//取得目录名称组成公用文件夹路径，用于模板中

		//如果奇数，则网址不包含入口文件名，如index.php，偶数则带入口文件
		if ( $this->appConfig['URL_REWRITE_ON']%2==1 ) {
			define('__APP__', __ROOT__);
		} else {
			define('__APP__', __ROOT__ . '/' . basename($this->server['SCRIPT_NAME']));//当前入口文件
		}
		define('__URL__', __APP__ . '/' . self::$module);//当前模块
	}

	//检查模块文件是否存在
	private function _checkModuleExists($module){
		//分组模块路径
		$path = $this->appConfig['MODULE_PATH'].$module.$this->appConfig['MODULE_SUFFIX'];

		if(file_exists($path)){
			require_once($path);//加载模块文件
			return true;
		}else {
			return false;
		}
	}

	//执行操作
	private function _execute($module){
		$suffix_arr = explode('.', $this->appConfig['MODULE_SUFFIX'], 2);
		$classname=$module . $suffix_arr[0];//模块名+模块后缀组成完整类名
		if(!class_exists($classname)) {
			$error = $this->appConfig['GROUP_DEFAULT'] ? '分组'.self::$group : '';//分组提示
			throw new Exception($error.' ' . $classname . "类未定义");
		}

		$object=new $classname();//实例化模块对象
		//类和方法同名，直接返回，因为跟类同名的方法会当成构造函数，已经被调用，不需要再次调用
		if($classname==self::$action){
			return true;
		}

		if ( method_exists($object, self::$action)) {
			$action=self::$action;
		} else if ( method_exists($object, $this->appConfig['ACTION_EMPTY'].$this->appConfig['MODULE_ACTION_SUFFIX']) ) {
			$action=$this->appConfig['ACTION_EMPTY'].$this->appConfig['MODULE_ACTION_SUFFIX'];
			//解决空操作的静态页面缓存读取
			if( $this->_readHtmlCache($module, $action) ) {
				return true;
			}
		} else {
			$error = $this->appConfig['GROUP_DEFAULT'] ? '分组'.self::$group : '';//分组提示
			throw new Exception($error.' ' . self::$action."操作方法在" . $module . "模块中不存在");
		}
		//执行指定模块的指定操作
		$object->$action();

		//如果缓存开启，写入静态缓存，只有符合规则的，才会创建缓存
		$this->_writeHtmlCache();
	}

	//读取静态页面缓存
	private function _readHtmlCache($module = '', $action = '') {
		if ( $this->appConfig['HTML_CACHE_ON'] ) {
			require_once(CP_CORE_PATH . '/cpHtmlCache.class.php');
			return cpHtmlCache::read($module, $action);
		}
		return false;
	}

	//写入静态页面缓存
	private function _writeHtmlCache() {
		if ( $this->appConfig['HTML_CACHE_ON'] ) {
			cpHtmlCache::write();
		}
	}

	//原生url参数获取
	private function _gmaUrl(){
		//$g = $m = $a = '';
		list($g,$m,$a) = explode(',',$this->appConfig['URL_GMA_VAR']);
		//获取原生地址变量名
		if($this->appConfig['GROUP_DEFAULT']){			
			//获取群组		
			if ($this->appConfig['GROUP_DOMAIN']) {	//域名绑定处理			
				foreach ($this->appConfig['GROUP_DOMAIN'] as $key => $domain){
					if ($domain == $_SERVER['HTTP_HOST']){						
						if(in_array($key,$group_dir)){//分组目录中有对应分组
							self::$group = $key;//正式获得分组
						}
						break;
					}
				}						
			}else{//url中有分组参数
				self::$group = isset($_GET[$g]) ? $_GET[$g] : $this->appConfig['GROUP_DEFAULT'];
			}
		}

		self::$module = empty($_GET[$m]) ? $this->appConfig['MODULE_DEFAULT'] : $_GET[$m];
		self::$action = empty($_GET[$a]) ? $this->appConfig['MODULE_DEFAULT'] : $_GET[$a];
		
		define('CP_GROUP',self::$group);//在其他页面通过CP_GROUP获取得到当前的分组
		define('CP_MODULE',self::$module);//在其他页面通过CP_MODULE获取得到当前的分组
		define('CP_ACTION',self::$action);//在其他页面通过CP_ACTION获取得到当前的分组
	}
	//获取群组
	private function _getGroup($url){
		//设置默认分组时获取分组
		if($this->appConfig['GROUP_DEFAULT']){
			$group_dir = $this->_getGroupDir();//取得分组目录
			//域名绑定处理
			if ($this->appConfig['GROUP_DOMAIN']) {				
				foreach ($this->appConfig['GROUP_DOMAIN'] as $key => $domain){
					if ($domain == $_SERVER['HTTP_HOST']){						
						if(in_array($key,$group_dir)){//分组目录中有对应分组
							self::$group = $key;//正式获得分组
						}
						break;
					}
				}						
			}
			//通过域名找不到分组，则通过url寻找
			if(!self::$group){
				//未进行域名绑定
				if ( $url && ($pos = @strpos($url, $this->appConfig['URL_GROUP_DEPR'], 1) )>0 ) {
					$group = substr($url,0,$pos);//分组
					if(in_array($group,$group_dir)){//分组目录中有对应分组
						self::$group = $group;//正式获得分组
						$url = substr($url,$pos+1);//除去分组名称，剩下的url字符串
					}
				}else {//url找不到分组时，直接用url作为分组
					if(in_array($url,$group_dir)){//分组目录中有对应分组
						self::$group = $url;//正式获得分组
						$url='';//清除剩余url
					}
				}
			}

			$this->status['group']=1;//分组找到 需要其他解析参数

			//分组为空，则设置默认值
			self::$group = empty(self::$group) ? $this->appConfig['GROUP_DEFAULT'] : self::$group;
			define('CP_GROUP',self::$group);//在其他页面通过CP_GROUP获取得到当前的分组
		}
		//返回剩余url
		return $url;
	}
	//获取模块
	private function _getModule($url){
		if ( $url && ($pos = @strpos($url, $this->appConfig['URL_MODULE_DEPR'], 1) )>0 ) {
			self::$module = substr($url,0,$pos);//模块
			$url = substr($url,$pos+1);//除去模块名称，剩下的url字符串
			$this->status['module']=1;//模块找到 需要其他解析参数
		}else {
			if (!$this->appConfig['GROUP_DEFAULT'] || $this->status['group']) {//没有开启分组或者已经找到分组
				self::$module = $url;
			}
		}
		//模块为空，则设置默认值
		self::$module = empty(self::$module) ? $this->appConfig['MODULE_DEFAULT'] : self::$module;
		define('CP_MODULE',self::$module);//在其他页面通过CP_MODULE获取得到当前的模块
		//返回剩余url
		return $url;
	}
	//获取操作方法
	private function _getAction($url){
		if($url&&($pos=@strpos($url,$this->appConfig['URL_ACTION_DEPR'],1))>0) {
			self::$action = substr($url, 0, $pos);//模块
			$url = substr($url, $pos+1);
			$this->status['action']=1;//操作方法找到 需要其他解析参数
		} else {
			//只有可以正常查找到模块之后，才能把剩余的当作操作来处理
			if($this->status['module']){
				self::$action=$url;
			}
		}
		//操作为空，则设置默认值
		self::$action = empty(self::$action) ? $this->appConfig['ACTION_DEFAULT'] : self::$action;
		define('CP_ACTION',self::$action);//在其他页面通过CP_ACTION获取得到当前的操作名
		//方法后缀
		self::$action = self::$action.$this->appConfig['MODULE_ACTION_SUFFIX'];

		//返回剩余url
		return $url;
	}
	//获取分组
	private function _getGroupDir(){
		$return = array();
		$group_dir = glob($this->appconfig_path.'*');//取得分组目录
		foreach ($group_dir as $group){
			basename($group) <> 'config.php' && $return[] = str_replace('.php','',basename($group));//排除config.php 配置文件名作为分组名称列表
		}
		return $return;
	}

	//实现类的自动加载
	public function autoload($classname) {
		$dir_array = array(
		$this->appConfig['MODULE_PATH'],	//模块文件
		CP_CORE_PATH . '/../lib/',	//官方扩展库
		CP_CORE_PATH . '/../ext/',	//第三方扩展库
		CP_CORE_PATH . '/',	//核心文件
		$this->appConfig['MODEL_PATH'],	//模型文件
		);
		$dir_array = array_merge($dir_array, $this->appConfig['AUTOLOAD_DIR']);
		foreach($dir_array as $dir) {
			$file = $dir . $classname . '.class.php';
			if ( is_file($file) ) {
				require_once($file);
				return true;
			}
		}
		return false;
	}

}