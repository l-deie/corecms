<?php
class groupModel extends Model{
	protected $_validate = array(
		array('name','require','请填写用户组名称'),
		array('name','','该用户组已存在','unique'),
	);
	
	
}