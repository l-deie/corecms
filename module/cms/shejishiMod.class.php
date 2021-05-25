<?php
//公共类
class shejishiMod extends base{
	public function lists(){
		$db = model();

		$id = intval($_GET['id']);
		$where = 'cid='.$id;
		if ($_GET['tag']) {
			$where .= " and keywords like '%{$this->textin(urldecode($_GET['tag']))}%'";
		}
		$cat = $db->table('categories')->where("id=".$id)->find();
		if(empty($cat)) $this->showmessage('没有找到分类',__REFERER__);
		//分页
		$count = $db->table('shejishi')->where($where)->count();
		list($limit,$pagestring) = $this->page('',$count,100);

		$content = $db->table('shejishi')->where($where)->order('id desc')->limit($limit)->select();


		$this->assign('cat',$cat);
		$this->assign('pagestring',$pagestring);
		$this->assign('content',$content);

		$this->display ($cat['template']);
	}

	public function show(){
		$db = model('shejishi');

		$id = intval($_GET['id']);
		$where['id']=$id;
		$content = $db->where($where)->find();
		$content['content'] = baidu::absolute($content['content']);
		if (!$content) {
			$this->error('未找到你要查看的内容');
		}
		$db_cat = model('categories');
		$cat = $db_cat->where("id=".$content['cid'])->find();
		
		$db_sheji = model('sheji');
		$where = "author='{$content['title']}'";
		$sheji = $db_sheji->where($where)->select();
	

		$this->assign('cat',$cat);		
		$this->assign('content',$content);
		$this->assign('sheji',$sheji);

		$this->display ($cat['vtemplate']);
	}


}
?>