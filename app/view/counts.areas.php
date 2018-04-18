<?php if($type=="iframe"){?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/counts.areas.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">
<table width="100%" height="100%" >
  <tr>
    <td class="tools">
          <span>订购日期：<input type="text" name="godate" id="godate" class="input" value="<?php echo $godate;?>" style="width:100px;text-align:center;"> - <input type="text" name="todate" id="todate" class="input" value="<?php echo $todate;?>" style="width:100px;text-align:center;"></span>
          <script type="text/javascript" src="<?php echo $S_ROOT;?>json/areas"></script>
		  <script type="text/javascript">var provid='';var cityid='';var areaid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.areas.js"></script>
		  <span><select name="provid" id="provid" class="select" style="width:150px;"></select>
	          <select name="cityid" id="cityid" class="select" style="width:150px;"></select>
	          <select name="areaid" id="areaid" class="select" style="width:150px; display:none;"></select></span>
	      <span><input type="button" onclick="countsd()" value="统计数据" class="button" ></span>
    </td>
  </tr>
  <tr>
    <td class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td height="100%">
    <iframe src="<?php echo $S_ROOT;?>counts/pages" width="100%" height="100%" name="frminfo" scrolling="auto" noresize="noresize" id="frminfo" frameborder="no" style="" /></iframe>
    </td>
  </tr>
</table>
</body>
</html>

<?php }elseif($type=="show"){?>

<table width="100%">
  <tr class="bgheader">
    <td colspan="6" height="30" class="tdcenter bold">整体统计</td>
  </tr>
  <tr class="bgtips">
    <td>客户总数</td>
    <td>主订单数</td>
    <td>激活客户数</td>
    <td>激活订单数</td>
    <td>激活率</td>
  </tr>
  <tr>
    <td height="30"><?php echo (int)$customsnums;?></td>
    <td><?php echo (int)$ordersnums;?></td>
    <td><?php echo (int)$pcustomsnums;?></td>
    <td><?php echo (int)$pordersnums;?></td>
    <td><?php echo ((int)$ordersnums&&$pordersnums)?round((int)$pordersnums/(int)$ordersnums*100,5):"0"?>%</td>
  </tr>
</table>

<table width="100%">
  <tr class="bgheader">
    <td colspan="6" height="30" class="tdcenter bold">区域统计</td>
  </tr>
  <tr class="bgtips">
    <td>区域/城市</td>
    <td>客户总数</td>
    <td>主订单数</td>
    <td>激活客户数</td>
    <td>激活订单数</td>
    <td>激活率</td>
  </tr>
  <?php if($arealists){ foreach($arealists AS $rs){?>
  <tr>
    <td height="30"><?php echo $rs["name"];?></td>
    <td><?php echo (int)$rs["customsnums"];?></td>
    <td><?php echo (int)$rs["ordersnums"];?></td>
    <td><?php echo (int)$rs["pcustomsnums"];?></td>
    <td><?php echo (int)$rs["pordersnums"];?></td>
    <td><?php echo ((int)$rs["ordersnums"]&&$rs["pordersnums"])?round((int)$rs["pordersnums"]/(int)$rs["ordersnums"]*100,5):"0"?>%</td>
  </tr>
  <?php }}?>
</table>  
  
<?php }else{?>

NULL

<?php }?>