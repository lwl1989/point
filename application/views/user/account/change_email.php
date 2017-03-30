
 
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $head-title; ?></title>
</head>
<body>
<form id="form1" name="form1" method="post" action="<?php echo site_url('user/account/change_email') ?>">
    <p>
        <label for="textfield"></label>      
		密码：<input type="password" name="password" id="textfield1" />
    </p>
    <p>
        旧邮箱：<input type="text" name="old_email" id="textfield2" />
	</p>
    <p>
        新邮箱：<input type="text" name="new_email" id="textfield3" />
    </p>
    <p>&nbsp; </p>
    <p> <input type="submit" name="submit" value="提交" /></p>
</form>

</body>
</html>