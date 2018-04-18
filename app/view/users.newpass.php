<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>更新登录密码</title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/users.newpass.js?<?php echo date("Ymd");?>"></script>
</head>
<body>
<div class="info">

<table width="100%">
  <tr>
    <td height="30" class="tdcenter bgheader">重置我的登录密码</td>
  </tr>
</table>

<form method="post" name="editfrm" id="editfrm" action="">
<table width="100%" class="table">

  <tr>
    <td width="40%" height="5" class="tdright"></td>
    <td class="red bold"></td>
  </tr>

  <tr>
    <td class="tdright">用户帐号：</td>
    <td class="red bold"><?php echo $info["username"]?></td>
  </tr>
  <tr>
    <td class="tdright">当前密码：</td>
    <td><input type="password" name="oldpasswd" id="oldpasswd" class="input" value="" style="width:180px;"> * </td>
  </tr>
  <tr>
    <td colspan="2" class="tdright"><hr></hr></td>
  </tr>
  <tr>
    <td class="tdright">新密码设置：</td>
    <td><input type="password" name="password" id="password" class="input" value="" style="width:180px;"> * </td>
  </tr>
  <tr>
    <td class="tdright">密码确认：</td>
    <td><input type="password" name="rpassword" id="rpassword" class="input" value="" style="width:180px;"></td>
  </tr>
  <tr>
    <td class=""></td>
    <td class=""><input type="button" class="button" id="editbtn" onclick="editinfo()" value="更新登录密码"></td>
  </tr>
</table>
</form>

</div>
</body>
</html>