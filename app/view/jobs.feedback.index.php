<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jobs.feedback.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">

<table width="100%" height="100%" >
  <tr>
    <td class="tools">
    	  <form method="post" name="searchFrm" id="searchFrm" action="">
    	  <input type="hidden" name="status" id="status" value="0">
    	  <span><input type="text" name="godate" id="godate" value="<?php echo ($godate)?$godate:date("Y-m-d");?>" style="width:100px;text-align:center;" class="input"></span>
          <span><input type="text" name="todate" id="todate" value="<?php echo ($todate)?$todate:date("Y-m-d");?>" style="width:100px;text-align:center;" class="input"></span>
          <!-- <span>手机号：<input type="text" name="phone" id="phone" class="input" value="" style="width:150px;"></span> -->
          <span>
            <select name="type" id="type" style="width:100px;text-align:center;" class="input">
          	  <option value="phone" <?php if($_GET["type"]=="phone"){ echo "selected"; }?>>手机号</option>
          	  <option value="name" <?php if($_GET["type"]=="name"){ echo "selected"; }?>>姓名</option>
          	  <option value="address" <?php if($_GET["type"]=="address"){ echo "selected"; }?>>地址</option>
          	</select></span>
            <span><input type="text" name="keywords" id="keywords" value="<?php echo $_GET["keywords"]?>" style="width:100px;text-align:center;" class="input"></span>
          <span><input type="button" class="button" onclick="search('')" value="搜索信息"></span>
          <span><input type="button" class="button" onclick="xlsed()" value="导出信息"></span>
    	  </form>
    </td>
  </tr>
  <tr>
    <td class="tooltabs bgheader" valign="top">
	<ul>
		<li id="otabs_1" class="ed" onclick="menutabs(1,3,'otabs_','ed|null');search('0');">待处理预约</li>
		<li id="otabs_2" onclick="menutabs(2,3,'otabs_','ed|null');search('1');">已受理预约</li>
		<li id="otabs_3" onclick="menutabs(3,3,'otabs_','ed|null');search('2');">取消的预约</li>
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
			<iframe src="<?php echo $S_ROOT;?>jobs/feedback?mo=lists" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe>
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
