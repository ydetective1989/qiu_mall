<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
</head>
<body>

<div class="forms">

<?php if($_GET["views"]=="1"){?>

<?php }else{?>

<?php if($list){ ?>

<table width="100%" class="tdcenter">
	<tr class="bgtips">
		<td width="120" class="tdcenter" height="30">订单编号</td>
		<td width="120" class="tdcenter">销售类别</td>
		<td width="100" class="tdcenter" height="30">订购日期</td>
		<td width="150" class="tdcenter">客户姓名</td>
		<td class="tdleft">联系地址</td>
		<td width="150" class="tdleft">销售来源</td>
		<td width="100" class="tdcenter">订单状态</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas pointer" onclick="location.href='<?php echo $S_ROOT;?>orders/views?id=<?php echo base64_encode($rs["id"]);?>';">
		<td class="tdcenter" height="30"><?php echo $rs["id"];?></td>
		<td class="tdcenter"><?php echo $ordertype[(int)$rs["type"]]["name"];?></td>
		<td class="tdcenter"><?php echo $rs["datetime"];?></td>
		<td class="tdcenter"><?php echo $rs["name"];?></td>
		<td class="tdleft"><?php echo plugin::cutstr($rs["address"],"20");?></td>
		<td class="tdleft"><?php echo plugin::cutstr($rs["salename"],"10");?></td>
		<td class="tdcenter<?php echo " ".$statustype[$rs["status"]]["color"];?>"><?php echo $statustype[$rs["status"]]["name"];?></td>
	</tr>
	<?php }?>
</table>

<table width="100%">
	<tr>
		<td class="tdcenter" height="30"></td>
	</tr>
</table>
<?php }else{?>
<table width="100%">
	<tr>
		<td class="tdcenter">没有找到相关订单</td>
	</tr>
</table>
<?php }?>


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
