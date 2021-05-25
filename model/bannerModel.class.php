<?php
class bannerModel extends Model{
	protected $_validate = array(
		array('title','require','请填标题'),			
	);
	protected $_auto = array(
		array('dateline','time','function'),
		array('editdate','time','function'),
		array('viewnum','1','string')
	);	
	
}