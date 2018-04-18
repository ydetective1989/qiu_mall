<?php if($show){?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<?php include(VIEW."config.script.php");?>
	<script type="text/javascript" src="<?php echo $S_ROOT?>js/orders.files.js"></script>
</head>

<body style="background:#FFF;">
<form action="" method="post" name="upfileto" id="upfileto" enctype="multipart/form-data">
<table width="100%" class="table">
	<tr>
		<td height="35" width="100" class="tdright">订单编号：</td>
		<td class=""><?php echo $orderinfo["id"]?> </td>
	</tr>
	<tr>
		<td height="35" width="100" class="tdright">附件类型：</td>
		<td class=""> <select name="type" id="type" class="select">
				<option value="">请选择文件类型</option>
				<?php foreach($filetype AS $rs){?>
					<option value="<?php echo $rs["id"]?>"><?php echo $rs["name"]?></option>
				<?php }?>
			</select> </td>
	</tr>
<?php if($taskjobs){?>
	<tr>
		<td height="35" width="100" class="tdright">工单任务：</td>
		<td class=""><select name="jobsid" id="jobsid" class="select">
				<option value="0">选择工单ID</option>
				<?php foreach($taskjobs AS $rs){?>
					<option value="<?php echo $rs["id"]?>"><?php echo $rs["id"]?></option>
				<?php }?>
			</select> *</td>
	</tr>
<?php }else{?>
	<input type="hidden" name="jobsid" id="jobsid" value="0">
<?php }?>
	<tr>
		<td height="35" class="tdright">上传附件：</td>
		<td class=""> <input type="file" name="files_upload" id="files_upload"></td>
	</tr>
	<tr>
		<td height="35" class="tdright">附件备注：</td>
		<td class=""> <input type="text" name="detail" id="detail" class="input" style="width:300px;"></td>
	</tr>

	<tr>
		<td height="35" class="tdright"></td>
		<td class="">
			<input type="button" class="button" id="btned" onclick="orders_upfiled()" value="上传图片">
			<input type="button" class="btnred" onclick="parent.closedialog()" value="取消"></td>
	</tr>
</table>
</form>
</body>
</html>
<?php }else{?>
<table width="500">
  <tr>
	<td><iframe src="<?php echo $S_ROOT;?>orders/upload?show=1&ordersid=<?php echo base64_encode((int)$orderinfo["id"]);?>" width="100%" height="250" name="upshow" scrolling="no" noresize="noresize" id="frminfo" frameborder="no" /></iframe></td>
  </tr>
</table>
<?php }?>
