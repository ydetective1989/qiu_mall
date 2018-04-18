<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/system.users.js?<?php echo date("Ymd");?>"></script>
</head>
<body>
<div class="info">

<table width="100%">
  <tr>
    <td height="30" class="tdcenter bgfocus"><?php echo ($_GET["do"]=="add")?"增加":"修改"; ?>用户信息</td>
  </tr>
</table>

<form method="post" name="editfrm" id="editfrm" action="">
<table width="100%" class="table">

  <tr>
    <td width="20%" class="tdright">用户帐号：</td>
    <td><input type="text" name="username" id="username" class="input" value="<?php echo $info["username"]?>" <?php if($info["username"]){ echo "disabled='disabled'"; }?> style="width:250px;"> <?php if($info["username"]){?><input type="checkbox" onclick="userslock()"> <font class='red'>* 修改用户名（慎用）</font><?php }?></td>
  </tr>
  <tr>
    <td class="tdright">密码设置：</td>
    <td><input type="text" name="password" id="password" class="input" value="" style="width:250px;"> * 密码留空不进行修改！</td>
  </tr>
  <tr>
    <td class="tdright">在职状态：</td>
    <td><input type="radio" name="checked" value="1" <?php if($info["checked"]=="1"||$info["checked"]==""){ echo "checked"; }?>> 在职
    <input type="radio" name="checked" value="0" <?php if($info["checked"]=="0"){ echo "checked"; }?>> 离职</td>
  </tr>
  <tr>
    <td class="tdright">员工岗位：</td>
    <td><select name="groupid" id="groupid" class="select" onchange="grouped(<?php echo (int)$info["userid"]?>,this.value)">
    	<option value="0">不设置岗位信息</option>
    	<?php foreach($grouplist AS $rs){?>
    	<option value="<?php echo $rs["id"];?>" <?php if($info["groupid"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"];?></option>
    	<?php }?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="tdright">姓名：</td>
    <td><input type="text" name="name" id="name" class="input" value="<?php echo $info["name"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">员工编号：</td>
    <td><input type="text" name="worknum" id="worknum" class="input" value="<?php echo $info["worknum"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">手机号码：</td>
    <td><input type="text" name="mobile" id="mobile" class="input" value="<?php echo $info["mobile"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright">电子邮箱：</td>
    <td><input type="text" name="email" id="email" class="input" value="<?php echo $info["email"]?>" style="width:250px;"></td>
  </tr>
  <tr>
    <td class="tdright" valign="top">订单权限：</td>
    <td class=""><input type="radio" name="alled" id="alled" class="input" value="0" <?php if((int)$info["alled"]=="0"){ echo "checked"; }?>> 普通权限
      <input type="radio" name="alled" id="alled" class="input" value="2" <?php if($info["alled"]=="2"){ echo "checked"; }?>> 销售大区
      <input type="radio" name="alled" id="alled" class="input" value="1" <?php if($info["alled"]=="1"){ echo "checked"; }?>> 全部权限
    </td>
  </tr>
  <?php if(IS_JOBS=="1"){?>
  <tr>
    <td class="tdright" valign="top">工单权限：</td>
    <td><input type="checkbox" name="jobsed" id="jobsed" class="input" value="1" <?php if($info["jobsed"]){ echo "checked"; }?>> 可查看全部服务站派工</td>
  </tr>
  <?php }?>
  <tr>
    <td class="tdright" valign="top">岗位权限：</td>
    <td class="checkboxs">
      <div class="tb" id="jobsarr1"></div>
      <?php if(IS_JOBS=="1"){?>
    	<div class="tb" id="jobsarr2"></div>
      <?php }?>
    	<script type="text/javascript">
		    $("#jobsarr1").load("<?php echo $S_ROOT;?>system/teams?do=treeajax&userid=<?php echo $info["userid"];?>&type=1&val=jobsteams");
    	</script>
      <?php if(IS_JOBS=="1"){?>
    	<script type="text/javascript">
      $("#jobsarr2").load("<?php echo $S_ROOT;?>system/teams?do=treeajax&userid=<?php echo $info["userid"];?>&type=3&val=jobsteams");
    	</script>
      <?php }?>
    	</script>
    </td>
  </tr>

  <?php if(IS_STORE=="1"){?>
  <tr>
    <td class="tdright" valign="top">库房权限：</td>
    <td class="checkboxs">
        <div class="tb" style="width:300px;">
		<div class="level">
		  <div>
		    <span><input type="checkbox" name="userstored" id="userstored" class="input" value="1" <?php if($info["stored"]=="1"){ echo "checked"; }?>> 可查看全部出库信息</span>
		    <?php if($stores){ foreach($stores AS $r){?>
		    <span style="width:300px;"><input type="checkbox" name="stored[]" value="<?php echo $r["id"];?>" <?php if($userstore[$r["id"]]){ echo "checked"; }?> /> <?php echo $r["name"];?></span>
		    <?php }}?>
		  </div>
		</div>
        </div>
    </td>
  </tr>
  <?php }?>

  <tr>
    <td class="tdright" valign="top">权限管理：</td>
    <td id="levelspace">空</td>
  </tr>
  <?php if($info["groupid"]){?><script>grouped("<?php echo (int)$info["userid"]?>","<?php echo (int)$info["groupid"]?>")</script><?php }?>
  <?php if($info){?>
  <tr>
    <td class="tdright">最后登录时间：</td>
    <td><?php echo date("Y-m-d H:i:s",$info["lastdate"])?></td>
  </tr>
  <tr>
    <td class="tdright">最后登录IP：</td>
    <td><?php echo $info["lastip"]?></td>
  </tr>
  <?php }?>
  <tr>
    <td class=""></td>
    <td class=""><input type="button" class="button" id="editbtn" onclick="editinfo()" value="<?php echo ($_GET["do"]=="add")?"增加":"修改"; ?>信息">
    <input type="button" class="btnwhite" onclick="location.href='<?php echo $urlto;?>'" value="返回上页"></td>
  </tr>
</table>
</form>

</div>
</body>
</html>
