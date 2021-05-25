<?php
class memberModel extends Model{
	protected $_validate = array(
		array('username','require','请填写用户名'),
		array('username','','用户名已被注册','unique'),
		array('password','require','请填写密码'),
		array('password2','password','重复密码不一致','confirm'),		
	);
	protected $_auto = array(
		array('regdate','time','function'),
		array('lastlogintime','time','function'),
	);
	
	
	
}