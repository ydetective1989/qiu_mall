
$(function() {

	$("#charge_datetime").die().live("focus",function(){
		$("#charge_datetime").datepicker({
			dateFormat: "yy-mm-dd"
		});
	});

});

$(function() {

	$("#charge_ptype").die().live("change",function(){
		var ptypeid	= $("#charge_ptype").val();
		$("#charge_payid").load(S_ROOT+"charge/gettype?id="+ptypeid+"&"+ Math.random());
	});

});

function addcharge(id)
{
	openDialog("增加支付记录",S_ROOT+"orders/charge?do=add&id="+id+"&" + Math.random());
}

function editcharge(id)
{
	openDialog("修改支付记录",S_ROOT+"orders/charge?do=edit&id="+id+"&" + Math.random());
}

function delcharge(id)
{
	var ordersid	= $("#ordersid").val();
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
			    url: S_ROOT+"orders/charge?do=del&id="+id+"&ordersid="+ordersid,
			    data: "",
			    success: function(rows){
			    	if(rows=="1"){
				    	msgshow("操作成功");
				    	chargelist(1);
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

function charged()
{
	var ordersid	= $("#charge_ordersid").val();
	var chargeid	= $("#charge_id").val();
	var jobsid		= $("#charge_jobsid").val();
	var type		= $(":radio[name='charge_type']:checked").val();
	var datetime	= $("#charge_datetime").val();
	var cates		= $("#charge_cates").val();
	var payid		= $("#charge_payid").val();
	var price		= $("#charge_price").val();
	var detail		= $("#charge_detail").val();
	if(type==""){ msgbox("请选择款项类别！"); return; }
	if(datetime==""){
		msgbox("时间不能为空！"); return;
	}else{
		if(!strDate(datetime)){
			msgbox("错误，日期格式不正确！<br>正确格式：2012-01-01");
			return;
		}
	}

	if(cates==""){
		msgbox("请选择费用类别！"); return;
	}

	if(payid==""){
		msgbox("请选择收支方式！"); return;
	}

	if(price==""){
		msgbox("金额不能为空！"); return;
	}else{
		if(type=="2"){
			if(!isMoneyDims(price)){
				msgbox("错误，金额格式不正确！<br>退款格式应为负数(带-符)，如：-100或-100.00");
				return;
			}
		}else{
			if(!isMoneyNums(price)){
				msgbox("错误，金额格式不正确！<br>入款格式应为正数，如：100或100.00");
				return;
			}
		}
	}

	if(detail==""){ msgbox("款项批注不能为空！"); return; }
	if(chargeid!=""){
		urlto = S_ROOT+"orders/charge?do=edit";
	}else{
		urlto = S_ROOT+"orders/charge?do=add";
	}

	$("#chargebtn").attr("value","正在提交..");			//锁定按钮
	$("#chargebtn").attr("disabled","disabled");		//锁定按钮
	$.ajax({
	    type: "POST",
		async: false,
	    url: urlto,
	    data: "ordersid="+ordersid+"&jobsid="+jobsid+"&id="+chargeid+"&type="+type+"&datetime="+datetime+"&price="+price+"&cates="+cates+"&payid="+payid+"&detail="+detail,
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow("操作成功");
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    	chargelist(1);
	    }
	});
}



//支付记录
function chargelist(page)
{
	var id = $("#charge_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/charge?id="+id+"&page="+page+"&"+ Math.random(),"#charge_list");
}
