<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/system.users.editinfo.js?<?php echo date("Ymd");?>"></script>
</head>
<body>
<div class="info">

<table width="100%">
  <tr>
    <td height="30" class="tdcenter bgtips">个人信息管理</td>
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
    <td class="tdright">姓名：</td>
    <td><?php echo $info["name"]?></td>
  </tr>
  <tr>
    <td class="tdright">系统编号：</td>
    <td><?php echo $info["worknum"]?></td>
  </tr>
  <tr>
    <td colspan="2" class="tdright"><hr></hr></td>
  </tr>
  <tr>
    <td class="tdright">新密码设置：</td>
    <td><input type="password" name="password" id="password" class="input" value="" style="width:250px;"> * 不修改密码请留空！</td>
  </tr>
  <tr>
    <td class="tdright">密码确认：</td>
    <td><input type="password" name="rpassword" id="rpassword" class="input" value="" style="width:250px;"></td>
  </tr>
  <tr>
    <td colspan="2" class="tdright"><hr></hr></td>
  </tr>
  <tr>
    <td class="tdright">手机号码：</td>
    <td><input type="text" name="mobile" id="mobile" class="input" value="<?php echo $info["mobile"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">电子邮箱：</td>
    <td><input type="text" name="email" id="email" class="input" value="<?php echo $info["email"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class=""></td>
    <td class=""><input type="button" class="button" id="editbtn" onclick="editinfo()" value="<?php echo ($_GET["do"]=="add")?"增加":"修改"; ?>信息">
    <input type="button" class="btnwhite" onclick="location.href='<?php echo $urlto;?>'" value="返回上页"></td>
  </tr>
</table>
</form>

</div>
</body>
</html>