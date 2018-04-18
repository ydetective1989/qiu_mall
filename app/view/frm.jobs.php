<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/frm.jobs.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">

<?php
$num = COUNT($worktype)+1;
$dateday = ($todate)?$todate:date("Y-m-d");
$backTime = date("Y-m-d",strtotime($dateday)-86400);
$nextTime = date("Y-m-d",strtotime($dateday)+86400);
?>

<table width="100%" height="100%" >
  <tr>
    <td class="tools">
    	  <form method="post" name="searchFrm" id="searchFrm" action="">

          <span><input type="button" value="前一天" onclick="backdate();jobstabs(1,<?php echo $num;?>,'otabs_','ed|null');search('')" class="btnwhite" ></span>
          <span><input type="text" name="godate" id="godate" value="<?php echo ($godate)?$godate:date("Y-m-d");?>" style="width:100px;text-align:center;" class="input"></span>
          <span><input type="text" name="todate" id="todate" value="<?php echo ($todate)?$todate:date("Y-m-d");?>" style="width:100px;text-align:center;" class="input"></span>
          <span><input type="button" value="后一天" onclick="nextdate();jobstabs(1,<?php echo $num;?>,'otabs_','ed|null');search('')" class="btnwhite" ></span>

    	  <span><select name="type" id="type" class="select">
          	<option value="">工单类型</option>
          	<?php foreach($jobstype AS $rs){?>
          	<option value="<?php echo $rs["id"]?>"><?php echo $rs["name"]?></option>
          	<?php }?>
          </select></span>

          <span style=""><select name="otype" id="otype" class="select">
          	<option value="">订单类型</option>
          	<?php foreach($ordertype AS $rs){?>
          	<option value="<?php echo $rs["id"]?>"><?php echo $rs["name"]?></option>
          	<?php }?>
          </select></span>
          <span><select name="ochecked" id="ochecked" class="select">
          	<option value="">订单审核</option>
          	<option value="1">已审核</option>
          	<option value="0">未审核</option>
          </select></span>

          <span><select name="checked" id="checked" class="select">
          	<option value="">工单确认</option>
          	<option value="1">已确认</option>
          	<option value="0">未确认</option>
          </select></span>
          <input type="hidden" name="worked" id="worked" class="input" value="0">
          <span>订单号：<input type="text" name="ordersid" id="ordersid" value="" class="input" style="width:100px;"></span>
          <span>工单号：<input type="text" name="jobsid" id="jobsid" value="" class="input" style="width:100px;"></span>
          <span>工单合同号：<input type="text" name="contract" id="contract" value="" class="input" style="width:100px;"></span>


      <?php if($usertype<>"1"){ $inlevel="&level=1"; }?>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?level=1&type=1&val=salesTeams<?php echo $inlevel;?>"></script>
		  <script type="text/javascript">var salesarea='';var salesid='';var saleuserid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
          <span><select name="salesarea" id="salesarea" style="width:120px;" class="select"></select>
	          <select name="salesid" id="salesid" style="width:120px;" class="select"></select>
          </span>
   		  <?php if($islevel||($usertype==1&&COUNT($aftergroup)>1)){?>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?level=1&type=3&val=afterTeams"></script><!-- level=1& -->
		  <script type="text/javascript">var afterarea='0';var afterid='0';var afteruserid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.after.js"></script>
          <span><select name="afterarea" id="afterarea" style="width:150px;" class="select" ></select>
	          <select name="afterid" id="afterid" style="width:150px;" class="select" ></select>
	      </span>
          <span><select name="afteruserid" id="afteruserid" style="width:150px;" class="select">
          	<option value="">选择服务人员</option>
          </select></span>
          <?php }else{?>
          <input type="hidden" name="afterarea" id="afterarea" value="">
          <input type="hidden" name="afterid" id="afterid" value="">
          <input type="hidden" name="afteruserid" id="afteruserid" value="">
          <?php }?>
          <span><input type="button" class="button" onclick="jobstabs(1,<?php echo $num;?>,'otabs_','ed|null');search('')" value="搜索工单"></span>
          <span><input type="button" class="btnorange" onclick="jobsxls()" value="导出工单"></span>
          <span><input type="hidden" name="views" id="views" value="<?php echo (int)$_GET["views"];?>"><input type="button" name="viewbtn" id="viewbtn" value="<?php echo ($_GET["views"]=="1")?"默认视图":"列表视图";?>" class="<?php echo ($_GET["views"]=="1")?"btngreen":"btnwhite";?>" onclick="viewlist()"></span>

    	  </form>
    </td>
  </tr>
  <tr>
    <td class="tooltabs bgheader" valign="top">
	<ul>
		<li id="otabs_<?php echo $i=1;?>" onclick="jobstabs(<?php echo $i;?>,<?php echo $num;?>,'otabs_','ed|null');search('');" >全部工单</li>
		<?php foreach($worktype AS $rs){ $i++; ?>
		<li <?php if($rs["id"]=="0"){ echo "class='ed'"; }?> id="otabs_<?php echo $i;?>" onclick="jobstabs(<?php echo $i;?>,<?php echo $num;?>,'otabs_','ed|null');search('<?php echo $rs["id"];?>');"><?php echo $rs["tname"];?></li>
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
	  <?php if($_GET["views"]=="1"){?>
		  <tr>
			<td height="100%"><iframe src="<?php echo $S_ROOT;?>jobs/lists?worked=0&views=<?php echo $_GET["views"];?>" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe></td>
		  </tr>
	  <?php }else{?>
		  <tr>
			<td width="220" height="100%">
			<iframe src="<?php echo $S_ROOT;?>jobs/lists?worked=0&views=<?php echo $_GET["views"];?>" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe>
			</td>
			<td width="3" class="mainside bgfocus"></td>
			<td class="scroll-wrapper">
			<iframe src="<?php echo $S_ROOT;?>pages" width="100%" height="100%" name="frminfo" scrolling="auto" noresize="noresize" id="frminfo" frameborder="no" style="" /></iframe>
			</td>
		  </tr>
	  <?php }?>
	  </table>
	</td>
  </tr>
</table>

</body>
</html>
