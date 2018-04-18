<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/invoice.js?<?php echo date("Ymd");?>"></script>
</head>
<body>
<div class="info">

<table width="100%" class="title">
	<tr>
		<td class="tdleft bold size14">&nbsp;发票申请[<?php echo $info["id"];?>]</td>
		<td class="tdright"><?php if($islevel){?>
		<input type="button" value="开票审核" class="btnorange" onclick="invoicechecked();" />
		<input type="button" value="发票开票" class="btnbrown" onclick="opensbtn();" />
		<input type="button" value="取消&作废" class="btnsky" onclick="killsbtn();" />
		<!-- <input type="button" value="修改信息" class="btnviolet" onclick="editinvoice('<?php echo base64_encode($info["id"])?>')" />--><?php }?>
		</td>
	</tr>
</table>

<table width="100%">
  <tr>
    <td colspan="3" class="headerfocus bgfocus"></td>
  </tr>
</table>

<table width="100%" class="table">
  <input type="hidden" name="id" id="id" value="<?php echo ((int)$info["id"])?base64_encode($info["id"]):"";?>" />
  <input type="hidden" name="ordersid" id="ordersid" value="<?php echo ((int)$info["ordersid"])?base64_encode($info["ordersid"]):"";?>" />
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">申请信息</td>
  </tr>
  <tr>
    <td width="15%" class="tdright">发票申请人：</td>
    <td width="35%"><?php echo $info["addname"];?></td>
    <td width="15%" class="tdright">申请时间：</td>
    <td width="35%"><?php echo date("Y-m-d H:i:s",$info["dateline"]);?></td>
  </tr>
  <tr>
    <td class="tdright">订单号：</td>
    <td colspan="3"><?php echo $info["ordersid"];?></td>
  </tr>
  <tr>
    <td class="tdright">销售部门：</td>
    <td ><?php echo $orderinfo["salesname"];?></td>
    <td class="tdright">销售人员：</td>
    <td ><?php echo $orderinfo["salesuname"];?></td>
  </tr>
  <tr>
    <td class="tdright">审核状态：</td>
    <td colspan="3"><?php echo $checktype[$info["checked"]]["name"];?> <?php if($info["checked"]){?>[审核人：<?php echo $info["checkname"]?> <?php echo date("Y-m-d H:i:s",$info["checkdate"]);?>]<?php }?></td>
  </tr>
  <?php if($info["checked"]=="2"){?>
  <tr>
    <td class="tdright">驳回信息：</td>
    <td colspan="3"><?php echo $info["workinfo"];?></td>
  </tr>
  <?php }?>
  <tr>
    <td class="tdright">处理状态：</td>
    <td colspan="3"><?php echo $worktype[$info["worked"]]["name"];?></td>
  </tr>
  <?php if((int)$info["worked"]){?>
  <tr>
    <td class="tdright">处理回执：</td>
    <td colspan="3"><?php echo $info["workinfo"];?></td>
  </tr>
  <tr>
    <td class="tdright">发票编号：</td>
    <td colspan="3"><?php echo $info["worknums"];?></td>
  </tr>
  <?php }?>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">发票信息</td>
  </tr>
  <tr>
    <td class="tdright">开票单位：</td>
    <td colspan="3"><?php echo $info["catename"];?></td>
  </tr>
  <tr>
    <td class="tdright">发票类型：</td>
    <td colspan="3"><?php echo ($info["type"])?"增值税专用发票":"增值税普通发票";?></td>
  </tr>
  <tr>
    <td class="tdright">发票抬头：</td>
    <td colspan="3"><?php echo $info["title"];?></td>
  </tr>
  <tr>
    <td class="tdright">发票金额：</td>
    <td colspan="3"><span class="red"><?php echo $info["price"];?></span>元</td>
  </tr>
  <tr>
    <td class="tdright">发票内容：</td>
    <td colspan="3"><?php echo $info["detail"];?></td>
  </tr>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">邮寄信息</td>
  </tr>
  <tr>
    <td class="tdright">是否邮寄：</td>
    <td colspan="3"><?php echo ($info["posted"])?"需要邮寄":"不需要邮寄";?></td>
  </tr>
  <?php if($info["posted"]){?>
  <tr>
    <td class="tdright">收件人姓名：</td>
    <td colspan="3"><?php echo $info["postname"];?></td>
  </tr>
  <tr>
    <td class="tdright">收件人地区：</td>
    <td colspan="3"><?php echo $info["cityname"];?></td>
  </tr>
  <tr>
    <td class="tdright">收件人地址：</td>
    <td colspan="3"><?php echo $info["postaddress"];?></td>
  </tr>

  <tr class="">
    <td class="tdright"></td>
    <td class="" colspan="3">
    <input type="button" value="韵达快递" class="btnorange" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=yunda&id=<?php echo base64_encode($info["id"]);?>'" />
    <input type="button" value="韵达[武汉]" class="btnorange" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=wheyd&id=<?php echo base64_encode($info["id"]);?>'" />
    <input type="button" value="百世快递" class="btnred" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=htky&id=<?php echo base64_encode($info["id"]);?>'" />
    <input type="button" value="百世快递[电子]" class="btnred" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=whehtky&id=<?php echo base64_encode($info["id"]);?>'" />
    <input type="button" value="圆通快递" class="button" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=yto&id=<?php echo base64_encode($info["id"]);?>'" />
    <input type="button" value="申通速递" class="btnviolet" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=sto&id=<?php echo base64_encode($info["id"]);?>'" />
    <input type="button" value="顺丰速递" class="btnblue" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=sf&id=<?php echo base64_encode($info["id"]);?>'" />
    <input type="button" value="顺丰[武汉]" class="btnred" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=whesf&id=<?php echo base64_encode($info["id"]);?>'" />
    <!-- <input type="button" value="中通速递" class="btnviolet" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=zto&id=<?php echo base64_encode($info["id"]);?>'" />
    <input type="button" value="联邦快递" class="btngreen" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=fedex&id=<?php echo base64_encode($info["id"]);?>'" /> -->
    <input type="button" value="全峰快递" class="btnblue" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=qfkd&id=<?php echo base64_encode($info["id"]);?>'" />
    <input type="button" value="全峰[武汉]" class="btnred" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=wheqf&id=<?php echo base64_encode($info["id"]);?>'" />
    <!-- <input type="button" value="天天快递" class="btnorange" onclick="location.href='<?php echo $S_ROOT;?>invoice/printexp?show=ttkd&id=<?php echo base64_encode($info["id"]);?>'" /> -->
    </td>
  </tr>

  <tr>
    <td class="tdright">收件人电话：</td>
    <td colspan="3"><?php echo $info["postphone"];?></td>
  </tr>
  <?php }?>
  <?php if($info["corpname"]){?>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">企业信息</td>
  </tr>
  <tr>
    <td class="tdright">企业名称：</td>
    <td colspan="3"><?php echo $info["corpname"];?></td>
  </tr>
  <tr>
    <td class="tdright">企业地址：</td>
    <td colspan="3"><?php echo $info["corpaddress"];?></td>
  </tr>
  <tr>
    <td class="tdright">企业电话：</td>
    <td colspan="3"><?php echo $info["corptel"];?></td>
  </tr>
  <tr>
    <td class="tdright">企业税号：</td>
    <td colspan="3"><?php echo $info["corpnums"];?></td>
  </tr>
  <tr>
    <td class="tdright">开户信息：</td>
    <td colspan="3"><?php echo $info["corpbank"];?></td>
  </tr>
  <?php }?>
</table>



<input type="hidden" name="focus_id" id="focus_id" value="<?php echo base64_encode($info["id"]);?>" />
<input type="hidden" name="focus_cates" id="focus_cates" value="fp" />
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/focus.js?<?php echo date("Ymd")?>"></script>
<div class="focus_div" id="focus_div"></div>
<script type="text/javascript">focus_page();</script>


<?php
$usered = 1;
$hidekd = 1;
$hidejobs = 1;
$hidedd = 1;
$hidets = 1;
$hideqt = 1;
?>

<?php include(VIEW."orders.viewinfo.php");?>



</div>
</body>
</html>
