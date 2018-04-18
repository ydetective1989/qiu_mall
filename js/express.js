$(document).keydown(function(){
	if(event.keyCode == 13){  search(); }
});

function search()
{
	var ordersid = $("#ordersid").val();
	//alert("1"+ordersid+"2");
	if(ordersid==""){  msgbox("抱歉，订单编号不能为空！"); return false; }
	var urlto = "ordersid="+ordersid;
	urlto = S_ROOT + "express?show=lists&" + urlto;
	frmlist.location.href = urlto;
}

function checked()
{
	
}