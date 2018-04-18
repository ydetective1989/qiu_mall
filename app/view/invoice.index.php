<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/invoice.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">

<table width="100%" height="100%" >
  <tr>
    <td align="center">
	<div class="forms">
      <table width="100%" >
		  <tr>
		    <td height="35" class="bold">&nbsp;发票开票系统</td>
		    <td class="tdright">
	    	  <form method="post" name="searchFrm" id="searchFrm" action="">
	    	  <input type="hidden" name="status" id="status" value="1">
         	  <span><select name="sotype" id="sotype" class="select">
         	  <option value="1">订单编号</option>
         	  <option value="2">发票编号</option>
         	  <option value="3">申请编号</option>
         	  </select></span>
         	  <span><input type="text" name="sokey" id="sokey" class="input" value="" style="width:120px;"></span>
         	  <span><select name="type" id="type" class="select">
				<option value="" selected>所有发票类型</option>
				<option value="0" >增值税普通发票</option>
				<option value="1" >增值税专用发票</option>
				</select>
         	  </span>
         	  <span><select name="cateid" id="cateid" class="select">
			    <option value="">选择开票单位</option>
			    <?php foreach($catetype AS $rs){?>
			    <option value="<?php echo $rs["id"];?>" <?php if((int)$info["cateid"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"];?></option>
			    <?php }?>
			    </select></span>
	          <span><input type="button" class="button" onclick="focustabs(7,7,'otabs_','ed|null');invoice_search('7')" value="搜索记录"></span>
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
    <td class="tooltabs bgheader" valign="top">
	<ul>
		<li id="otabs_1" class="ed" onclick="focustabs(1,7,'otabs_','ed|null');invoice_search('1');">等待审核</li>
		<li id="otabs_2" onclick="focustabs(2,7,'otabs_','ed|null');invoice_search('2');">等待开票</li>
		<li id="otabs_3" onclick="focustabs(3,7,'otabs_','ed|null');invoice_search('3');">已开票据</li>
		<li id="otabs_4" onclick="focustabs(4,7,'otabs_','ed|null');invoice_search('4');">审核未通过</li>
		<li id="otabs_5" onclick="focustabs(5,7,'otabs_','ed|null');invoice_search('5');">申请取消</li>
		<li id="otabs_6" onclick="focustabs(6,7,'otabs_','ed|null');invoice_search('6');">票据作废</li>
		<li id="otabs_7" onclick="focustabs(7,7,'otabs_','ed|null');invoice_search('7');">全部票据</li>
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
			<iframe src="<?php echo $S_ROOT;?>invoice/lists?status=0" width="100%" height="100%" name="frmlist" scrolling="auto" noresize="noresize" id="frmlist" class="frmlist" frameborder="no" style="" /></iframe>
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