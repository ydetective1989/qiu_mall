$(function() {
	
	$("#datetime").datepicker({
		dateFormat: "yy-mm-dd"
	});
	
});

$(document).keydown(function(){
	if(event.keyCode == 13){  
		search();
	}
});

function search(status)
{
	var status = status;
	//alert(status);
	var ordersid  = $("#ordersid").val();
	var contract  = $("#contract").val();
	var salesarea = $("#salesarea").val();
	var salesid	  = $("#salesid").val();
	var urlto = "ordersid="+ordersid+"&contract="+contract+"&salesarea="+salesarea+"&salesid="+salesid;
	frmlist.location.href = S_ROOT + "orders/checkstatus?show=lists&" + urlto;
}
