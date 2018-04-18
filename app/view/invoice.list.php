<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
</head>
<body>

<div class="lists">
<?php if($list){ ?>
<?php foreach($list AS $rs){?>
<div onclick="parent.frminfo.location.href='<?php echo $S_ROOT;?>invoice/views?id=<?php echo base64_encode($rs["id"]);?>';">
<table width="100%">
	<tr>
		<td class="tdleft" colspan="2"><?php echo plugin::cutstr($rs["title"],15,"");?></td>
	</tr>
	<tr>
		<td class="tdleft gray" colspan="2"><?php echo plugin::cutstr($rs["catename"],15,"");?></td>
	</tr>
	<tr>
		<td class="tdleft gray">订单号：<?php echo (int)$rs["ordersid"];?></td>
		<td class="tdright gray"><span class="red"><?php echo $rs["price"];?></span>元</td>
	</tr>
	<tr>
		<td class="tdleft gray"><span class="<?php echo $checktype[(int)$rs["checked"]]["color"];?>"><?php echo $checktype[(int)$rs["checked"]]["name"];?></span></td>
		<td class="tdright gray"><span class="<?php echo $worktype[(int)$rs["worked"]]["color"];?>"><?php echo $worktype[(int)$rs["worked"]]["name"];?></span></td>
	</tr>
</table>
</div>
<?php }?>
<table width="100%">
	<tr>
		<td class="tdcenter" height="30"></td>
	</tr>
</table>
<?php }else{?>
<table width="100%">
	<tr>
		<td class="tdcenter">没有找到相关清单</td>
	</tr>
</table>
<?php }?>
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

</body>
</html>
