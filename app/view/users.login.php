<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="<?php echo META_DESC;?>">
<meta name="author" content="<?php echo META_AUTHOR;?>">
<title><?php echo META_TITLE;?></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/users.login.js?<?php echo date("Ymd");?>"></script>
</head>
<body class="loginbg">

<table  width="100%" height="100%">
  <tr>
    <td height="100%">
      <form method="post" id="loginsubmit" action="" />
      <table width="100%" height="100" class="loginbg">
        <tr>
          <td height="220" class="tdcenter"></td>
        </tr>
        <tr>
          <td height="100" class="tdcenter loginicon" ></td>
        </tr>
      	<tr>
      	  <td class="loginbar uwhite bgwhite">用户名：<input type="text" name="username" id="username" class="input" style="width:150px;" align="absmiddle" />&nbsp;&nbsp;&nbsp;密码：<input type="password" name="password" id="password" class="input" style="width:150px;" align="absmiddle" />&nbsp;&nbsp;&nbsp;验证码：<input type="text" name="authnum" id="authnum" style="width:50px;" class="input" maxlength="5" align="absmiddle" />&nbsp;&nbsp;<img src="<?php echo $S_ROOT;?>authimg" id="authnums" class="pointer" onclick="getAuth();" style="height:24px;" align="absmiddle" alt="更换验证码" ></td>
      	</tr>
        <tr>
          <td height="90" class="tdcenter"><input type="button" class="loginbtn" onclick="login()" value="登录系统"></td>
        </tr>
        <tr>
          <td height="10" class="tdcenter"></td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
</table>

</body>
</html>
