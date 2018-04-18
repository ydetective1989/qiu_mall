<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jobs.feedback.js?<?php echo date("Ymd");?>"></script>
</head>
<body>
<div class="info">
<table width="100%" class="title">
	<tr>
		<td class="tdleft bold size14">&nbsp;预约编号：[<?php echo (int)$info["id"];?>]</td>
		<td class="tdright">
		<input type="button" value="受理操作" class="btngreen" onclick="checkede('<?php echo base64_encode($info["id"]);?>');" />
		</td>
	</tr>
</table>

<table width="100%">
  <tr>
    <td colspan="3" class="headerfocus bgfocus"></td>
  </tr>
</table>

<table width="100%" class="table">
  <input type="hidden" name="id" id="id" value="<?php echo ($info["id"])?base64_encode($info["id"]):"";?>" />
  <tr class="bgheader">
    <td colspan="2" class="tdcenter">客户预约信息</td>
  </tr>
  <tr>
    <td height="0" class="tdcenter"></td>
  </tr>
  <tr>
    <td width="25%" class="tdright">信息类型：</td>
    <td><?php switch($info["type"]){
    	case "1": echo "安装"; break;
    	case "2": echo "报修"; break;
    	default	: echo "登记";
     };?></td>
  </tr>
  <tr>
    <td width="25%" class="tdright">当前状态：</td>
    <td><?php switch($info["checked"]){
    	case "1": echo "受理完成"; break;
    	case "2": echo "预约取消"; break;
    	default	: echo "等待处理";
     };?></td>
  </tr>
  <?php if($info["checked"]=="1"){?>
  <tr>
    <td class="tdright">受理操作：</td>
    <td><?php echo $info["checkuname"]." 于 ".date("Y-m-d H:i:s",$info["checkdate"]); ?></td>
  </tr>
  <tr>
    <td class="tdright">受理批注：</td>
    <td><?php echo $info["checkinfo"]?></td>
  </tr>
  <?php }?>
  <tr>
    <td height="0" class="tdcenter"></td>
  </tr>

  <tr class="bgheader">
    <td colspan="2" class="tdcenter">客户预约信息</td>
  </tr>
  <tr>
    <td height="0" class="tdcenter"></td>
  </tr>
	<?php if($info["makedate"]){?>
  <tr>
    <td width="25%" class="tdright">生产日期：</td>
    <td><?php echo $info["makedate"];?></td>
  </tr>
	<?php }?>
	<?php if($info["setupdate"]){?>
  <tr>
    <td width="25%" class="tdright">安装日期：</td>
    <td><?php echo $info["setupdate"];?></td>
  </tr>
	<?php }?>
  <tr>
    <td width="25%" class="tdright">客户姓名：</td>
    <td><?php echo $info["name"];?></td>
  </tr>
	<?php
	$cityname = ($info["cityname"])?$info["cityname"]." ":"";
	$areaname = ($info["areaname"])?$info["areaname"]." ":"";
	$address = $cityname.$areaname.$info["address"];
	$urlto = "http://api.map.baidu.com/geocoder?address=".urlencode($address)."&output=html";
	?>
  <tr>
    <td class="tdright">所在地区：</td>
    <td><?php echo $info["provname"]." ".$info["cityname"]." ".$info["areaname"];?></td>
  </tr>
  <tr>
    <td class="tdright">联系地址：</td>
    <td><?php echo $info["address"];?> <input type="button" class="button" value="查询地图" onclick="window.open('<?php echo $urlto;?>')"></td>
  </tr>
  <tr>
    <td class="tdright">联系电话：</td>
    <td><?php echo $info["phone"];?></td>
  </tr>
  <tr>
    <td class="tdright">购买渠道：</td>
    <td><?php echo $info["itembuy"];?></td>
  </tr>
  <tr>
    <td class="tdright">产品编码：</td>
    <td><?php echo $info["itemcontract"];?></td>
  </tr>
  <tr>
    <td class="tdright">产品名称：</td>
    <td><?php echo $info["itemname"];?></td>
  </tr>
  <tr>
    <td class="tdright">预约留言：</td>
    <td><?php echo $info["detail"];?></td>
  </tr>
  <tr>
    <td class="tdright">预约时间：</td>
    <td><?php echo date("Y-m-d H:i:s",$info["dateline"]);?></td>
  </tr>
	<?php if(!empty($info["upfiles"])) {  ?>
		<tr>
			<td class="tdright">产品图片：</td>
			<td><img src="<?php echo OSS_URL;?><?php echo $info['upfiles'];?>"/></td>
		</tr>
	<?php	} ?>

</table>


</div>
</body>
</html>
