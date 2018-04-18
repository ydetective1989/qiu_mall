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

function insert()
{
	frminfo.location.href=S_ROOT+'market/salesinfo?do=add';
}

function search()
{
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var urlto = "godate="+godate+"&todate="+todate;
	frmlist.location.href = S_ROOT + "market/salesinfo?do=lists&" + urlto;
}



