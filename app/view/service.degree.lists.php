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
<div onclick="parent.frminfo.location.href='<?php echo $S_ROOT;?>service/degree?do=views&id=<?php echo ($rs["id"])?base64_encode($rs["id"]):"";?>&ordersid=<?php echo ($rs["ordersid"])?base64_encode($rs["ordersid"]):"";?>&jobsid=<?php echo ($rs["jobsid"])?base64_encode($rs["jobsid"]):"";?>';">
<table width="100%">
	<tr>
		<td class="tdleft">订单号:<?php echo $rs["ordersid"]?></td>
		<td class="tdright"><?php echo ($jobstype[$rs["jobstype"]]["name"])?$jobstype[$rs["jobstype"]]["name"]:"未知"?></td>
	</tr>
	<tr>
		<td class="tdleft" colspan="2"><?php echo $rs["provname"]." ".$rs["cityname"]." ".$rs["areaname"];?></td>
	</tr>
	<tr>
		<td class="tdleft" colspan="2"><?php if($_GET["status"]=="0"){ echo "回访时间："; }else{ echo "服务时间："; } ?><?php echo $rs["datetime"]?></td>
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
		<td class="tdcenter">没有找到相关信息</td>
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