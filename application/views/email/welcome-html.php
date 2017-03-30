<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Welcome to <?php echo $site_name; ?>!</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Welcome to <?php echo $site_name; ?>!</h2>
谢谢你加入 <?php echo $site_name; ?>. 为了更安全的访问 <?php echo $site_name; ?>，我们给您列举出了登录方法<br />
登录账号，请点击下面的链接:<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/auth/login/'); ?>" style="color: #3366cc;">Go to <?php echo $site_name; ?> 现在!</a></b></big><br />
<br />
    如果链接不起作用，请复制链接到您的浏览器地址栏:<br />
    <nobr><a href="<?php echo site_url('/auth/login/activate/'.$email_activate_key); ?>" style="color: #3366cc;"><?php echo site_url('/auth/login/activate/'.$email_activate_key); ?></a></nobr><br />
<br />
<br />
    <?php if (strlen($username) > 0) { ?>您的用户名: <?php echo $username; ?><br /><?php } ?>
    您的注册邮箱: <?php echo $email; ?><br />
    <?php /* Your password: <?php echo $password; ?><br /> */ ?>
    <br />
    <br />
    祝您工作、生活愉快!<br />
    <?php echo $site_name; ?> 团队
</td>
</tr>
</table>
</div>
</body>
</html>