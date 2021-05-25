<?php
//公共类
class shejiMod extends base{
	public function lists(){
		$db = model();
		if(empty($_GET['cid'])){
			$count = $db->table('sheji')->count();
			list($limit,$pagestring) = $this->page('',$count,10);
			$content = $db->table('sheji')->limit($limit)->select();
		}else{
			$cid = intval($_GET['cid']);
			$where['cid'] = $cid;
			$cat = $db->table('categories')->where("id=".$cid)->find();
			if(empty($cat)) $this->showmessage('没有找到分类',__REFERER__);
			//分页
			$count = $db->table('sheji')->where($where)->count();
			list($limit,$pagestring) = $this->page('',$count,10);
			
			$content = $db->table('sheji')->where($where)->order('id desc')->limit($limit)->select();
			
		}
		$this->assign('cat',$cat);
		$this->assign('pagestring',$pagestring);
		$this->assign('content',$content);

		$this->display ();
	}

	public function add(){		
		if(!empty($_POST['title'])){
			$this->do_add();
		}else{
			$db = model();
			$cid = intval($_GET['cid']);
			$cat = $db->table('categories')->where('id='.$cid)->find();			
			if(empty($cat)) $this->error('没有找到分类');
			$this->assign('cat',$cat);
			$this->assign('cattree',module('cat')->get_cat());
			$this->display();
		}

	}
	private function do_add(){		
		$db = model('sheji');				
		$data = $db->checkData();//数据验证	
		$error = $db->getError();
		if ($error) {
			$this->error($error);
		}		
		$data = $this->htmlin($data);
		$data['content'] = baidu::relative($data['content']);//绝对地址转为相对地址
		
		$data['thumb'] = $this->upfile();
		$sid = $db->data($data)->insert();		
		
		$this->success('添加成功');
	}

	public function edit(){
		$db = model();
		
		if(!empty($_POST['content'])){
			$this->do_edit();
			exit;
		}else{
			$cattree = module('cat')->get_cat('sheji');
			$id = intval($_GET[id]);
			$sheji = $db->table('sheji')->where('id='.$id)->find();			

			$sheji['content'] = baidu::absolute($sheji['content']);//相对地址转为绝对地址			
			$this->assign('sheji',$sheji);
			$this->assign('cattree',$cattree);

			$this->display();
		}
	}
	private function do_edit(){
		$id = intval($_POST['id']);
		$cid = intval($_POST['cid']);
		$db = model('sheji');				
		$data = $db->checkData();//数据验证	
		$error = $db->getError();
		if ($error) {
			$this->error($error);
		}		
		$data = $this->htmlin($data);
		$data['thumb'] = $this->upfile();
		if (empty($data['thumb'])) unset($data['thumb']);
		$data['content'] = baidu::relative($data['content']);//绝对地址转为相对地址
		
		$sid = $db->data($data)->where('id='.$id)->update();
		
		$this->success('修改成功',url('sheji/lists',array('cid'=>$cid) ));
	}

	public function delete()
	{
		$db = model('sheji');
		if($_GET['id']){$delarr[] = $_GET['id'];}
		if($_POST['id']){$delarr = $_POST['id'];}
		if(empty($delarr)) $this->error('请选择要删除的数据!');
		foreach($delarr as $id){
			$id = intval($id);
			$db->where('id='.$id)->delete();
		}		
		$this->success('删除成功!');
	}

	

	public function catdel($cid){
		$db = model('sheji');		
		$where = "sheji.cid=$cid and sheji.id=sheji_content.id";
		$db->where($where)->delete($table);
	}

	public function userdel($uid){	}

	public function upfile(){
		
		$upload = new UploadFile();

		//设置上传文件大小
		$upload->maxSize=1024*1024*2;//最大2M
		//设置上传文件类型
		$upload->allowExts  = explode(',','jpg,jpeg,gif,png');
		
		//设置附件上传目录
		$upload->savePath ='upload/'.date('Y/m/',$this->_G['timestamp']);
		FS::s_mkdir($upload->savePath);
		$upload->saveRule = time() . rand( 1 , 10000 );		

		if(!$upload->upload()){
			//捕获上传异常
			$state = $upload->getErrorMsg();
			return '';
		}else{
			$upfileinfo = $upload->getUploadFileInfo();			
			//取得成功上传的文件信息
			$fileName = $upfileinfo[0]['savepath'].$upfileinfo[0]['savename'];
			return $fileName;
			
		}
	}

	
	
	
}
?>