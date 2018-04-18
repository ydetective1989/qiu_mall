<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/service.clockd.maps.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">

<table width="100%" height="100%" >
  <tr>
    <td class="tools">
    	  <form method="post" name="searchFrm" id="searchFrm" action="">
    	  <input type="hidden" name="status" id="status" value="1">
          <span>订单号：<input type="text" name="ordersid" id="ordersid" class="input" value="" style="width:100px;"></span>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=2&val=afterTeams"></script>
		  <script type="text/javascript">var salesarea='';var salesid='';var saleuserid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
          <span><select name="salesarea" id="salesarea" style="width:120px;" class="select"></select>
	          <select name="salesid" id="salesid" style="width:120px;" class="select"></select>
          </span>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/areas"></script>
		  <script type="text/javascript">var provid='';var cityid='';var areaid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.areas.js"></script>
          <span><select name="provid" id="provid" style="width:120px;" class="select"></select>
	          <select name="cityid" id="cityid" style="width:120px;" class="select"></select>
	          <select name="areaid" id="areaid" style="width:120px;" class="select"></select>
          </span>
          <span><input type="button" class="button" onclick="search('')" value="搜索订单"></span>
    	  </form>
    </td>
  </tr>
  <tr>
    <td class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td height="100%">
	  	<iframe src="<?php echo $S_ROOT;?>service/clockd?do=maps" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe>
	</td>
  </tr>
</table>

</body>
</html>
