<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/system.teams.js?<?php echo date("Ymd");?>"></script>
</head>
<body>

<div class="forms">

<?php if($tempd=="users"){?>

<table width="100%" class="size14 table">
<?php foreach($lists AS $rs){?>
	<tr class="bgheader white">
		<td class="tdcenter" height="30"><?php echo $rs["name"]?></td>
	</tr>
	<tr>
		<td class="tdleft" valign="top" >
		<?php if($rs["tree"]){?>
			<table width="100%">
			<?php foreach($rs["tree"] AS $tree){?>
			<tr>
				<td width="300" class="tdleft" style="border-bottom:1px solid #ccc;" ><?php echo $tree["name"]?></td>
				<td width="100" class="tdleft" style="border-bottom:1px solid #ccc;" ><?php echo $tree["encoded"]?></td>
				<td width="80" class="tdleft" style="border-bottom:1px solid #ccc;" ><?php echo ($tree["checked"])?"正常":"已关闭"?></td>
				<td class="tdleft" valign="top" style="border-bottom:1px solid #ccc;" >
				<?php if($tree["users"]){?>
				<?php foreach($tree["users"] AS $ru){?>
					<?php echo $ru["worknum"];?>:<?php echo $ru["name"];?>||
				<?php }?>
				<?php }?>
				</td>
			</tr>
			<?php }?>
			</table>
			<?php }?>
		</td>
	</tr>
<?php }?>
</table>

<?php }else{?>

<table width="100%" class="tdcenter" id="list">
	<thead>
	<tr class="bgheader white">
		<td class="" height="30">组织名称</td>
		<td class="">副名称</td>
		<td width="250"class="">省市区</td>
		<td width="130" class="">客户编码</td>
		<td width="50" class="">状态</td>
		<td width="90"  class="">排序</td>
		<td width="150" class="">操作</td>
	</tr>
	<form method="post" name="editlist" id="editlist" action="">
	<?php if($list){?>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<input type="hidden" name="ids[]" value="<?php echo $rs["id"];?>">
		<td class="" height="30"><input type="text" name="name[<?php echo $rs["id"];?>]" class="input" value="<?php echo $rs["name"];?>" style="width:99%;" class="tdcenter"></td>
		<td class=""><input type="text" name="subname[<?php echo $rs["id"];?>]" class="input" value="<?php echo $rs["subname"];?>" style="width:99%;" class="tdcenter"></td>
		<td class=""><?php echo $rs["provname"]?>-<?php echo $rs["cityname"]?>-<?php echo $rs["areaname"]?></td>
		<td class=""><input type="text" name="encoded[<?php echo $rs["id"];?>]" class="input tdcenter" value="<?php echo $rs["encoded"];?>" style="width:120px;" class="tdcenter"></td>
		<td class=""><a href="?do=<?php echo $_GET["do"];?>&to=edit&type=checked&id=<?php echo $rs["id"];?>"><?php echo ($rs["checked"])?"正常":"<span class='red'>停用</span>";?></a></td>
		<td class=""><input type="text" name="orderd[<?php echo $rs["id"];?>]" class="input tdcenter" maxlength="3" value="<?php echo (int)$rs["orderd"];?>" style="width:80px;"></td>
		<td class="gray"><?php if($_GET["id"]){?>[下级]<?php }else{?><a href="?do=<?php echo $_GET["do"];?>&show=lists&id=<?php echo $rs["id"];?>">[下级]</a><?php }?><a href="?do=<?php echo $_GET["do"];?>&to=edit&id=<?php echo $rs["id"];?>">[修改]</a>[删除]</td>
	</tr><!-- <a href="?do=del&id=<?php echo $rs["id"];?>" onclick="javascript:{if(!confirm('确定要取消操作吗？\n一旦取消，不可恢复！')){return false;};}" >[删除]</a> -->
	<?php }?>
	<?php }else{?>
	<tr>
		<td colspan="7" height="40" class="tdcenter red">没有找到相关数据</td>
	</tr>
	<?php }?>
	</thead>
	<tbody>
  	</tbody>
	</form>
</table>


<table width="100%" class="pagenav bgheader">
	<tr>
		<td class="tdcenter">
			<input type="button" id="editbtn" onclick="editlists()" class="btnwhite" value="批量修改"><?php if($_GET["id"]){?>
			<input type="button" onclick="location.href='?do=<?php echo $_GET["do"];?>&show=lists'" class="button" value="返回上级"><?php }?>
		</td>
	</tr>
</table>

<table width="100%" class="pagenav ">
	<tr>
		<td class="tdcenter"><?php echo $page;?></td>
	</tr>
</table>

<?php }?>

</div>


</body>
</html>
