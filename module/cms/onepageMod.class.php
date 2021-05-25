<?php
class onepageMod extends base{
	public function index() {
		$id = intval($_GET['id']);
		$db = model('onepage');
		$where['id'] = $id;
		$onepage = $db->where($where)->find();
		$onepage['content'] = baidu::absolute($onepage['content']);
		$db_cat = model('categories');
		$cat = $db_cat->where($where)->find();
		if (empty($onepage) or empty($cat)) {
			$this->error('未找到您要查找的数据',__ROOT__);
		}		
		$this->assign('onepage',$onepage);
		$this->display ($cat['vtemplate']);
	}
	
}