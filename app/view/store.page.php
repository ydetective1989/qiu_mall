<?php if($show!=""){?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><?php }?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.store.js?<?php echo date("Ymd");?>"></script>
</head>
<body <?php if($show==""){ echo "scroll=\"no\""; }?>>

<?php if($show=="deliver"){?>

<div class="info">


<form name="sendto" id="sendto" action="" method="post">

<input type="hidden" name="dialog_id" id="dialog_id" value="<?php echo base64_encode($info["id"]);?>">
<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo base64_encode($info["ordersid"]);?>">

<table width="100%" class="title">
	<tr>
		<td class="tdleft bold" height="">&nbsp;<?php echo $info["ordersid"];?> 的出库信息 #<?php echo $info["erpnum"];?></td>
		<td class="tdright"></td>
	</tr>
</table>
<table width="100%">
  <tr>
    <td colspan="3" class="headerfocus bgfocus"></td>
  </tr>
</table>

<table width="100%" class="table">

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">出库信息</td>
  </tr>
  <tr>
    <td colspan="4" height="3"></td>
  </tr>
  <tr>
    <td width="15%" class="tdright">出库类别：</td>
    <td width="35%"><?php echo ((int)$info["type"]=="1")?"出库":"退库"?>
    <td width="15%" class="tdright">&nbsp;</td>
    <td width="35%">&nbsp;</td>
  </tr>
  <tr>
    <td class="tdright">ERP单据号：</td>
    <td><?php echo $info["erpnum"];?></td>
    <td class="tdright">OMS订单号：</td>
    <td><a href="javascript:void(0)"  onclick="parent.parent.addTab('查看订单[<?php echo $info["ordersid"];?>]','orders/views?id=<?php echo base64_encode($info["ordersid"]);?>','orderview');"><?php echo $info["ordersid"]?></a></td>
  </tr>
  <tr>
    <td class="tdright">订购日期：</td>
    <td><?php echo date("Y-m-d",$orderinfo["dateline"]);?></td>
    <td class="tdright">ERP制单人：</td>
    <td><?php echo $info["addname"]?> [<?php echo date("Y-m-d H:i",$info["dateline"]);?>]</td>
  </tr>
  <tr>
    <td colspan="4" height="3"></td>
  </tr>

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">商品信息</td>
  </tr>

  <?php if($deliverinfo){ foreach($deliverinfo AS $rs){?>
  <input type="hidden" name="idarr[]" class="storedarr" value="<?php echo $rs["id"]?>">
  <input type="hidden" name="nums[<?php echo $rs["id"]?>]" value="<?php echo $rs["nums"];?>">
  <input type="hidden" id="enbarcode_<?php echo $rs["id"]?>" value="<?php echo ($rs["storeid"]=="1002")?trim($rs["enbarcode"]):"";?>">
  <input type="hidden" id="encoded_<?php echo $rs["id"]?>" value="<?php echo trim($rs["encoded"]);?>">
  <tr>
    <td class="tdright"><?php echo $rs["storename"]?>：</td>
    <td><span class="blue bold"><?php echo $rs["encoded"];?></span> - <?php echo $rs["title"]?>&nbsp;&nbsp;[数量：<span class='red bolder'><?php echo $rs["nums"]?></span> ]</td>
    <td class="tdright">商品条码：</td>
    <td ><input type="text" name="serial[<?php echo $rs["id"]?>]" id="serial_<?php echo $rs["id"]?>" value="<?php echo $rs["serial"]?>" style="width:200px;" class="input"></td>
  </tr>
  <tr class="datas">
  	<td class="tdright">商品序列号：</td>
  	<td colspan="3">
  	<?php for($i=0;$i<$rs["nums"];$i++){ ?>
  	<input type="text" name="barcode[<?php echo $rs["id"]?>][]" id="barcode_<?php echo $rs["id"]?>" value="<?php echo $rs["barcode"][$i]["barcode"]?>" style="width:150px;" class="input">
  	<?php }?>
  	</td>
  </tr>
  <?php }}?>


  <tr>
    <td colspan="4" height="3"></td>
  </tr>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">客户信息</td>
  </tr>
  <tr>
    <td colspan="4" height="3"></td>
  </tr>
  <tr>
    <td class="tdright">客户姓名：</td>
    <td><?php echo $orderinfo["name"];?></td>
    <td class="tdright"></td>
    <td></td>
  </tr>

  <tr>
    <td class="tdright">客户地址：</td>
    <td colspan="3"><?php echo $orderinfo["address"];?></td>
  </tr>

  <tr>
    <td colspan="4" height="10"></td>
  </tr>

  <tr>
    <td colspan="4" class="tdcenter">
    <input type="button" class="button" id="btned" onclick="storedeliver()" value="提交复核">
    <input type="button" value="取消操作" class="btnviolet" onclick="location.href='<?php echo $S_ROOT?>store/views?id=<?php echo base64_encode($info["id"])?>'" />
    </td>
  </tr>

</table>

</form>

</div>


<?php }elseif($show=="checked"){?>

<div class="info">

333

</div>

<?php }elseif($show=="views"){?>

<div class="info">

<div class="top_menu bgwhite">
<table width="100%" class="title">
	<tr>
		<td class="tdleft bold" height="">&nbsp;查看订单[<?php echo $info["ordersid"];?>]出库信息#<?php echo $info["erpnum"];?></td>
		<td class="tdright">

		<input type="button" value="出库确认" class="button" onclick="checkstore('<?php echo base64_encode($info["id"]);?>');" />
		<input type="button" value="复核操作" class="btnorange" onclick="deliverstore('<?php echo base64_encode($info["id"]);?>');" />
		<input type="button" value="取消出库" class="btnred" onclick="delstore('<?php echo base64_encode($info["id"]);?>')" />
		<input type="button" value="返回页面" class="btngreen" onclick="parent.parent.delTab()" />
		</td>
	</tr>
</table>

<table width="100%">
  <tr>
    <td colspan="3" class="headerfocus bgfocus"></td>
  </tr>
</table>

</div>
<table width="100%" class="table">
<tr><td height="30"></td></tr>
</table>



<table width="100%" class="table">
  <tr>
    <td colspan="4" height="3"></td>
  </tr>
  <tr>
    <td width="15%" class="tdright">出库类别：</td>
    <td width="35%"><?php echo ((int)$info["type"]=="1")?"出库":"退库"?>
    <td width="15%" class="tdright">ERP单据号：</td>
    <td width="35%"><?php echo $info["erpnum"]?></td>
  </tr>
  <tr>
    <td class="tdright">OMS订单号：</td>
    <td><a href="javascript:void(0)" onclick="parent.parent.addTab('查看订单[<?php echo $info["ordersid"];?>]','orders/views?id=<?php echo base64_encode($info["ordersid"]);?>','orderview');"><?php echo $info["ordersid"]?></a></td>
    <td class="tdright">库房：</td>
    <td><?php if($info["checked"]=="1"){?><?php echo $info["storename"]?>(<?php echo $info["storecode"]?>)<?php }else{?>-<?php }?></td>
  </tr>
  <tr>
    <td colspan="4" height="3"></td>
  </tr>

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">出库内容</td>
  </tr>

  <?php if($deliverinfo){ foreach($deliverinfo AS $rs){?>
  <tr>
    <td colspan="4" height="3" style="padding:0px;"></td>
  </tr>
  <tr class="bgwhite">
    <td class="tdright red">(<?php echo $rs["storecode"]?>)<?php echo $rs["storename"]?>：</td>
    <td><span class="blue bold"><?php echo $rs["encoded"];?></span> - <?php echo $rs["title"]?>&nbsp;&nbsp;&nbsp;数量：<span class='bgheadero'>&nbsp;&nbsp;<?php echo $rs["nums"]?>&nbsp;&nbsp;</span></td>
    <td class="tdright">商品条码：</td>
    <td ><?php echo ($rs["serial"])?$rs["serial"]:"无"?></td>
  </tr>
  <?php if($info["deliver"]=="1"){?>
  <tr class="bgheader">
  	<td class="tdright">商品序列号：</td>
  	<td colspan="3">
  	<?php for($i=0;$i<$rs["nums"];$i++){ ?>
  	<?php echo $rs["barcode"][$i]["barcode"]."&nbsp;&nbsp;&nbsp;"?>
  	<?php }?>
  	</td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="4" height="3" style="padding:0px;border-bottom:1px solid #ccc;"></td>
  </tr>
  <?php }}?>
  <tr>
    <td colspan="4" height="3"></td>
  </tr>
  <tr>
    <td class="tdright">订购日期：</td>
    <td><?php echo date("Y-m-d",$orderinfo["dateline"]);?></td>
    <td class="tdright">单据录入：</td>
    <td><?php echo $info["addname"]?> <?php echo date("Y-m-d H:i",$info["dateline"]);?></td>
  </tr>
  <tr>
    <td class="tdright">确认状态：</td>
    <td><?php switch($info["checked"]){
			case "1" : echo "<span class='green'>完成确认</span>";break;
			case "4" : echo "<span class='gray'>取消出库</span>";break;
			default  : echo "<span class='red'>等待确认</span>";
		}?></td>
    <td class="tdright">确认操作：</td>
    <td><?php echo ($info["checkuserid"])?$info["checkname"]:""?> <?php echo ($info["checkdate"])?date("Y-m-d H:i",$info["checkdate"]):"";?></td>
  </tr>
  <tr>
    <td class="tdright">复核状态：</td>
    <td><?php switch($info["deliver"]){
			case "1" : echo "<span class='green'>完成复核</span>";break;
			case "4" : echo "<span class='gray'>无需复核</span>";break;
			default  : echo "<span class='red'>等待复核</span>";
		}?></td>
    <td class="tdright">复核操作：</td>
    <td><?php echo ($info["deliveruserid"])?$info["delivername"]:""?> <?php echo ($info["deliverdate"])?date("Y-m-d H:i",$info["deliverdate"]):"";?></td>
  </tr>
  <tr>
    <td colspan="4" height="3"></td>
  </tr>

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">客户信息</td>
  </tr>
  <tr>
    <td colspan="4" height="3"></td>
  </tr>
  <tr>
    <td class="tdright">客户姓名：</td>
    <td><?php echo $orderinfo["name"];?></td>
    <td class="tdright">销售日期：</td>
    <td><?php echo $orderinfo["datetime"]?></td>
  </tr>

  <tr>
    <td class="tdright">客户地址：</td>
    <td colspan="3"><?php echo $orderinfo["address"];?></td>
  </tr>
  <tr>
    <td class="tdright">是否有发票：</td>
    <td colspan="3"><?php echo ($invoiced)?"已开发票":"未开发票";?></td>
  </tr>

  <tr>
    <td class="tdright">销售部门：</td>
    <td><?php echo $orderinfo["salesname"];?><?php if($orderinfo["salesencoded"]){?>（<?php echo htmlspecialchars($orderinfo["salesencoded"])?>）<?php }?></td>
    <td class="tdright">销售人员：</td>
    <td><?php echo $orderinfo["salesuname"]?>（<?php echo $orderinfo["salesworknum"]?>）</td>
  </tr>
    <tr>
        <td class="tdright">销售合同号：</td>
        <td><?php echo $orderinfo["contract"];?></td>
        <td class="tdright"></td>
        <td></td>
    </tr>
  <tr>
    <td class="tdright">订单备注：</td>
    <td colspan="3"><?php echo $orderinfo["detail"]?></td>
  </tr>

  <tr>
    <td colspan="4" height="3"></td>
  </tr>
  <tr class=bgheader>
    <td colspan="4" class="tdcenter">订购信息</td>
  </tr>
  <tr>
    <td colspan="4" style="padding:0px;">
    <table width="100%" class="parinfo">
		<tr class="bgash">
			<td width="150" class="tdcenter">产品编码</td>
			<td class="tdleft">产品名称/产品SN/备注信息</td>
			<td width="100" class="tdcenter">数量</td>
			<td width="100" class="tdcenter">单价(ERP)</td>
			<td width="100" class="tdcenter">合计金额</td>
		</tr>
		<?php if($orders_product){?>
		<?php foreach($orders_product AS $rs){?>
		<tr class="datas">
			<td class="tdcenter"><?php echo $rs["encoded"]?></td>
			<td class="tdleft"><?php if($rs["serials"]){ echo "[<font class='gray'>".$rs["serials"]."] "; }?><?php echo $rs["title"]?> <?php if($rs["detail"]){ echo "(<font class='red'>".$rs["detail"].")"; }?></td>
			<td class="tdcenter"><?php echo (int)$rs["nums"]?></td>
			<td class="tdcenter red"><?php echo $rs["erpprice"]?></td>
			<td class="tdcenter"><?php echo $rs["erpprice"]*(int)$rs["nums"]?></td>
		</tr>
		<?php }?>

	  <tr class="bgtips">
	    <td colspan="5" class="tdcenter">总价:<span class='red'><?php echo $orderinfo["price_all"];?></span>元、安装:<span class='red'><?php echo $orderinfo["price_setup"];?></span>元、物流:<span class='red'><?php echo $orderinfo["price_deliver"];?></span>元、优惠:<span class='red'><?php echo $orderinfo["price_minus"];?></span>元、其它:<span class='red'><?php echo $orderinfo["price_other"];?></span>元、保证金：<span class='red'><?php echo round($orderinfo["price_cash"],2);?></span>元、已付:<span class='red'><?php echo round($paycharge,2);?></span>元、实收:<span class='red'><?php echo $orderinfo["price"];?></span>元、应付:<span class='red'><?php echo round($orderinfo["price"]-$paycharge,2);?></span>元</td>
	  </tr>
		<?php }else{?>
		<tr class="datas">
			<td colspan="5" class="tdcenter">暂无订购信息</td>
		</tr>
		<?php }?>
	</table>

    </td>
  </tr>


  <input type="hidden" name="exp_ordersid" id="exp_ordersid" value="<?php echo base64_encode($info["ordersid"])?>">
  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.express.js?<?php echo date("YmdHi")?>"></script>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">物流记录 <span class="pointer uwhite" onclick="addexpress('<?php echo base64_encode($info["ordersid"])?>');">[+]</span></td><!-- -->
  </tr>
  <tr>
    <td colspan="4" class="tdcenter" style="padding:0px;" id="express_list"><br>正在载入数据，请稍候...<br></td>
  </tr>
  <script type="text/javascript">expresslist(1);</script>

  <tr class=bgheader>
    <td colspan="4" class="tdcenter">出库详情</td>
  </tr>
  <tr>
    <td colspan="4" style="padding:0px;">
    <table width="100%" class="parinfo">
		<tr class="bgash">
			<td width="150" class="tdcenter">类别</td>
			<td width="150" class="tdleft">库房</td>
			<td width="120" class="tdleft">商品编码</td>
			<td width="" class="tdleft">商品名称</td>
			<td width="100" class="tdcenter">数量</td>
			<td width="100" class="tdcenter">确认状态</td>
			<td width="100" class="tdcenter">复核状态</td>
		</tr>
		<?php if($deliverlist){?>
		<?php foreach($deliverlist AS $rs){?>
		<tr class="datas">
			<td class="tdcenter"><?php echo ($rs["type"])?"出库":"退库"?></td>
			<td class="tdleft"><?php echo $rs["storename"]?>(<?php echo $rs["storecode"]?>)</td>
			<td class="tdleft"><?php echo $rs["encoded"]?></td>
			<td class="tdleft"><?php echo $rs["title"]?></td>
			<td class="tdcenter"><?php echo (int)$rs["nums"]?></td>
			<td class="tdcenter"><?php switch($rs["checked"]){
			case "1" : echo "<span class='green'>完成确认</span>";break;
			case "4" : echo "<span class='gray'>取消出库</span>";break;
			default  : echo "<span class='red'>等待确认</span>";
		}?></td>
			<td class="tdcenter"><?php switch($rs["deliver"]){
			case "1" : echo "<span class='green'>完成复核</span>";break;
			case "4" : echo "<span class='gray'>取消出库</span>";break;
			default  : echo "<span class='red'>等待复核</span>";
		}?></td>
		</tr>
		<?php }?>
		<?php }else{?>
		<tr class="datas">
			<td colspan="4" class="tdcenter">暂无出库信息</td>
		</tr>
		<?php }?>
	</table>

    </td>
  </tr>



  <tr class=bgheader>
    <td colspan="4" class="tdcenter">出库统计</td>
  </tr>
  <tr>
    <td colspan="4" style="padding:0px;">
    <table width="100%" class="parinfo">
		<tr class="bgash">
			<td width="150" class="tdcenter">商品编码</td>
			<td width="" class="tdleft">商品名称</td>
			<td width="150" class="tdcenter">订购数量</td>
			<td width="150" class="tdcenter">出库数量</td>
		</tr>
		<?php if($productc){?>
		<?php foreach($productc AS $rs){?>
		<tr class="datas">
			<td class="tdcenter"><?php echo $rs["encoded"]?></td>
			<td class="tdleft"><?php echo $rs["title"]?></td>
			<td class="tdcenter"><?php echo (int)$rs["nums"]?></td>
			<td class="tdcenter"><?php echo (int)$rs["storenums"]?></td>
		</tr>
		<?php }?>
		<?php }else{?>
		<tr class="datas">
			<td colspan="4" class="tdcenter">暂无统计信息</td>
		</tr>
		<?php }?>
	</table>

    </td>
  </tr>


  <tr>
    <td colspan="4" height="50" class="tdcenter"><input type="button" value="返回页面" class="btngreen" onclick="parent.parent.delTab()" /></td>
  </tr>

</table>


</div>

<?php }elseif($show=="lists"){?>

<div class="forms">

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="80" class="tdcenter" height="30">类型</td>
		<td width="140" class="tdleft">录单时间</td>
		<td width="80" class="tdleft">录单人</td>
		<td class="tdleft">库房</td>
		<td class="tdleft">ERP编号</td>
		<td width="80" class="tdleft">确认状态</td>
		<td width="130" class="tdleft">确认时间</td>
		<td width="80" class="tdleft">复核状态</td>
		<td width="150" class="tdleft">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter" height="30"><?php echo ($rs["type"]=="1")?"出库":"退库";?></td>
		<td class="tdleft"><?php echo date("Y-m-d H:i",$rs["dateline"]);?></td>
		<td class="tdleft"><?php echo ($rs["userid"])?$rs["addname"]:"系统默认";?></td>
		<td class="tdleft"><?php echo ($rs["storeid"])?$rs["storename"]:"";?></td>
		<td class="tdleft blue"><a href="javascript:void(0)" onclick="viewstore('<?php echo base64_encode($rs["id"]);?>')"><?php echo $rs["erpnum"];?></a></td>
		<td class="tdleft"><?php switch($rs["checked"]){
			case "1" : echo "<span class='green'>完成确认</span>";break;
			case "4" : echo "<span class='gray'>取消出库</span>";break;
			default  : echo "<span class='red'>等待确认</span>";
		}?></td>
		<td class="tdleft"><?php echo ($rs["checkdate"])?date("Y-m-d H:i",$rs["checkdate"]):"-";?></td>
		<td class="tdleft blue"><?php switch($rs["deliver"]){
			case "1" : echo "<span class='green'>完成复核</span>";break;
			case "4" : echo "<span class='gray'>无需复核</span>";break;
			default  : echo "<span class='red'>等待复核</span>";
		}?></td>
		<td class="tdleft"><a href="javascript:void(0)" onclick="viewstore('<?php echo base64_encode($rs["id"]);?>')">[查看]</a><span class="pointer" onclick="editstore('<?php echo base64_encode($rs["id"]);?>')">[修改]</span><span class="pointer" onclick="delstore('<?php echo base64_encode($rs["id"]);?>')">[取消]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="8" class="tdcenter"><?php echo $page;?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="8" class="tdcenter">暂无出库记录</td>
	</tr>
	<?php }?>
</table>

</div>

<?php }else{?>

<script type="text/javascript">
$(document).keydown(function(){
	if(event.keyCode == 13){  search(''); }
});
</script>
<table width="100%" height="100%" >
  <tr>
    <td colspan="2" align="center">
	<div class="forms">
      <table width="100%" >
		  <tr>
		    <td height="35" class="bold"></td>
		    <td class="tdright">
    	  <form method="post" name="searchFrm" id="searchFrm" action="">
          <span>ERP单据号：<input type="text" name="erpnum" id="erpnum" class="input" value="" style="width:180px;"></span>
          <span>OMS订单号：<input type="text" name="ordersid" id="ordersid" class="input" value="" style="width:180px;"></span>
          <span><input type="button" class="button" onclick="search()" value="搜索单据"></span>
    	  </form>
		    </td>
		  </tr>
	        <tr>
	          <td></td>
	        </tr>
      </table>
	</div>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td colspan="2" height="100%">
    <iframe src="<?php echo $S_ROOT;?>pages" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe>
    </td>
  </tr>
</table>

<?php }?>


</body>
</html>
