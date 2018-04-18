<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/system.users.js?<?php echo date("Ymd");?>"></script>
</head>
<body>

<div class="forms">

<table width="100%" class="tdcenter">
	<tr class="bgheader white">
		<td width="80" class="" height="30">ID</td>
		<td class="">用户名</td>
		<td width="100" class="">姓名</td>
		<td class="">EMAIL</td>
		<td class="">手机号码</td>
		<td>岗位</td>
        <td width="50" class="">状态</td>
		<td width="110" class="">操作</td>
	</tr>
	<?php if($list){?>
	<form method="post" name="editlist" id="editlist" action="">
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="" height="30"><?php echo $rs["userid"];?></td>
		<td class=""><?php echo $rs["username"];?></td>
		<td class=""><?php echo $rs["name"];?></td>
		<td class=""><?php echo $rs["email"];?></td>
		<td class=""><?php echo $rs["mobile"];?></td>
		<td class=""><?php echo ($rs["groupname"])?$rs["groupname"]:"<font class='gray'>暂无岗位</font>";?></td>
		<td class=""><a href="<?php echo $S_ROOT;?>system/users?do=edit&type=checked&id=<?php echo $rs["userid"];?>"><?php if($rs["checked"]){?>在职<?php }else{?><span class='red'>离职</span></a><?php }?></td>
		<td class="gray"><a href="?do=edit&id=<?php echo $rs["userid"];?>">[修改]</a><a href="?do=del&id=<?php echo $rs["userid"];?>" onclick="javascript:{if(!confirm('确定要取消操作吗？\n一旦取消，不可恢复！')){return false;};}" >[删除]</a></td>
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
		<td class="tdcenter"><?php echo $page;?></td>
	</tr>
</table>


</div>


</body>
</html>