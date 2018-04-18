<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="author" content="sunsy@shui.cn">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scale=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=yes">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<title><?php echo $feedtype;?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="stylesheet" type="text/css" href="<?php echo $S_ROOT;?>images/weserver/style.css">
<link href="<?php echo $S_ROOT;?>js/css/jquery.date.css?20170118" rel="stylesheet" type="text/css" />
<link href="<?php echo $S_ROOT;?>js/css/jquery.dialog.css?20170118" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.date.js?20170118"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.dialog.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.dialog.plugin.js?20170118"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/province.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/plugin.js"></script>
<script type="text/javascript">
var defaults = {
    s1:'provid',
    s2:'cityid',
    s3:'areaid',
    v1:null,
    v2:null,
    v3:null
};
</script>
<!-- 微信公众号JS-SDK -->
<script type='text/javascript' src='https://res.wx.qq.com/open/js/jweixin-1.0.0.js'></script>
<script type="text/javascript" src="https://api.shui.cn/weixin/sdkjs?do=aux&url=<?php echo urlencode('http://crm.auxwater.com'.plugin::getURL());?>"></script>
<script type='text/javascript' src='<?php echo $S_ROOT;?>js/wxsdk.js'></script>
</head>
<body>
<div class="tipbox"></div>
<!-- <div class="header">
	<div class="title"><?php echo $feedtype;?></div>
</div> -->
<div class="container">
	<form action="" method="post" name="formdata" id="formdata" enctype="multipart/form-data">
		<table class="table">
			<tr>
				<td class="tdright" width="80">商品条码：</td>
				<td><input type="text" name="itemcontract" id="itemcontract" class="text" placeholder="商品条码-->位于纸箱侧面或机器背部（包含字母）"></td>
			</tr>
      <tr>
          <td></td>
          <td><input type="button" onclick="getScanCode('itemcontract')"  class="butn butn-lg" value="点击扫描条码快速录入"></td>
      </tr>
			<tr>
				<td class="tdright">商品型号：</td>
				<td><input type="text" name="itemname" id="itemname" class="text" placeholder="商品型号-->位于纸箱正面或机器背部铭牌"></td>
			</tr>
			<tr>
				<td class="tdright">安装日期：</td>
				<td><input type="date" name="setupdate" id="setupdate" class="text" placeholder="安装日期"></td>
			</tr>
			<tr>
				<td class="tdright">您的姓名：</td>
				<td><input type="text" name="name" id="name" class="text" placeholder="您的姓名"></td>
			</tr>
			<tr>
				<td class="tdright">省/市/区：</td>
				<td>
					<select name="provid" id="provid" class="select" style="width:32%;"></select>
					<select name="cityid" id="cityid" class="select" style="width:32%;"></select>
					<select name="areaid" id="areaid" class="select" style="width:32%;"></select>
				</td>
			</tr>
			<tr>
				<td class="tdright">联系地址：</td>
				<td><input type="text" name="address" id="address" class="text" placeholder="详细地址"></td>
			</tr>
			<tr>
				<td class="tdright">联系手机：</td>
				<td><input type="text" name="phone" id="phone" class="text" placeholder="联系手机"></td>
			</tr>
		    <tr>
				<td class="tdright">购买方式：</td>
				<td>
				 <select name="itembuy" id="itembuy" class="select" style="width:100%">
          <option value=""></option>
				 	<option value="天猫">天猫</option>
				 	<option value="京东">京东</option>
				 	<option value="淘宝">淘宝</option>
				 	<option value="线上平台">线上平台</option>
				 	<option value="线下渠道">线下渠道</option>
				 	<option value="其它">其它</option>
				 </select>
				</td>
			</tr>
      <tr>
				<td class="tdright"><?php echo $feedpic;?>：</td>
				<td><input type="file" name="files_upload" id="files_upload" class="text"></td>
			</tr>
			<tr>
				<td class="tdright">反馈备注：</td>
				<td><textarea name="detail" id="detail" class="textarea" placeholder="留言信息"></textarea></td>
			</tr>
			<tr><td colspan="2"><input type="button" value="提交信息" class="butn butn-lg" id="formbutn" onclick="checkform()"></td></tr>
		</table>
	</form>
</div>
<script type="text/javascript">
function checkform()
{
	var itemcontract = $("#itemcontract").val();
	var itemname     = $("#itemname").val();
	var name         = $("#name").val();
	var address      = $("#address").val();
	var phone        = $("#phone").val();
  var itembuy      = $("#itembuy").val();
  var provid       = $("#provid").val();
  var cityid       = $("#cityid").val();
  var areaid       = $("#areaid").val();
	if(itemcontract=="")
	{
		showmsg("请输入商品编码");
		return false;
	}
	if(itemname=="")
	{
		showmsg("请输入商品名称");
		return false;
	}
	if(name=="")
	{
		showmsg("请输入您的姓名");
		return false;
	}
  if(provid=="")
  {
    showmsg("请选择省");
    return false;
  }
  if(cityid=="")
  {
    showmsg("请选择市");
    return false;
  }
  if(areaid=="")
  {
    showmsg("请选择区域");
    return false;
  }
	if(address=="")
	{
		showmsg("请输入详细地址");
		return false;
	}
  if(itembuy==""){
    showmsg("请选择购买渠道");
    return false;
  }
  if(phone==""){ showmsg("客户手机号码/联系电话需要填写一项"); return; }
  if(phone!=""){
    if(!isWhiteWpace(phone)){ showmsg("手机号码中有空格，请检查！"); return; }
    if(phone.length!=11){ showmsg("手机号码长度不正确，请检查！"); return; }
    if(!isMobile(phone)){ showmsg("手机号码格式不正确，请检查！"); return; }
  }
	$("#formbutn").attr("onclick","").html("提交中..");
	$("#formdata").submit();
}
function showmsg(text)
{
   if(text!="")
   {
     $(".tipbox").show().html(text);
     setTimeout("showhide()",5000);
   }else{
     showhide();
   }
}
function showhide()
{
  $(".tipbox").hide()
}
</script>
</body>
</html>
