$(function() {
	
	$("#express_datetime").die().live("focus",function(){
		$("#express_datetime").datepicker({
			dateFormat: "yy-mm-dd"
		});
	});
	
});


$(function() {
	$("#express_images").die().live("click",function(){ 
		var id  = $("#express_id").val();
		var key = $("#express_key").val();
		var com = $("#express_com").val();
		//http://api.kuaidi100.com/verifyCode?id=$key&com=$com&
		$("#express_images").attr("src","http://api.kuaidi100.com/verifyCode?id="+key+"&com="+com+"&" + Math.random());
	});
});

function viewexpress(id)
{
	//openDialog("查看物流信息",S_ROOT+"express/views?id="+id+"&" + Math.random());
	window.open(S_ROOT+"express/views?id="+id+"&" + Math.random());
}

function addexpress(type)
{
	var id = $("#exp_ordersid").val();
	openDialog("增加物流信息",S_ROOT+"express/add?id="+id+"&type="+type+"&" + Math.random());
}


function editexpress(id)
{
	openDialog("修改物流信息",S_ROOT+"express/edit?id="+id+"&" + Math.random());
}


function checkexpress(id)
{
	openDialog("确认物流信息",S_ROOT+"express/checked?id="+id+"&" + Math.random());
}

function delexpress(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要删除这条记录吗？(一旦删除不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定删除',
	    ok: function(){
			$.ajax({  
			    type: "GET",  
				async: false,
			    url: S_ROOT+"express/del?id="+id,
			    data: "",             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	msgshow("操作成功");
				    	expresslist(1);
			    	}else{
			    		msgbox(rows);
			    	}
			    }
			});
	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});
}

function exp_infod()
{
	var ordersid	= $("#ordersid").val();
	var datetime	= $("#express_datetime").val();
	var id			= $("#express_id").val();
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
	}
	*/
	//if(detail==""){ msgbox("请填写ERP批注！"); return; }
	if(id!=""){
		urlto = S_ROOT+"express/edit";
	}else{
		urlto = S_ROOT+"express/add";
	}
	$("#infoed").attr("value","正在提交..");			//锁定按钮
	$("#infoed").attr("disabled","disabled");		//锁定按钮	
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: urlto,//weight="+weight+"&price="+price+"&
	    data: "ordersid="+ordersid+"&id="+id+"&cateid="+cateid+"&type="+type+"&datetime="+datetime+"&numbers="+numbers+"&detail="+detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    	expresslist(1);
	    }
	});
}

function checkdo()
{
	var ordersid	= $("#ordersid").val();
	var datetime	= $("#express_datetime").val();
	var id			= $("#express_id").val();
	var cateid		= $("#express_cateid").val();
	var numbers		= $("#express_numbers").val();
	var weight		= $("#express_weight").val();
	var price		= $("#express_price").val();
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
	if(weight==""){
		msgbox("物流发货确认时，重量数值不能为空！");
		return;
	}else{
		if(!isMoney(weight)){ msgbox("错误，重量格式不正确！<br>正确格式：100或100.00"); return; }
	}
	if(price!=""){ 
		if(!isMoney(price)){ msgbox("错误，物流费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
	}
	if(detail==""){ msgbox("请填写物流批注！"); return; }

	urlto = S_ROOT+"express/checked";

	$("#infoed").attr("value","正在提交..");			//锁定按钮
	$("#infoed").attr("disabled","disabled");		//锁定按钮	
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: urlto,
	    data: "ordersid="+ordersid+"&id="+id+"&cateid="+cateid+"&datetime="+datetime+"&numbers="+numbers+"&weight="+weight+"&price="+price+"&detail="+detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    	expresslist(1);
	    }
	});
}

//物流记录
function expresslist(page)
{
	var id = $("#exp_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/express?id="+id+"&page="+page+"&"+ Math.random(),"#express_list");
}




