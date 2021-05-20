<?php if (!defined('TPL_INC')) exit;?>
<?php $cpTemplate->display("common/header"); ?>
<script src="<?php if(defined('__SITEROOT__')){echo __SITEROOT__;}else{echo '__SITEROOT__';} ?>/static/js/hialert/jquery.alert.js"></script>
<link rel="stylesheet" href="<?php if(defined('__SITEROOT__')){echo __SITEROOT__;}else{echo '__SITEROOT__';} ?>/static/js/hialert/css/alert.css" />

<script>
$(function(){
	$("tr:odd").addClass('odd');
	$('tr').hover(
		function(){
			$(this).addClass('hover')
		},
		function(){
			$(this).removeClass('hover')
		}
	);
	//复选框
	$("#chk_all").click(function(){
    	 $("input[name='id[]']").attr("checked",$(this).attr("checked"));
		 $("#chk_all2").attr("checked",$(this).attr("checked"));
	});
	$("#chk_all2").click(function(){
    	 $("input[name='id[]']").attr("checked",$(this).attr("checked"));
		 $("#chk_all").attr("checked",$(this).attr("checked"));
	});
	//删除确认
	$(".del").click(function(){		
	   var url = $(this).attr("href");
		hiConfirm('删除将不可恢复,你确认此操作吗?', '确认框', function(r) {
           if(r) window.location.href=url;
        });
		return false;
	});
	//提交删除表单数据
	$('#listsubmit').click(function(){
		if($("input[name='id[]']:checked").length>0){
			hiConfirm('删除将不可恢复,你确认此操作吗?', '确认框', function(r) {
			   if(r) $('#listform').submit();
			});	
		}else{
			hiAlert("请选择要删除的信息!","提示");
		}
	});
	
});


</script>
 
  <div class="content clearfix">  	
    <div class="box box-info">提示：你现在看到的是 <?php echo $cat['title']; ?> 下的所有文章列表</div>
    <a href="<?php echo url('article/add',array('cid'=>$cat['id']) );?>" class="btn btn-blue">添 加</a><br>
    <form action="<?php echo url('article/delete');?>" method="post" id="listform">
     <table class="stylized full">
    	<thead>
          <tr>
          <th width="50px"><input type="checkbox" name="chk_all" id="chk_all" /><label for="chk_all">全选</label></th>
      	  <th class="w50">ID</th>
      	  <th>标题</th>        
     	  <th class="w100">时间</th>
          <th class="w100">操作</th>
     	 </tr>
   		</thead>
    	<tbody>
     	<?php $n=1;if(is_array($content)) foreach($content AS $val) { ?>
     	 <tr>
         	<td><input type="checkbox" name="id[]" value="<?php echo $val['id']; ?>" /></td>
        	<td><?php echo $val['id']; ?></td>
        	<td><a href="<?php echo url('article/show',array('id'=>$val['id']) );?>" target="_blank"><?php echo $val['title']; ?></a></td>        
            <td><?php echo date('Y-m-d',$val['dateline']);?></td> 
        	<td><a href="<?php echo url('article/delete',array('id'=>$val['id']) );?>" class="del">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo url('article/edit',array('id'=>$val['id']) );?>">修改</a></td>
      	</tr>
     	<?php $n++;}unset($n); ?>
    	</tbody>
        <tfoot>
          <tr>
            <td><input type="checkbox" name="chk_all" id="chk_all2" /><label for="chk_all2">全选</label></td>
            <td><input type="button" value="删除选中" class="btn btn-red" id="listsubmit" /></td>
            <td></td>    
            <td></td>
            <td></td>    
          </tr>    
        </tfoot>
  	</table>
    <?php echo $_G['formhash']; ?>
    </form>
    <div class="page"><?php echo $pagestring; ?></div>
    
  	
  </div>
  
<?php $cpTemplate->display("common/footer"); ?>