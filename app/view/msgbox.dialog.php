<?php if($wapfun){?>
<!DOCTYPE html>
<html lang="zh-cn" class="w640">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="shui.cn">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=yes">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<?php }?>
<link href="<?php echo $S_ROOT?>images/style.css" rel="stylesheet" type="text/css" />
<div class="divc">
  <div class="dialogform">
    <div class="msgbox">
	  <ul>
	    <li class="message"><img src="<?php echo $S_ROOT;?>images/erroricon.png" width="80" align="absmiddle"> <?php echo $msgbox?></li>
	  </ul>
	</div>
  </div>
</div>
<?php if($wapfun){?>
</body>
</html>
<?php }?>
