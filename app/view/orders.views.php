<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.views.js?<?php echo date("YmdHi")?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.plugin.js?<?php echo date("YmdHi")?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/message.js?<?php echo date("YmdHi");?>"></script>
</head>
<body>

<div class="info">

<div class="top_menu bgwhite">
<table width="100%" class="title">
	<tr>
		<td height="36" class="tdleft bold size14">&nbsp;订单操作</td>
		<td class="tdright">
		<input type="button" value="订单审核" class="button" onclick="checkbtn('<?php echo base64_encode($orderinfo["id"]);?>');" />
		<input type="button" value="付款状态" class="btngreen" onclick="paystate('<?php echo base64_encode($orderinfo["id"]);?>');" />
    <input type="button" value="订单完成" class="btnorange" onclick="completed('<?php echo base64_encode($orderinfo["id"]);?>');" />
		<input type="button" value="修改订单" class="btnviolet" onclick="location.href='<?php echo $S_ROOT;?>orders/edit?id=<?php echo base64_encode($orderinfo["id"]);?>'" />
		<input type="button" value="作废订单" class="btngreen" onclick="killed('<?php echo base64_encode($orderinfo["id"]);?>');" />
    <input type="button" value="刷新页面" class="button" onclick="location.reload();" />
		</td>
	</tr>
  <tr>
    <td colspan="3" class="headerfocus bgfocus"></td>
  </tr>
</table>
</div>
<table width="100%" class="table">
<tr><td height="30"></td></tr>
</table>


<input type="hidden" name="ordersid" id="ordersid" value="<?php echo base64_encode($orderinfo["id"]);?>" />
<input type="hidden" name="customsid" id="customsid" value="<?php echo base64_encode($orderinfo["customsid"]);?>" />
<table width="100%" class="table">

	<?php
	switch($orderinfo["status"]){
		case "0" :	echo "<tr><td colspan='4' align='center'><img src=".$S_ROOT."images/status/0.png></td></tr>"; break;
		case "2" :	echo "<tr><td colspan='4' align='center'><img src=".$S_ROOT."images/status/2.png></td></tr>"; break;
		case "1" :	echo "<tr><td colspan='4' align='center'><img src=".$S_ROOT."images/status/1.png></td></tr>"; break;
		case "-1" :	echo "<tr><td colspan='4' align='center'><img src=".$S_ROOT."images/status/-1.png></td></tr>"; break;
		default : echo "";
	}?>

  <tr>
    <td width="15%" class="tdright">订单编号：</td>
    <td width="35%"><?php echo $orderinfo["id"];?>
    <?php if($orderinfo["parentid"]){?>
    <font class='red'>[主订单:<a href="<?php echo $S_ROOT;?>orders/views?id=<?php echo base64_encode($orderinfo["parentid"]);?>" class="ured">查看</a>]</font>
    <input type="button" class="btnorange" onclick="location.href='<?php echo $S_ROOT;?>orders/add?id=<?php echo base64_encode($orderinfo["parentid"]);?>'" value="增加子订单">
    <?php }else{?>
    <input type="button" class="btnorange" onclick="location.href='<?php echo $S_ROOT;?>orders/add?id=<?php echo base64_encode($orderinfo["id"]);?>'" value="增加子订单">
    <?php }?>
    <td width="15%" class="tdright"></td>
    <td width="35%"></td>
  </tr>
  <?php if($usered=="1"){?>
  <tr>
  <!--
    <td class="tdright">会员卡：</td>
    <td><?php if($cardinfo){?><span class='red'><?php echo $cardinfo["cardnums"];?></span> <span class="pointer" onclick="closecards('<?php echo $cardinfo["cardnums"]?>')">[取消绑定]</span><?php }else{?><span class='red'>没有会员卡信息，</span><span class="pointer blue" onclick="bindcards()">[绑定会员卡]</span><?php }?></td> -->
    <td class="tdright">订单来源：</td>
    <td colspan="3"><?php echo $orderinfo["source"];?></td>
  </tr>
  <?php }?>
  <tr>
    <td class="tdright">订单类型：</td>
    <td><?php echo $ordertype[$orderinfo["type"]]["name"];?><span class="red"><?php if($usered=="1"&&$orderinfo["parentid"]=="0"){ echo "（".$customstype[$orderinfo["ctype"]]["name"]."）";  };?></span></td>
    <td class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td class="tdright">订购时间：</td>
    <td><?php echo $orderinfo["datetime"];?></td>
    <td class="tdright">合同编号：</td>
    <td><?php echo $orderinfo["contract"];?></td>
  </tr>
  <tr>
    <td class="tdright">支付状态：</td>
    <td><?php echo $paystatetype[(int)$orderinfo["paystate"]]["name"];?></td>
    <td class="tdright">付款方式：</td>
    <td><?php echo $paytype[(int)$orderinfo["paytype"]]["name"];?></td>
  </tr>
  <tr>
    <td class="tdright">审核状态：</td>
    <td><?php echo $checktype[(int)$orderinfo["checked"]]["name"];?></td>
    <td class="tdright">受理进度：</td>
    <td><?php echo $statustype[(int)$orderinfo["status"]]["name"];?></td>
  </tr>
  <tr>
    <td class="tdright">安装方式：</td>
    <td><?php echo $setuptype[(int)$orderinfo["setuptype"]]["name"];?></td>
    <td class="tdright">送货方式：</td>
    <td><?php echo $delivertype[(int)$orderinfo["delivertype"]]["name"];?></td>
  </tr>
  <tr>
    <td class="tdright">计划送货时间：</td>
    <td><?php echo $orderinfo["plansend"];?></td>
    <td class="tdright">计划安装时间：</td>
    <td><?php echo $orderinfo["plansetup"];?></td>
  </tr>

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">订单信息</td>
  </tr>
  <tr>
    <td class="tdright">审核操作：</td>
    <td><?php if($orderinfo["checked"]){?><?php echo $orderinfo["checkname"];?> <?php echo date("Y-m-d H:i:s",$orderinfo["checkdate"]);?><?php }else{ echo "无"; }?></td>
    <td class="tdright">订单录入：</td>
    <td><?php echo $orderinfo["addname"];?> <?php echo date("Y-m-d H:i:s",$orderinfo["dateline"]);?></td>
  </tr>
  <tr>
    <td class="tdright">订单销售：</td>
    <td><?php echo $orderinfo["salesname"];?> <?php echo $orderinfo["salesuname"];?></td>
    <td class="tdright"></td>
    <td></td>
  </tr>

</table>


<input type="hidden" name="focus_id" id="focus_id" value="<?php echo base64_encode($orderinfo["id"]);?>" />
<input type="hidden" name="focus_cates" id="focus_cates" value="dd" />
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/focus.js?<?php echo date("Ymd")?>"></script>
<div class="focus_div" id="focus_div"></div>
<script type="text/javascript">focus_page();</script>

<?php include(VIEW."orders.viewinfo.php");?>

</div>
</body>
</html>
