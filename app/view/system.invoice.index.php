<?php if($type=="iframe"){?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/cpinfo.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">
<table width="100%" height="100%" >
  <tr>
    <td height="40" class="bold">&nbsp;开票公司</td>
    <td align="right">
	      <span><input type="button" value="增加开票公司" class="button" onclick="frminfo.location.href='<?php echo $S_ROOT;?>system/invoice?show=add'" />&nbsp;&nbsp;</span>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td colspan="2" height="100%">
    <iframe src="<?php echo $S_ROOT;?>system/invoice?show=lists" width="100%" height="100%" name="frminfo" scrolling="auto" noresize="noresize" id="frminfo" frameborder="no" style="" /></iframe>
    </td>
  </tr>
</table>
</body>
</html>

<?php }elseif($type=="lists"){?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/cpinfo.js?<?php echo date("Ymd");?>"></script>
</head>
<body>

<div class="forms">

  <table width="100%" class="tdcenter">
  	<tr class="bgheader white">
  		<td width="100" class="" height="30">公司名称</td>
  		<td width="100" class="">公司编码</td>
      <td width="100" class="">排序</td>
  		<td width="100" class="">操作</td>
  	</tr>
  	<?php if($list){?>
  	<?php foreach($list AS $rs){?>
  	<tr class="datas">
  		<td class="tdcenter" height="30"><?php echo $rs["name"];?></td>
  		<td class=""><?php echo $rs["encoded"];?></td>
  		<td class=""><?php echo $rs["orderd"];?></td>
  		<td class="gray"><a href="<?php echo $S_ROOT;?>system/invoice?show=edit&id=<?php echo $rs["id"];?>">[修改]</a>
        <a href="<?php echo $S_ROOT;?>system/invoice?show=del&id=<?php echo $rs["id"];?>" onclick="javascript:{if(!confirm('确定要删除操作吗？\n一旦取消，不可恢复！')){return false;};}" >[删除]</a></td>
  	</tr>
  	<?php }?>
    	<tr>
    		<td class="tdcenter" height="30"></td>
    	</tr>
  	<?php }else{?>
  	<tr class="datas">
  		<td colspan="10" height="30" class="tdcenter">无</td>
  	</tr>
  	<?php }?>
  </table>

  <?php if($page){ ?>
  <div class="bottom_tools">
  <table width="100%" class="pagenav bgheader">
  	<tr>
  		<td class="tdcenter"><?php echo $page;?></td>
  	</tr>
  </table>
  </div>
  <?php }?>

</div>

</body>
</html>

<?php }else{?>

NULL

<?php }?>
