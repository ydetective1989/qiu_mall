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
    <td height="30" class="bgfocus tdcenter white"><?php echo ($_GET["do"]=="add")?"增加":"修改"; ?>商品信息</td>
  </tr>
</table>

<form method="post" name="editfrm" id="editfrm" action="">
<table width="100%" class="table">

  <tr>
    <td width="20%" class="tdright">商品名称：</td>
    <td><input type="text" name="title" id="title" class="input" value="<?php echo $info["title"]?>" style="width:80%;"></td>
  </tr>
  <tr>
    <td class="tdright">ERP名称：</td>
    <td><input type="text" name="erpname" id="erpname" class="input" value="<?php echo $info["erpname"]?>" style="width:80%;"> *</td>
  </tr>
  <tr>
    <td class="tdright">商品编码：</td>
    <td><input type="text" name="encoded" id="encoded" class="input" value="<?php echo $info["encoded"]?>" style="width:150px;"> *</td>
  </tr>
  <tr>
    <td class="tdright">商品型号：</td>
    <td><input type="text" name="models" id="models" class="input" value="<?php echo $info["models"]?>" style="width:150px;"> *</td>
  </tr>
  <tr>
    <td class="tdright">商品类别：</td>
    <td><select name="categoryid" id="categoryid" class="select">
    <option value="">选择类别</option>
    <?php foreach($cates AS $rs){?>
    <option value="<?php echo $rs["categoryid"]?>" <?php if($rs["categoryid"]==$info["categoryid"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
    <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="tdright">商品品牌：</td>
    <td><select name="brandid" id="brandid" class="select">
    <option value="">选择品牌</option>
    <?php foreach($brands AS $rs){?>
    <option value="<?php echo $rs["brandid"]?>" <?php if($rs["brandid"]==$info["brandid"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
    <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="tdright">市场价格：</td>
    <td><input type="text" name="price_users_a" id="price_users_a" class="input" value="<?php echo $info["price_users_a"]?>" style="width:120px;"> 元 *</td>
  </tr>
  <tr>
    <td class="tdright">销售价格：</td>
    <td><input type="text" name="price_users_c" id="price_users_c" class="input" value="<?php echo $info["price_users_c"]?>" style="width:120px;"> 元 *</td>
  </tr>
  <tr>
    <td class="tdright">商品单位：</td>
    <td><input type="text" name="units" id="units" class="input" value="<?php echo $info["units"]?>" style="width:100px;">
      <select name="select" class="select" onchange="document.editfrm.units.value=this.value">
      <option value="">选择</option>
      <option value="套">套</option>
      <option value="只">只</option>
      <option value="台">台</option>
      <option value="个">个</option>
      <option value="支">支</option>
      </select></td>
  </tr>
  <tr>
    <td class="tdright">商品产地：</td>
    <td><input type="text" name="locality" id="locality" class="input" value="<?php echo $info["locality"]?>" style="width:100px;"> *</td>
  </tr>
  <tr>
    <td class="tdright">商品信息：</td>
    <td><textarea name="detail" id="detail" class="textarea" style="width:80%;height:100px;"><?php echo $info["detail"]?></textarea></td>
  </tr>
  <tr>
    <td class="tdright">启用状态：</td>
    <td><input type="radio" name="checked" value="1" <?php if($info["checked"]=="1"||$info["checked"]==""){ echo "checked"; }?>> 启用
    <input type="radio" name="checked" value="0" <?php if($info["checked"]=="0"){ echo "checked"; }?>> 停用</td>
  </tr>
  <tr>
    <td class=""></td>
    <td class=""><input type="button" class="button" id="editbtn" onclick="editproduct()" value="<?php echo ($_GET["show"]=="add")?"增加":"修改"; ?>类目信息">
    <input type="button" class="btnwhite" onclick="location.href='<?php echo $urlto;?>'" value="返回上页"></td>
  </tr>
</table>
</form>

</div>
</body>
</html>
