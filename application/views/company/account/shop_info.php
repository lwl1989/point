
 
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
      <head>
         <meta charset="utf-8">
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <title><?php echo $head-title; ?></title>
      </head>
<body>
  <form id="form1" name="form1" method="post" action="<?php echo site_url('user/account/change_email') ?>">
    <p>
        <label for="textfield"></label>      
		地址：<input type="text" name="address" id="textfield1" />
    </p>
    <p>
        ???:<input type="text" name="lng" id="textfield2" />
	</p>
    <p>
        ???:<input type="text" name="lat" id="textfield3" />
    </p>
	<p>    
		公司名：<input type="text" name="company_name" id="textfield4" />
    </p>
    <p>
        ???:<input type="text" name="charge" id="textfield5" />
	</p>
    <p>
        数量：<input type="text" name="number" id="textfield6" />
    </p>
	<p>
        电话；<input type="text" name="mobile" id="textfield7" />
    </p>
    <p>&nbsp; </p>
    <p> <input type="submit" name="submit" value="提交" /></p>
  </form>

</body>
</html>