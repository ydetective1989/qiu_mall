$(function() {
	var dates = $("#godate,#todate").datepicker({
		defaultDate: "+1w",
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "godate" ? "minDate" : "maxDate",
				instance = $(this).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not(this).datepicker( "option", option, date);
		}
	});
});

$(document).keydown(function(){
	if(event.keyCode == 13){  search(); }
});

function btnall()
{
	var alled = $("#alled").val();
	if(alled=="1"){
		alled = 0;
		$("#btnalls").attr("class","btnwhite");
		$("#btnalls").attr("value","查看全部客户");
	}else{
		alled = 1;
		$("#btnalls").attr("class","btnorange");
		$("#btnalls").attr("value","查看我的客户");
	}
	//alert(alled);
	$("#alled").attr("value",alled);
	search('');
}

function search(status)
{
	if(status=="undefined"||status==""){
		var status = $("#status").val();
	}else{
		$("#status").attr("value",status);
	}
	//alert(status);
	var ordersid = $("#ordersid").val();
	var salesarea= $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var provid	 = $("#provid").val();
	var cityid	 = $("#cityid").val();
	var areaid	 = $("#areaid").val();
	var urlto = "status="+status+"&ordersid="+ordersid+"&salesarea="+salesarea+"&salesid="+salesid+"&provid="+provid+"&cityid="+cityid+"&areaid="+areaid;
	frmlist.location.href = S_ROOT + "service/clockd?do=maps&" + urlto;
}
