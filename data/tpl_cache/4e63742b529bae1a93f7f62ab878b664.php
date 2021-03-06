<?php if (!defined('TPL_INC')) exit;?><?php $cpTemplate->display("common/header"); ?>
<script type="text/javascript">
$.validator.addMethod("vc",function(value){ 
   if(editor.getContent().length<10){ 
    return false; 
   } else{
	    return true;
	}  
},"内容必须大于10个字符");
$(document).ready(function(){	
	// validate signup form on keyup and submit
	var validator = $("#articleform").validate({
		rules: {
			thumb:{accept:"gif|png|jpg|jpeg"},
			title: {
 				required: true,
 				minlength: 1
			},
			content: {
 				vc: true
			},
			keywords:{
				maxlength:100
			},
			description:{
				maxlength:200
			}
			
		},
		messages: {
				thumb:{accept:"只能上传gif，png，jpg，jpeg格式的文件"},
				title: { 
					required: "请填写标题！",
 					minlength: $.format("至少要{0}个字符！") 								
				},
				content: { 
					vc: "内容必须大于10个字符！"							
				},
				keywords:{
					maxlength:$.format("最多{0}个字符！")
				},
				description:{
					maxlength:$.format("最多{0}个字符！")
				}
			
		},
		// the errorPlacement has to take the layout into account
		errorPlacement: function(error, element) {
			error.insertAfter(element.parent().find('label:first'));			
		},
		// set new class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE			
			label.html("&nbsp;").addClass("ok");
		}
	});

});

</script>


<div class="content"> <div class="box box-info">提示：添加内容分类 <?php echo $cat['title']; ?></div><a href="<?php echo url('article/lists',array('cid'=>$cat['id']) );?>" class="btn btn-blue">列 表</a>
  <form action="<?php echo url('article/add');?>" method="post" enctype="multipart/form-data" id="articleform" >
  	<p>
      <label for="thumb">缩略图</label>      <br>
      <input type="file" name="thumb" id="thumb" />
    </p>
    <p>
      <label for="title" class="required">标题</label>      <br>
      <input type="text" name="title" id="title" value="<?php echo $article['title']; ?>" class="half">
    </p>
    <p>
      <label for="content" class="required">内容</label>      <br>
      <textarea id="content" name="content" style="width:80%;min-height:400px;" ><?php echo $article['content']; ?></textarea>
<link href="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/js/editor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
      <script type="text/javascript" src="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/js/editor/umeditor.config.js"></script>
<script type="text/javascript" src="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/js/editor/umeditor.min.js"></script>
<script type="text/javascript" src="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/js/editor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
    var ue = UM.getEditor('content');
    
    //1.2.4以后可以使用一下代码实例化编辑器
    //UE.getEditor('myEditor')
</script>

    </p>
    <p>
      <label for="keywords">标签(关键字)</label><br>
      <input type="text" name="keywords" id="keywords" class="half">
    </p>
    <p>
      <label for="description">摘要</label><br>
      <textarea type="text" name="description" id="description" class="half small"></textarea>
    </p>
    <p>
      <input type="hidden" name="cid" value="<?php echo $cat['id']; ?>">
      <button type="submit" class="btn btn-green big">提交</button>      
    </p>
   <?php echo $_G['formhash']; ?>
  </form>
</div>
<?php $cpTemplate->display("common/footer"); ?>