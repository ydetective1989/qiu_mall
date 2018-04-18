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


function search()
{
	var issend	 = $("#issend").val();
	var contract = $("#contract").val();
	var ordersid = $("#ordersid").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var salesarea= $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var urlto = "issend="+issend+"&contract="+contract+"&ordersid="+ordersid+"&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid;
	urlto = S_ROOT + "express/sendstatus?show=lists&" + urlto;
	frmlist.location.href = urlto;
}