<?php
class shejiModel extends Model{
	protected $_validate = array(
		array('title','require','请填标题'),			
		array('content','require','请填内容'),		
	);
	protected $_auto = array(
		array('dateline','time','function'),
		array('viewnum','1','string')
	);	
	
}