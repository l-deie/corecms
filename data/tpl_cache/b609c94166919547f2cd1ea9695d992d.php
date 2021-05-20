<?php if (!defined('TPL_INC')) exit;?><?php $cpTemplate->display("common/header"); ?>

<div class="content">

<div class="box box-info">网站基本信息</div>
    <p><label for="title">程序版本</label>
    CoreCms Release 20130808</p>
    <p><label for="title">服务器域名及端口</label>
    <?php echo $siteinfo['domain']; ?></p>
    <p><label for="title">您当前的ip</label>
    <?php echo $siteinfo['addr']; ?></p>
    <p><label for="keywords">服务器系统及 PHP</label>
   <?php echo $siteinfo['server']; ?></p>
    <p><label for="description">服务器软件</label>
    <?php echo $siteinfo['serversoft']; ?></p>
    <p><label for="email">服务器 MySQL 版本</label>
    <?php echo $siteinfo['mysql']; ?></p>
    <p><label for="personality">上传许可</label>
    <?php echo $siteinfo['upload']; ?></p>
    <p><label for="icp">当前数据库尺寸</label>
    <?php echo $siteinfo['dbsize']; ?></p>
    <p><label for="salt">当前附件尺寸</label>
    <?php echo $siteinfo['attachments']; ?></p>
    
    

</div>
<?php $cpTemplate->display("common/footer"); ?>