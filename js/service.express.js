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


function search(status)
{
	//alert(status);
	var numbers  = $("#numbers").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var cateid	 = $("#cateid").val();
	var finished = $("#finished").val();
	var salesarea 	= $("#salesarea").val();
	var salesid 	= $("#salesid").val();
	var provid	 = $("#provid").val();
	var cityid	 = $("#cityid").val();
	var areaid	 = $("#areaid").val();
	var status	 = $("#status").val();
	var setuptype	 = $("#setuptype").val();
	//if(ordersid==""&&contract==""&&mobile==""){ msgshow("请输入一个搜索条件！");return; }
	var urlto = "godate="+godate+"&todate="+todate+"&numbers="+numbers+"&cateid="+cateid+"&finished="+finished+"&status="+status+"&setuptype="+setuptype+"&salesarea="+salesarea+"&salesid="+salesid+"&provid="+provid+"&cityid="+cityid+"&areaid="+areaid;
	frmlist.location.href = S_ROOT + "service/express?show=1&" + urlto;
}