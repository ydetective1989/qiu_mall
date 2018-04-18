<?php if($type=="iframe"){?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/counts.product.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">
<table width="100%" height="100%" >
  <tr>
    <td class="tools">
          <span><input type="text" name="godate" id="godate" class="input" value="<?php echo $godate;?>" style="width:100px;text-align:center;"> - <input type="text" name="todate" id="todate" class="input" value="<?php echo $todate;?>" style="width:100px;text-align:center;"></span>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/areas"></script>
		  <script type="text/javascript">var provid='';var cityid='';var areaid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.areas.js"></script>
		  <span><select name="provid" id="provid" class="select" style="width:150px;"></select>
	          <select name="cityid" id="cityid" class="select" style="width:150px;"></select>
	          <select name="areaid" id="areaid" class="select" style="width:150px;"></select></span>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=1&val=salesTeams"></script><!-- level=1& -->
		  <script type="text/javascript">var salesarea='0';var salesid='0';var saleuserid='';</script>
		  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
          <span><select name="salesarea" id="salesarea" class="select" ></select>
	          <select name="salesid" id="salesid" class="select" ></select>
	          <select name="saleuserid" id="saleuserid" class="select" >
	            <option value="">选择销售人员</option>
	            <?php if($users){ foreach($users AS $rs){?>
	            <option value="<?php echo $rs["userid"]?>"><?php echo $rs["worknum"]?>_<?php echo $rs["name"]?></option>
	            <?php }}?>
	          </select>
	      </span>
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
    <td colspan="4" height="30" class="tdcenter bold">产品类目统计</td>
  </tr>
  <tr class="bgtips">
    <td width="50%" height="30">分类名称</td>
    <td width="25%" >产品销量(件)</td>
    <td width="25%" >总金额(元)</td>
  </tr>
  <?php if($categoryarr){ ?>
  <?php foreach($categoryarr AS $rs){?>
  <tr>
    <td height="30"><?php echo ($rs["name"])?$rs["name"]:"其它";?></td>
    <td><?php echo (int)$rs["productnums"]?></td>
    <td><?php echo round($rs["productprice"],2)?></td>
  </tr>
  <?php }?>
  <?php }?>
</table>



<table width="100%">
  <tr class="bgheader">
    <td colspan="4" height="30" class="tdcenter bold">品牌销量统计</td>
  </tr>
  <tr class="bgtips">
    <td width="50%" height="30">品牌名称</td>
    <td width="25%" >产品销量(件)</td>
    <td width="25%" >总金额(元)</td>
  </tr>
  <?php if($brandarr){ ?>
  <?php foreach($brandarr AS $rs){?>
  <tr>
    <td height="30"><?php echo ($rs["name"])?$rs["name"]:"其它";?></td>
    <td ><?php echo (int)$rs["productnums"]?></td>
    <td ><?php echo round($rs["productprice"],2)?></td>
  </tr>
  <?php }?>
  <?php }?>
</table>



<table width="100%">
  <tr class="bgheader">
    <td colspan="4" height="30" class="tdcenter bold">产品销量统计[商品总价、非订单总价]</td>
  </tr>
  <tr class="bgtips">
    <td width="50%" height="30">产品名称</td>
    <td width="25%" >产品销量(件)</td>
    <td width="25%" >总金额(元)</td>
  </tr>
  <?php if($productarr){ ?>
  <?php foreach($productarr AS $rs){?>
  <tr>
    <td height="30"><?php echo ($rs["title"])?$rs["title"]:"其它";?></td>
    <td ><?php echo (int)$rs["productnums"]?></td>
    <td ><?php echo round($rs["productprice"],2)?></td>
  </tr>
  <?php }?>
  <?php }?>
</table>

 
<?php }else{?>

NULL

<?php }?>