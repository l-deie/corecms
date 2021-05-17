<?php
class Action extends cpHttpRequest {

	protected $config = array();

	protected function init(){}

	public function __construct(){
		//parent::__construct();//cpApp中已经初始化过所以覆盖 cpHttpRequest的__construct()
		$this->init();
	}

	/**
	 * 获取模板对象
	 *
	 * @return unknown
	 */
	public function cpView(){
		static $view = NULL;
		if( empty($view) ){
			$view = new cpTemplate( cpConfig::get('APP') );
		}
		return $view;
	}

	/**
	 * 模板赋值
	 *
	 * @param unknown_type $name
	 * @param unknown_type $value
	 * @return unknown
	 */
	protected function assign($name, $value=null){
		return $this->cpView()->assign($name, $value);
	}

	/**
	 * 模板显示
	 *
	 * @param unknown_type $tpl
	 * @param unknown_type $return
	 * @param unknown_type $is_tpl
	 * @return unknown
	 */
	protected function display($tpl = '', $return = false, $is_tpl = true ){
		return $this->cpView()->display($tpl, $return, $is_tpl);
	}

	/**
	 * 直接跳转
	 *
	 * @param unknown_type $url
	 * @param unknown_type $code
	 */
	protected function redirect( $url, $code=302) {
		header('location:' . $url, true, $code);
		exit;
	}

	/**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @return void
     */
	protected function ajaxReturn($data,$type='') {
		if(func_num_args()>2) {// 参数多于2个
			$args           =   func_get_args();
			array_shift($args);
			$info           =   array();
			$info['data']   =   $data;
			$info['info']   =   array_shift($args);
			$info['status'] =   array_shift($args);
			$data           =   $info;
			$type           =   $args?array_shift($args):'';
		}
		if(empty($type)) $type  =   'JSON';
		switch (strtoupper($type)){
			case 'JSON' :
				// 返回JSON数据格式到客户端 包含状态信息
				header('Content-Type:application/json; charset=utf-8');
				exit(json_encode($data));
			case 'XML'  :
				// 返回xml格式数据
				header('Content-Type:text/xml; charset=utf-8');
				exit(xml_encode($data));
			default  :
				// 返回可执行的js脚本
				header('Content-Type:text/html; charset=utf-8');
				exit($data);
		}
	}
	/**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
	protected function error($message,$url='',$ajax=false) {
		$this->showMessage($message,0,$url,$ajax);
	}

	/**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
	protected function success($message,$url='',$ajax=false) {
		$this->showMessage($message,1,$url,$ajax);
	}
	/**
     * 默认跳转操作 支持错误导向和正确跳转
     * 调用模板显示 默认为public目录下面的success页面
     * 提示页面为可配置 支持模板标签
     * @param string $message 提示信息
     * @param Boolean $status 状态
     * @param string $url 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @access private
     * @return void
     */
	private function showMessage($message,$status=1,$url='',$ajax=false, $waitSecond=null) {
		if(true === $ajax ) {// AJAX提交
			$data           =   is_array($ajax)?$ajax:array();
			$data['info']   =   $message;
			$data['status'] =   $status;
			$data['url']    =   $url;
			$this->ajaxReturn($data);
		}
		$this->assign('msgTitle',$status? '成功提示' : '失败提示');// 提示标题
		$this->assign('status',$status);   // 状态
		//保证输出不受静态缓存影响
		cpConfig::set('HTML_CACHE_ON',false);
		if($status) { //发送成功信息
			$this->assign('message',$message);// 提示信息
			// 成功操作后默认停留1秒
			if(!isset($waitSecond)){
				$waitSecond = 1;
				$this->assign('waitSecond',$waitSecond);
			}
			// 默认操作成功自动返回操作前页面
			$url = empty($url) ? $_SERVER["HTTP_REFERER"] : $url;
			$this->assign("url",$url);
			if(!cpConfig::$config['APP']['TPL_ACTION_SUCCESS']){
				$this->showTpl($message,$status,$url,$waitSecond);
				exit;
			}
			$this->display(cpConfig::$config['APP']['TPL_ACTION_SUCCESS']);
		}else{
			$this->assign('error',$message);// 提示信息
			//发生错误时候默认停留3秒
			if(!isset($waitSecond)){
				$waitSecond = 3;
				$this->assign('waitSecond',$waitSecond);
			}
			// 默认发生错误的话自动返回上页
			$url = empty($url) ? "javascript:history.back(-1);" : $url;
			$this->assign("url",$url);
			if(!cpConfig::$config['APP']['TPL_ACTION_ERROR']){
				$this->showTpl($message,$status,$url,$waitSecond);
				exit;
			}
			$this->display(cpConfig::$config['APP']['TPL_ACTION_ERROR']);
			// 中止执行  避免出错后继续执行
			exit ;
		}
	}

	/**
	 * 默认提示模板
	 * 在未指定错误和成功提示模板时使用此方法输出
	 *
	 * @param unknown_type $message
	 * @param unknown_type $status
	 * @param unknown_type $url
	 * @param unknown_type $waitSecond
	 */
	private function showTpl($message,$status=1,$url='',$waitSecond=0){
		$title = $status? '成功提示' : '失败提示';
		print <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>跳转提示!</title>
<STYLE>
BODY{FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; COLOR: #333; background:#fff; FONT-SIZE: 12px;padding:0px;margin:0px;}
A{text-decoration:none;color:#3071BF}
A:hover{text-decoration:underline;}
.wrap{ margin:20px auto; padding:15px; width:800px;}
.error_title{border-bottom:1px #9CF dotted;font-size:20px;line-height:28px; height:28px;font-weight:600;padding-bottom:8px;}
.error_box{border-left:3px solid #FC0;font-size:14px; line-height:22px; padding:6px 15px;background:#FFE}
.error_tip{margin-top:15px;}
</STYLE>
</head>
<body>
	<div class="wrap">
	<div class="error_title">$title</div>
	<div style="height:10px"></div>
	<div class="error_box">$message</div>
<div class="error_tip">页面自动 <a id="href" href="$url">跳转</a> 等待时间： <b id="wait"> $waitSecond </b></div>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>
EOT;
}


}