//修改订单客户类别
function upctype(id){
	openDialog("更正客户类型",S_ROOT+"orders/upctype?id="+id+"&" + Math.random());
}


function upctyped()
{
	var id	 	 = $("#dialog_ordersid").val();
	var ctype	 = $("#dialog_ctype").val();
	var ctypename= $("#dialog_ctype").find("option:selected").text();
	var detail	 = $("#dialog_detail").val();
	//if(detail==""){ msgbox("更新批注不能为空！");return;  }
	$.ajax({
		type: "POST",
		async: false,
		url: S_ROOT+"orders/upctype?id="+id+"&"+ Math.random(),
		data: "ctype="+ctype+"&ctypename="+ctypename+"&detail="+detail,
		success: function(rows){
			closedialog();
			if(rows=="1"){
				var msg = "修正成功！";
				msgshow(msg);
			}else{
				var msg = rows;
				msgbox(msg);
			}
		}
	});
}

//订单信息整理
function superinfo(id){
	//var id = $("#ordersid").val();
	openDialog("更改订单",S_ROOT+"orders/superinfo?id="+id+"&"+ Math.random());
}

function supered()
{
	var ordersid 	= $("#dialog_ordersid").val();
	var type	 	= $("#dialog_type").val();
	var ctype	 	= $("#dialog_ctype").val();
	var parentid 	= $("#dialog_parentid").val();
	var customsid	= $("#dialog_customsid").val();
	var checked		= $("#dialog_checked").val();
	var status		= $("#dialog_status").val();
	var paytype		= $("#dialog_paytype").val();
	var paystate 	= $("#dialog_paystate").val();
	var price_all	= $("#dialog_price_all").val();
	var price_setup	= $("#dialog_price_setup").val();
	var price_deliver=$("#dialog_price_deliver").val();
	var price_minus	= $("#dialog_price_minus").val();
	var price_other	= $("#dialog_price_other").val();
	var price_cash	= $("#dialog_price_cash").val();
	if($("#dialog_customsed").attr("checked")=="checked"){
		var customsed = 1;
	}else{
		var customsed = 0;
	}
	//alert(customsed);return;
	if(ordersid=="0"||ordersid==null){ msgbox("数据异常！");return; }
	if(type=="1"||type=="9"){
		if(parentid>"0"){
			msgbox("主订单类别，归属订单号必须为空和0！");return;
		}
	}else{
		if(parentid=="0"||parentid==""){
			msgbox("非主订单类别，归属订单号不能为空！");return;
		}
	}
	if(customsid==""){
		msgbox("客户编号不能为空！");return;
	}

	if(price_setup!=""){
		if(!isWhiteWpace(price_setup)){ msgbox("安装费用格式中包括空格，请重新填写！"); return; }
		if(!isMoney(price_setup)){ msgbox("错误，安装费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
		if(!isMoneyNums(price_setup)){ msgbox("错误，安装费用不能为负数！"); return; }
	}
	if(price_deliver!=""){
		if(!isWhiteWpace(price_deliver)){ msgbox("送货费用格式中包括空格，请重新填写！"); return; }
		if(!isMoney(price_deliver)){ msgbox("错误，送货费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
		if(!isMoneyNums(price_deliver)){ msgbox("错误，送货费用不能为负数！"); return; }
	}
	if(price_minus!=""){
		if(!isWhiteWpace(price_minus)){ msgbox("优惠费用格式中包括空格，请重新填写！"); return; }
		if(!isMoney(price_minus)){ msgbox("错误，优惠费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
		//if(!isMoneyDims(price_deliver)){ msgbox("错误，优惠费用必须为负数！"); return; }
	}
	if(price_other!=""){
		if(!isWhiteWpace(price_other)){ msgbox("其它费用格式中包括空格，请重新填写！"); return; }
		if(!isMoney(price_other)){ msgbox("错误，其它费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
		//if(!isMoneyNums(price_other)){ msgbox("错误，其它费用不能为负数！"); return; }
	}
	if(price_cash!=""){
		if(!isWhiteWpace(price_cash)){ msgbox("保证金格式中包括空格，请重新填写！"); return; }
		if(!isMoney(price_cash)){ msgbox("错误，保证金格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
		if(!isMoneyNums(price_cash)){ msgbox("错误，保证金不能为负数！"); return; }
	}

	$("#btned").attr("value","正在提交");				//锁定按钮
	$("#btned").attr("disabled","disabled");		//锁定按钮

	$.ajax({
		type: "POST",
		async: false,
		url: S_ROOT+"orders/superinfo?id="+ordersid,
		data: "ctype="+ctype+"&type="+type+"&customsed="+customsed+"&parentid="+parentid+"&customsid="+customsid+"&checked="+checked+"&status="+status+"&paytype="+paytype+"&paystate="+paystate+"&price_setup="+price_setup+"&price_deliver="+price_deliver+"&price_minus="+price_minus+"&price_other="+price_other+"&price_cash="+price_cash,
		success: function(rows){
			closedialog();
			if(rows=="1"){
				var msg = "操作成功！";
				msgshow(msg);
			}else{
				var msg = rows;
				msgbox(msg);
			}
		}
	});
}