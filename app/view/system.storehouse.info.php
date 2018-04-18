<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/storehouse.js?<?php echo date("Ymd");?>"></script>
</head>
<body>
<div class="info">

<table width="100%">
  <tr>
    <td height="30" class="bgfocus tdcenter white"><?php echo ($_GET["show"]=="add")?"增加":"修改"; ?>仓库</td>
  </tr>
</table>

<form method="post" name="editfrm" id="editfrm" action="">
<table width="100%" class="table">

  <tr>
    <td width="40%" class="tdright">仓库名称：</td>
    <td><input type="text" name="name" id="name" class="input" value="<?php echo $info['name']?>" style="width:250px;"> *</td>
  </tr>
  <tr>
    <td class="tdright">仓库编码：</td>
    <td><input type="text" name="encoded" id="encoded" class="input" value="<?php echo $info["encoded"]?>" style="width:250px;"> *</td>
  </tr>
  <tr>
    <td class="tdright">排序：</td>
    <td><input type="text" name="orderd" id="orderd" class="input" value="<?php echo $info["orderd"]?>" style="width:250px;"></td>
  </tr>
  <!-- <tr>
    <td class="tdright">状态：</td>
    <td>
 <input type="radio" name="hide" id="hide" class="input" value="1" <?php if ($info["hide"]=="1") { echo "checked='checked'";}?> >启用
 <input type="radio" name="hide" id="hide" class="input" value="0" <?php if ($info["hide"]=="0") { echo "checked='checked'";}?>>不启用
    </td>
  </tr> -->
  <tr>
    <td class=""></td>
    <td class=""><input type="button" class="button" id="editbtn" onclick="editinvoice()" value="<?php echo ($_GET["show"]=="add")?"增加":"修改"; ?>仓库信息">
    <input type="button" class="btnwhite" onclick="location.href='<?php echo $S_ROOT;?>system/storehouse?show=lists'" value="返回上页"></td>
  </tr>
</table>
</form>

</div>
</body>
</html>
