<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/clockd.js?<?php echo date("Ymd");?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/message.js?<?php echo date("Ymd");?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.views.js?<?php echo date("YmdHi")?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.plugin.js?<?php echo date("YmdHi")?>"></script>
</head>
<body>
<div class="info">
<table width="100%" class="title">
	<tr>
		<td class="tdleft bold size14">&nbsp;订单编号：[<?php echo (int)$orderinfo["id"];?>]</td>
		<td class="tdright">
		<?php if($info){?>
		<input type="button" value="提醒操作" class="btngreen" onclick="clocked('<?php echo base64_encode($info["id"]);?>');" />
		<?php }?>
		<input type="button" value="增加提醒记录" class="btnred" onclick="clockdinfo(0);" />
    <input type="button" value="操作记录" class="btnorange" onclick="addlogs();" />
    <!-- <input type="button" value="更正订单类别" class="btngreen" onclick="upctype('<?php echo base64_encode($orderinfo["id"])?>');" /> -->
		<input type="button" value="关闭订单提醒" class="btnviolet" onclick="clockedclose('<?php echo base64_encode($orderinfo["id"]);?>');" />
		<input type="button" value="订单完成" class="button" onclick="completed('<?php echo base64_encode($orderinfo["id"]);?>');" />
		<input type="button" value="新建服务订单" class="btnsky" onclick="location.href='<?php echo $S_ROOT;?>orders/add?addtype=cc&clockid=<?php echo ($info["id"])?base64_encode($info["id"]):"";?>&id=<?php echo base64_encode($orderinfo["id"]);?>'" />
		</td>
	</tr>
</table>

<table width="100%">
  <tr>
    <td colspan="3" class="headerfocus bgfocus"></td>
  </tr>
</table>

<table width="100%" class="table">
  <input type="hidden" name="id" id="id" value="<?php echo ($info["id"])?base64_encode($info["id"]):"";?>" />
  <input type="hidden" name="clock_ordersid" id="clock_ordersid" value="<?php echo ($orderinfo["id"])?base64_encode($orderinfo["id"]):"";?>" />

  <?php if($orderinfo){ ?>
  <?php $dateline = time()-86400*15; if($info["workdateline"]>$dateline||$usertype=="1"||!$info["workdateline"]){?>

	<?php if($info){ ?>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">提醒信息</td>
  </tr>
  <tr>
    <td width="15%" class="tdright">提醒时间：</td>
    <td width="35%"><?php echo $info["datetime"];?> [周期:<?php echo $info["cycle"];?>天]</td>
    <td width="15%" class="tdright">提醒级别：</td>
    <td width="35%"><?php switch($info["stars"]){
			case "2": echo "★★☆☆☆"; break;
			case "3": echo "★★★☆☆"; break;
			case "4": echo "★★★★☆"; break;
			case "5": echo "★★★★★"; break;
			default : echo "★☆☆☆☆";
		}?></td>
  </tr>
  <tr>
    <td class="tdright">提醒内容：</td>
    <td colspan="3"><?php echo $info["clockinfo"];?></td>
  </tr>
  <tr>
    <td class="tdright">提醒备注：</td>
    <td colspan="3"><?php echo $info["detail"];?></td>
  </tr>
  <?php if($info["worked"]){?>
  <tr>
    <td width="150" class="tdright">提醒状态：</td>
    <td><?php echo ($info["worked"])?"已提醒":"未提醒";?></td>
    <td class="tdright">有效状态：</td>
    <td width="150"><?php echo ($info["checked"])?"有效":"不再提醒";?></td>
  </tr>
  <tr>
    <td class="tdright">服务批注：</td>
    <td colspan="3"><?php echo $info["workdetail"];?></td>
  </tr>
  <tr>
    <td width="150" class="tdright">操作时间：</td>
    <td><?php echo date("Y-m-d H:i:s",$info["workdate"]);?></td>
    <td class="tdright">操作人：</td>
    <td width="150"><?php echo $info["workuname"]?></td>
  </tr>
  <?php }?>
  <?php }?>

  <tr class="bgtips">
    <td colspan="4" class="tdcenter">订单信息</td>
  </tr>
  <tr>
    <td width="15%" class="tdright">订单编号：</td>
    <td width="35%"><a href="<?php echo $S_ROOT;?>orders/views?id=<?php echo base64_encode($orderinfo["id"]);?>"><?php echo $orderinfo["id"];?></a></td>
    <td width="15%" class="tdright"></td>
    <td width="35%"></td>
  </tr>
  <tr>
    <td class="tdright">订单类型：</td>
    <td><?php echo $ordertype[$orderinfo["type"]]["name"];?><span class="red"><?php if($orderinfo["parentid"]=="0"){ echo "（".$customstype[$orderinfo["ctype"]]["name"]."）";  };?></span></td>
    <td class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td class="tdright">审核状态：</td>
    <td><?php echo $checktype[(int)$orderinfo["checked"]]["name"];?></td>
    <td class="tdright">订单进度：</td>
    <td><?php echo $statustype[(int)$orderinfo["status"]]["name"];?></td>
  </tr>
  <tr>
    <td class="tdright">订购时间：</td>
    <td><?php echo $orderinfo["datetime"];?></td>
    <td class="tdright">合同编号：</td>
    <td><?php echo $orderinfo["contract"];?></td>
  </tr>

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">提醒队列 <span onclick="clockdinfo();" class="pointer">[+]</span></td>
  </tr>
  <tr>
    <td colspan="4" class="tdcenter" style="padding:0px;" id="clockd_list"><br>正在载入数据，请稍候...<br><br><script>clockdlist(1);</script></td>
  </tr>

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">历史提醒</td>
  </tr>
  <tr>
    <td colspan="4" class="tdcenter" style="padding:0px;" id="clockd_logslist"><br>正在载入数据，请稍候...<br><br><script>clockdlogslist(1);</script></td>
  </tr>


  <?php }?>
  <?php }?>

</table>

<?php
$hideclockd = 1;
?>
<?php include(VIEW."orders.viewinfo.php");?>


</div>
</body>
</html>
