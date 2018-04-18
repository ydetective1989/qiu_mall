<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/frm.jobs.js?<?php echo date("YmdH");?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.jobs.js?<?php echo date("YmdH");?>"></script>
</head>
<body>


<?php if($list){ ?>

<?php if($_GET["views"]=="1"){?>

<div class="forms">

<table width="100%" class="tdcenter">

	<tr class="bgtips">
		<td width="100" class="tdleft">服务日期</td>
		<td width="80" class="tdleft" height="30">订单编号</td>
		<td width="100" class="tdleft">派工类型</td>
		<td class="tdleft">服务地址/服务内容</td>
		<td class="tdleft" width="80"><a href="<?php echo plugin::get2html(array('order'=>'adduserid','page'=>''));?>" class="<?php if($_GET["order"]=="adduserid"){ echo "gray"; }?>">派工人</a></td>
		<td class="tdleft" width="150"><a href="<?php echo plugin::get2html(array('order'=>'afteruserid','page'=>''));?>" class="<?php if($_GET["order"]=="afteruserid"){ echo "gray"; }?>">受派人</a></td>
		<td class="tdleft" width="110">销售门店</td>
		<td class="tdleft" width="80">确认状态</td>
		<td class="tdleft" width="80" class="">完成状态</td>
		<td class="" width="100" class="">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdleft"><?php echo $rs["datetime"];?></td>
		<td class="tdleft" height="30"><?php echo ($rs["ordersid"])?$rs["ordersid"]:"其它";?></td>
		<td class="tdleft"><?php echo $jobstype[$rs["type"]]["name"]?></td>
		<td class="tdleft"><?php echo plugin::cutstr($rs["address"],20,"..");?><br>
		<span class="gray"><?php echo $rs["detail"];?></span></td>
		<td class="tdleft"><?php echo $rs["addname"];?></td>
		<td class="tdleft"><?php echo plugin::cutstr($rs["aftername"],"5","");?><br><span class="gray"><?php echo $rs["afters"];?></span></td>
		<td class="tdleft"><?php echo plugin::cutstr($rs["salesname"],"7","")?></td>
		<td class="tdleft"><span class="pointer" onclick="checkjobs('<?php echo base64_encode($rs['id']);?>');"><?php echo ($rs["checked"])?"已确定":"未确认";?></span></td>
		<td class="tdleft"><span class="pointer" onclick="workjobs('<?php echo base64_encode($rs['id']);?>');"><font class="<?php echo $worktype[$rs["worked"]]["color"];?>"><?php echo $worktype[$rs["worked"]]["name"];?></font></span></td>
		<td class="tdleft"><span class="pointer" onclick="revise('<?php echo base64_encode($rs['id']);?>');">[调整]</span><a href="javascript:void(0)" onclick="parent.parent.addTab('查看工单[<?php echo $rs["id"];?>]','jobs/views?id=<?php echo base64_encode($rs["id"]);?>','jobsview');" >[查看]</a></td>
	</tr>
	<?php }?>
</table>

<?php }else{?>
<div class="lists">
<?php foreach($list AS $rs){?>
<div onclick="parent.frminfo.location.href='<?php echo $S_ROOT;?>jobs/views?id=<?php echo base64_encode($rs["id"]);?>';">
<table width="100%">
	<tr>
		<td class="tdleft">编号：<?php echo ($rs["id"])?$rs["id"]:"普通派工"?></td>
		<td class="tdright"><?php echo $jobstype[$rs["type"]]["name"]?></td>
	</tr>
	<tr>
		<td class="tdleft">时间：<?php echo $rs["datetime"]?></td>
		<td class="tdright"><?php echo ($rs["checked"])?"已确定":"未确认";?></td>
	</tr>
	<?php if($usertype=="1"){?>
	<tr>
		<td colspan="2" class="tdleft">销售：<?php echo plugin::cutstr($rs["salesname"],11,"..")?></td>
	</tr>
	<?php }?>
	<tr>
		<td class="tdleft">状态:<font class="<?php echo $worktype[$rs["worked"]]["color"];?>"><?php echo $worktype[$rs["worked"]]["name"];?></font></td>
		<td class="tdright green"><?php echo plugin::cutstr($rs["aftername"],6)?></td>
	</tr>
</table>
</div>
<?php }?>
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
		<td class="tdcenter">没有找到相关派工</td>
	</tr>
</table>
<?php }?>



<?php if($page){ ?>

<!-- 百度地图API -->
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/baidu.maps.js?<?php echo date("YmdH")?>"></script>
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
