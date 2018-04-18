

$(document).keydown(function(){
	if(event.keyCode == 13){  search(); }
});

function search(status)
{
	//alert(status);
	var ordersid = $("#ordersid").val();
	//var address = $("#address").val();
	var contract = $("#contract").val();
	var wangwang = $("#wangwang").val();
	var mobile	 = $("#mobile").val();
	var address	 = $("#address").val();
	if(ordersid==""&&address==""&&contract==""&&mobile==""&&wangwang==""){ msgshow("请输入一个搜索条件！");return; }
	var urlto = "ordersid="+ordersid+"&contract="+contract+"&mobile="+mobile+"&wangwang="+wangwang+"&address="+address;
	frmlist.location.href = S_ROOT + "service/calls?show=1&" + urlto;
}