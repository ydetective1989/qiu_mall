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
<div class="divc">
  <div class="msgform">
    <div class="msgbox">
	  <ul>
	    <li class="message"><?php echo $msgbox?></li>
		<li class="msgbutton"><input type="button" class="button msgbtnd" onclick="<?php echo ($urlto)?"location.href='".$urlto."'":"javascript:history.back(-1);"; ?>" value="确定"></li>
	  </ul>
	</div>
  </div>
</div>
<?php echo $script?>


<?php }else{?>


<?php echo "正在进入页面... ".$script?>

<?php //header("location:$urlto");?>

<?php }?>

<script type="text/javascript"> 
//<!--
//function isIFrameSelf(){try{if(window.top ==window){return false;}else{return true;}}catch(e){return true;}}
function toHome(){
	<?php if($urlto){?>
	location.href="<?php echo $urlto?>";
	<?php }else{?>
	history.back(-1);
	<?php }?>
}
window.setTimeout("toHome()",<?php echo (int)$timeout;?>);
//-->
</script>

</body>
</html>
