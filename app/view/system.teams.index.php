<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
</head>
<body scroll="no">

<table width="100%" height="100%">
  <tr>
    <td colspan="3" align="center">
	<div class="forms">
      <table width="100%" >
		  <tr>
		    <td height="40" class="bold">&nbsp;组织管理</td>
		    <td class="tdright">
		    <form method="get" action="?" target="frmlist">
		    <input type="hidden" name="do" value="<?php echo $_GET["do"]?>">
		    <input type="hidden" name="show" value="lists">
		    <select name="type" class="select">
			    <option value="numbers">编号</option>
			    <option value="name">名称</option>
		    </select>
		    <input type="text" name="key" class="input" value="" style="width:180px;" />
		    <select name="id" class="select">
			    <option value="0">机构根目录</option>
		    	<?php foreach($list AS $rs){?>
		    	<option value="<?php echo $rs["id"];?>"><?php echo $rs["name"];?></option>
		    	<?php }?>
		    </select>
		    <input type="submit" value="搜索结构" class="btnorange">
		    <input type="button" onclick="frmlist.location.href='?do=<?php echo $_GET["do"];?>&to=users'" class="btngreen" value="人员名录">
		    <input type="button" onclick="frmlist.location.href='<?php echo $S_ROOT?>system/teams?do=<?php echo $_GET["do"]?>&to=add'" class="button" value="新建机构"></td>
		  </tr>
	        <tr>
	          <td></td>
	        </tr>
      </table>
	</div>
    </td>
  </tr>
  <tr>
    <td colspan="3" class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td height="100%">
    <iframe src="" width="100%" height="100%" name="frmlist" id="frmlist" scrolling="auto" noresize="noresize" frameborder="no" style="" /></iframe>
    </td>
  </tr>
</table>
<script>
function tolinks()
{
	frmlist.location.href='?do=<?php echo $_GET["do"]?>&show=lists';
}
var the_timeout = setTimeout("tolinks();",0);//每5分钟提醒一次
</script>
</body>
</html>