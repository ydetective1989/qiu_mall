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
		    <td height="40" class="bold">&nbsp;用户管理</td>
		    <td class="tdright">
		    <form method="get" action="?" target="frmlist">
		    <input type="hidden" name="do" value="list">
		    <select name="type" class="select">
			    <option value="worknum">员工编号</option>
			    <option value="name">姓名</option>
			    <option value="userid">用户ID</option>
			    <option value="username">用户名</option>
			    <option value="email">邮箱</option>
		    </select>
		    <input type="text" name="key" class="input" value="" style="width:180px;" />
		    <select name="groupid" class="select">
			    <option value="">所属岗位</option>
		    	<option value="0">不设置岗位信息</option>
		    	<?php foreach($grouplist AS $rs){?>
		    	<option value="<?php echo $rs["id"];?>" <?php if($info["groupid"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"];?></option>
		    	<?php }?>
		    </select>
		    <select name="checked" class="select">
			    <option value="">在职状态</option>
			    <option value="1">在职</option>
			    <option value="0">离职</option>
		    </select>
		    <input type="submit" value="搜索用户" class="btnorange">
		    <input type="button" onclick="frmlist.location.href='<?php echo $S_ROOT?>system/users?do=add'" class="button" value="新建用户"></form></td>
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
	frmlist.location.href='?do=list';
}
var the_timeout = setTimeout("tolinks();",1000);//每5分钟提醒一次
</script>
</body>
</html>