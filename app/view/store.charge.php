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

<?php if($show=="lists"){?>

<div class="forms">

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="100" class="tdcenter" height="30">类型</td>
		<td class="tdleft">OMS订单号</td>
		<td class="tdleft">录单时间</td>
		<td class="tdleft">录单人</td>
		<!-- <td class="tdleft">库房</td> -->
		<td class="tdleft">ERP编号</td>
		<td width="100" class="tdleft">确认状态</td>
		<td width="100" class="tdleft">复核状态</td>
		<td width="150" class="tdleft">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter" height="30"><?php echo ($rs["type"]=="1")?"出库":"退库";?></td>
		<td class="tdleft"><?php echo $rs["ordersid"];?></td>
		<td class="tdleft"><?php echo date("Y-m-d H:i",$rs["dateline"]);?></td>
		<td class="tdleft"><?php echo ($rs["userid"])?$rs["addname"]:"系统默认";?></td>
		<!-- <td class="tdleft"><?php echo ($rs["storeid"])?$rs["storename"]:"";?></td> -->
		<td class="tdleft blue"><a href="javascript:void(0)" onclick="viewstore('<?php echo base64_encode($rs["id"]);?>')"><?php echo $rs["erpnum"];?></a></td>
		<td class="tdleft"><?php switch($rs["checked"]){
			case "1" : echo "<span class='green'>完成确认</span>";break;
			case "4" : echo "<span class='gray'>取消出库</span>";break;
			default  : echo "<span class='red'>等待确认</span>";
		}?></td>
		<!-- <td class="tdleft"><?php echo ($rs["checkdate"])?date("Y-m-d H:i",$rs["checkdate"]):"-";?></td> -->
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
		<td colspan="8" height="30" class="tdcenter red">暂无查询到相关出库记录</td>
	</tr>
	<?php }?>
</table>

</div>


<?php }elseif($show=="stores"){?>

<div class="forms">

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="80" class="tdcenter" height="30">类型</td>
		<td width="100" class="tdleft">OMS订单号</td>
		<td width="50" class="tdleft">校对</td>
		<td width="100" class="tdleft">时间</td>
		<td width="140" class="tdleft">库房</td>
		<td width="140" class="tdleft">ERP编号</td>
		<td width="100" class="tdleft">商品编码</td>
		<td class="tdleft">商品名称</td>
		<td width="80" class="tdleft">单价</td>
		<td width="50" class="tdleft">数量</td>
		<td width="80" class="tdleft">确认状态</td>
		<td width="80" class="tdleft">复核状态</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter" height="30"><?php echo ($rs["type"]=="1")?"出库":"退库";?></td>
		<td class="tdleft"><?php echo $rs["ordersid"];?></td>
		<td class="tdleft"><input type="checkbox" value="<?php echo $rs["id"]?>" name="verif_<?php echo $rs["id"]?>" id="verif_<?php echo $rs["id"]?>" <?php if($rs["verifed"]=="1"){ echo "checked"; }?> onclick="verifed('<?php echo base64_encode($rs["id"]);?>')"></td>

		<td class="tdleft"><?php echo date("Y-m-d",$rs["dateline"]);?></td>
		<td class="tdleft"><?php echo ($rs["storeid"])?$rs["storename"]:"";?></td>
		<td class="tdleft blue"><a href="javascript:void(0)" onclick="viewstore('<?php echo base64_encode($rs["sid"]);?>')"><?php echo $rs["erpnum"];?></a></td>

		<td class="tdleft"><?php echo $rs["encoded"];?></td>
		<td class="tdleft"><?php echo $rs["title"];?></td>
		<td class="tdleft red"><?php echo round($rs["price"],2);?></td>
		<td class="tdleft"><?php echo $rs["nums"];?></td>
		<td class="tdleft"><?php switch($rs["checked"]){
			case "1" : echo "<span class='green'>完成确认</span>";break;
			case "4" : echo "<span class='gray'>取消出库</span>";break;
			default  : echo "<span class='red'>等待确认</span>";
		}?></td>
		<!-- <td class="tdleft"><?php echo ($rs["checkdate"])?date("Y-m-d H:i",$rs["checkdate"]):"-";?></td> -->
		<td class="tdleft blue"><?php switch($rs["deliver"]){
			case "1" : echo "<span class='green'>完成复核</span>";break;
			case "4" : echo "<span class='gray'>无需复核</span>";break;
			default  : echo "<span class='red'>等待复核</span>";
		}?></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="12" class="tdcenter"><?php echo $page;?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="12" height="30" class="tdcenter red">暂无查询到相关出库记录</td>
	</tr>
	<?php }?>
</table>

</div>

<?php }else{?>

<script type="text/javascript">
$(document).keydown(function(){
	if(event.keyCode == 13){  charge(''); }
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
    	  <input type="hidden" name="status" id="status" value="<?php echo ($status)?$status:"deliver";?>">
          <span><input type="text" name="godate" id="godate" value="<?php echo $godate;?>" style="width:100px;text-align:center;" class="input"></span>
          <span><input type="text" name="todate" id="todate" value="<?php echo $todate;?>" style="width:100px;text-align:center;" class="input"></span>
          <span>ERP单据号：<input type="text" name="erpnum" id="erpnum" class="input" value="" style="width:130px;"></span>
          <span>OMS订单号：<input type="text" name="ordersid" id="ordersid" class="input" value="" style="width:130px;"></span>

          <?php if(COUNT($stores)>1){?>
          <span><select name="storeid" id="storeid" class="select" style="width:200px;">
          <option value="">选择库房</option>
          <?php foreach($stores AS $rs){?>
          <option value="<?php echo $rs["id"]?>"><?php echo $rs["encoded"]?>_<?php echo $rs["name"]?></option>
          <?php }?>
          </select></span>
          <?php }else{?>
          <input type="hidden" name="storeid" id="storeid" value="">
          <?php }?>

          <?php if($_GET["do"]=="stores"){?>
          <span><select name="deliver" id="deliver" class="select" style="width:80px;">
          <option value="">复核状态</option>
          <option value="1">完成复核</option>
          <option value="0">等待复核</option>
          </select>
          </span>
          <?php }else{?>
          <input type="hidden" name="deliver" id="deliver" value="">
          <?php }?>

          <span><input type="button" class="button" onclick="charge()" value="搜索单据"></span>
          <span><input type="button" class="btnorange" onclick="xls()" value="导出单据"></span>
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
    <?php
    $status = ($status)?$status:"deliver";
    if($status=="all"){
		$urlto = $S_ROOT."pages";
	}else{
		//if($_GET["do"]=="stores"){ $show = "stores"; }else{ $show = "lists"; }
		$urlto = $S_ROOT."store/charge?do=".$status."&show=lists";
	}?>
    <iframe src="<?php echo $urlto;?>" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe>
    </td>
  </tr>
</table>

<?php }?>


</body>
</html>
