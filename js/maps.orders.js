$(document).keydown(function(){
	if(event.keyCode == 13){  search(); }
});

function search()
{
	var provid		= $("#provid").val();
	var cityid		= $("#cityid").val();
	var areaid		= $("#areaid").val();
	var urlto = "provid="+provid+"&cityid="+cityid+"&areaid="+areaid;
	frmlist.location.href = S_ROOT + "maps/orders?show=maps&" + urlto;
}

function vieworders(id)
{
		parent.parent.addTab('查看订单','orders/views?id='+id,'orderview');
}
