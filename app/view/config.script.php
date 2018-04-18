<?php if($webie){?>
<link href="<?php echo $S_ROOT;?>images/style_ie.css?<?php echo date("Ymd");?>" rel="stylesheet" type="text/css" />
<?php }else{?>
<link href="<?php echo $S_ROOT;?>images/style.css?<?php echo date("Ymd");?>" rel="stylesheet" type="text/css" />
<?php }?>
<script>var webie	= '<?php echo (int)$webie;?>';</script>
<link href="<?php echo $S_ROOT;?>js/css/jquery.date.css?<?php echo date("Ymd");?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $S_ROOT;?>js/css/jquery.dialog.css?<?php echo date("Ymd");?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">var S_ROOT="<?php echo $S_ROOT;?>"</script>
<!--[if lte IE 6]>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/noie6/noIe6.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.js?<?php echo date("Ymd");?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.date.js?<?php echo date("Ymd");?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.dialog.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.dialog.plugin.js?<?php echo date("Ymd");?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/plugin.js?<?php echo date("YmdHi");?>"></script>
