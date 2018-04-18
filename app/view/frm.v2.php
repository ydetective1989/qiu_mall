<!DOCTYPE html>
<html>
<head>
<title><?php echo META_TITLE?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script>var S_ROOT = '<?php echo $S_ROOT?>';</script>
<!--[if lte IE 6]>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/noie6/noIe6.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo $S_ROOT;?>images/iframe.css?<?php echo time();?>">
<link rel="stylesheet" type="text/css" href="<?php echo $S_ROOT;?>js/easyui/themes/metro/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $S_ROOT;?>js/easyui/themes/icon.css">
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/frame.js?<?php echo date("Ymd");?>"></script>

</head>
<body class="easyui-layout">

<div class="header bgheader">
<div class="drop">
  <ul>
    <li class="logo" style="width:150px;"><!--  onclick="addTab('消息盒子','note/lists','person');" -->
    <a href="javascript:void(0)"><img src="<?php echo UI_LOGS;?>" style="height:20px;"><span id="note_img" class="yellow"></span></a>
    <dl class="bgcolor">
      <dd class="bgwhite">用户用户：<?php echo $userinfo["username"]?></dd>
      <dd><a href="javascript:void(0)" onclick="addTab('修改密码','users/editinfo','person');">修改密码</a></dd>
      <dd><a href="<?php echo $S_ROOT;?>users/logout" target="_top">退出登录</a></dd>
    </dl>
    </li>
  	<?php if($menus){ $i=1;$x=99;
    foreach($menus AS $r){?>
  	<?php if($r["tree"]){?>
  	<li style="z-index:9<?php echo $x?>">
	  <a class="" href="javascript:void(0);"><?php echo $r["name"];?></a>
    <dl class="bgcolor">
      <?php foreach($r["tree"] AS $rs){?>
  			<dd><a href="javascript:void(0);" class="chd" onclick="addTab('<?php echo $rs["name"];?>','<?php echo $rs["urlto"]?>','<?php echo $rs["reqmod"];?><?php echo $rs["reqac"];?>');"><?php echo $rs["name"];?></a></dd>
      <?php }?>
    </dl>
  	</li>
    <?php }?>
    <?php $i++;$x--;}}?>
  </ul>
</div>
</div>

<div region="north" border="false" style="height:40px;"></div>

<div region="center" border="false" >
    <div id="tt" class="easyui-tabs"  fit="true" border="false" plain="true">
         <div title="我的关注" style="padding:0px;background:#F0F9FE">
            <iframe src="<?php echo $S_ROOT;?>pages/focus" width="100%" height="100%" name="mainfrm" scrolling="auto" noresize="noresize" id="mainfrm" frameborder="no" style=""/></iframe>
         </div>
    </div>
</div>

</body>
</html>
