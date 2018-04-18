<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/system.level.js?<?php echo date("Ymd");?>"></script>
</head>
<body>
<div class="info">

<table width="100%" class="title">
	<tr>
		<td class="tdleft bold">&nbsp;<?php echo ($_GET["do"]=="add")?"增加":"修改"; ?>权限信息</td>
		<td class="tdright"><input type="button" class="button" onclick="location.href='<?php echo $urlto;?>'" value="返回上页"></td>
	</tr>
</table>

<table width="100%">
  <tr>
    <td colspan="3" class="headerfocus bgfocus"></td>
  </tr>
</table>

<form method="post" name="editfrm" id="editfrm" action="">
<table width="100%" class="table">
  <tr>
    <td width="30%" class="tdright">权限名称：</td>
    <td><input type="text" name="name" id="name" class="input" value="<?php echo $info["name"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">权限目录：</td><!-- <option value="0">权限根目录</option> -->
    <td><select name="parentid" id="parentid" class="select">
    <option value="0">权限根目录</option>
    	<?php foreach($list AS $rs){?>
    	<option value="<?php echo $rs["id"];?>" <?php if($info["parentid"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"];?></option>
    	<?php }?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="tdright">MOD参数：</td>
    <td><input type="text" name="reqmod" id="reqmod" class="input" value="<?php echo $info["reqmod"]?>" style="width:250px;"> * 根目录无需设置 MOD,AC,DO</td>
  </tr>
  <tr>
    <td class="tdright">AC参数：</td>
    <td><input type="text" name="reqac" id="reqac" class="input" value="<?php echo $info["reqac"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">DO参数：</td>
    <td><input type="text" name="reqdo" id="reqdo" class="input" value="<?php echo $info["reqdo"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">菜单显示：</td>
    <td><input type="radio" name="naved" value="1" <?php if($info["naved"]=="1"||$info["naved"]==""){ echo "checked"; }?>> 显示
    <input type="radio" name="naved" value="0" <?php if($info["naved"]=="0"){ echo "checked"; }?>> 隐藏</td>
  </tr>
  <tr>
    <td class="tdright">链接参数：</td>
    <td><input type="text" name="urlto" id="urlto" class="input" value="<?php echo $info["urlto"]?>" style="width:500px;"></td>
  </tr>
  <tr>
    <td class="tdright">有效状态：</td>
    <td><input type="radio" name="checked" value="1" <?php if($info["checked"]=="1"||$info["checked"]==""){ echo "checked"; }?>> 有效
    <input type="radio" name="checked" value="0" <?php if($info["checked"]=="0"){ echo "checked"; }?>> 无效</td>
  </tr>
  <tr>
    <td class="tdright">管理员权限：</td>
    <td><input type="radio" name="isadmin" value="1" <?php if($info["isadmin"]=="1"){ echo "checked"; }?>> 使用
    <input type="radio" name="isadmin" value="0" <?php if($info["isadmin"]=="0"||$info["isadmin"]==""){ echo "checked"; }?>> 不使用</td>
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