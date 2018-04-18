<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jobs.js?<?php echo date("YmdH");?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.jobs.js?<?php echo date("YmdH");?>"></script>
</head>
<body>

<div class="info">
<table width="100%" class="title">
	<tr>
		<td class="tdleft bold size14">&nbsp;工单信息</td>
		<td class="tdright">
		<input type="button" id="checkbtn" value="<?php echo (!$info["checked"])?"工单确认":"已确认";?>" <?php if(!$info["checked"]){?>class="btnred" onclick="checkjobs('<?php echo base64_encode($info['id']);?>');"<?php }else{?>class="btnwhite"<?php }?> />
		<input type="button" value="指派服务人员" class="btnorange" onclick="revise('<?php echo base64_encode($info['id']);?>');" />
		<input type="button" value="工单回执" class="btnblue" onclick="workjobs('<?php echo base64_encode($info['id']);?>');" />
		<input type="button" value="操作记录" class="btnbrown" onclick="addlogs();" />
		<?php if(IS_FUWU=="1"){?>
		<input type="button" value="派给无忧服务" class="btnbrown" onclick="tofuwu('<?php echo base64_encode($info['id']);?>');" />
		<?php }?>
		<input type="button" value="修改工单" class="btngreen" onclick="editjobs('<?php echo base64_encode($info['id']);?>');" />
		<input type="button" value="刷新页面" class="button" onclick="location.reload();" />
		</td>
	</tr>
</table>

<table width="100%">
  <tr>
    <td colspan="3" class="headerfocus bgfocus"></td>
  </tr>
</table>

<!-- 百度地图API -->
  <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=EC1bb4d2591cdc482c712b0626f63066&s=1"></script>

<table width="100%" class="table">
  <input type="hidden" name="ordersid" id="ordersid" value="<?php echo base64_encode($ordersinfo["id"]);?>" />
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">工单信息</td>
  </tr>
  <tr>
    <td width="15%" class="tdright">工单编号：</td>
    <td width="35%"><?php echo $info["id"];?></td>
    <td width="15%" class="tdright">订单编号：</td>
    <td width="35%"><?php if($usertype=="1"){?><a href="<?php echo $S_ROOT;?>orders/views?id=<?php echo ($info["ordersid"])?base64_encode($info["ordersid"]):"";?>"><?php echo ($info["ordersid"])?$info["ordersid"]:"普通工单";?></a><?php }else{?><?php echo ($info["ordersid"])?$info["ordersid"]:"普通工单";?><?php }?></td>
  </tr>
  <?php if($info["contract"]){?>
  <tr>
    <td width="15%" class="tdright">工单合同：</td>
    <td width="85%" colspan="3"><?php echo $info["contract"];?></td>
  </tr>
  <?php }?>
  <tr>
    <td class="tdright">工单类型：</td>
    <td><?php echo $jobstype[$info["type"]]["name"];?></td>
    <td class="tdright">预约服务时间：</td>
    <td><?php echo $info["datetime"];?></td>
  </tr>
  <tr>
    <td class="tdright">预约服务站：</td>
    <td><?php echo $info["afters"]?></td>
    <td class="tdright">服务人员：</td>
    <td><?php echo $info["aftername"];?> <?php if($info["afterusermobile"]){?>|| <?php echo $info["afterusermobile"];?> <img src="<?php echo $S_ROOT;?>images/smsicon.jpg" onclick="sendsms('<?php echo $info["afterusermobile"]?>','');" class="pointer" align="absmiddle"><?php }?></td>
  </tr>
  <?php if($fuwuinfo["chargeinfo"]){?>
    <tr class="detailbg">
      <td height="35" class="tdright">服务结算提示：</td>
      <td class="" colspan="3"><?php echo $fuwuinfo["chargeinfo"];?></td>
    </tr>
  <?php }?>
  <tr class="detailbg">
    <td class="tdright">服务内容：</td>
    <td colspan="3"><?php echo $info["detail"];?></td>
  </tr>
  <tr>
      <td class="tdright">派工人员：</td>
      <td><?php echo $info["addname"]?></td>
      <td class="tdright">派工时间：</td>
      <td><?php echo date("Y-m-d H:i",$info["dateline"]);?></td>
  </tr>

  <?php if($info["checked"]=="1"){?>
  <tr>
    <td class="tdright">工单确认：</td>
    <td><?php echo $info["checkuname"]?></td>
    <td class="tdright">确认日期：</td>
    <td><?php echo date("Y-m-d H:i",$info["checkdate"]);?></td>
  </tr>
  <?php }?>


  <?php if($info["worked"]){?>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">工单回执</td>
  </tr>
  <tr class="">
    <td class="tdright">回执状态：</td>
    <td colspan="3"><?php echo $worktype[$info["worked"]]["name"];?></td>
  </tr>
  <tr class="">
      <td class="tdright">回执来源：</td>
      <td colspan="3"><?php echo $workto[(int)$info["workto"]]["name"];?></td>
  </tr>
  <tr class="">
    <td class="tdright">完成时间：</td>
    <td colspan="3"><?php echo $info["workdate"];?></td>
  </tr>
  <tr class="">
    <td class="tdright">回执内容：</td>
    <td colspan="3"><?php echo $info["workdetail"];?></td>
  </tr>
  <tr class="">
    <td class="tdright">回执操作人：</td>
    <td colspan="3"><?php echo $info["workname"];?></td>
  </tr>
  <?php }?>

  <?php if($ordersinfo){ ?>
  <?php $dateline = time()-86400*15; if($info["workdateline"]>$dateline||$usertype=="1"||!$info["workdateline"]){?>
  <tr class="bgtips">
    <td colspan="4" class="tdcenter">客户信息</td>
  </tr>
  <tr>
    <td class="tdright">客户姓名：</td>
    <td><?php echo $ordersinfo["name"];?></td>
    <td class="tdright">所在地区：</td>
    <td><?php echo $ordersinfo["provname"];?> <?php echo $ordersinfo["cityname"];?> <?php echo $ordersinfo["areaname"];?></td>
  </tr>
  <tr>
    <td class="tdright">联系地址：</td>
    <td colspan="3"><?php echo $ordersinfo["address"];?><?php if($ordersinfo["loops"]){ echo  "（".$looptype[$ordersinfo["areaid"]]["lists"][$ordersinfo["loops"]]["name"]."）"; }?> <?php echo ($ordersinfo["postnum"])?" 邮编：".$ordersinfo["postnum"]."]":"";?><?php if($ordersinfo["pointlng"]&&$ordersinfo["pointlat"]){?><input type="button" value="查看地图"  onclick="viewmaps('<?php echo base64_encode($ordersinfo["id"]);?>');" /><?php }?>

    </td>
  </tr>
  <tr>
    <td class="tdright">手机号码：</td>
    <td><?php echo $ordersinfo["mobile"];?></td>
    <td class="tdright">其它电话：</td>
    <td><?php echo $ordersinfo["phone"];?></td>
  </tr>

  <tr class="bgtips">
    <td colspan="4" class="tdcenter">订单信息</td>
  </tr>  <tr>
    <td class="tdright">订单编号：</td>
    <td><?php echo $ordersinfo["id"];?></td>
    <td class="tdright">订单类型：</td>
    <td><?php echo $ordertype[$ordersinfo["type"]]["name"];?></td>
  </tr>
  <tr>
    <td class="tdright">审核状态：</td>
    <td><?php echo $checktype[(int)$ordersinfo["checked"]]["name"];?></td>
    <td class="tdright">订单进度：</td>
    <td><?php echo $statustype[(int)$ordersinfo["status"]]["name"];?></td>
  </tr>
  <tr>
    <td class="tdright">订购时间：</td>
    <td><?php echo $ordersinfo["datetime"];?></td>
    <td class="tdright">合同编号：</td>
    <td><?php echo $ordersinfo["contract"];?></td>
  </tr>
  <tr>
    <td class="tdright">安装方式：</td>
    <td><?php echo $setuptype[(int)$ordersinfo["setuptype"]]["name"];?></td>
    <td class="tdright">送货方式：</td>
    <td><?php echo $delivertype[(int)$ordersinfo["delivertype"]]["name"];?></td>
  </tr>
  <tr>
    <td class="tdright">计划送货时间：</td>
    <td><?php echo $ordersinfo["plansend"];?></td>
    <td class="tdright">计划安装时间：</td>
    <td><?php echo $ordersinfo["plansetup"];?></td>
  </tr>
  <tr class="detailbg">
    <td class="tdright">订单备注：</td>
    <td colspan="3"><?php echo $info["detail"];?></td>
  </tr>
  <tr>
    <td colspan="4" style="padding:0px;">
    	<table width="100%" class="parinfo">
    		<tr class="bgtips">
    			<td width="80" class="tdcenter">产品编码</td>
    			<td width="150" class="tdcenter">序列编号</td>
    			<td class="tdcenter">产品名称/产品SN/备注信息</td>
    			<td width="80" class="tdcenter">数量</td>
    			<?php if($usertype=="1"){?>
    			<td width="80" class="tdcenter">单价</td>
    			<?php }?>
    		</tr>
    		<?php if($orders_product){?>
    		<?php foreach($orders_product AS $rs){?>
    		<tr class="datas">
    			<td class="tdcenter"><?php echo $rs["encoded"]?></td>
    			<td class="tdcenter"><?php echo ($rs["serials"])?$rs["serials"]:"无"?></td>
    			<td class="tdleft"><?php if($rs["serials"]){ echo "[<font class='gray'>".$rs["serials"]."] "; }?><a href="http://www.1j.cn/product/<?php echo $rs["encoded"];?>.html" target="_blank"><?php echo $rs["title"]?></a><?php if($rs["detail"]){ echo "(<font class='red'>".$rs["detail"].")"; }?></td>
    			<td class="red tdcenter"><?php echo $rs["nums"]?></td>
    			<?php if($usertype=="1"){?>
    			<td class="red tdcenter"><?php echo $rs["price"]?>元</td>
    			<?php }?>
    		</tr>
    		<?php }?>
    		<?php }else{?>
    		<tr class="datas">
    			<td colspan="4" class="tdcenter">暂无订购信息</td>
    		</tr>
    		<?php }?>
    	</table>
    </td>
  </tr>

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">客户标签</td>
  </tr>
  <tr>
    <td colspan="4">
    <input type="hidden" name="tags_ordersid" id="tags_ordersid" value="<?php echo ($ordersinfo["parentid"])?base64_encode($ordersinfo["parentid"]):base64_encode($ordersinfo["id"]);?>">
    <?php
    $customsid = base64_encode((int)$ordersinfo["customsid"]);
    include(VIEW."customs.tags.page.php");
    ?>
    </td>
  </tr>

  <tr class="bgtips">
    <td colspan="4" class="tdcenter">其它信息</td>
  </tr>

  <?php if($usertype=="1"){?>
  <tr>
    <td class="tdright">审核操作：</td>
    <td><?php if($ordersinfo["checked"]){?><?php echo $ordersinfo["checkname"];?> <?php echo date("Y-m-d H:i:s",$ordersinfo["checkdate"]);?><?php }else{ echo "无"; }?></td>
    <td class="tdright">订单录入：</td>
    <td><?php echo $ordersinfo["addname"];?> <?php echo date("Y-m-d H:i:s",$ordersinfo["dateline"]);?></td>
  </tr>
  <tr>
    <td class="tdright">订单销售：</td>
    <td><?php echo $ordersinfo["salesname"];?> <?php echo $ordersinfo["salesuname"];?></td>
    <td class="tdright">服务人员：</td>
    <td><?php echo $ordersinfo["aftername"];?> <?php echo $ordersinfo["afteruname"];?></td>
  </tr>
  <?php }?>

  <?php }?>
  <?php }?>

</table>




<input type="hidden" name="focus_id" id="focus_id" value="<?php echo base64_encode($info["id"]);?>" />
<input type="hidden" name="focus_cates" id="focus_cates" value="gd" />
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/focus.js?<?php echo date("Ymd")?>"></script>
<div class="focus_div" id="focus_div"></div>
<script type="text/javascript">focus_page();</script>

<?php
$usered = 1;
if($usertype!="1"){
	$hidetab = "logs";
	$hidekd = 1;
	$hidefp = 1;
	$hidewl = 1;
	$hidedd = 1;
}
?>

<?php include(VIEW."orders.viewinfo.php");?>



</div>
</body>
</html>
