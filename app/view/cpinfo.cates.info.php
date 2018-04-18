<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/cpinfo.js?<?php echo date("Ymd");?>"></script>
</head>
<body>
<div class="info">

<table width="100%">
  <tr>
    <td height="30" class="bgfocus tdcenter white"><?php echo ($_GET["do"]=="add")?"增加":"修改"; ?>类目信息</td>
  </tr>
</table>

<form method="post" name="editfrm" id="editfrm" action="">
<table width="100%" class="table">

  <tr>
    <td width="30%" class="tdright">类目名称：</td>
    <td><input type="text" name="name" id="name" class="input" value="<?php echo $info["name"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">英文名称：</td>
    <td><input type="text" name="tags" id="tags" class="input" value="<?php echo $info["tags"]?>" style="width:250px;"> *</td>
  </tr>
  <tr>
    <td class="tdright">启用状态：</td>
    <td><input type="radio" name="checked" value="1" <?php if($info["checked"]=="1"||$info["checked"]==""){ echo "checked"; }?>> 启用
    <input type="radio" name="checked" value="0" <?php if($info["checked"]=="0"){ echo "checked"; }?>> 停用</td>
  </tr>
  <tr>
    <td class="tdright">类目介绍：</td>
    <td><textarea name="description" id="description" class="textarea" style="width:500px;height:50px;"><?php echo $info["description"]?></textarea></td>
  </tr>
  <tr>
    <td class=""></td>
    <td class=""><input type="button" class="button" id="editbtn" onclick="editcates()" value="<?php echo ($_GET["show"]=="add")?"增加":"修改"; ?>类目信息">
    <input type="button" class="btnwhite" onclick="location.href='<?php echo $urlto;?>'" value="返回上页"></td>
  </tr>
</table>
</form>

</div>
</body>
</html>
