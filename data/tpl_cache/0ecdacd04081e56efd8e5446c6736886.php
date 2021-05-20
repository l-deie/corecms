<?php if (!defined('TPL_INC')) exit;?><!DOCTYPE html>
<!--STATUS OK-->
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>加华国际咨询中心</title>
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
<div class="banner">
<div class="bg">
<img src="<?php if(defined('__TEMPLATE__')){echo __TEMPLATE__;}else{echo '__TEMPLATE__';} ?>/img/banner.jpg" width="925" height="527"><div class="qiu"><img src="<?php if(defined('__TEMPLATE__')){echo __TEMPLATE__;}else{echo '__TEMPLATE__';} ?>/img/qiu.png" width="367" height="367"></div>
</div>
</div>
<div class="phone1">
<h2>中国总部：VIP客户24小时专线：1581578855</h2>
<p>电话：0750-5566020   传真：0750-5566021 邮箱：jiahua@cachina.ca<br>
地址：中国广东省台山市台城荣华路荣华花园昌盛楼111号</p>
</div>
<div class="phone2">
<h2>加拿大总部：24小时招生专线（204）294-1314</h2>
<p>Tel：(204)417-8787   Fax：(204)417-8785   Email：jiahua@cachina.ca<br>
Add：206-1345 Pembina HighwayWinnipeg Manitoba CANADA R3T 2B6</p>
</div>
<div class="footer">加华国际咨询中心    加拿大专业移民机构</div>
</div>
</body>
</html>
