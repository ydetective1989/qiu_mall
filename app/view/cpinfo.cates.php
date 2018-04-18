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
    <td height="40" class="bold">&nbsp;商品类目管理</td>
    <td align="right">
	      <span><input type="button" value="增加类目" class="button" onclick="frminfo.location.href='<?php echo $S_ROOT;?>cpinfo/cates?do=add'" />&nbsp;&nbsp;</span>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td colspan="2" height="100%">
    <iframe src="<?php echo $S_ROOT;?>cpinfo/cates?show=lists" width="100%" height="100%" name="frminfo" scrolling="auto" noresize="noresize" id="frminfo" frameborder="no" style="" /></iframe>
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
  		<td width="100" class="" height="30">类目ID</td>
  		<td class="">类目名称</td>
  		<td class="">类目英文名</td>
      <td width="100" class="">排序</td>
      <td width="100" class="">状态</td>
  		<td width="200" class="">操作</td>
  	</tr>
  	<?php if($list){?>
  	<?php foreach($list AS $rs){?>
  	<tr class="datas">
  		<td class="" height="30"><?php echo $rs["categoryid"];?></td>
  		<td class=""><?php echo $rs["name"];?></td>
  		<td class=""><?php echo $rs["tags"];?></td>
  		<td class=""><?php echo $rs["orderid"];?></td>
  		<td class=""><a href="<?php echo $S_ROOT;?>cpinfo/cates?do=checked&id=<?php echo $rs["categoryid"];?>"><?php if($rs["checked"]=="1"){?>有效<?php }else{?><span class='red'>停用</span></a><?php }?></td>
  		<td class="gray"><a href="<?php echo $S_ROOT;?>cpinfo/cates?do=edit&id=<?php echo $rs["categoryid"];?>">[修改]</a>
        <a href="<?php echo $S_ROOT;?>cpinfo/cates?do=del&id=<?php echo $rs["categoryid"];?>" onclick="javascript:{if(!confirm('确定要删除操作吗？\n一旦取消，不可恢复！')){return false;};}" >[删除]</a></td>
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
