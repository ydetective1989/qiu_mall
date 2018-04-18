<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/system.group.js?<?php echo date("Ymd");?>"></script>
</head>
<body>

<div class="forms">

<table width="100%">
  <tr>
    <td height="40" class="bold">&nbsp;岗位管理</td>
    <td class="tdright"><input type="button" onclick="location.href='?do=add'" class="button" value="新建岗位"></td>
  </tr>
</table>

<table width="100%" class="tdcenter">
	<tr class="bgheader white">
		<td width="100" class="" height="30">ID</td>
		<td class="">岗位名称</td>
		<td width="100" class="">状态</td>
		<td width="100"  class="">排序</td>
		<td width="150" class="">操作</td>
	</tr>
	<?php if($list){?>
	<form method="post" name="editlist" id="editlist" action="">
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="" height="30"><?php echo $rs["id"];?><input type="hidden" name="ids[]" value="<?php echo $rs["id"];?>"></td>
		<td class=""><input type="text" name="name[<?php echo $rs["id"];?>]" class="input" value="<?php echo $rs["name"];?>" style="width:90%;" class="tdcenter"></td>
		<td class=""><a href="<?php echo $S_ROOT;?>system/group?do=edit&type=checked&id=<?php echo $rs["id"];?>"><?php echo ($rs["checked"])?"正常":"<span class='red'>停用</span>";?></a></td>
		<td class=""><input type="text" name="orderd[<?php echo $rs["id"];?>]" class="input tdcenter" maxlength="3" value="<?php echo (int)$rs["orderd"];?>" style="width:80px;"></td>
		<td class="gray"><a href="?do=edit&id=<?php echo $rs["id"];?>">[修改]</a><a href="?do=del&id=<?php echo $rs["id"];?>" onclick="javascript:{if(!confirm('确定要取消操作吗？\n一旦取消，不可恢复！')){return false;};}" >[删除]</a></td>
	</tr>
	<?php }?>
	</form>
	<?php }else{?>
	<tr class="datas">
		<td colspan="10" height="30" class="tdcenter">无</td>
	</tr>
	<?php }?>
</table>


<table width="100%" class="pagenav bgheader">
	<tr>
		<td class="tdcenter">
			<input type="button" id="editbtn" onclick="editlists()" class="btnwhite" value="批量修改">
		</td>
	</tr>
</table>


</div>


</body>
</html>
