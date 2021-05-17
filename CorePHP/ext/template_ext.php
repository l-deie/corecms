<?php

//模板扩展函数
function template_ext($template){
	$left = cpConfig::get('TPL_TEMPLATE_LEFT');
	$right = cpConfig::get('TPL_TEMPLATE_RIGHT');
	//php标签
	/*
	{php echo phpinfo();}	=>	<?php echo phpinfo(); ?>
	*/
	$template = preg_replace ( "/".$left."php\s+(.+)".$right."/", "<?php \\1?>", $template );

	//if 标签
	/*
	{if $name==1}		=>	<?php if ($name==1){ ?>
	{elseif $name==2}	=>	<?php } elseif ($name==2){ ?>
	{else}				=>	<?php } else { ?>
	{/if}				=>	<?php } ?>
	*/
	$template = preg_replace ( "/".$left."if\s+(.+?)".$right."/", "<?php if(\\1) { ?>", $template );
	$template = preg_replace ( "/".$left."else".$right."/", "<?php } else { ?>", $template );
	$template = preg_replace ( "/".$left."elseif\s+(.+?)".$right."/", "<?php } elseif (\\1) { ?>", $template );
	$template = preg_replace ( "/".$left."\/if".$right."/", "<?php } ?>", $template );


	//for 标签
	/*
	{for $i=0;$i<10;$i++}	=>	<?php for($i=0;$i<10;$i++) { ?>
	{/for}					=>	<?php } ?>
	*/
	$template = preg_replace("/".$left."for\s+(.+?)".$right."/","<?php for(\\1) { ?>",$template);
	$template = preg_replace("/".$left."\/for".$right."/","<?php } ?>",$template);

	//loop 标签
	/*
	{loop $arr $vo}			=>	<?php $n=1; if (is_array($arr) foreach($arr as $vo){ ?>
	{loop $arr $key $vo}	=>	<?php $n=1; if (is_array($array) foreach($arr as $key => $vo){ ?>
	{/loop}					=>	<?php $n++;}unset($n) ?>
	*/
	$template = preg_replace ( "/".$left."loop\s+(\S+)\s+(\S+)".$right."/", "<?php \$n=1;if(is_array(\\1)) foreach(\\1 AS \\2) { ?>", $template );
	$template = preg_replace ( "/".$left."loop\s+(\S+)\s+(\S+)\s+(\S+)".$right."/", "<?php \$n=1; if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>", $template );
	$template = preg_replace ( "/".$left."\/loop".$right."/", "<?php \$n++;}unset(\$n); ?>", $template );

	//函数 标签
	/*
	{date('Y-m-d H:i:s')}	=>	<?php echo date('Y-m-d H:i:s');?>
	{$date('Y-m-d H:i:s')}	=>	<?php echo $date('Y-m-d H:i:s');?>
	*/
	$template = preg_replace ( "/".$left."([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))".$right."/", "<?php echo \\1;?>", $template );
	$template = preg_replace ( "/".$left."(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))".$right."/", "<?php echo \\1;?>", $template );

	//变量/常量 标签
	/*
	{$name}	=>	<?php echo $name; ?>
	{CONSTANCE}	=> <?php echo CONSTANCE;?> 或 {CON_STANCE}	=> <?php echo CON_STANCE;?>
	*/
	/*$template = preg_replace ( "/".$left."(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)".$right."/", "<?php echo \\1;?>", $template );*/	
	$template = preg_replace ( "/".$left."([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>", $template );
	return $template;
}
?>