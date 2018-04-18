<?php if($type=="iframe"){?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/counts.clockd.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">
<table width="100%" height="100%" >
  <tr>
    <td class="tools">
          <span><input type="text" name="godate" id="godate" class="input" value="<?php echo $godate;?>" style="width:100px;text-align:center;"> - <input type="text" name="todate" id="todate" class="input" value="<?php echo $todate;?>" style="width:100px;text-align:center;"></span>
	      <span><select name="calluserid" id="calluserid" class="select" >
	            <option value="">选择回访人员</option>
	            <?php if($users){ foreach($users AS $rs){?>
	            <option value="<?php echo $rs["userid"]?>"><?php echo $rs["worknum"]?>_<?php echo $rs["name"]?></option>
	            <?php }}?>
	          </select></span>
	      <span><input type="button" onclick="countsd()" value="统计数据" class="button" ></span>
          <!-- <div style="clear:both"></div>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=1&val=salesTeams"></script>
		  <script type="text/javascript">var salesarea='0';var salesid='0';var saleuserid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
          <span><select name="salesarea" id="salesarea" ></select>
	          <select name="salesid" id="salesid" ></select>
	      </span>
	      <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=3&val=afterTeams"></script>
		  <script type="text/javascript">var afterarea='0';var afterid='0';var afteruserid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.after.js"></script>
          <span><select name="afterarea" id="afterarea" ></select>
	          <select name="afterid" id="afterid" ></select>
	      </span> -->
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
    <td colspan="6" height="30" class="tdcenter bold">回访统计</td>
  </tr>
  <tr class="bgtips">
    <td>服务订单数</td>
    <td>服务客户数</td>
    <td>客户总数</td>
    <td>服务激活率</td>
    <td>提醒操作量</td>
    <td>销售金额</td>
  </tr>
  <tr>
    <td height="30"><?php echo (int)$ordernums;?></td>
    <td><?php echo (int)$servicecustoms;?></td>
    <td><?php echo (int)$allcustoms;?></td>
    <td><?php echo ((int)$servicecustoms&&$allcustoms)?round((int)$servicecustoms/(int)$allcustoms*100,5):"0"?>%</td>
    <td><?php echo (int)$clockdnums;?></td>
    <td><?php echo round($oprice,2);?></td>
  </tr>
</table>

<?php if($userscount){?>
<table width="100%">
  <tr class="bgheader">
    <td colspan="7" height="30" class="tdcenter bold">服务人员回访统计</td>
  </tr>
  <tr class="bgtips">
    <td width="25%" height="30">服务人员</td>
    <td >服务订单数</td>
    <td >服务客户数</td>
    <td >服务激活率</td>
    <td >提醒操作量</td>
    <td >销售金额</td>
  </tr>
  <?php foreach($userscount AS $rs){?>
  <tr>
    <td height="30"><?php echo $rs["worknum"]?>_<?php echo $rs["name"]?></td>
    <td><?php echo (int)$rs["ordernums"]?></td>
    <td><?php echo (int)$rs["servicecustoms"];?></td>
    <td><?php echo ((int)$rs["servicecustoms"]&&$allcustoms)?round((int)$rs["servicecustoms"]/(int)$allcustoms*100,5):"0";?>%</td>
    <td><?php echo (int)$rs["clockdnums"];?></td>
    <td><?php echo round($rs["oprice"],2)?></td>
  </tr>
  <?php }?>
</table>
<?php }?>
 
<?php }else{?>

NULL

<?php }?>