var BrowserUpgrade = function(){ 
	var IsbrowserUpgrade = 0;	 
	if(IsbrowserUpgrade!=1){
		browserUpgrade = '<div class="lteie6_transparent"></div>';
		browserUpgrade +='<div class="lteie6_main">';
		browserUpgrade +=    '<h2 class="lteie6_title" title="反Internet Explorer 6"><span>YWS不能完全兼容IE，即日禁止使用IE进入！</span></h2>';
		browserUpgrade +=    '<p class="lteie6_cont">为推动YWS系统的使用及更好的用户体验，强烈建议你使用<a target="_blank" title="下载Chrome" style="color:red;font-weight:bold;" href="http://chrome.360.cn/">Chrome For 360极速浏览器</a>或安装/使用下列新版本浏览器：</p>';
		browserUpgrade +=    '<ul class="lteie6_browser">';
		browserUpgrade +=        '<li><a class="chrome" target="_blank" title="下载Chrome" href="http://chrome.360.cn/">Chrome For 360极速浏览器</a></li>';
		browserUpgrade +=        '<li><a class="chromes" target="_blank" title="下载Chrome" href="http://www.baidu.com/s?ie=UTF-8&wd=chrome&tn=qiuyong">Chrome For Google</a></li>';
		//browserUpgrade +=        '<li><a class="ie8" title="下载Internet Explorer 8" href="http://www.microsoft.com/windows/internet-explorer/beta/worldwide-sites.aspx">Internet Explorer 8</a></li>';
		//browserUpgrade +=        '<li><a class="firefox" target="_blank" title="下载Firefox" href="http://www.mozillaonline.com/">Firefox</a></li>';
		//browserUpgrade +=        '<li><a class="opera" target="_blank" title="下载Opera" href="http://cn.opera.com/download/thanks/win/">Opera</a></li>';
		//browserUpgrade +=        '<li><a class="safari" target="_blank" title="下载Safari" href="http://www.apple.com.cn/safari/download/">Safari</a></li>';
		browserUpgrade +=    '</ul>';
		browserUpgrade +=    '<p class="more"><a class="link" title="亿家净水商城" href="http://www.shui.cn">www.shui.cn</a></p>';
		browserUpgrade +=    '<p class="close"></p>';
		browserUpgrade +='</div>';
		browserUpgrade +='<style type="text/css">';
		browserUpgrade +='body{height:100%;}';
		browserUpgrade +='.lteie6_transparent{position:absolute;top:0;left:0;width:100%;height:100%;background:#FFFFFF;}';
		browserUpgrade +='.lteie6_main *{margin:0;padding:0;border:none; font-family:Verdana,"宋体";}';
		browserUpgrade +='.lteie6_main .lteie6_title,';
		browserUpgrade +='.lteie6_main .ie8,';
		browserUpgrade +='.lteie6_main .firefox,';
		browserUpgrade +='.lteie6_main .chrome,';
		browserUpgrade +='.lteie6_main .chromes,';
		browserUpgrade +='.lteie6_main .opera,';
		browserUpgrade +='.lteie6_main .safari,';
		browserUpgrade +='.lteie6_main .close{padding-left:19px;background:url('+S_ROOT+'js/noie6/lte_ie6.png) no-repeat;}';
		browserUpgrade +='.lteie6_main .close span,';
		browserUpgrade +='.lteie6_main .lteie6_title span{display:none}';
		browserUpgrade +='.lteie6_main{position:absolute;top:40%;left:50%;margin:-80px 0 0 -250px;border:4px solid #3399cc;width:500px;height:185px;background:#FFFFFF;}';
		browserUpgrade +='.lteie6_main .lteie6_title{float:left;display:inline;margin:20px;padding:0;width:150px;height:86px;}';
		browserUpgrade +='.lteie6_main .lteie6_cont{float:left;margin-top:20px;width:285px;font:12px/200% Verdana!important;text-align:left;color:#333;}';
		browserUpgrade +='.lteie6_main .lteie6_cont a{color:#000000; padding:2px 2px 2px 2px;}';
		browserUpgrade +='.lteie6_main .lteie6_browser {position:absolute;top:105px;left:20px;}';
		browserUpgrade +='.lteie6_main .lteie6_browser li{display:inline;padding-left:18px;}';
		browserUpgrade +='.lteie6_main .lteie6_browser a{display:inline-block;text-decoration:underline;font:12px/18px Verdana;color:#3399cc;padding-left:40px;height:40px;line-height:40px;}';
		browserUpgrade +='.lteie6_main .lteie6_browser a:hover{color:#1D6120;}';
		browserUpgrade +='.lteie6_main .ie8{background-position:-0px -120px;}';
		browserUpgrade +='.lteie6_main .firefox{background-position:0 -160px;;}';
		browserUpgrade +='.lteie6_main .chromes{background-position:0 -320px;}';
		browserUpgrade +='.lteie6_main .chrome{background-position:0 -280px;}';
		browserUpgrade +='.lteie6_main .opera{background-position:0 -200px;}';
		browserUpgrade +='.lteie6_main .safari{background-position:0 -240px;}';
		browserUpgrade +='.lteie6_main .close{position:absolute;top:4px;right:4px;padding:0;overflow:hidden;border:none;line-height:50px;width:0px;height:0px;font-size:0;cursor:pointer;background-position:-158px -93px;}';
		browserUpgrade +='.lteie6_main .close button{width:14px;height:14px;background:1px solid #f00;cursor:pointer;}';
		browserUpgrade +='.lteie6_main .more{position:absolute;top:162px;right:6px; font-size:11px;font-family:Verdana}';
		browserUpgrade +='.lteie6_main .more .link{color:#3399cc;}';
		browserUpgrade +='.lteie6_main .more .support span{font-weight:bold;}';
		browserUpgrade +='.lteie6_main .more .em{color:#3399cc;}';
		browserUpgrade +='.lteie6_main .more .strong{color:#1D6120;}';
		browserUpgrade +='.lteie6_main .more .important{color:#3399cc;}';
		browserUpgrade +='</style>';
		var browserUpgradeContainer = document.createElement("div");
		browserUpgradeContainer.id='browserUpgrade';
		browserUpgradeContainer.className='lte_ie6';
		browserUpgradeContainer.innerHTML=browserUpgrade;
		var browserUpgradeCloser = document.createElement("button");
		browserUpgradeCloser.onclick=function(){document.getElementById('browserUpgrade').style.display='none';}
		browserUpgradeCloser.innerHTML='';
		browserUpgradeContainer.getElementsByTagName('p')[2].appendChild(browserUpgradeCloser);
		document.body.appendChild(browserUpgradeContainer);
	} 

} 
window.attachEvent('onload',BrowserUpgrade);