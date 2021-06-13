<?php
class base extends Action{
	protected $_G = array();

	/**
	 * 对数据进行处理
	 *
	 */
	protected function init(){
		/*if (isset($_GET)) $_GET = $this->_htmlspecialchars($_GET);
		if (isset($_POST)) $_POST = $this->_htmlspecialchars($_POST);
		if (isset($_REQUEST)) $_REQUEST = $this->_htmlspecialchars($_REQUEST);
		if (isset($_COOKIE)) $_COOKIE = $this->_htmlspecialchars($_COOKIE);*/
	}

	public function __construct(){		
		$this->_G['timestamp'] = time();
		//$this->init();
		$this->check_login();//登录验证		
	
		if (!$this->_G['member']['uid'] ) {
			$this->redirect(url('login/index'));
		}
		$auth = $this->check_auth();//权限验证
		if (!$auth) {			
			$this->error('你没有权限');
		}
		$this->assign('_G',$this->_G);
		
	}

	/**
	 * 验证登录状态
	 *
	 */
	protected function check_login(){
		$member = array();
		$cookie = cookie('member');
		
		$db = model();
		$member = cp_decode($cookie,cpConfig::get('authkey'));
		
		if($member['user_agent']==user_agent()){//检测cookie有效性，防止用户盗用cookie
			$find['uid'] = $member['uid'];
			$find['password'] = $member['password'];
			$have = $db->table('member')->where($find)->find();
		}
		if($have){
			unset($have['salt']);
			$this->_G['member'] = $have;
		}else{
			cookie('member',null);
			$this->_G['member'] = Array(
			'uid' => 0,
			'usergroup' => 4
			);
		}		
	}
	/**
	 * 验证权限
	 *
	 * @return unknown
	 */
	protected function check_auth(){
		$config['AUTH_GROUP']=$this->_G['member']['usergroup'];
		$config['AUTH_ADMIN']=1;
		$config['AUTH_NO_CHECK']=array(
			'admin'=>array(
				'login'=>'*',		
			),		
		);
		RBAC::init($config);
		return RBAC::check();
	}
	/**
	 * 采用htmlspecialchars反转义特殊字符
	 *
	 * @param array|string $data 待反转义的数据
	 * @return array|string 反转义之后的数据
	 */
	private function _htmlspecialchars(&$data) {
		return is_array($data) ? array_map(array($this, '_htmlspecialchars'), $data) : trim ( htmlspecialchars ( $data ) );
	}
	protected function textin($data){
		return is_array($data) ? array_map(array($this, 'textin'), $data) : CPstr::s_text($data);
	}
	protected function htmlin($data){
		return is_array($data) ? array_map(array($this, 'htmlin'), $data) : CPstr::s_html($data);
	}

	
	/**
	
$url，基准网址，若为空，将会自动获取，不建议设置为空 
$total，信息总条数 
$perpage，每页显示行数 
$pagebarnum，分页栏每页显示的页数 
$mode，显示风格，参数可为整数1，2，3，4任意一个 
	 */
	protected function page($url="",$total=0,$perPage=10,$pageBarNum=10,$mode=1){		
		$page=new Page();
		$page->pageSuffix=cpConfig::get('URL_HTML_SUFFIX');		
		$cur_page=$page->getCurPage();
		$limit_start=($cur_page-1)*$perPage;
		$limit = $limit_start.','.$perPage;		
		$pagestring = $page->show($url,$total,$perPage,$pageBarNum,$mode) ;
		return array($limit,$pagestring);
	}
	
}