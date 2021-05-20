<?php if (!defined('TPL_INC')) exit;?><?php $cpTemplate->display("common/header"); ?>  
<script>
$(function(){
	$('li a').click(function(){
		$('li a').removeClass('hover');
		$(this).addClass('hover');
	});
});
</script>
  <header>
    <h1><a href="<?php if(defined('__ROOT__')){echo __ROOT__;}else{echo '__ROOT__';} ?>" target="_blank"><?php echo $_G['site']['title']; ?>管理后台</a></h1>  
    <nav>
    	<ul>
         <li><a href="<?php echo url('index/left');?>" target="menu">内容管理</a></li>
         <li><a href="<?php echo url('cat/index');?>" target="main">栏目管理</a></li>
     	 <li><a href="<?php echo url('member/index');?>" target="main">用户管理</a></li>
         <li><a href="<?php echo url('index/group');?>" target="menu">权限管理</a></li>
     	 <!--<li><a href="<?php echo url('index/system');?>" target="menu">系统工具</a></li>-->   
         <li><a href="<?php echo url('login/logout');?>" target="_parent">退出</a></li>  	     
   	 	</ul>
 	 </nav>  
  </header>
<?php $cpTemplate->display("common/footer"); ?> 