<?php if (!defined('TPL_INC')) exit;?><!DOCTYPE html>
<!--STATUS OK-->
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title><?php echo $article['title']; ?></title>
<link href="<?php if(defined('__TEMPLATE__')){echo __TEMPLATE__;}else{echo '__TEMPLATE__';} ?>/css/reset.css" rel="stylesheet" type="text/css">
<link href="<?php if(defined('__TEMPLATE__')){echo __TEMPLATE__;}else{echo '__TEMPLATE__';} ?>/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="wrap">
<div class="header">
<div class="nav">
<ul>
<li><a href="<?php if(defined('__ROOT__')){echo __ROOT__;}else{echo '__ROOT__';} ?>/">网站首页</a></li>
<li><a href="<?php echo url('article/view',array('id'=>1) );?>">公司简介</a></li>
<li><a href="<?php echo url('article/view',array('id'=>4) );?>">特别推荐</a></li>
<li><a href="<?php echo url('article/view',array('id'=>6) );?>">加拿大概况</a></li>
<li><a href="<?php echo url('article/view',array('id'=>10) );?>">加拿大联邦移民</a></li>
<li><a href="<?php echo url('article/view',array('id'=>15) );?>">曼尼托巴省提名</a></li>
</ul>
</div>
</div>
<div class="subnav">
<ul>
<?php $n=1;if(is_array($list)) foreach($list AS $val) { ?>
<li<?php if($val['id']==$_GET['id']) { ?> class="select"<?php } ?>>
<a href="<?php echo url('article/view',array('id'=>$val['id']) );?>"><?php echo $val['title']; ?></a>
</li>
<?php $n++;}unset($n); ?>
</ul>
</div>
<div class="content"><?php echo $article['content']; ?></div>
<div class="footer">加华国际咨询中心    加拿大专业移民机构</div>
</div>
</body>
</html>
