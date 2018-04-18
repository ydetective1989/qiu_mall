

//付款状态
function paystate(id){
	//var id = $("#ordersid").val();
	openDialog("付款状态",S_ROOT+"orders/paystate?id="+id+"&"+ Math.random());
	//var dialog = art.dialog({id:'orders_paystate'});
	//dialog.close();
}

function paystated()
{
	var id = $("#dialog_ordersid").val();
	var item = $(":radio[name='paystate']:checked").val();
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"orders/paystate",
	    data: "id="+id+"&paystate="+item,
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

//审核状态
function checkbtn(id){
	//var id = $("#ordersid").val();
	openDialog("审核订单",S_ROOT+"orders/checked?id="+id+"&"+ Math.random());
}

function checkodo()
{
	var id = $("#dialog_ordersid").val();
	var item = $(":radio[name='checkval']:checked").val();
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"orders/checked",
	    data: "id="+id+"&checked="+item,
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




//审核状态
function status(id){
	//var id = $("#ordersid").val();
	openDialog("订单状态",S_ROOT+"orders/status?id="+id+"&"+ Math.random());
}

function statused()
{

	var id = $("#dialog_ordersid").val();
	var item = $(":radio[name='status']:checked").val();
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"orders/status",
	    data: "id="+id+"&status="+item,
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

function priceadm(id)
{
	//var id = $("#ordersid").val();
	openDialog("价格调整",S_ROOT+"orders/priceadm?id="+id+"&"+ Math.random());

}

function editproduct(id)
{
	//var id = $("#ordersid").val();
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定调整这个订单的产品信息吗？(注：一旦调整，一旦保存无法恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定调整',
	    ok: function(){
	    	pageload();
	    	location.href= S_ROOT+'orders/editinfo?id='+id;
	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});
}

function closed(id)
{
	//var id = $("#ordersid").val();
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定客户退货并取消这个订单吗？(注：一旦取消不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定取消',
	    ok: function(){

	    	openDialog("取消订单",S_ROOT+"orders/closed?id="+id+"&"+ Math.random());

	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});
}

function closedbtn(id)
{
	//var id = $("#ordersid").val();
	var detail = $("#closed_detail").val();
	if(detail==""){ msgbox("请填写取消操作批注信息！");return; }
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"orders/closed",
	    data: "id="+id+"&detail="+detail,
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


function killed(id)
{
	//var id = $("#ordersid").val();
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定作废这个订单吗？(注：一旦作废不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定作废',
	    ok: function(){
	    		openDialog("作废订单",S_ROOT+"orders/killed?id="+id+"&"+ Math.random());
	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});
}

function killedbtn(id)
{
	//var id = $("#ordersid").val();
	var id = $("#dialog_ordersid").val();
	var detail = $("#killed_detail").val();
	if(detail==""){ msgbox("请填写作废操作批注信息！");return; }
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"orders/killed",
	    data: "id="+id+"&detail="+detail,
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

function completed(id)
{
	//

	//var id = $("#dialog_ordersid").val();
	//var id = $("#ordersid").val();
	art.dialog({
		title:'操作确认',
		content: '你确定这个订单已经完成了吗？(一旦操作不可恢复)',
		lock: true,
		fixed: true,
	    okValue: '确认完成',
	    ok: function(){
			$.ajax({
			    type: "GET",
				async: false,
			    url: S_ROOT+"orders/completed?id="+id+"&"+ Math.random(),
			    data: "",
			    success: function(rows){
			    	if(rows=="1"){
			    		var msg = "操作完成！";
				    	msgshow(msg);
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
