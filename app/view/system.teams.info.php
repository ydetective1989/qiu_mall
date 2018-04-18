<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/system.teams.js?<?php echo date("Ymd");?>"></script>
<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=EC1bb4d2591cdc482c712b0626f63066&s=1"></script>
</head>
<body>
<div class="info">



<form method="post" name="editfrm" id="editfrm" action="">
<table width="100%" class="table">
  <tr>
    <td width="30%" class="tdright">机构名称：</td>
    <td><input type="text" name="name" id="name" class="input" value="<?php echo $info["name"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">机构副名称：</td>
    <td><input type="text" name="subname" id="subname" class="input" value="<?php echo $info["subname"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">级别目录：</td>
    <td><select name="parentid" id="parentid" class="select">
    <option value="0">机构根目录</option>
    	<?php foreach($list AS $rs){?>
    	<option value="<?php echo $rs["id"];?>" <?php if($info["parentid"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"];?></option>
    	<?php }?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="tdright">客户编码：</td>
    <td><input type="text" name="encoded" id="encoded" class="input" value="<?php echo $info["encoded"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">省份城市：</td>
    <td><script type="text/javascript" src="<?php echo $S_ROOT;?>json/areas"></script>
		  <script type="text/javascript">var provid='<?php echo $info["provid"]?>';var cityid='<?php echo $info["cityid"]?>';var areaid='<?php echo $info["areaid"]?>';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.areas.js"></script>
          <select name="provid" id="provid" style="width:120px;" class="select"></select>
	          <select name="cityid" id="cityid" style="width:120px;" class="select"></select>
	          <select name="areaid" id="areaid" style="width:120px;" class="select"></select>
			<select name="loops" id="loops" class="select" style="display:none;">
		    <option value="0">无需选择</option>
		    </select></td>
  </tr>
  <tr>
    <td class="tdright">联系地址：</td>
    <td><input type="text" name="address" id="address" class="input" value="<?php echo $info["address"]?>" style="width:80%;"></td>
  </tr>
  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/maps.dialog.js"></script>
  <tr>
    <td class="tdright">服务坐标：</td>
    <td><input type="text" name="point" id="point" class="input" value="<?php if($info["pointer"]){ echo $info["pointer"]; }?>" readonly style="width:200px;"><input type="button" class="button" onclick="mapsopen()" value="设置坐标"></td>
  </tr>
  <?php if($_GET["do"]=="after"){?>
  <tr>
    <td class="tdright">淡季接单量：</td>
    <td><input type="text" name="minplan" id="minplan" class="input" value="<?php echo (int)$info["minplan"]?>" style="width:100px;"></td>
  </tr>
  <tr>
    <td class="tdright">旺季接单量：</td>
    <td><input type="text" name="maxplan" id="maxplan" class="input" value="<?php echo (int)$info["maxplan"]?>" style="width:100px;"></td>
  </tr>
  <?php }?>
  <tr>
    <td class="tdright">联系电话：</td>
    <td><input type="text" name="phone" id="phone" class="input" value="<?php echo $info["phone"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">有效状态：</td>
    <td><input type="radio" name="checked" value="1" <?php if($info["checked"]=="1"||$info["checked"]==""){ echo "checked"; }?>> 有效
    <input type="radio" name="checked" value="0" <?php if($info["checked"]=="0"){ echo "checked"; }?>> 无效</td>
  </tr>
  <tr>
    <td></td>
    <td><input type="button" class="button" id="editbtn" onclick="editinfo()" value="<?php echo ($_GET["do"]=="add")?"增加":"修改"; ?>信息">
    <input type="button" class="btnwhite" onclick="location.href='<?php echo $urlto;?>'" value="返回上页"></td>
  </tr>
</table>
</form>

</div>
</body>
</html>