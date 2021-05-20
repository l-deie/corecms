<?php if (!defined('TPL_INC')) exit;?><?php $cpTemplate->display("common/header"); ?>
<div class="content">  
  <a href="<?php echo url('cat/add');?>" class="btn btn-blue">添加分类</a>
  <script type="text/javascript">
$(function(){
	$("#chk_all").click(function(){
    	 $("input[name='catid[]']").attr("checked",$(this).attr("checked"));
		 $("#chk_all2").attr("checked",$(this).attr("checked"));
	});
	$("#chk_all2").click(function(){
    	 $("input[name='catid[]']").attr("checked",$(this).attr("checked"));
		 $("#chk_all").attr("checked",$(this).attr("checked"));
	});
});
</script>
 <form id="catform" method="post" action="<?php echo url('cat/del');?>">
  <table class="stylized full">
    <thead>
      <tr>
      	<th><input type="checkbox" name="chk_all" id="chk_all" />选择</th>
        <th>ID</th>
        <th>名称</th>       
        <th>模型</th> 
        <th>排序</th>  
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
     <?php $n=1;if(is_array($cattree)) foreach($cattree AS $val) { ?>
      <tr>
      	<td><input type="checkbox" name="catid[]" value="<?php echo $val['id']; ?>" /></td>
        <td><?php echo $val['id']; ?></td>
        <td><?php echo $val['ctitle']; ?></td>    
        <td><?php echo $val['model']; ?></td>
        <td><?php echo $val['orderfield']; ?></td>    
        <td><a href="<?php echo url('cat/del',array('id'=>$val['id']) );?>">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo url('cat/edit',array('id'=>$val['id']) );?>">修改</a></td>
      </tr>
     <?php $n++;}unset($n); ?>
    </tbody>
    <tfoot>
      <tr>
      	<td><input type="checkbox" name="chk_all" id="chk_all2" />选择</td>
        <td><input type="submit" value="删除选中" class="btn btn-red" /></td>
        <td></td>    
        <td></td>
        <td></td>    
        <td></td>
      </tr>    
    </tfoot>
  </table>
  </form>
</div>
<?php $cpTemplate->display("common/footer"); ?>