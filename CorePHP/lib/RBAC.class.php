<?php
/*
功能:权限验证。
作者：风微萧 QQ:82523829;
创建时间：2013-6-5;
使用样例：
<?php

$config['AUTH_GROUP']=7;
$config['AUTH_ADMIN']=1;
$config['AUTH_NO_CHECK']=array(
'index'=> 
array('index','login','verify'),
'common'=>'*'
);
RBAC::init($config);
if(RBAC::check()) 
	echo "!";
else
	echo "dd";
?>
*/
//权限认证类
class RBAC
{
	static public $model=NULL;//数据库模型
	static public $config;

	static public function init($config=array())
	{
		/*
		//不需要认证的模块，对后台认证有效
		self::$config['AUTH_NO_CHECK']=isset($config['AUTH_NO_CHECK'])?$config['AUTH_NO_CHECK']:array('index'=> array('login','verify'),'common'=>'*');
		//session前缀
		self::$config['AUTH_SESSION_PREFIX']=isset($config['AUTH_SESSION_PREFIX'])?$config['AUTH_SESSION_PREFIX']:'auth_';
		//是否缓存权限信息，如果设置为false，每次都需要从数据库读取数据*/
		//用户组
		self::$config['AUTH_GROUP'] = $config['AUTH_GROUP'];
		//管理员用户组
		self::$config['AUTH_ADMIN'] = isset($config['AUTH_ADMIN']) ? $config['AUTH_ADMIN'] : 1;//默认是1
		//无需验证模块
		self::$config['AUTH_NO_CHECK'] = isset($config['AUTH_NO_CHECK']) ? $config['AUTH_NO_CHECK'] : null;
		//数据库表
		self::$config['AUTH_TABLE_NODE']=isset($config['AUTH_TABLE_NODE']) ? $config['AUTH_TABLE_NODE'] : 'node';//模块功能表
		self::$config['AUTH_TABLE_ACCESS']=isset($config['AUTH_TABLE_ACCESS']) ? $config['AUTH_TABLE_ACCESS'] : 'access';//用户组与模块功能关联表

	}

	/**
	 * 取得所有功能节点
	 *
	 * @return unknown
	 */
	static public function getNode(){
		$model = Model();
		$table = self::$config['AUTH_TABLE_NODE'];
		$node = $model->table($table)->order('id ASC')->select();
		//转换数组，用主键做key
		foreach ($node as $one_node){
			$one_node['name'] = self::tolower($one_node['name']);//转换为小写，防止因为大小写出现验证失误
			$return[$one_node['id']]=$one_node;
		}
		return $return;
	}

	/**
	 * 取得用户组的权限
	 *
	 * @return unknown
	 */
	static public function getAccess(){
		$model = Model();
		$table = self::$config['AUTH_TABLE_ACCESS'];
		if (!self::$config['AUTH_GROUP']) {
			exit('未设置用户组');
		}
		$where = array(
		'user_group_id'=>self::$config['AUTH_GROUP'],
		);
		$access = $model->table($table)->where($where)->select();
		return $access;
	}

	/**
	 * 获取用户组权限
	 *
	 * @return unknown
	 */
	static public function getAllow(){
		$access = self::getAccess();
		$node = self::getNode();
		foreach ($access as $one){			
			$action_node = $node[$one['node_id']];
			$action = $action_node['name'];//取得action	
			
			if ($action_node['pid']) {
				$module_node = $node[$action_node['pid']];
				$module = $module_node['name'];//取得module
				if (!cpConfig::get('GROUP_DEFAULT')) {
					$Allow[$module][$action] = 1;
				}
			}
			//开启群组时
			if (cpConfig::get('GROUP_DEFAULT')) {
				if ($module_node['pid']) {//如果模块有上级，则获取分组名称
					$group_node = $node[$module_node['pid']];
					$group = $group_node['name'];
					$Allow[$group][$module][$action] = 1;
				}
			}

		}
		return $Allow;
	}
	/**
	 * 验证手工设置 管理员和无需验证模块
	 *
	 * @return unknown
	 */
	static public function noCheck(){
		//根据参数个数设置$group,$module,$action
		$args = func_num_args();
		if ($args > 2) {
			list($group, $module, $action) = func_get_args();
		}
		if ($args == 2) {
			list($module, $action) = func_get_args();
		}

		if (self::$config['AUTH_ADMIN'] == self::$config['AUTH_GROUP']) {//如果用户是管理员
			return true;
		}else {
			//取得模块和操作方法
			$module = empty($module) ? cpApp::$module : $module;
			$module = self::tolower($module);//转换为小写，防止因为大小写出现验证失误
			$action = empty($action) ? cpApp::$action : $action;
			$action = self::tolower($action);//转换为小写，防止因为大小写出现验证失误
			if (cpConfig::get('GROUP_DEFAULT')) {//分组功能开启时
				$group = empty($group) ? cpApp::$group : $group;
				$group = self::tolower($group);
				if(isset(self::$config['AUTH_NO_CHECK'])){//配置无需验证模块时
					//所有模块无需验证
					if(self::$config['AUTH_NO_CHECK'][$group]=='*'){
						return true;
					}
					//模块属于分组，并且模块内所有方法无需验证
					if(self::$config['AUTH_NO_CHECK'][$group][$module]=='*'){
						return true;
					}
					//操作方法在模块内无需验证
					if (is_array(self::$config['AUTH_NO_CHECK'][$group][$module]) && in_array($action,self::$config['AUTH_NO_CHECK'][$group][$module])) {
						return true;
					}
				}
			}else {//未开启分组功能
				//所有方法无需验证
				if (self::$config['AUTH_NO_CHECK'][$module]=='*') {
					return true;
				}
				//操作方法在无需验证数组中
				if (is_array(self::$config['AUTH_NO_CHECK'][$module]) && in_array($action,self::$config['AUTH_NO_CHECK'][$module])) {
					return true;
				}
				
			}//end 分组验证

		}//end 管理员

		//不在管理员和无需验证范围内返回false
		return false;
	}
	/**
	 * 权限验证
	 * RBAC::check()或RBAC::check('group','module','action')
	 * @return unknown
	 */
	static public function check(){
		//根据参数个数设置$group,$module,$action 并进行配置验证
		$args = func_num_args();
		if ($args > 2) {
			list($group, $module, $action) = func_get_args();
			//管理员或无需验证 返回true
			if(self::noCheck($group, $module, $action)){
				return true;
			}
		}
		if ($args == 2) {
			list($module, $action) = func_get_args();
			//管理员或无需验证 返回true
			if(self::noCheck($module, $action)){
				return true;
			}
		}
		if ($args == 0) {
			//管理员或无需验证 返回true
			if(self::noCheck()){
				return true;
			}
		}

		//需要验证
		$Allow = self::getAllow();
		//取得模块和操作方法
		$module = empty($module) ? cpApp::$module : $module;
		$module = self::tolower($module);//转换为小写，防止因为大小写出现验证失误
		$action = empty($action) ? cpApp::$action : $action;
		$action = self::tolower($action);//转换为小写，防止因为大小写出现验证失误
		//分组功能开启时
		if (cpConfig::get('GROUP_DEFAULT')) {
			$group = empty($group) ? cpApp::$group : $group;
			$group = self::tolower($group);//转换为小写，防止因为大小写出现验证失误
			return isset($Allow[$group][$module][$action]);//返回true 或false
		}else {
			return isset($Allow[$module][$action]);//返回true 或false
		}
	}
	
	/**
	 * 转换为小写，防止因为大小写出现验证失误
	 *
	 * @param unknown_type $str
	 * @return unknown
	 */
	static public function tolower($str){
		return strtolower($str);
	}

}
?>