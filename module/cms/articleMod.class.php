<?php
class articleMod extends base{
	public function index() {
		$id = intval($_GET['id']);
		
		//$cat = model('categories')->where('id='.$id);
		$table = array('article'=>'a','article_content'=>'c');
		$where = "a.id=c.id and a.cid=".$id;
		$db = model();
		$list = $db->table($table)->where($where)->select();		
		if ($list) {
			$this->assign('list',$list);
			$this->display('cat');
		}else{
			$this->error('没有找到您要查看的内容',__ROOT__);
		}
		
		//$this->display ($cat['vtemplate']);
	}
	public function view(){
		$id = intval($_GET['id']);				
		//$cat = model('categories')->where('id='.$id);
		$table = array('article'=>'a','article_content'=>'c');
		$where = "a.id=c.id and a.id=".$id;
		$db = model();
		$article = $db->table($table)->where($where)->find();		
		
		if ($article) {
			$list = model('article')->where('cid='.$article['cid'])->select();//分类型所有文章
			$this->assign('list',$list);
			$article['content'] = baidu::absolute($article['content']);
			$this->assign('article',$article);
			$this->display('view');
		}else{
			$this->error('没有找到您要查看的内容',__ROOT__);
		}
	}
	
}