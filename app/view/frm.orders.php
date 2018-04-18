<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/frm.orders.js?<?php echo date("Ymds");?>"></script>
</head>
<body scroll="no">

<?php $num = COUNT($statustype)+1;?>

<table width="100%" height="100%" >
  <tr>
    <td class="tools">
    	  <form method="post" name="searchFrm" id="searchFrm" action="">
    	  <input type="hidden" name="status" id="status" value="">

          <input type="hidden" name="checked" id="checked" value="">
          <span style=""><select name="type" id="type" class="select">
          	<option value="">订单类型</option>
          	<?php foreach($ordertype AS $rs){?>
          	<option value="<?php echo $rs["id"]?>"><?php echo $rs["name"]?></option>
          	<?php }?>
          </select></span>
          <span><select name="ctype" id="ctype" class="select" style="width:100px;">
          	<option value="">客户类别</option>
          	<?php foreach($customstype AS $rs){?>
          	<option value="<?php echo $rs["id"]?>"><?php echo $rs["name"]?></option>
          	<?php }?>
          </select></span>
          <input type="hidden" name="tagid" id="tagid" value="">
          <!-- <span><select name="tagid" id="tagid" class="select" style="width:100px;">
          	<option value="">客户标签</option>
          	<?php foreach($taglist AS $rs){?>
          	<option value="<?php echo $rs["id"]?>"><?php echo $rs["name"]?></option>
          	<?php }?>
          </select></span> -->
          <span>订单号：<input type="text" name="ordersid" id="ordersid" class="input" value="" style="width:100px;">
          <input type="checkbox" name="showpid" id="showpid" value="1" ><font class="gray">显示子订单</font></span>
          <span>合同号：<input type="text" name="contract" id="contract" class="input" value="" style="width:100px;"></span>
          <span>姓名：<input type="text" name="name" id="name" class="input" value="" style="width:100px;"></span>
          <span>时间：<input type="text" name="datetime" id="datetime" class="input" value="" style="width:100px;"></span>
          <span>电话：<input type="text" name="mobile" id="mobile" class="input" value="" style="width:100px;"></span>
          <span>旺旺：<input type="text" name="wangwang" id="wangwang" class="input" value="" style="width:100px;"></span>
          <span style="display:none;">地址：<input type="text" name="address" id="address" class="input" value="" style="width:120px;"></span>

          <script type="text/javascript" src="<?php echo $S_ROOT;?>json/areas"></script>
          <script type="text/javascript">var provid='';var cityid='';var areaid='';</script>
          <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.areas.js"></script>
          <span><select name="provid" id="provid" style="width:120px;" class="select"></select>
          <select name="cityid" id="cityid" style="width:120px;" class="select"></select>
          <select name="areaid" id="areaid" style="width:120px;" class="select"></select>
          <select name="loops" id="loops" class="select" style="display:none;">
          <option value="0">无需选择</option>
          </select>
          </span>
          <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=1&val=salesTeams&level=1"></script>
          <script type="text/javascript">var salesarea='';var salesid='';var saleuserid='';</script>
          <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
          <span><select name="salesarea" id="salesarea" style="width:120px;" class="select"></select>
          <select name="salesid" id="salesid" style="width:120px;" class="select"></select>
          </span>
          <span><input type="button" class="button" onclick="ordertabs(1,<?php echo $num;?>,'otabs_','ed|null');search('')" value="搜索"></span>
		  <span><input type="button" class="btnorange" onclick="frmlist.location.href='<?php echo $S_ROOT;?>orders/add'" value="增加新客户订单"></span>
    	  </form>
    </td>
  </tr>
  <tr>
    <td class="tooltabs bgheader" valign="top">
	<ul>
		<li id="otabs_<?php echo $i=1;?>" class='ed'  onclick="ordertabs(<?php echo $i;?>,<?php echo $num;?>,'otabs_','ed|null');search('');" >全部订单</li>
		<?php foreach($statustype AS $rs){ $i++; ?>
		<li  id="otabs_<?php echo $i;?>" onclick="ordertabs(<?php echo $i;?>,<?php echo $num;?>,'otabs_','ed|null');search('<?php echo $rs["id"];?>');"><?php echo $rs["name"];?></li>
		<?php }?>
	</ul>
    </td>
  </tr>
  <tr>
    <td class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td height="100%">
		<table width="100%" height="100%">
		  <tr>
			<td width="100%" class="frmleft" height="100%"><iframe src="<?php echo $S_ROOT;?>orders/lists?status=&showpid=0" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe></td>
		  </tr>
		</table>
	</td>
  </tr>

</table>

</body>
</html>
