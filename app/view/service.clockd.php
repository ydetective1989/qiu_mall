<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/service.clockd.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">

<table width="100%" height="100%" >
  <tr>
    <td class="tools">
  	  <form method="post" name="searchFrm" id="searchFrm" action="">
  	  <input type="hidden" name="status" id="status" value="1">
      <span>时间范围：<input type="text" name="godate" id="godate" value="" style="width:100px;text-align:center;" class="input"> - <input type="text" name="todate" id="todate" value="" style="width:100px;text-align:center;" class="input"></span>
      <span>订单号：<input type="text" name="ordersid" id="ordersid" class="input" value="" style="width:100px;"></span>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/areas"></script>
		  <script type="text/javascript">var provid='';var cityid='';var areaid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.areas.js"></script>
          <span><select name="provid" id="provid" style="width:150px;" class="select"></select>
	          <select name="cityid" id="cityid" style="width:150px;" class="select"></select>
	          <select name="areaid" id="areaid" style="width:150px;" class="select"></select>
          </span>
          <span><select name="brandid" id="brandid" class="select">
          <option value="">选择品牌</option>
          <?php foreach($brands AS $rs){?>
          <option value="<?php echo $rs["brandid"]?>"><?php echo $rs["name"]?></option>
          <?php }?>
          </select>
          </span>
          <span><select name="stars" id="stars" class="select">
          	<option value="">所有星标</option>
          	<option value="1">★☆☆☆☆</option>
          	<option value="2">★★☆☆☆</option>
          	<option value="3">★★★☆☆</option>
          	<option value="4">★★★★☆</option>
          	<option value="5">★★★★★</option>
          </select></span>
          <span>产品编码：<input type="text" name="encoded" id="encoded" class="input" value="" style="width:100px;"></span>
          <span>地址：<input type="text" name="address" id="address" class="input" value="" style="width:150px;"></span>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?level=1&type=1&val=salesTeams"></script>
		  <script type="text/javascript">var salesarea='';var salesid='';var saleuserid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
          <span><select name="salesarea" id="salesarea" style="width:150px;" class="select"></select>
	          <select name="salesid" id="salesid" style="width:150px;" class="select"></select>
          </span>
		  <input type="hidden" name="alled" id="alled" value="0">
          <span><input type="button" class="button" onclick="search('')" value="搜索提醒"></span>
    	  </form>
    </td>
  </tr>
  <tr>
    <td class="tooltabs bgheader" valign="top">
	<ul>
		<li id="otabs_1" class="ed" onclick="clockdtabs(1,5,'otabs_','ed|null');search('1');">即将处理的提醒</li>
		<li id="otabs_2" onclick="clockdtabs(2,5,'otabs_','ed|null');search('2');">过期未处理的提醒</li>
		<li id="otabs_3" onclick="clockdtabs(3,5,'otabs_','ed|null');search('3');">无需再处理的提醒</li>
		<li id="otabs_4" onclick="clockdtabs(4,5,'otabs_','ed|null');search('4');">未提醒记录的订单</li>
		<li id="otabs_5" onclick="clockdtabs(5,5,'otabs_','ed|null');search('5');">无需再提醒的订单</li>
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
			<td width="250" height="100%">
			<iframe src="<?php echo $S_ROOT;?>service/clockd?do=lists&status=1" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe>
			</td>
			<td width="3" class="mainside bgfocus"></td>
			<td>
			<iframe src="<?php echo $S_ROOT;?>pages" width="100%" height="100%" name="frminfo" scrolling="auto" noresize="noresize" id="frminfo" frameborder="no" style="" /></iframe>
			</td>
		  </tr>
	  </table>
	</td>
  </tr>
</table>

</body>
</html>
