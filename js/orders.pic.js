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
	if(event.keyCode == 13){  
		search();
	}
});

function search()
{
	var type	  = $("#type").val();
	var godate    = $("#godate").val();
	var todate	  = $("#todate").val();
	var ordersid  = $("#ordersid").val();
	var salesarea = $("#salesarea").val();
	var salesid	  = $("#salesid").val();
	var urlto = "type="+type+"&godate="+godate+"&todate="+todate+"&ordersid="+ordersid+"&salesarea="+salesarea+"&salesid="+salesid;
	frmlist.location.href = S_ROOT + "orders/pic?show=lists&" + urlto;
}