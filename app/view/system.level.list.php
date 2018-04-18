<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/system.level.js?<?php echo date("Ymd");?>"></script>
</head>
<body>

<div class="forms">

<table width="100%">
  <tr>
    <td height="40" class="bold">&nbsp;权限管理</td>
    <td class="tdright"><input type="button" id="add" class="button" value="新建权限"></td>
    <!-- onclick="location.href='?do=add'" -->
  </tr>
</table>

<form method="post" name="editlist" id="editlist" action="">
<table width="100%" class="tdcenter" id="list">
	<thead>
	<tr class="bgheader white">
		<td width="80" class="" height="30">ID</td>
		<td width="160" class="">权限名称</td>
		<td width="100" class="">MOD</td>
		<td width="100" class="">AC</td>
		<td width="100" class="">DO</td>
		<td class="">链接</td>
		<td width="80" class="">状态</td>
		<td width="50" class="">菜单</td>
		<td width="90"  class="">排序</td>
		<td width="150" class="">操作</td>
	</tr>
	<input type="hidden" name="parentid" id="parentid" value="<?php echo (int)$_GET["id"]?>">
 	<input type="hidden" name="alllevel" id="alllevel" value="0">
	<?php if($list){?>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="" height="30"><?php echo $rs["id"];?><?php if($rs["isadmin"]){ echo "<font class='red'>(*)</font>"; } ?><input type="hidden" name="ids[]" value="<?php echo $rs["id"];?>"></td>
		<td class=""><input type="text" name="name[<?php echo $rs["id"];?>]" class="input" value="<?php echo $rs["name"];?>" style="width:150px;" class="tdcenter"></td>
		<?php if($_GET["id"]){?>
		<td class=""><input type="text" name="reqmod[<?php echo $rs["id"];?>]" class="input" value="<?php echo $rs["reqmod"];?>" style="width:90px;" class="tdcenter"></td>
		<td class=""><input type="text" name="reqac[<?php echo $rs["id"];?>]" class="input" value="<?php echo $rs["reqac"];?>" style="width:90px;" class="tdcenter"></td>
		<td class=""><input type="text" name="reqdo[<?php echo $rs["id"];?>]" class="input" value="<?php echo $rs["reqdo"];?>" style="width:90px;" class="tdcenter"></td>
		<td class=""><input type="text" name="urlto[<?php echo $rs["id"];?>]" class="input" value="<?php echo $rs["urlto"];?>" style="width:100%;" class=""></td>
		<?php }else{?>
		<td colspan="4" class="tdcenter">无</td>
		<?php }?>
		<td class=""><a href="<?php echo $S_ROOT;?>system/level?do=edit&type=checked&id=<?php echo $rs["id"];?>"><?php echo ($rs["checked"])?"正常":"<span class='red'>停用</span>";?></a></td>
		<td class=""><a href="<?php echo $S_ROOT;?>system/level?do=edit&type=naved&id=<?php echo $rs["id"];?>"><?php echo ($rs["naved"])?"显示":"<span class='red'>隐藏</span>";?></a></td>
		<td class=""><input type="text" name="orderd[<?php echo $rs["id"];?>]" class="input tdcenter" maxlength="3" value="<?php echo (int)$rs["orderd"];?>" style="width:80px;"></td>
		<td class="gray"><?php if($_GET["id"]){?>[下级]<?php }else{?><a href="?id=<?php echo $rs["id"];?>">[下级]</a><?php }?><a href="?do=edit&id=<?php echo $rs["id"];?>">[修改]</a><a href="?do=del&id=<?php echo $rs["id"];?>" onclick="javascript:{if(!confirm('确定要取消操作吗？\n一旦取消，不可恢复！')){return false;};}" >[删除]</a></td>
	</tr>
	<?php }?>
	<?php }?>
	</thead>
	<tbody>
  	</tbody>
</table>
</form>


<table width="100%" class="pagenav bgheader">
	<tr>
		<td class="tdcenter">
			<input type="button" id="editbtn" onclick="editlists()" class="btnwhite" value="批量修改"><?php if($_GET["id"]){?>
			<input type="button" onclick="location.href='?'" class="button" value="返回上级"><?php }?>
		</td>
	</tr>
</table>


</div>


</body>
</html>
