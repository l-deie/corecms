<?php
//公共类
class onepageMod extends base{
	public function lists(){
		$id = intval($_GET['cid']);
		//查找分类
		$db_cat = model('categories');
		$where = array(
		'id'=>$id,
		);
		$cat = $db_cat->where($where)->find();
		if (!$cat) {
			$this->error('参数错误');
		}
		//查找单页
		$db = model('onepage');
		$where = array(
		'id'=>$id,
		);
		$content = $db->where($where)->find();
		//没有单页就创建
		if (!$content) {
			$content = array(
			'id'=>$id,
			'cid'=>$id,
			'title'=>$cat['title'],
			'keywords'=>$cat['keywords'],
			'description'=>$cat['description'],
			'dateline'=>$this->_G['timestamp'],
			'editdate'=>$this->_G['timestamp'],
			'authorid'=>$this->_G['member']['uid'],
			);
			$db->data($content)->insert();
		}
		$content['content'] = baidu::absolute($content['content']);//相对地址转为绝对地址
		$this->assign('cat',$cat);
		$this->assign('content',$content);
		$this->display ();
	}

	public function edit(){
		$db = model('onepage');
		$data = $db->clear('id')->checkData();//数据验证

		$error = $db->getError();
		if ($error) {
			$this->error($error);
		}
		$data['thumb'] = $this->upfile();
		$data['content'] = baidu::relative($data['content']);//相对地址转为绝对地址
		if (empty($data['thumb'])) unset($data['thumb']);
		$where['id']=intval($_POST['id']);
		$db->where($where)->data($data)->update();
		$this->success('更新成功');

	}

	public function catdel($cid){
		$db = model('onepage');
		$where = "cid=".$cid;
		$db->where($where)->delete();
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