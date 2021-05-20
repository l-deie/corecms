<?php if (!defined('TPL_INC')) exit;?><?php $cpTemplate->display("common/header"); ?> 
<style>body{background:#DDEAF9;padding:10px;}</style>
<link rel="stylesheet" href="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/js/dtree/dtree.css" />
<script>var IMGROOT = '<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>'</script>
<script src="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/js/dtree/dtree.js"></script>

	<p><a href="javascript: d.openAll();">全部展开</a> | <a href="javascript: d.closeAll();">全部关闭</a> | <a href="javascript:window.location.reload()">刷新</a></p>
	<script type="text/javascript">
	<!--
		d = new dTree('d');
		<?php if(CP_ACTION=='left') { ?>
		d.add(0,-1,'内容管理');		
		<?php $n=1;if(is_array($list)) foreach($list AS $v) { ?>
					d.add(<?php echo $v['id']; ?>,<?php echo $v['parentid']; ?>,'<?php echo $v['title']; ?>','<?php echo $v['url']; ?>','','main');
		<?php $n++;}unset($n); ?>
		<?php } ?>
		
		<?php if(CP_ACTION=='group') { ?>
		d.add(0,-1,'权限管理');		
		<?php $n=1;if(is_array($list)) foreach($list AS $v) { ?>
					d.add(<?php echo $v['id']; ?>,<?php echo $v['parentid']; ?>,'<?php echo $v['title']; ?>','<?php echo $v['url']; ?>','','main');
		<?php $n++;}unset($n); ?>
		<?php } ?>
 			
 				/*d.add(22,0,'Node22','example01.html');
		d.add(23,22,'Node22','example01.html');
		d.add(3,1,'Node 1.1','example01.html');
		d.add(4,0,'Node 3','example01.html');
		d.add(5,3,'Node 1.1.1','example01.html');
		d.add(6,5,'Node 1.1.1.1','example01.html');
		d.add(7,0,'Node 4','example01.html');
		d.add(8,1,'Node 1.2','example01.html');*/	

		document.write(d);
		//-->
	</script>



<?php $cpTemplate->display("common/footer"); ?> 