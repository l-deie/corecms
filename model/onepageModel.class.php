<?php
class onepageModel extends Model{
	protected $_validate = array(
		array('title','require','请填写标题'),
		array('content','require','请填写内容'),		
	);
	protected $_auto = array(
		array('editdate','time','function')
	);
	
	
	
}