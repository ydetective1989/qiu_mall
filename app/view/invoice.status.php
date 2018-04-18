<?php if($show=="lists"){?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php }else{?>
<html>
<?php }?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/invoice.status.js?<?php echo date("Ymd");?>"></script>
</head>

<?php if($show=="lists"){?>
<body>
<div class="forms">

<table width="100%" class="tdcenter">
	<tr class="bgheader white">
		<td width="100" class="tdcenter" height="30">订单号码</td>
		<td width="250" class="tdleft">发票类型</td>
		<td class="tdleft">抬头[点击查看]</td>
		<td width="80" class="tdleft">金额</td>
		<td width="100" class="tdcenter">申请时间</td>
		<td width="100" class="tdcenter">审核</td>
		<td width="100" class="tdcenter">开票状态</td>
	</tr>
	<?php if($list){?>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter" height="30"><a href="<?php echo $S_ROOT;?>orders/views?id=<?php echo base64_encode($rs["ordersid"]);?>"><?php echo $rs["ordersid"];?></a></td>
		<td class="tdleft"><?php echo plugin::cutstr($catetype[$rs["cateid"]]["name"],15,"");?></td>
		<td class="tdleft"><a href="<?php echo $S_ROOT?>invoice/views?id=<?php echo base64_encode($rs["id"]);?>"><?php echo $rs["title"];?></a></td>
		<td class="tdleft"><span class="red"><?php echo $rs["price"];?></span>元</td>
		<td class="tdcenter"><?php echo date("Y-m-d",$rs["dateline"]);?></td>
		<td class="tdcenter"><span class="<?php echo $checktype[(int)$rs["checked"]]["color"];?>"><?php echo $checktype[$rs["checked"]]["name"];?></span></td>
		<td class="tdcenter"><span class="<?php echo $worktype[(int)$rs["worked"]]["color"];?>"><?php echo $worktype[$rs["worked"]]["name"];?></span></td>
	</tr>
	<?php }?>
	<?php }else{?>
	<tr class="datas">
		<td colspan="10" height="30" class="tdcenter">无</td>
	</tr>
	<?php }?>
</table>
<br><br>

<div class="bottom_tools">
<table width="100%" class="pagenav bgheader">
	<tr>
		<td class="tdcenter"><?php echo $page;?></td>
	</tr>
</table>
</div>

</div>

<?php }else{?>
<body scroll="no">
<table width="100%" height="100%">
  <tr>
    <td colspan="3" align="center">
	<div class="forms">
      <table width="100%" >
		  <tr>
		    <td class="tdleft">
		    订单编号：<input type="text" name="ordersid" id="ordersid" class="input" value="">
		    合同编号：<input type="text" name="contract" id="contract" class="input" value="">
		    发票编号：<input type="text" name="worknums" id="worknums" class="input" value="">
		    <input type="button" value="搜索" class="btnorange" onclick="search();">
		  </tr>
	        <tr>
	          <td></td>
	        </tr>
      </table>
	</div>
    </td>
  </tr>
  <tr>
    <td colspan="3" class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td height="100%">
    <iframe src="<?php echo $S_ROOT;?>invoice/status?show=lists" width="100%" height="100%" name="frmlist" id="frmlist" scrolling="auto" noresize="noresize" frameborder="no" style="" /></iframe>
    </td>
  </tr>
</table>
<?php }?>

</body>
</html>