//Jquery mobile datepicker setting
jQuery(function($){
	$.datepicker.regional['zh-CN'] = {
		changeYear: true,
		//changeMonth: true,
		closeText: '关闭',
		prevText: '<上月',
		nextText: '下月>',
		currentText: '今天',
		monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
		monthNamesShort: ['01','02','03','04','05','06','07','08','09','10','11','12'],
		dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
		dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
		dayNamesMin: ['日','一','二','三','四','五','六'],
		weekHeader: '周',
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['zh-CN']);
});

//email checked
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

function pageload(){}

//tips message
function msgshow(message)
{
	if(webie=="0"){
		tips(message);
	}else{
		alert(message);
	}
}

artDialog.notice = function (options) {
    var opt = options || {},
        api, aConfig, hide, wrap, top,
        duration = 800;

    var config = {
        id: 'Notice',
        left: '100%',
        top: '100%',
        fixed: true,
        drag: false,
        resize: false,
        follow: null,
        lock: false,
        init: function(here){
            api = this;
            aConfig = api.config;
            wrap = api.DOM.wrap;
            top = parseInt(wrap[0].style.top);
            hide = top + wrap[0].offsetHeight;

            wrap.css('top', hide + 'px')
                .animate({top: top + 'px'}, duration, function () {
                    opt.init && opt.init.call(api, here);
                });
        },
        close: function(here){
            wrap.animate({top: hide + 'px'}, duration, function () {
                opt.close && opt.close.call(this, here);
                aConfig.close = $.noop;
                api.close();
            });

            return false;
        }
    };

    for (var i in opt) {
        if (config[i] === undefined) config[i] = opt[i];
    };

    return artDialog(config);
};

function tipmsg(message,time)
{
	art.dialog.notice({
        id: 'msgshowTips',
	    title: '消息盒子',
	    width: 280,// 必须指定一个像素宽度值或者百分比，否则浏览器窗口改变可能导致artDialog收缩
	    content: message,
	   // icon: 'face-sad',
	    time: 180
	});
}

artDialog.tips = function (content, time) {
    return artDialog({
        id: 'Tips',
        title: false,
        cancel: false,
        fixed: true,
        lock: true
    })
    .content('<div style="padding:0px 6px;" class="size12">' + content + '</div>')
    .time(time||1);
};

function tips(message,time)
{
	art.dialog.tips(message,time);
}

//dialog message
function msgbox(message,time)
{
	//if(webie=="0"){
	art.dialog({
		title: '消息提示',
		lock: true,
		focus:false,
		fixed: true,
		time:time,
		content: message,
		okValue: '确定',
		ok: function(){}
	});
	///}else{
	//	alert(message);
	//}
}

function openDialog(title,urlto)
{
	var dialog = art.dialog({
		id: 'dialog_yws',
		title:title,
		padding: '5px',
		lock: true,
		drag:false
	});
	$.ajax({
	    url: urlto,
	    success: function (data) {
	        dialog.content(data);
	    },
	    cache: false
	});
}

function closedialog()
{
	var dialog = art.dialog({id:'dialog_yws'});
	dialog.close();
}

function viewhtml(urlto)
{
	window.open(S_ROOT+"data/"+urlto);
}

//页面调用
function ajaxurl(urlto,obj)
{
	$(obj).load(urlto + "&"+new Date().getTime());
}

function pagedo()
{
	var maxpage	= $("#pagenav_maxpage").val();
	var url		= $("#pagenav_urlto").val();
	var page	= $("#pagenav_page").val();
	//alert(maxpage+"|"+page);return;
	var maxpage = maxpage-0;
	var page = page-0;
	if(maxpage < page){ msgshow("抱歉，不能超过超过最大页数！"); $("#pagenav_page").attr("value",maxpage); return; }
	var urlto = url+"page="+page;
	//alert(urlto);
	location.href = urlto;
}

function show_div(obid){
	if($("#"+obid).is(":hidden")){
		$("#"+obid).show();
	}else{
		$("#"+obid).hide();
	}
}

/*********检查长时间格式 2008-09-09 22:22:22********/
function strDateTime(str)
{
	var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;
	var r = str.match(reg);
	if(r==null)return false;
	var d= new Date(r[1], r[3]-1,r[4],r[5],r[6],r[7]);
	return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]&&d.getHours()==r[5]&&d.getMinutes()==r[6]&&d.getSeconds()==r[7]);
}

/*********检查长时间 2008-09-09 ********/
function strDate(str)
{
	var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/;
	var r = str.match(reg);
	if(r==null)return false;
	var d= new Date(r[1],r[3]-1,r[4]);
	return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]);
}

//检查空格
function isWhiteWpace(s)
{
  var whitespace = " \t\n\r";
  var i;
  for (i = 0; i < s.length; i++){
     var c = s.charAt(i);
     if (whitespace.indexOf(c) >= 0) {
		  return false;
	  }
   }
   return true;
}

//英文字符
function isSsnString (ssn)
{
	var re=/^[0-9a-z][\w-.]*[0-9a-z]$/i;
	if(re.test(ssn))
	return true;
	else
	return false;
}

function checkEmail(email)
{
	//var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	var reg = /^(?:\w+\.?)*\w+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	flag = reg.test(email);
	if (!flag) {
		return false;
	}
	return true
}

//检查价格格式
function isMoney(s){

	var regex = /^-?\d[\d,]*([.]\d+)?$/; // 123,456.0129 or -123456 or -1,23,,,45,6.0909 or 123456,,,,,.09
	if (!s.match(regex)) {
		return false;
	}
	return true;
	//var regu = "^[0-9]+[\.?][0-9?]{0,2}$";
	//var re = new RegExp(regu);
	//if (re.test(s)) {
	//	return true;
	//} else {
	//	return false;
	//}
}

//检查价格格式
function isMoneyDims(s){

	var regex = /^-\d[-\d,]*([.]\d+)?$/;  // 123,456.0129 or -123456 or -1,23,,,45,6.0909 or 123456,,,,,.09
	if (!s.match(regex)) {
		return false;
	}
	return true;
	//var regu = "^[0-9]+[\.?][0-9?]{0,2}$";
	//var re = new RegExp(regu);
	//if (re.test(s)) {
	//	return true;
	//} else {
	//	return false;
	//}
}

//检查价格格式
function isMoneyNums(s){

	var regex = /^\d[\d,]*([.]\d+)?$/; // 123,456.0129 or -123456 or -1,23,,,45,6.0909 or 123456,,,,,.09
	if (!s.match(regex)) {
		return false;
	}
	return true;
	//var regu = "^[0-9]+[\.?][0-9?]{0,2}$";
	//var re = new RegExp(regu);
	//if (re.test(s)) {
	//	return true;
	//} else {
	//	return false;
	//}
}

//检查是否数字
function isNumber(s){
	var s = s+"";
	var regu = "^[0-9]+$";
	var re = new RegExp(regu);
	if (s.search(re) != -1) {
		return true;
	} else {
		return false;
	}
}

//检查是否负数字
function isFNumber(s){
	var s = s+"";
	var regu = "^-[0-9]+$";
	var re = new RegExp(regu);
	if (s.search(re) != -1) {
		return true;
	} else {
		return false;
	}
}

function isMobile(phone){
	var num = phone;
	var partten = /^1[3,4,7,5,8]\d{9}$/;
	if(partten.test(num)){
		return true;
	}else{
		return false;
    }
}

function itemShow(itemName,showId,num,bgItemName,clsName){
  var clsNameArr=new Array(2)
  if(clsName.indexOf("|")<=0){
    clsNameArr[0]=clsName
    clsNameArr[1]=""
  }else{
    clsNameArr[0]=clsName.split("|")[0]
    clsNameArr[1]=clsName.split("|")[1]
  }

  for(i=1;i<=num;i++){
    if(document.getElementById(itemName+i)!=null)
      document.getElementById(itemName+i).style.display="none"
    if(document.getElementById(bgItemName+i)!=null)
      document.getElementById(bgItemName+i).className=clsNameArr[1]
    if(i==showId){
      if(document.getElementById(itemName+i)!=null)
        document.getElementById(itemName+i).style.display=""
      else
        $.dialog.alert("未找到您请求的内容！")
      if(document.getElementById(bgItemName+i)!=null)
        document.getElementById(bgItemName+i).className=clsNameArr[0]
    }
  }
}




function allselect()
{
	$("input[name='selected']").attr("checked",true);
}
