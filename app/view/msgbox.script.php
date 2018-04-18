<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="" />
<link href="<?php echo $S_ROOT?>images/style.css" rel="stylesheet" type="text/css" />
<title>消息提示</title>
</head>

<body>

<?php if($msgbox){?>
<div class="divc" style="padding:0px;margin:0px;">
  <div class="msgform" style="padding:0px;margin:0px;width:100%;">
    <div class="msgbox">
	  <ul>
	    <li class="message"><?php echo $msgbox?></li>
		<li class="msgbutton"><input type="button" class="button msgbtnd" onclick="toHome()" value="确定"></li>
	  </ul>
	</div>
  </div>
</div>
<?php }else{?>
Loading ...
<?php }?>

<script type="text/javascript"> 
//<!--
//function isIFrameSelf(){try{if(window.top ==window){return false;}else{return true;}}catch(e){return true;}}
function toHome(){
	<?php echo $script?>
}
window.setTimeout("toHome()",<?php echo (int)$timeout;?>);
//-->
</script>

</body>
</html>
