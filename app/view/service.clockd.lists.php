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
<div onclick="parent.frminfo.location.href='<?php echo $S_ROOT;?>service/clockd?do=views&id=<?php echo ($rs["id"])?base64_encode($rs["id"]):"";?>&ordersid=<?php echo ($rs["ordersid"])?base64_encode($rs["ordersid"]):"";?>';">
<table width="100%">
	<tr>
		<td class="tdleft">订单号:<?php echo $rs["ordersid"]?></td>
		<td class="tdright"><?php switch($rs["stars"]){
			case "2": echo "★★☆☆☆"; break;
			case "3": echo "★★★☆☆"; break;
			case "4": echo "★★★★☆"; break;
			case "5": echo "★★★★★"; break;
			default : echo "★☆☆☆☆";
		}?></td>
	</tr>
	<!-- <?php echo $rs["id"];?> -->
	<tr>
		<td class="tdleft" colspan="2"><?php echo $rs["provname"]." ".$rs["cityname"]." ".$rs["areaname"];?></td>
	</tr>
	<tr>
		<td class="tdleft" colspan="2"><?php echo $rs["address"];?></td>
	</tr>
	<tr>
        <td class="tdleft" colspan="2">预提醒时间：<?php echo $rs["datetime"]?></td>
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
		<td class="tdcenter">没有找到相关订单</td>
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
