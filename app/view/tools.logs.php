<?php if($type=="iframe"){?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/tools.logs.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">
<table width="100%" height="100%" >
  <tr>
    <td class="tools">
		<span>
          <span><select name="cateid" id="cateid" class="select">
          	<option value="1">订单编号</option>
          	<option value="2">模糊搜索</option>
            <option value="3">用户ID</option>
          </select></span>
          <span><input type="text" name="keyword" id="keyword" class="input" value="" style="width:130px;"></span>
          <span><select name="name" id="name" class="select">
          	<option value="">操作类型</option>
          	<?php foreach($namelist AS $rs){?>
          	<option value="<?php echo $rs?>"><?php echo $rs?></option>
          	<?php }?>
          </select></span>
          <span><input type="text" name="godate" id="godate" class="input" value="<?php echo $godate;?>" style="width:100px;text-align:center;"> - <input type="text" name="todate" id="todate" class="input" value="<?php echo $todate;?>" style="width:100px;text-align:center;"></span>
	      <span><input type="button" onclick="search()" value="查询记录" class="button" ><input type="button" onclick="xls()" value="导出记录" class="btnorange" ></span>
    </td>
  </tr>
  <tr>
    <td class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td height="100%">
    <iframe src="<?php echo $S_ROOT;?>pages" width="100%" height="100%" name="frminfo" scrolling="auto" noresize="noresize" id="frminfo" frameborder="no" style="" /></iframe>
    </td>
  </tr>
</table>
</body>
</html>

<?php }elseif($type=="list"){?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/tools.logs.js"></script>
</head>
<body>

<div class="forms">
<table width="100%" class="tdcenter" id="list">
<thead>
  <tr class="bgheader">
    <td width="170" height="30" class="tdleft">操作时间</td>
    <td width="80" class="tdleft">类型</td>
    <td width="200" class="tdleft">类型</td>
    <td class="tdleft">内容</td>
    <td width="130" class="tdleft">IP</td>
    <td width="120" class="tdleft">操作人</td>
    <td width="50" class="tdcenter">详情</td>
  </tr>
  <?php if($list){?>
  <?php foreach($list AS $rs){?>
  <tr class="datas">
    <td class="tdleft" height="30"><?php echo date("Y-m-d H:i:s",$rs["dateline"]);?></td>
    <td class="tdleft"><?php echo $rs["type"];?></td>
    <td class="tdleft">[<?php echo $rs["ordersid"];?>]<?php echo $rs["name"];?></td>
    <td class="tdleft gray"><?php echo $rs["detail"];?></td>
    <td class="tdleft"><?php echo $rs["ip"];?></td>
    <td class="tdleft"><?php echo $rs["userid"];?></td>
    <td class="tdcenter"><span class="pointer" onclick="views('<?php echo base64_encode($rs["_id"]);?>')">查看</span></td>
  </tr>
  <?php }?>
  <?php }?>
</table>
</div>

<br>
<br>
<br>
<br>

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

<?php }elseif($type=="show"){?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/tools.logs.js"></script>
</head>
<body>

<table width="550" class="table">
  <tr class="bgheader">
    <td colspan="2" height="30" class="tdcenter">查看记录详情</td>
  </tr>
  <tr>
    <td width="130" height="30" class="tdright">操作时间：</td>
    <td><?php echo date("Y-m-d H:i:s",$info["dateline"]);?></td>
  </tr>
  <tr>
    <td height="30" class="tdright">操作人：</td>
    <td><?php echo $info["worknum"];?>_<?php echo $info["username"];?></td>
  </tr>
  <tr>
    <td height="30" class="tdright">操作类型：</td>
    <td><?php echo $info["type"];?></td>
  </tr>
  <tr>
    <td height="30" class="tdright">操作名称：</td>
    <td><?php echo $info["name"];?></td>
  </tr>
  <tr>
    <td height="30" class="tdright">操作描述：</td>
    <td><?php echo $info["detail"];?></td>
  </tr>
  <tr>
    <td colspan="2"><textarea style="width:520px;height:200px;padding:8px 10px;" class="select"><?php echo ($info["logsinfo"])?$info["logsinfo"]:"无SQL操作记录";?></textarea></td>
  </tr>
 </table>

</body>
</html>

<?php }else{?>

NULL

<?php }?>
