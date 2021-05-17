<?php
class cpTemplate {
	public $config =array(); //配置
	protected $vars = array();//存放变量信息
	protected $_replace = array();
	protected $cachetime=0;
	
	public function __construct($config = array()) {
		$this->config = array_merge(cpConfig::get('TPL'), (array)$config);//参数配置	
		$this->assign('cpTemplate', $this);
		$this->_replace = array(
				'str' => array( 'search' => array(),
								'replace' => array()
							),
				'reg' => array( 'search' => array("/__[A-Z]+__/",	//替换常量
												"/".$this->config['TPL_TEMPLATE_LEFT']."(\\$[a-zA-Z_]\w*(?:\[[\w\.\"\'\[\]\$]+\])*)".$this->config['TPL_TEMPLATE_RIGHT']."/i",	//替换变量
												"/".$this->config['TPL_TEMPLATE_LEFT']."include\s*(.*)".$this->config['TPL_TEMPLATE_RIGHT']."/i",	//递归解析模板包含
												),
								'replace' => array("<?php if(defined('$0')){echo $0;}else{echo '$0';} ?>",
												 "<?php echo $1; ?>",
												 "<?php \$cpTemplate->display(\"$1\"); ?>",
												)					   
							)
		);
	}
	
	//模板赋值
	public function assign($name, $value = '') {
		if( is_array($name) ){
			foreach($name as $k => $v){
				$this->vars[$k] = $v;
			}
		} else {
			$this->vars[$name] = $value;
		}
	}

	//执行模板解析输出
	public function display($tpl = '', $return = false, $is_tpl = true ) {
		//如果没有设置模板，则调用当前模块的当前操作模板
		if ( $is_tpl &&  ($tpl == '')) {
			$tpl = CP_MODULE . "/" . CP_ACTION;			
		}
		if( $return ){
			if ( ob_get_level() ){
				ob_end_flush();
				flush(); 
			} 
			ob_start();
		}
		extract($this->vars, EXTR_OVERWRITE);
		if ( $is_tpl && $this->config['TPL_CACHE_ON'] ) {
			define('TPL_INC', true);
			$tplFile = $this->config['TPL_TEMPLATE_PATH'] . $tpl . $this->config['TPL_TEMPLATE_SUFFIX'];
			$cacheFile = $this->config['TPL_CACHE_PATH'] . md5($tplFile) . $this->config['TPL_CACHE_SUFFIX'];
			
			if ( !file_exists($tplFile) ) {
				throw new Exception($tplFile . "模板文件不存在");
			}
			//普通的文件缓存
			if ( empty($this->config['TPL_CACHE_TYPE']) ) {
				if ( !is_dir($this->config['TPL_CACHE_PATH']) ) {
					@mkdir($this->config['TPL_CACHE_PATH'], 0777, true);	
				}
				if ( (!file_exists($cacheFile)) || (filemtime($tplFile) > filemtime($cacheFile)) || ($this->cachetime>0 && time()-filemtime($cacheFile)>$this->cachetime) ) {
					if ($this->cachetime>0){
						$template = $this->compile( $tpl, $is_tpl);
						preg_match_all('/<#(.*)#>/',$template,$templatec);//取得执行前的程序段
						ob_start();
						eval('?>' . $template);
						$html = ob_get_contents();
						ob_end_clean();
						preg_match_all('/<#(.*)#>/',$html,$htmlc);//取得执行后的代码
						$template = str_replace($htmlc[0],$templatec[1],$html);//替换非缓存区域
						file_put_contents($cacheFile, "<?php if (!defined('TPL_INC')) exit;?>" . $template);
					}else{
						$template = $this->compile($tpl);
						$template = str_replace(array('<#','#>'),array('',''),$template);
						file_put_contents($cacheFile, "<?php if (!defined('TPL_INC')) exit;?>" . $template);//写入缓存
					}
				}
				include( $cacheFile );//加载编译后的模板缓存
				
			} else {
				//支持memcache等缓存
				$tpl_key = md5( realpath($tplFile) );
				$tpl_time_key = $tpl_key.'_time';
				static $cache = NULL;
				$cache = is_object($cache) ? $cache : new cpCache($this->config, $this->config['TPL_CACHE_TYPE']);
				$compile_content = $cache->get( $tpl_key );
				if ( empty($compile_content) || (filemtime($tplFile) > $cache->get($tpl_time_key)) ) {
					$compile_content = $this->compile($tpl);
					$cache->set($tpl_key, $compile_content, 3600*24*365);	//缓存编译内容
					$cache->set($tpl_time_key, time(), 3600*24*365);	//缓存编译内容
				}
				eval('?>' . $compile_content);
			}
		} else {
			eval('?>' . $this->compile( $tpl, $is_tpl));//直接执行编译后的模板
		}
		
		if( $return ){
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}
	}	
	
	//自定义添加标签
	public function addTags($tags = array(), $reg = false) {
		$flag = $reg ? 'reg' : 'str';
		foreach($tags as $k => $v) {
			$this->_replace[$flag]['search'][] = $k;
			$this->_replace[$flag]['replace'][] = $v;
		}
	}
	
	//模板编译核心
	protected function compile( $tpl, $is_tpl = true ) {
		if( $is_tpl ){
			$tplFile = $this->config['TPL_TEMPLATE_PATH'] . $tpl . $this->config['TPL_TEMPLATE_SUFFIX'];
			if ( !file_exists($tplFile) ) {
				throw new Exception($tplFile . "模板文件不存在");
			}
			$template = file_get_contents( $tplFile );
		} else {
			extract($this->vars, EXTR_OVERWRITE);
			$template = $tpl;
		}
		
		//如果自定义模板标签解析函数tpl_parse_ext($template)存在，则执行
		if ( function_exists('tpl_parse_ext') ) {
			$template = tpl_parse_ext($template);
		}
		$template = str_replace($this->_replace['str']['search'], $this->_replace['str']['replace'], $template);
		$template = preg_replace($this->_replace['reg']['search'], $this->_replace['reg']['replace'], $template);
		return $template;
	}
	
	//判断二级缓存是否有效
	public function is_cached($tpl, $time=0){
		//如果没有设置模板，则调用当前模块的当前操作模板
		if ( $tpl == "" ) {
			$tpl = CP_MODULE . "/" . CP_ACTION;
		}
		$tplFile = $this->config['TPL_TEMPLATE_PATH'] . $tpl . $this->config['TPL_TEMPLATE_SUFFIX'];
		$cacheFile = $this->config['TPL_CACHE_PATH'] . md5($tplFile) . $this->config['TPL_CACHE_SUFFIX'];
		if ( !file_exists($tplFile) ) {
			throw new Exception($tplFile . "模板文件不存在");
		}
		$this->cachetime = $time ? $time : $this->config['TPL_TEMPLATE_CACHETIME'];
		if ($time<0) $this->cachetime = 0;//$time<0本页关闭二级缓存
		if ( (!file_exists($cacheFile)) || (time()-filemtime($cacheFile)>$this->cachetime) || (filemtime($tplFile) > filemtime($cacheFile)) ) {
			return false;
		}else{
			return true;
		}
	}
}