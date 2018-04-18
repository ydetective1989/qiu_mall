<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
</head>
<body>

<div class="lists">
<?php if($list){ ?>
<?php foreach($list AS $rs){?>
<div onclick="parent.frminfo.location.href='<?php echo $S_ROOT;?>jobs/feedback?mo=views&id=<?php echo ($rs["id"])?base64_encode($rs["id"]):"";?>';">
<table width="100%">
	<tr>
		<td class="tdleft" colspan="2">预约编号:<?php echo $rs["id"]?></td>
	</tr>
	<tr>
		<td class="tdleft" colspan="2">客户姓名：<?php echo $rs["name"];?></td>
	</tr>
	<tr>
		<td class="tdleft" colspan="2">提交时间：<?php echo date("Y-m-d",$rs["dateline"]);?></td>
	</tr>
</table>
</div>
<?php }?>
<table width="100%">
	<tr>
		<td class="tdcenter" height="30"></td>
	</tr>
</table>
<?php }else{?>
<table width="100%">
	<tr>
		<td class="tdcenter">没有找到预约信息</td>
	</tr>
</table>
<?php }?>
</div>


<?php if($page){ ?>
<div class="bottom_tools">
<table width="100%" class="pagenav bgheader">
	<tr>
		<td class="tdcenter"><?php echo $page;?></td>
	</tr>
</table>
</div>
<?php }?>

</body>
</html>