<?php

/**
 * 生成url路径
 *
 */
class Murl {
	/**
 * 生成url
 * @access public
 * @param array $url 地址参数url( '[模块/操作]','额外参数1=值1&额外参数2=值2...')
 * 支持 array('name'=>$value) 或者 name=$value
 * @return array
 */
	static function url($module,$request='',$author=''){
		//url生成模式		
		$url_model = cpConfig::get('URL_REWRITE_ON');
		switch ($url_model){
			case 0:
			case 1:
				return self::path_info($module,$request,$author);
			case 2:
			case 3:
				return self::gma_url($module,$request,$author);
			case 4:
			case 5:
				return self::rewrite_url($module,$request,$author);
		}

	}
	static function path_info($module,$request='',$author=''){
		$group_default = cpConfig::get('GROUP_DEFAULT');
		$group_depr = cpConfig::get('URL_GROUP_DEPR');
		$module_depr = cpConfig::get('URL_MODULE_DEPR');
		$action_depr = cpConfig::get('URL_ACTION_DEPR');
		$param_depr = cpConfig::get('URL_PARAM_DEPR');
		$domain_list = cpConfig::get('GROUP_DOMAIN');//分组域名列表
		$domain = $domain_list[CP_GROUP];//取得当前分组对应域名
		//分解分组 模块 操作方法
		$marray = explode('/',$module);

		//如果只有模块和操作方法
		if (count($marray)==2) {
			$module = $marray[0].$module_depr.$marray[1].$action_depr;//生成module/action/格式
			if ($group_default) {//分组开启状态
				if (CP_GROUP != $group_default && !$domain) {//当前分组不是默认分组 并且没有设置域名
					$module = CP_GROUP.$group_depr.$module;//添加当前分组到url中 生成group/module/action/
				}
			}
		}
		//有分组 模块 操作方法
		if (count($marray)==3) {
			$module = $marray[1].$module_depr.$marray[2].$action_depr;//module/action/格式 无需加入分组名，最后生成url时将域名加入
			if ($marray[0] != $group_default && !$domain) {//指定分组不是默认分组 并且没有设置域名
				$module = $marray[0].$group_depr.$module;
			}
		}
		if(!empty($request)){
			if (is_array($request)) {
				$param = '';
				foreach ($request as $key=>$val){
					$param .= $param_depr.$key.$param_depr.$val;
				}
				$param = substr($param,1);//第一个字符是分隔符，去除出第一个字符
				$module = $module.$param;//组合模块和参数
			}else {
				$request = str_replace(array('=','&'), array($param_depr,$param_depr), $request);
				$module = $module.$request;
			}

		}else {//没有reque参数
			$module = substr($module,0,-1);//去除最后的action结尾分隔，符生成module/action格式
		}//end if request
		if ($domain) {//有对应域名时生成地址加入域名
			$return = $domain.__APP__.'/'.$module.cpConfig::get('URL_HTML_SUFFIX');
		}else {
			$return = cpConfig::get('URL_HTTP_HOST').__APP__.'/'.$module.cpConfig::get('URL_HTML_SUFFIX');
		}
		return $author ? $return.'#'.$author : $return;
	}
	static function gma_url($module,$request='',$author=''){
		$group_default = cpConfig::get('GROUP_DEFAULT');
		$domain_list = cpConfig::get('GROUP_DOMAIN');//分组域名列表
		$domain = $domain_list[CP_GROUP];//取得当前分组对应域名
		//获取原生地址变量名
		list($g,$m,$a) = explode(',',cpConfig::get('URL_GMA_VAR'));
		
		//分解分组 模块 操作方法
		$marray = explode('/',$module);

		//如果只有模块和操作方法
		if (count($marray)==2) {
			$module = $m.'='.$marray[0].'&'.$a.'='.$marray[1];//生成m=module&a=action格式
			if ($group_default) {//分组开启状态
				if (CP_GROUP != $group_default && !$domain) {//当前分组不是默认分组 并且没有设置域名
					$module = $g.'='.CP_GROUP.'&'.$module;//添加当前分组到url中 生成g=group&m=module&a=action
				}
			}
		}
		//有分组 模块 操作方法
		if (count($marray)==3) {
			$module = $m.'='.$marray[1] .'&'. $a.'='.$marray[2];//m=module&a=action格式 无需加入分组名，最后生成url时将域名加入
			if ($marray[0] != $group_default && !$domain) {//指定分组不是默认分组 并且没有设置域名
				$module = $g.'='.$marray[0].'&'.$module;
			}
		}
		if(!empty($request)){
			if (is_array($request)) {
				$param = '';
				foreach ($request as $key=>$val){
					$param .= '&'.$key.'='.$val;
				}
				//$param = substr($param,1);//第一个字符是分隔符，去除出第一个字符
				$module = $module.$param;//组合模块和参数
			}else {
				$module = $module.'&'.$request;
			}
		}//end if request
		$app = cpConfig::get('URL_REWRITE_ON')==3 ? __APP__.'/' : __APP__;
		if ($domain) {//有对应域名时生成地址加入域名
			$return = $domain.$app.'?'.$module;
		}else {
			$return = cpConfig::get('URL_HTTP_HOST').$app.'?'.$module;
		}		
		return $author ? $return.'#'.$author : $return;
	}
	static function rewrite_url($module,$request='',$author=''){
		$group_default = cpConfig::get('GROUP_DEFAULT');
		$group_depr = cpConfig::get('URL_GROUP_DEPR');
		$module_depr = cpConfig::get('URL_MODULE_DEPR');
		$action_depr = cpConfig::get('URL_ACTION_DEPR');
		$param_depr = cpConfig::get('URL_PARAM_DEPR');
		$domain_list = cpConfig::get('GROUP_DOMAIN');//分组域名列表
		$domain = $domain_list[CP_GROUP];//取得当前分组对应域名
		//分解分组 模块 操作方法
		$marray = explode('/',$module);

		//如果只有模块和操作方法
		if (count($marray)==2) {
			$module = $marray[0].$module_depr.$marray[1].$action_depr;//生成module/action/格式
			if ($group_default) {//分组开启状态
				if (CP_GROUP != $group_default && !$domain) {//当前分组不是默认分组 并且没有设置域名
					$module = CP_GROUP.$group_depr.$module;//添加当前分组到url中 生成group/module/action/
				}
			}
		}
		//有分组 模块 操作方法
		if (count($marray)==3) {
			$module = $marray[1].$module_depr.$marray[2].$action_depr;//module/action/格式 无需加入分组名，最后生成url时将域名加入
			if ($marray[0] != $group_default && !$domain) {//指定分组不是默认分组 并且没有设置域名
				$module = $marray[0].$group_depr.$module;
			}
		}
		if(!empty($request)){
			if (is_array($request)) {
				$param = '';
				foreach ($request as $key=>$val){
					$param .= $param_depr.$key.$param_depr.$val;
				}
				$param = substr($param,1);//第一个字符是分隔符，去除出第一个字符
				$module = $module.$param;//组合模块和参数
			}else {
				$request = str_replace(array('=','&'), array($param_depr,$param_depr), $request);
				$module = $module.$request;
			}

		}else {//没有reque参数
			$module = substr($module,0,-1);//去除最后的action结尾分隔，符生成module/action格式
		}//end if request
		$app = cpConfig::get('URL_REWRITE_ON')==5 ? __APP__.'/' : __APP__;
		if ($domain) {//有对应域名时生成地址加入域名
			$return = $domain.$app.'?'.$module;
		}else {
			$return = cpConfig::get('URL_HTTP_HOST').$app.'?'.$module;
		}		
		
		if ($domain) {//有对应域名时生成地址加入域名
			$return = $domain.$app."?".cpConfig::get('URL_R_VAR')."=".$module.cpConfig::get('URL_HTML_SUFFIX');
		}else {
			$return = cpConfig::get('URL_HTTP_HOST').$app."?".cpConfig::get('URL_R_VAR')."=".$module.cpConfig::get('URL_HTML_SUFFIX');
		}
		return $author ? $return.'#'.$author : $return;
	}
}