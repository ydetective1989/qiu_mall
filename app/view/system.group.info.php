<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/system.group.js?<?php echo date("Ymd");?>"></script>
</head>

<body>
<div class="info">

<table width="100%" class="title">
	<tr>
		<td class="tdleft bold">&nbsp;<?php echo ($_GET["do"]=="add")?"增加":"修改"; ?>岗位信息</td>
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
    <td width="20%" class="tdright">岗位名称：</td>
    <td><input type="text" name="name" id="name" class="input" value="<?php echo $info["name"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">有效状态：</td>
    <td><input type="radio" name="checked" value="1" <?php if($info["checked"]=="1"||$info["checked"]==""){ echo "checked"; }?>> 有效
    <input type="radio" name="checked" value="0" <?php if($info["checked"]=="0"){ echo "checked"; }?>> 无效</td>
  </tr>
  <?php if($levels){ foreach($levels AS $rs){?>
	<?php if($rs["tree"]){ ?>
  <tr>
    <td class="tdright" valign="top"><?php echo $rs["name"]?>：</td>
    <td class="level">
    <?php foreach($rs["tree"] AS $r){?>
    <span><input type="checkbox" name="grouplevel[]" value="<?php echo $r["id"];?>" <?php if($grouplevel[$r["id"]]==$r["id"]){ echo "checked"; }?> /> <?php echo $r["name"];?></span>
    <?php }?>
    </td>
  </tr>
  <?php }?>
  <?php }}?>
  <tr>
    <td class="" height="10"></td>
    <td class=""></td>
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
