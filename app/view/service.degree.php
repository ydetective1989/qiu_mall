<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/service.degree.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">

<table width="100%" height="100%" >
  <tr>
    <td class="tools">
    	  <form method="post" name="searchFrm" id="searchFrm" action="">
    	  <input type="hidden" name="status" id="status" value="0">
          <span><select name="type" id="type" class="select">
          <option value="">工单类别</option>
          <option value="2">安装</option>
          <option value="5">维修</option>
          <option value="6">耗材更换</option>
          </select></span>
          <span>订单号：<input type="text" name="ordersid" id="ordersid" class="input" value="" style="width:100px;"></span>
          <span>时间范围：<input type="text" name="godate" id="godate" class="input" value="<?php echo $godate;?>" style="width:100px;"> - <input type="text" name="todate" id="todate" class="input" value="<?php echo $todate;?>" style="width:100px;"></span>
		<script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=1&val=salesTeams"></script>
		<script type="text/javascript">var salesarea='';var salesid='';var saleuserid='';</script>
		<script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
		<span><select name="salesarea" id="salesarea" style="width:200px;" class="select"></select>
		<select name="salesid" id="salesid" style="width:200px;" class="select"></select>
		</span>
          <span><input type="button" class="button" onclick="search('')" value="搜索订单"></span>
    	  </form>
    </td>
  </tr>
  <tr>
    <td class="tooltabs bgheader" valign="top">
	<ul>
		<li id="otabs_1" class="ed" onclick="degreetabs(1,4,'otabs_','ed|null');search('0');">等待回访</li>
		<li id="otabs_2" onclick="degreetabs(2,4,'otabs_','ed|null');search('2');">无需回访</li>
		<li id="otabs_3" onclick="degreetabs(3,4,'otabs_','ed|null');search('3');">无法回访</li>
		<li id="otabs_4" onclick="degreetabs(4,4,'otabs_','ed|null');search('1');">回访记录</li>
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
			<iframe src="<?php echo $S_ROOT;?>service/degree?do=lists" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe>
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