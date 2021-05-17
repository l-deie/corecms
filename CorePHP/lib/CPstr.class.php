<?php
/**
 * 字符串处理类
 * 魔术引号处理 s_addslashes s_stripslashes
 * 数据输入处理 s_text s_textarea s_html
 * 字符编码 s_iconv
 * 
 * 字符截取s_substr s_summary
 *
 * @author shooke <QQ:82523829>
 */
class CPstr {
	/**
	 * url与GET传递数据进行编码
	 *
	 * CPstr::s_rawurlencode($data);
	 */
	public static function s_rawurlencode($data) {
		if (is_array ( $data )) {
			foreach ( $data as $key => $value ) {
				$data [$key] = self::s_rawurlencode ( $value );
			}
		} else {
			$data = rawurlencode ( $data );
		}
		return $data;
	}
	
	/**
	 * url与GET传递数据进行解码
	 *
	 * CPstr::s_rawurldecode($data);
	 */
	public static function s_rawurldecode($data) {
		if (is_array ( $data )) {
			foreach ( $data as $key => $value ) {
				$data [$key] = self::s_rawurldecode ( $value );
			}
		} else {
			$data = rawurldecode ( $data );
		}
		return $data;
	}
	/**
	 * url与GET传递数据进行编码
	 *
	 * CPstr::s_urlencode($data);
	 */
	public static function s_urlencode($data) {
		if (is_array ( $data )) {
			foreach ( $data as $key => $value ) {
				$data [$key] = self::s_urlencode ( $value );
			}
		} else {
			$data = urlencode ( $data );
		}
		return $data;
	}
	
	/**
	 * url与GET传递数据进行解码
	 *
	 * CPstr::s_urldecode($data);
	 */
	public static function s_urldecode($data) {
		if (is_array ( $data )) {
			foreach ( $data as $key => $value ) {
				$data [$key] = self::s_urldecode ( $value );
			}
		} else {
			$data = urldecode ( $data );
		}
		return $data;
	}
	
	/**
	 * 添加魔术引号，用于数据库录入
	 *
	 * CPstr::s_addslashes($data);
	 */
	public static function s_addslashes($data) {
		if (is_array ( $data )) {
			foreach ( $data as $key => $value ) {
				$data [$key] = self::s_addslashes ( $value );
			}
		} else {
			$data = addslashes ( $data );
		}
		return $data;
	}
	
	/**
	 * 去除魔术引号，用于还原输出CPstr::s_addslashes处理过的数据
	 *
	 * CPstr::s_stripslashes($data);
	 */
	public static function s_stripslashes($data) {
		if (is_array ( $data )) {
			foreach ( $data as $key => $value ) {
				$data [$key] = self::s_stripslashes ( $value );
			}
		} else {
			$data = stripslashes ( $data );
		}
		return $data;
	}
	
	/**
	 * 将html代码转换后输出主要是对<>
	 *
	 * CPstr::s_text('<br>');
	 * 输出&lt;br&gt;
	 */
	public static function s_text($string) {
		return trim ( htmlspecialchars ( $string ) ); // 防止被挂马，跨站攻击
	}
	
	/**
	 * 多行文本
	 *
	 * CPstr::s_textarea($string);
	 */
	public static function s_textarea($string) {
		$string = strip_tags ( $string, '<br>' );
		$string = str_replace ( " ", "&nbsp;", $string );
		$string = nl2br ( $string );
		return $string;
	}
	
	/**
	 * 编辑器数据允许html代码
	 * $text 原始字符串
	 * $tags 不过滤的标签
	 * CPstr::s_html($text);
	 * 
	 */
    public static function s_html($text, $tags = null) {
    	$text	=	trim($text);
		//完全过滤注释
		$text = preg_replace('/<!--?.*-->/','',$text);
		//完全过滤动态代码
		$text = preg_replace('/<\?|\?'.'>/','',$text);		
		
		$text = str_replace('[','&#091;',$text);
		$text = str_replace(']','&#093;',$text);
		$text = str_replace('|','&#124;',$text);
		//过滤换行符
		$text = preg_replace('/\r?\n/','',$text);
		
		//过滤危险的属性，如：过滤on事件lang js
		while(preg_match('/(<[^><]+)( lang|on|action|background|codebase|dynsrc|lowsrc)[^><]+/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1],$text);
		}
		while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].$mat[3],$text);
		}
		if(empty($tags)) {
		$tags = 'table|td|th|tr|i|b|u|strong|img|p|br|div|strong|em|ul|ol|li|dl|dd|dt|a';
		}
		//将 table|td转为 <table><td>格式
		$allow_tags = '<'.str_replace('|','><',$tags).">";
		$text = strip_tags($text,$allow_tags);
		
		//过滤多余空格
		$text = str_replace('  ',' ',$text);
		return $text;
	}
	/* 旧的当遇到标签内有样式时会出错
    public static function s_html($text, $tags = null) {
		$text	=	trim($text);
		//完全过滤注释
		$text = preg_replace('/<!--?.*-->/','',$text);
		//完全过滤动态代码
		$text = preg_replace('/<\?|\?'.'>/','',$text);
		//完全过滤js
		$text = preg_replace('/<script?.*\/script>/','',$text);
		
		$text = str_replace('[','&#091;',$text);
		$text = str_replace(']','&#093;',$text);
		$text = str_replace('|','&#124;',$text);
		//过滤换行符
		$text = preg_replace('/\r?\n/','',$text);
		//br
		$text = preg_replace('/<br(\s\/)?'.'>/i','[br]',$text);
		$text = preg_replace('/(\[br\]\s*){10,}/i','[br]',$text);
		//过滤危险的属性，如：过滤on事件lang js
		while(preg_match('/(<[^><]+)( lang|on|action|background|codebase|dynsrc|lowsrc)[^><]+/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1],$text);
		}
		while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].$mat[3],$text);
		}
		if(empty($tags)) {
		$tags = 'table|td|th|tr|i|b|u|strong|img|p|br|div|strong|em|ul|ol|li|dl|dd|dt|a';
		}
		//允许的HTML标签
		$text = preg_replace('/<('.$tags.')( [^><\[\]]*)>/i','[\1\2]',$text);
		//过滤多余html
		$text = preg_replace('/<\/?(html|head|meta|link|base|basefont|body|bgsound|title|style|script|form|iframe|frame|frameset|applet|id|ilayer|layer|name|script|style|xml)[^><]*>/i','',$text);
		//过滤合法的html标签
		while(preg_match('/<([a-z]+)[^><\[\]]*>[^><]*<\/\1>/i',$text,$mat)){
		$text=str_replace($mat[0],str_replace('>',']',str_replace('<','[',$mat[0])),$text);
		}
		//转换引号
		while(preg_match('/(\[[^\[\]]*=\s*)(\"|\')([^\2=\[\]]+)\2([^\[\]]*\])/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].'|'.$mat[3].'|'.$mat[4],$text);
		}
		//过滤错误的单个引号
		while(preg_match('/\[[^\[\]]*(\"|\')[^\[\]]*\]/i',$text,$mat)){
		$text=str_replace($mat[0],str_replace($mat[1],'',$mat[0]),$text);
		}
		//转换其它所有不合法的 < >
		$text = str_replace('<','&lt;',$text);
		$text = str_replace('>','&gt;',$text);
		$text = str_replace('"','&quot;',$text);
		//反转换
		$text = str_replace('[','<',$text);
		$text = str_replace(']','>',$text);
		$text = str_replace('|','"',$text);
		//过滤多余空格
		$text = str_replace('  ',' ',$text);
		return $text;
	}
    */
	
	/**
	 * 移除Html代码中的XSS攻击
	 * 
	 * CPstr::s_remove_xss($val);
	 * 
	 */
	public static function s_remove_xss($val) {
		// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
		// this prevents some character re-spacing such as <java\0script>
		// note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
		$val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
	
		// straight replacements, the user should never need these since they're normal characters
		// this prevents like <IMG SRC=@avascript:alert('XSS')>
		$search = 'abcdefghijklmnopqrstuvwxyz';
		$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$search .= '1234567890!@#$%^&*()';
		$search .= '~`";:?+/={}[]-_|\'\\';
		for ($i = 0; $i < strlen($search); $i++) {
			// ;? matches the ;, which is optional
			// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
	
			// @ @ search for the hex values
			$val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
			// @ @ 0{0,7} matches '0' zero to seven times
			$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
		}
	
		// now the only remaining whitespace attacks are \t, \n, and \r
		$ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
		$ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
		$ra = array_merge($ra1, $ra2);
	
		$found = true; // keep replacing as long as the previous round replaced something
		while ($found == true) {
			$val_before = $val;
			for ($i = 0; $i < sizeof($ra); $i++) {
				$pattern = '/';
				for ($j = 0; $j < strlen($ra[$i]); $j++) {
					if ($j > 0) {
						$pattern .= '(';
						$pattern .= '(&#[xX]0{0,8}([9ab]);)';
						$pattern .= '|';
						$pattern .= '|(&#0{0,8}([9|10|13]);)';
						$pattern .= ')*';
					}
					$pattern .= $ra[$i][$j];
				}
				$pattern .= '/i';
				$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
				$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
				if ($val_before == $val) {
					// no replacements were made, so exit the loop
					$found = false;
				}
			}
		}
		return $val;
	}
	/**
	 * ubb编码转换html	 * 
	 * CPstr::s_ubb($Text);
	 *
	 */
	public static function s_ubb($Text) {
		$Text=trim($Text);
		//$Text=htmlspecialchars($Text);
		$Text=preg_replace("/\\t/is","  ",$Text);
		$Text=preg_replace("/\[h1\](.+?)\[\/h1\]/is","<h1>\\1</h1>",$Text);
		$Text=preg_replace("/\[h2\](.+?)\[\/h2\]/is","<h2>\\1</h2>",$Text);
		$Text=preg_replace("/\[h3\](.+?)\[\/h3\]/is","<h3>\\1</h3>",$Text);
		$Text=preg_replace("/\[h4\](.+?)\[\/h4\]/is","<h4>\\1</h4>",$Text);
		$Text=preg_replace("/\[h5\](.+?)\[\/h5\]/is","<h5>\\1</h5>",$Text);
		$Text=preg_replace("/\[h6\](.+?)\[\/h6\]/is","<h6>\\1</h6>",$Text);
		$Text=preg_replace("/\[separator\]/is","",$Text);
		$Text=preg_replace("/\[center\](.+?)\[\/center\]/is","<center>\\1</center>",$Text);
		$Text=preg_replace("/\[url=http:\/\/([^\[]*)\](.+?)\[\/url\]/is","<a href=\"http://\\1\" target=_blank>\\2</a>",$Text);
		$Text=preg_replace("/\[url=([^\[]*)\](.+?)\[\/url\]/is","<a href=\"http://\\1\" target=_blank>\\2</a>",$Text);
		$Text=preg_replace("/\[url\]http:\/\/([^\[]*)\[\/url\]/is","<a href=\"http://\\1\" target=_blank>\\1</a>",$Text);
		$Text=preg_replace("/\[url\]([^\[]*)\[\/url\]/is","<a href=\"\\1\" target=_blank>\\1</a>",$Text);
		$Text=preg_replace("/\[img\](.+?)\[\/img\]/is","<img src=\\1>",$Text);
		$Text=preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is","<font color=\\1>\\2</font>",$Text);
		$Text=preg_replace("/\[size=(.+?)\](.+?)\[\/size\]/is","<font size=\\1>\\2</font>",$Text);
		$Text=preg_replace("/\[sup\](.+?)\[\/sup\]/is","<sup>\\1</sup>",$Text);
		$Text=preg_replace("/\[sub\](.+?)\[\/sub\]/is","<sub>\\1</sub>",$Text);
		$Text=preg_replace("/\[pre\](.+?)\[\/pre\]/is","<pre>\\1</pre>",$Text);
		$Text=preg_replace("/\[email\](.+?)\[\/email\]/is","<a href='mailto:\\1'>\\1</a>",$Text);
		$Text=preg_replace("/\[colorTxt\](.+?)\[\/colorTxt\]/eis","color_txt('\\1')",$Text);
		$Text=preg_replace("/\[emot\](.+?)\[\/emot\]/eis","emot('\\1')",$Text);
		$Text=preg_replace("/\[i\](.+?)\[\/i\]/is","<i>\\1</i>",$Text);
		$Text=preg_replace("/\[u\](.+?)\[\/u\]/is","<u>\\1</u>",$Text);
		$Text=preg_replace("/\[b\](.+?)\[\/b\]/is","<b>\\1</b>",$Text);
		$Text=preg_replace("/\[quote\](.+?)\[\/quote\]/is"," <div class='quote'><h5>引用:</h5><blockquote>\\1</blockquote></div>", $Text);
		$Text=preg_replace("/\[code\](.+?)\[\/code\]/eis","highlight_code('\\1')", $Text);
		$Text=preg_replace("/\[php\](.+?)\[\/php\]/eis","highlight_code('\\1')", $Text);
		$Text=preg_replace("/\[sig\](.+?)\[\/sig\]/is","<div class='sign'>\\1</div>", $Text);
		$Text=preg_replace("/\\n/is","<br/>",$Text);
		return $Text;
	}
	/**
	 * 字符串截取
	 *
	 * CPstr::s_substr($string, 0 ,10);
	 * 
	 */	
	public static function s_substr($str, $start=0, $length, $charset="utf-8", $suffix=true){
		switch($charset){
			case 'utf-8':$char_len=3;break;
			case 'UTF8':$char_len=3;break;
			default:$char_len=2;
		}
		//小于指定长度，直接返回
		if(strlen($str)<=($length*$char_len)){
			return $str;
		}
		if(function_exists("mb_substr")){
			$slice= mb_substr($str, $start, $length, $charset);
		} else if(function_exists('iconv_substr')){
			$slice=iconv_substr($str,$start,$length,$charset);
		} else {
			$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
			$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
			$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
			$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
			preg_match_all($re[$charset], $str, $match);
			$slice = join("",array_slice($match[0], $start, $length));
		}
		if($suffix) return $slice."…";
		return $slice;
	}
	
	/**
	 * 截取摘要：截断一段含有HTML代码的文本，但是不会出现围堵标记没有封闭的问题。
	 *
	 * CPstr::s_summary($string, 800);
	 * 
	 */	
	public static function s_summary($text,$length=800){
		mb_regex_encoding("UTF-8");
		if(mb_strlen($text) <= $length ) return $text;
		$Foremost = mb_substr($text, 0, $length);
		$re = "<(\/?)(P|DIV|H1|H2|H3|H4|H5|H6|ADDRESS|PRE|TABLE|TR|TD|TH|INPUT|SELECT|TEXTAREA|OBJECT|A|UL|OL|LI|BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT|SPAN)[^>]*(>?)";
		$Single = "/BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT|BR/i";
	
		$Stack = array(); $posStack = array();
	
		mb_ereg_search_init($Foremost, $re, 'i');
	
		while($pos = mb_ereg_search_pos()){
			$match = mb_ereg_search_getregs();
			/*        [Child-matching Formulation]:
	
			$matche[1] : A "/" charactor indicating whether current "<...>" Friction is Closing Part
			$matche[2] : Element Name.
			$matche[3] : Right > of a "<...>" Friction
			*/
	
			if($match[1]==""){
				$Elem = $match[2];
				if(mb_eregi($Single, $Elem) && $match[3] !=""){
					continue;
				}
				array_push($Stack, mb_strtoupper($Elem));
				array_push($posStack, $pos[0]);
			}else{
				$StackTop = $Stack[count($Stack)-1];
				$End = mb_strtoupper($match[2]);
				if(strcasecmp($StackTop,$End)==0){
					array_pop($Stack);
					array_pop($posStack);
					if($match[3] ==""){
						$Foremost = $Foremost.">";
					}
				}
			}
		}
	
		$cutpos = array_shift($posStack) - 1;
		$Foremost =  mb_substr($Foremost,0,$cutpos,"UTF-8");
		if(mb_strlen($Foremost)<2) $Foremost = msubstr(strip_tags($text),0,$length);
		return $Foremost;
	}
	
	/**
	 * 编码转换
	 *
	 * CPstr::s_iconv($string, 'gbk','utf8');
	 * 
	 */	
	public static function s_iconv($fContents,$from='gbk',$to='utf-8'){
		$from   =  strtoupper($from)=='UTF8'? 'utf-8':$from;
		$to       =  strtoupper($to)=='UTF8'? 'utf-8':$to;
		if( strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents)) ){
			//如果编码相同或者非字符串标量则不转换
			return $fContents;
		}
		if(is_string($fContents) ) {
			if(function_exists('mb_convert_encoding')){
				return mb_convert_encoding ($fContents, $to, $from);
			}elseif(function_exists('iconv')){
				return iconv($from,$to,$fContents);
			}else{
				return $fContents;
			}
		}
		elseif(is_array($fContents)){
			foreach ( $fContents as $key => $val ) {
				$_key = self::s_iconv($key,$from,$to);
				$fContents[$_key] = self::s_iconv($val,$from,$to);
				if($key != $_key )
					unset($fContents[$key]);
			}
			return $fContents;
		}
		else{
			return $fContents;
		}
	}
	
	// 检查字符串是否是UTF8编码,是返回true,否则返回false
	public static function is_utf8($string)
	{
		return preg_match('%^(?:
		 [\x09\x0A\x0D\x20-\x7E]            # ASCII
	   | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
	   |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
	   | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
	   |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
	   |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
	   | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
	   |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
   		)*$%xs', $string);
	}
}
?>