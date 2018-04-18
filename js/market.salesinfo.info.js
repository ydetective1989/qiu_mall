$(function() {
	$("#datetime").datepicker({ minDate:varmindate,maxDate:varmaxdate });
});

function editinfo()
{
	var datetime	= $("#datetime").val();
	var salesid		= $("#salesid").val();
	var clientcount	= $("#clientcount").val();
	var clientphone	= $("#clientphone").val();
	var clientsales	= $("#clientsales").val();
	var ordernums	= $("#ordernums").val();
	var orderprice	= $("#orderprice").val();
	var productnums	= $("#productnums").val();
	var homenums	= $("#homenums").val();
	var homeprice	= $("#homeprice").val();
	var ternums		= $("#ternums").val();
	var terprice	= $("#terprice").val();
	var epsonnums	= $("#epsonnums").val();
	var epsonprice	= $("#epsonprice").val();
	var retnums		= $("#retnums").val();
	var retprice	= $("#retprice").val();
	var cash		= $("#cash").val();
	var pos			= $("#pos").val();
	var source		= $("#source").val();
	var storage		= $("#storage").val();
	var market		= $("#market").val();
	var service		= $("#service").val();
	var other		= $("#other").val();
	if(datetime==""){ msgbox("汇报日期不能为空！");return;}
	if(salesid==""){ msgbox("请选择上报的门店！");return;}
	if(clientcount==""){ msgbox("请填写当日客流数（访问数）！");return;}
	if(clientphone==""){ msgbox("请填写当日电话数量");return;}
	if(clientsales==""){ msgbox("请填写当日成交客户数");return;}
	if(ordernums==""){ msgbox("请填写当日成交订单数！");return;}
	if(orderprice==""){ msgbox("请填写当日成交订单金额");return;}
	if(productnums==""){ msgbox("请填写当日成交产品总数！");return;}
	if(homenums==""){ msgbox("请填写销售全屋净水产品数量！");return;}
	if(homeprice==""){ msgbox("请填写销售全屋净水销售金额！");return;}
	if(ternums==""){ msgbox("请填写销售终端净水产品数量！");return;}
	if(terprice==""){ msgbox("请填写销售终端净水销售金额！");return;}
	if(epsonnums==""){ msgbox("请填写销售滤芯耗材产品数量！");return;}
	if(epsonprice==""){ msgbox("请填写销售滤芯耗材销售金额！");return;}
	if(retnums==""){ msgbox("请填写当日退货订单数！");return;}
	if(retprice==""){ msgbox("请填写当日退货金额！");return;}
	if(cash==""){ msgbox("请填写现金收款金额！");return;}
	if(pos==""){ msgbox("请填写刷卡及代收金额！");return;}
	if(source==""){ msgbox("请填写客户来源情况！");return;}
	if(storage==""){ msgbox("请填写出入库情况！");return;}
	if(market==""){ msgbox("请填写市场反馈情况！");return;}
	if(service==""){ msgbox("请填写产品及售后问题！");return;}
	if(other==""){ msgbox("请填写其他备注！");return;}
	$("#editinfod").attr("value","正在提交..");			//锁定按钮
	$("#editinfod").attr("disabled","disabled");			//锁定按钮
	$("#sendto").submit();
}

function delreports()
{
	var id = $("#id").val();
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要删除这条报告吗？？(一旦删除不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定删除',
	    ok: function(){
			location.href= S_ROOT+"market/salesinfo?do=del&id="+id;
	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});
}