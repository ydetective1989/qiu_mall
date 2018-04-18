<?php if($type=="iframe"){?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/counts.orders.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">
<table width="100%" height="100%" >
  <tr>
    <td class="tools">
		<span>
          <span><input type="text" name="godate" id="godate" class="input" value="<?php echo $godate;?>" style="width:100px;text-align:center;"> - <input type="text" name="todate" id="todate" class="input" value="<?php echo $todate;?>" style="width:100px;text-align:center;"></span>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=1&level=1&val=salesTeams"></script><!-- level=1& -->
		  <script type="text/javascript">var salesarea='0';var salesid='0';var saleuserid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
          <span><select name="salesarea" id="salesarea" class="select" style="width:200px;" ></select>
	          <select name="salesid" id="salesid" class="select" style="width:200px;" ></select>
	          <select name="saleuserid" id="saleuserid" class="select" style="width:200px;" >
	            <option value="">选择销售人员</option>
	            <?php if($users){ foreach($users AS $rs){?>
	            <option value="<?php echo $rs["userid"]?>"><?php echo $rs["worknum"]?>_<?php echo $rs["name"]?></option>
	            <?php }}?>
	          </select>
	      </span>
	      <span><input type="button" onclick="countsd()" value="统计数据" class="button" ></span>
	      <span><input type="button" onclick="xlsed()" value="导出数据" class="btngreen" ></span>

    </td>
  </tr>
  <tr>
    <td class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td height="100%">
    <iframe src="<?php echo $S_ROOT;?>counts/pages" width="100%" height="100%" name="frminfo" scrolling="auto" noresize="noresize" id="frminfo" frameborder="no" style="" /></iframe>
    </td>
  </tr>
</table>
</body>
</html>
<?php }elseif($type=="show"){?>

<table width="100%">
  <tr class="bgheader">
    <td colspan="2" class="tdcenter bold" height="30">订单数据</td>
  </tr>
  <tr>
    <td width="20%" height="30">销售订单数：</td>
    <td><?php echo (int)$ordernums;?></td>
  </tr>
  <tr>
    <td height="30">总客户数：</td>
    <td><?php echo round($customsnums,2)?></td>
  </tr>
  <tr>
    <td height="30">总订购产品数目：</td>
    <td><?php echo (int)$products;?></td>
  </tr>
  <tr>
    <td height="30">总订购产品数量：</td>
    <td><?php echo (int)$productnums;?></td>
  </tr>
  <tr>
    <td height="30">总订单金额：</td>
    <td><?php echo round($orderprice,2)?> 元</td>
  </tr>
  <tr>
    <td height="30">平均订单金额：</td>
    <td><?php echo ($orderprice&&$ordernums)?round($orderprice/$ordernums,2):"0"?> 元</td>
  </tr>
  <tr>
    <td height="30">客户平均金额：</td>
    <td><?php echo ($orderprice&&$customsnums)?round($orderprice/$customsnums,2):"0"?> 元</td>
  </tr>
</table>

<table width="100%">
  <tr class="bgheader">
    <td colspan="3" height="30" class="tdcenter bold">付款状态</td>
  </tr>
  <tr class="bgtips">
    <td width="20%" height="30">名称</td>
    <td width="40%" >订单总数</td>
    <td width="40%" >订单总额</td>
  </tr>
  <?php foreach($paycount AS $rs){?>
  <tr>
    <td height="30"><?php echo $rs["name"]?>：</td>
    <td><?php echo (int)$rs["ordernums"]?></td>
    <td><?php echo round($rs["orderprice"],2)?></td>
  </tr>
  <?php }?>
</table>

  <table width="100%">
    <tr class="bgheader">
      <td colspan="4" height="30" class="tdcenter bold">订单类型</td>
    </tr>
    <tr class="bgtips">
      <td width="25%" height="30">名称</td>
      <td width="25%" >订单总数</td>
      <td width="25%" >订单总额</td>
      <td width="25%" >平均金额</td>
    </tr>
    <?php foreach($typecount AS $rs){?>
      <tr>
        <td width="25%" height="30"><?php echo $rs["name"]?></td>
        <td width="25%" ><?php echo (int)$rs["ordernums"]?></td>
        <td width="25%" ><?php echo round($rs["orderprice"],2)?></td>
        <td width="25%" ><?php echo ($rs["orderprice"]&&(int)$rs["ordernums"])?round($rs["orderprice"]/(int)$rs["ordernums"],2):"0"?></td>
      </tr>
    <?php }?>
  </table>

    <table width="100%">
      <tr class="bgheader">
        <td colspan="4" height="30" class="tdcenter bold">客户类型</td>
      </tr>
      <tr class="bgtips">
        <td width="25%" height="30">名称</td>
        <td width="25%" >订单总数</td>
        <td width="25%" >订单总额</td>
        <td width="25%" >平均金额</td>
      </tr>
      <?php foreach($customscount AS $rs){?>
        <tr>
          <td width="25%" height="30"><?php echo $rs["name"]?></td>
          <td width="25%" ><?php echo (int)$rs["ordernums"]?></td>
          <td width="25%" ><?php echo round($rs["orderprice"],2)?></td>
          <td width="25%" ><?php echo ($rs["orderprice"]&&(int)$rs["ordernums"])?round($rs["orderprice"]/(int)$rs["ordernums"],2):"0"?></td>
        </tr>
      <?php }?>
    </table>

<table width="100%">
  <tr class="bgheader">
    <td colspan="4" height="30" class="tdcenter bold">门店统计</td>
  </tr>
  <tr class="bgtips">
    <td width="25%" height="30">门店名称</td>
    <td width="25%" >订单总数</td>
    <td width="25%" >订单总额</td>
    <td width="25%" >平均金额</td>
  </tr>
  <?php if($teamcount){ ?>
  <?php foreach($teamcount AS $rs){?>
  <tr>
    <td height="30"><?php echo $rs["name"]?>(<?php echo $rs["id"]?>)：</td>
    <td ><?php echo (int)$rs["ordernums"]?></td>
    <td ><?php echo round($rs["orderprice"],2)?></td>
    <td ><?php echo ($rs["orderprice"]&&(int)$rs["ordernums"])?round($rs["orderprice"]/(int)$rs["ordernums"],2):"0"?></td>
  </tr>
  <?php }?>
  <?php }?>
</table>

<?php }else{?>

NULL

<?php }?>
