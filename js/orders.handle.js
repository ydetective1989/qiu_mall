

//审核记录
function handle_check(id)
{
	ajaxurl(S_ROOT+"handle/checkpage?ordersid="+id+"&"+ Math.random(),"#handle_checks");
}

//订单退款返现
function addhandle(id)
{

	openDialog("退换货&返现申请",S_ROOT+"handle/add?id="+id+"&"+ Math.random());
}

//订单退款返现
function edithandle(id)
{

	openDialog("退换货&返现申请",S_ROOT+"handle/edit?id="+id+"&"+ Math.random());
}

function delhandle(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要删除这条申请吗？(一旦删除不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定删除',
	    ok: function(){
			$.ajax({  
			    type: "GET",  
				async: false,
			    url: S_ROOT+"handle/del?id="+id,
			    data: "",             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	msgshow("操作成功");
				    	handlelist(1);
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

function handledo()
{
	var id				= $("#dialog_id").val();
	var ordersid		= $("#dialog_ordersid").val();
	var cateid  		= $('#dialog_cateid').val();
	var deliver  		= $('#dialog_deliver').val();
	var salesid			= $('#dialog_salechk').val();
	var invoice			= $('input[name="dialog_invoice"]:checked').val();
	var express			= $("#dialog_express").val();
	var price			= $("#dialog_price").val();
	if(cateid==""){
		msgshow("请选择业务申请类型！");return;
	}
	if(deliver==""){
		msgshow("请选择发货情况！");return;
	}
	if(salesid==""){
		msgshow("所属销售部门不能为空！");return;
	}
	if(price!=""){
		if(!isWhiteWpace(price)){ msgbox("费用格式中包括空格，请重新填写！"); return; }
		if(!isMoney(price)){ msgbox("错误，费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
		//if(!isMoneyNums(price)){ msgbox("错误，费用不能为负数！"); return; }
	}

	var chk_arr =[];  
	$('input[name="dialog_checked"]:checked').each(function(){  
		chk_arr.push($(this).val());  
	});
	//if(chk_arr.length==0){ msgshow('没有选择审核人');return; }
	var	checked = chk_arr;
	var detail	= $("#dialog_detail").val();
	if(detail==""){ msgbox("申请说明不能为空！"); return; }

	//$("#btned").attr("value","正在提交..");			//锁定按钮
	//$("#btned").attr("disabled","disabled");		//锁定按钮
	if(id==""){
		urlto = S_ROOT+"handle/add?id="+ordersid+"&"+ Math.random();
	}else{
		urlto = S_ROOT+"handle/edit?id="+id+"&"+ Math.random();
	}
	//alert(urlto);
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: urlto,
	    data: "cateid="+cateid+"&deliver="+deliver+"&invoice="+invoice+"&price="+price+"&express="+express+"&salesid="+salesid+"&checked="+checked+"&detail="+detail,             
	    success: function(rows){
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    	handlelist(1);
	    	closedialog();
	    }
	});	
}

//审核记录
function lists_loadcheck(oid)
{
	openDialog("审核状态",S_ROOT+"handle/checkpage?id="+oid+"&"+ Math.random());
}

//子订记录
function handlelist(page)
{
	var id = $("#handle_ordersid").val();
	//alert(id);
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"handle/lists?id="+id+"&page="+page+"&"+ Math.random(),"#handle_list");
}


