<?php
class article_contentModel extends Model{
	protected $_validate = array(
		array('content','require','请填内容'),			
	);
	
	
}