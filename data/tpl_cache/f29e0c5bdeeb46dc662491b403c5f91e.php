<?php if (!defined('TPL_INC')) exit;?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理后台</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>*{margin:0;padding:0;}</style>
</head>
<body scroll="no">
<table cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td colspan="2" height="80"><iframe src="<?php echo url('index/top');?>" name="header" width="100%" height="80" scrolling="no" frameborder="0" ></iframe></td>
	</tr>
	<tr>
		<td valign="top" width="220"><iframe src="<?php echo url('index/left');?>" name="menu" target="main" width="220" height="100%" scrolling="no" frameborder="0"></iframe></td>
		<td valign="top"><iframe src="<?php echo url('index/main');?>" name="main" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow:visible;"></iframe></td>
	</tr>
</table>
</body>
</html>
