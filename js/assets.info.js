$(function() {

	$("#purchasetime").datepicker({
		dateFormat: "yy-mm-dd"
	});

});


function editinfo()
{
	var name = $("#name").val();
	if(name==""){ msgbox("物品名称不能为空！");return; }
	var type = $("#type").val();
	if(type==""){ msgbox("请选择物品类型！");return; }
	var source = $("#source").val();
	if(source==""){ msgbox("请选择物品来源方式！");return; }
	var units = $("#units").val();
	if(units==""){ msgbox("请选择物品的识别单位！");return; }
	var count = $("#count").val();
	if(count==""){ 
		msgbox("物品数量不能为空！");return;
	}else{
		if(!isNumber(count)){ msgbox("物品数量格式不正确！请用阿拉伯数字 0~9 ！");return; }
	}
	var purchase = $("#purchase").val();
	if(purchase==""){ msgbox("请选择物品的采购部门！");return; }
	var employ = $("#employ").val();
	if(employ==""){ msgbox("请选择物品的使用部门！");return; }
	var storage = $("#storage").val();
	if(storage==""){ msgbox("物品存放地点不能为空！");return; }
	var purchasetime = $("#purchasetime").val();
	if(purchasetime==""){ msgbox("请选择物品的采购时间！");return; }
	var price = $("#price").val();
	if(price==""){ 
		msgbox("请选择物品的采购金额不能为空！");return;
	}else{
		if(!isMoney(price)){ msgbox("请选择物品的采购金额格式不正确！");return; }
	}
	var oldnew = $("#oldnew").val();
	if(oldnew==""){ msgbox("请选择物品的新旧程度！");return; }
	var charge = $("#charge").val();
	if(charge==""){ msgbox("请选择/填写物品的使用人员！");return; }
	var plandate = $("#plandate").val();
	if(plandate==""){ msgbox("请填写计划使用的期限！");return; }
	var employinfo = $("#employinfo").val();
	if(employinfo==""){ msgbox("请填写物品的使用说明/批注！");return; }
	
	$("#editinfod").attr("value","正在提交..");			//锁定按钮
	$("#editinfod").attr("disabled","disabled");			//锁定按钮
	pageload();
	$("#editfrm").submit();
}