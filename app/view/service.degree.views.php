<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/service.degree.js?<?php echo date("Ymd");?>"></script>
</head>
<body>
<div class="info">
<table width="100%" class="title">
	<tr>
		<td class="tdleft bold size14">&nbsp;满意度回访</td>
		<td class="tdright">
		<input type="button" value="满意度回执" class="btnred" onclick="degreed();" />
		<input type="button" value="增加操作记录" class="btngreen" onclick="addlogs();" />
		</td>
	</tr>
</table>

<table width="100%">
  <tr>
    <td colspan="3" class="headerfocus bgfocus"></td>
  </tr>
</table>

<table width="100%" class="table">
  <input type="hidden" name="ordersid" id="ordersid" value="<?php echo ($orderinfo["id"])?base64_encode((int)$orderinfo["id"]):"";?>" />
  <input type="hidden" name="jobsid" id="jobsid" value="<?php echo ($jobsinfo["id"])?base64_encode((int)$jobsinfo["id"]):"";?>" />
  <input type="hidden" name="id" id="id" value="<?php echo ($info["id"])?base64_encode((int)$info["id"]):"";?>" />

  <?php if($info){?>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">满意度回访信息</td>
  </tr>
  <?php if($info["sales"]){?>
  <tr>
    <td width="15%" class="tdright">销售人员：</td>
    <td width="35%"><?php echo $info["salesname"];?> - <?php echo $info["salesuname"];?></td>
    <td width="15%" class="tdright">销售评分：</td>
    <td width="35%"><?php echo $info["sales"];?></td>
  </tr>
  <tr>
    <td class="tdright">销售反馈：</td>
    <td colspan="3"><?php echo $info["salesinfo"]?></td>
  </tr>
  <?php }?>
  <?php if($info["after"]){?>
  <tr>
    <td class="tdright">服务人员：</td>
    <td><?php echo $info["aftername"];?> - <?php echo $info["afteruname"];?></td>
    <td class="tdright">服务评分：</td>
    <td><?php echo $info["after"];?></td>
  </tr>
  <tr>
    <td class="tdright">服务反馈：</td>
    <td colspan="3">
			<?php
			$afterinfo = $info["afterinfo"];
			$afterjson = json_decode($afterinfo,true);
			if($afterjson){
				foreach($afterjson AS $rs){
						echo $rs["name"]."：".$rs["val"]."；";
				}
			}else{
				echo $afterinfo;
			}
			?></td>
  </tr>
  <?php }?>
  <tr>
    <td class="tdright">回访批注：</td>
    <td colspan="3"><?php echo $info["detail"]?></td>
  </tr>
  <tr>
    <td class="tdright">回访操作人：</td>
    <td><?php echo $info["callname"];?></td>
    <td class="tdright">回访操作时间：</td>
    <td><?php echo date("Y-m-d H:i:s",$info["dateline"]);?></td>
  </tr>
  <?php }?>

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">订单信息</td>
  </tr>
  <tr>
    <td width="15%" class="tdright">订单编号：</td>
    <td width="35%"><?php echo $orderinfo["id"];?></td>
    <td width="15%" class="tdright">订单流水号：</td>
    <td width="35%"><?php echo $orderinfo["customsid"];?></td>
  </tr>
  <tr>
    <td class="tdright">类型：</td>
    <td><?php echo $ordertype[$orderinfo["type"]]["name"];?></td>
    <td class="tdright">订单进度：</td>
    <td><?php echo $statustype[(int)$orderinfo["status"]]["name"];?></td>
  </tr>
  <tr>
    <td class="tdright">订购时间：</td>
    <td><?php echo $orderinfo["datetime"];?></td>
    <td class="tdright">合同编号：</td>
    <td><?php echo $orderinfo["contract"];?></td>
  </tr>
  <tr>
    <td class="tdright">安装方式：</td>
    <td><?php echo $setuptype[(int)$orderinfo["setuptype"]]["name"];?></td>
    <td class="tdright">送货方式：</td>
    <td><?php echo $delivertype[(int)$orderinfo["delivertype"]]["name"];?></td>
  </tr>
  <tr>
    <td class="tdright">计划送货时间：</td>
    <td><?php echo $orderinfo["plansend"];?></td>
    <td class="tdright">计划安装时间：</td>
    <td><?php echo $orderinfo["plansetup"];?></td>
  </tr>
  <tr>
    <td class="tdright">订单备注：</td>
    <td colspan="3"><?php echo $orderinfo["detail"];?></td>
  </tr>
</table>

<?php
$usered = 1;
$hidekd = 1;
$hideyw = 1;
$hidejobs = 1;
$hidefp = 1;
$hidewl = 1;
$hidefy = 1;
$hideqt = 1;
$hidets = 1;
$hidepay = 1;
$hidetab = "logs";
?>
<?php include(VIEW."orders.viewinfo.php");?>



</div>
</body>
</html>
