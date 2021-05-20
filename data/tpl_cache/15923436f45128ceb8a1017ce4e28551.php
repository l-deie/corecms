<?php if (!defined('TPL_INC')) exit;?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<link rel="stylesheet" href="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/css/core.css" />
<link rel="stylesheet" href="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/css/admin.css" />
<!--[if lt IE 9]>
<script src="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/js/html5.js"></script>
<script src="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/js/IE9.js"></script>
<![endif]-->
<script src="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/js/jquery.js"></script>
<script>var CMS_ROOT = '<?php if(defined('__ROOT__')){echo __ROOT__;}else{echo '__ROOT__';} ?>/';</script>
</head>
<body>
<div class="wrap"> 
  