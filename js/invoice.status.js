

$(document).keydown(function(){
	if(event.keyCode == 13){  search(); }
});


function search()
{
	var contract = $("#contract").val();
	var ordersid = $("#ordersid").val();
	var worknums = $("#worknums").val();
	var urlto = "contract="+contract+"&ordersid="+ordersid+"&worknums="+worknums;
	urlto = S_ROOT + "invoice/status?show=lists&" + urlto;
	frmlist.location.href = urlto;
}