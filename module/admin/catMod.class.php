<?php
class catMod extends base {
	public function index() {	
		$db = model();	
		$catsql = $db->table('categories')->order("orderfield asc")->select();
		$cat=new Category(array('id','parentid','title','ctitle'));
		$cattree=$cat->getTree($catsql);//获取分类数据树结构
		$this->assign('cattree',$cattree);
		$this->display ();
	}
	public function del(){
		$db = model();
		$delarr = array();
		if ($_GET['id']) {
			$delarr[]=intval($_GET['id']);
		}else {
			$delarr = $_POST['catid'];
		}
		
		foreach($delarr as $catid){
			$id=intval($catid);
			$catarr = $db->table('categories')->where("id=$id or parentid=$id")->select();
			foreach($catarr as $cat){
				$module = module($cat['model']);
				if(method_exists($module,'catdel')) $module->catdel($cat['id']);
			}
			$db->table('categories')->where("id=$id or parentid=$id")->delete();
		}
		
		$this->success('删除成功');
	}
	
	public function edit(){
		$db = model();
		if(!empty($_POST['title'])){
			$id = intval($_POST['id']);
			$update = array(
			'parentid'=>intval($_POST['parentid']),
			'title'=>$this->textin($_POST['title']),
			'keywords'=>$this->textin($_POST['keywords']),
			'description'=>$this->textin($_POST['description']),
			'template'=>$this->textin($_POST['template']),
			'vtemplate'=>$this->textin($_POST['vtemplate']),
			'orderfield'=>intval($_POST['orderfield']),
			);
			$parent = $db->table('categories')->where('id='.$update['parentid'])->find();
			$update['parenttitle'] = $parent['title'];
			$db->table('categories')->data($update)->where("id=$id")->update();
			$this->success('修改成功',url('cat/index'));
			exit;
		}
		$id = intval($_GET['id']);
		
		$catsql = $db->table('categories')->where("id <> ".$id)->select();
		$cat=new Category(array('id','parentid','title','ctitle'));
		$cattree=$cat->getTree($catsql);//获取分类数据树结构
		$this->assign('cattree',$cattree);
		
		
		$cat = $db->table('categories')->where("id=$id")->find();
		$this->assign('id',$id);
		$this->assign('cat',$cat);
		$this->display();
	}
	
	public function add() {		
		$db = model();
		if(!empty($_POST['title'])){
		$instert = array(
			'parentid'=>intval($_POST['parentid']),
			'model'=>$this->textin($_POST['model']),
			'title'=>$this->textin($_POST['title']),
			'keywords'=>$this->textin($_POST['keywords']),
			'description'=>$this->textin($_POST['description']),
			'template'=>$this->textin($_POST['template']),
			'vtemplate'=>$this->textin($_POST['vtemplate']),
			'orderfield'=>intval($_POST['orderfield']),
		);
		$parent = $db->table('categories')->where('id='.$instert['parentid'])->find();
		$instert['parenttitle'] = $parent['title'];
		$db->table('categories')->data($instert)->insert();
		$this->success('添加成功',url('cat/index'));
		exit;
		}
		//获取模型
		$model = $db->table('node')->where("type=1")->select();
		$this->assign('model',$model);
		//取得分类
		$catsql = $db->table('categories')->select();
		$cat=new Category(array('id','parentid','title','ctitle'));
		$cattree=$cat->getTree($catsql);//获取分类数据树结构
		$this->assign('cattree',$cattree);
		$this->display ();
	}
	
	function check(){		
		$db = model();
		$title=$this->textin($_POST['title']);		
		$id = intval($_POST['id']);
		if(empty($title)){
			echo 'false';
		}else{
			$cat = $db->table('categories')->where("title='{$title}'")->find();
			if(!empty($cat) && $cat['id']!=$id){
				echo 'false';
			}else{
				echo 'true';
			}
		}
	}
	function get_cat($model=''){
		$db = model();
		if(empty($model)){
			$catsql = $db->table('categories')->order("orderfield asc")->select();
		}else{
			$catsql = $db->table('categories')->where("model='$model'")->select();
		}
		$cat=new Category(array('id','parentid','title','ctitle'));
		$cattree=$cat->getTree($catsql);//获取分类数据树结构
		return $cattree;
	}
}
?>