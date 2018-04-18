<?php if($type=="iframe"){?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/counts.degreelogs.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">
<table width="100%" height="100%" >
  <tr>
    <td class="tools">
          <span><input type="text" name="godate" id="godate" class="input" value="<?php echo $godate;?>" style="width:100px;text-align:center;"> - <input type="text" name="todate" id="todate" class="input" value="<?php echo $todate;?>" style="width:100px;text-align:center;"></span>
          <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=1&val=salesTeams"></script>
          <script type="text/javascript">var salesarea='0';var salesid='0';var saleuserid='';</script>
          <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
          <span><select name="salesarea" id="salesarea" class="select" ></select>
          <select name="salesid" id="salesid" class="select"></select>
          </span>
          <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=3&val=afterTeams"></script>
          <script type="text/javascript">var afterarea='0';var afterid='0';var afteruserid='';</script>
          <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.after.js"></script>
          <span><select name="afterarea" id="afterarea" class="select"></select>
          <select name="afterid" id="afterid" class="select"></select>
          </span>
          <span><input type="button" onclick="countsd()" value="统计数据" class="button" ></span>
<!--          <span><input type="button" onclick="xlsed()" value="导出数据" class="button" ></span>-->
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
  <tr class="bgtips">
    <td height="30">服务中心|工程师</td>
    <td width="80" >当期工单</td>
    <td width="80" >累计完成</td>
    <td width="80" >累计回访</td>
    <td width="80" >当期回访</td>
    <td width="80" >非常满意</td>
    <td width="80" >满意</td>
    <td width="80" >一般</td>
    <td width="80" >不满意</td>
    <td width="80" >满意度</td>
  </tr>
  <?php if($rows){?>
  <?php foreach($rows AS $rs){?>
  <tr>
    <td height="30"><?php echo $rs["teamname"]?>||<?php echo $rs["aftername"]?></td>
    <td><?php echo (int)$rs["jobnums"]?></td>
    <td><?php echo (int)$rs["worknum"];?></td>
    <td><?php echo (int)$rs["callall"];?></td>
    <td><?php echo (int)$rs["callnum"];?></td>
    <td><?php echo (int)$rs["good"];?></td>
    <td><?php echo (int)$rs["cool"];?></td>
    <td><?php echo (int)$rs["hehe"];?></td>
    <td><?php echo (int)$rs["nono"];?></td>
    <td><?php echo ($rs["callnum"])?@round(($rs["good"]+$rs["cool"])/$rs["callnum"]*100,2):"0";?>%</td>
  </tr>
  <?php }?>
  <?php }else{?>

    <tr>
      <td colspan="10" height="30" class="tdcenter bold">没有统计到相关数据</td>
    </tr>

  <?php }?>
</table>


<?php }else{?>

NULL

<?php }?>