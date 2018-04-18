
function uptext(obid)
{
	var text = $("#"+obid).html();
	//alert(text);
	openDialog("修改内容",S_ROOT+"express/uptext?obid="+obid+"&text="+text+"&"+ Math.random());
}

function uptexted()
{
	var obid = $("#dialog_obid").val();
	var text = $("#dialog_text").val();
	$("#"+obid).html(text);
	closedialog();
}


function printlogs()
{
	var LODOP;
	LODOP = getLodop(document.getElementById('LODOP'),document.getElementById('LODOP_EM'));
    if ((LODOP==null)||(typeof(LODOP.VERSION)=="undefined")) {
    	alert("抱歉，你没有安装打印控件！请在打印引导处进行下载安装，否则无法进行打印！");return;
    }
	var id		= $("#exp_ordersid").val();
	var type	= $("#exp_type").val();
	var cateid	= $("#exp_cateid").val();
	var numbers = $("#exp_numbers").val();
	var definfo = $("#exp_definfo").val();
	openDialog("打印物流信息",S_ROOT+"express/add?id="+id+"&type="+type+"&cateid="+cateid+"&numbers="+numbers+"&definfo="+definfo+"&"+ Math.random());
}

function exp_infod()
{

	var datetime	= $("#express_datetime").val();
	var ordersid	= $("#express_ordersid").val();
	var cateid		= $("#express_cateid").val();
	var type		= $("#express_type").val();
	var numbers		= $("#express_numbers").val();
	//var weight		= $("#express_weight").val();
	//var price		= $("#express_price").val();
	var detail		= $("#express_detail").val();
	if(datetime==""){ 
		msgbox("时间不能为空！"); return;
	}else{
		if(!strDate(datetime)){
			msgbox("错误，日期格式不正确！<br>正确格式：2012-01-01"); 
			return; 
		}
	}
	if(cateid==""){ msgbox("请选择物流公司！"); return; }
	if(type==""){ msgbox("请选择物品类别！"); return; }
	if(numbers==""){ 
		msgbox("请填写物流单号！"); return; 
	}else{
		if(numbers.length < 6 ){ 
			msgbox("物流单号长度不正确！");
			return;
		}
		if(!isWhiteWpace(numbers)){ msgbox("物流号码中有空格，请检查！"); return; }
		var regExp=/^[0-9a-zA-Z-]+$/;
		if(!regExp.test(numbers)){
			msgbox("物流单号格式错误"); return;
		}
	}
	/*
	if(weight!=""){ 
		if(!isMoney(weight)){ msgbox("错误，重量格式不正确！<br>正确格式：100或100.00"); return; }
	}
	if(price!=""){ 
		if(!isMoney(price)){ msgbox("错误，物流费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
	}*/
	//if(detail==""){ msgbox("请填写物流批注！"); return; }
	var urlto = S_ROOT+"express/add";
	//alert("ordersid="+ordersid+"&cateid="+cateid+"&type="+type+"&datetime="+datetime+"&numbers="+numbers+"&weight="+weight+"&price="+price+"&detail="+detail);return;
	$("#infoed").attr("value","正在提交..");			//锁定按钮
	$("#infoed").attr("disabled","disabled");		//锁定按钮	
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: urlto,//&weight="+weight+"&price="+price+"
	    data: "ordersid="+ordersid+"&cateid="+cateid+"&type="+type+"&datetime="+datetime+"&numbers="+numbers+"&detail="+detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
		    	printView();
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    }
	});
	
}