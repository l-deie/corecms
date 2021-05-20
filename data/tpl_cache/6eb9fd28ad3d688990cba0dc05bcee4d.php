<?php if (!defined('TPL_INC')) exit;?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/css/core.css" />
        <link rel="stylesheet" href="<?php if(defined('__PUBLIC__')){echo __PUBLIC__;}else{echo '__PUBLIC__';} ?>/css/admin.css" />
    </head>
    <body>        
        <div class="loginbox">            
            <form id="loginform" class="form-vertical" method="POST" action="<?php echo url('login/do_login');?>">
				<h1 class="text-red ta-center">后台登陆</h1>
                <label class="left"><i class="icon-user"></i></span><input name="username" type="text" placeholder="用户名" /></label>
            	<label class="right"><i class="icon-lock"></i></span><input name="password" type="password" placeholder="密码" /></label>
                <div >
                    <input type="submit" class="btn btn-success right" value="登录" />
                </div>
            </form>            
        </div>        
    </body>
</html>
