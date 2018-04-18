
function sendsms(mobile,message)
{
	var ordersid	= $("#ordersid").val();
	openDialog("发送短信",S_ROOT+"message/sendsms?ordersid="+ordersid+"&mobile="+mobile+"&message="+message+"&"+ Math.random());
}

function sendsmsd()
{
	
	var ordersid	= $("#ordersid").val();
	var mobile		= $("#msg_mobile").val();
	var content		= $("#msg_content").val();
	
	if(mobile==""){ 
		msgbox("请填写手机号码！"); return;
	}else{
		if(!isWhiteWpace(mobile)){ msgbox("手机号码中有空格，请检查！"); return; }
		if(mobile.length!=11){ msgbox("手机号码长度不正确，请检查！"); return; }
		if(!isMobile(mobile)){ msgbox("手机号码格式不正确，请检查！"); return; }
	}
	if(content=="")	{ 
		msgbox("请填写发送内容！"); return;
	}else{
		if(content.length>70){
			 msgbox("短信内容长度不能超过70个汉字及字母！"); return;
		}
	}

	$("#btned").attr("value","正在发送..");			//锁定按钮
	$("#btned").attr("disabled","disabled");		//锁定按钮
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"message/sendsms?ordersid="+ordersid,
	    data: "mobile="+mobile+"&content="+content,             
	    success: function(rows){
	    	msgbox(rows);
	    	closedialog();
	    }
	});
}






