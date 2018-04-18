<?php if($show=="lists"){?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.files.js?<?php echo date("YmdH");?>"></script>
</head>

<body scroll="no">

<?php if($list){?>
<div class="pics">
<?php foreach($list AS $rs){?>

<div>
<table width="100%">
	<tr>
		<td class="tdleft"><img src="http://upfile.paas.shui.cn/<?php echo $rs["files"];?>" style="float:left; margin-right:8px;" onclick="viewfiles('<?php echo base64_encode($rs["id"]);?>');" class="pointer">订单号：<a href="javascript:void(0);"  onclick="parent.parent.addTab('查看订单[<?php echo $rs["ordersid"];?>]','orders/views?id=<?php echo base64_encode($rs["ordersid"]);?>','orderview');"><?php echo $rs["ordersid"]?></a> <span class="green">[<?php echo $filetype[(int)$rs["type"]]["name"]?>]</span><br>
		说明：<span class="blue"><?php echo $rs["detail"]?></span><br>
		上传：<?php echo $rs["addname"]?><br>
		时间：<?php echo date("Y-m-d H:i",$rs["dateline"])?></td>
	</tr>
</table>
</div>

<?php }?>

<table width="100%">
	<tr>
		<td height="40" class="tdcenter"></td>
	</tr>
</table>

</div>
<?php if($page){ ?>
<div class="bottom_tools">
<table width="100%" class="pagenav bgheader">
	<tr>
		<td class="tdcenter"><?php echo $page;?></td>
	</tr>
</table>
</div>
<?php }?>

<?php }else{?>
<table width="100%">
	<tr>
		<td height="30" class="tdcenter">没有找到相关信息</td>
	</tr>
</table>
<?php }?>

</body>
</html>

<?php }else{?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.pic.js?<?php echo date("YmdH");?>"></script>
</head>
<body scroll="no">

<table width="100%" height="100%" >
  <tr>
    <td class="tools">
    	  <form method="post" name="searchFrm" id="searchFrm" action="">
          <input type="hidden" name="checked" id="checked" class="input" value="0">
          <span><input type="text" name="godate" id="godate" value="<?php echo $godate;?>" style="width:100px;text-align:center;" class="input"></span>
          <span><input type="text" name="todate" id="todate" value="<?php echo $todate;?>" style="width:100px;text-align:center;" class="input"></span>
          <span><select name="type" id="type" class="select">
          <option>全部类别</option>
          <?php foreach($filetype AS $rs){?>
          <option value="<?php echo $rs["id"]?>"><?php echo $rs["name"]?></option>
          <?php }?>
          </select></span>
          <span>订单号：<input type="text" name="ordersid" id="ordersid" value="" class="input" style="width:100px;"></span>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=1&val=salesTeams"></script>
		  <script type="text/javascript">var salesarea='';var salesid='';var saleuserid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
          <span><select name="salesarea" id="salesarea" class="select"></select>
	          <select name="salesid" id="salesid" class="select"></select>
          </span>
          <span><input type="button" class="button" onclick="search()" value="搜索资料"></span>
    	  </form>
    </td>
  </tr>

  <tr>
    <td class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td height="100%">
	  <table width="100%" height="100%">
		  <tr>
			<td height="100%"><iframe src="<?php echo $S_ROOT;?>orders/pic?show=lists" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe></td>
		  </tr>
	  </table>
	</td>
  </tr>
</table>
</body>
</html>
<?php }?>
