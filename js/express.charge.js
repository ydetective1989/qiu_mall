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
			var cateid = $("#cateid").val();
			var godate = $("#godate").val();
			var todate = $("#todate").val();
			//alert(S_ROOT+"express/afters?cateid="+cateid+"&godate="+godate+"&todate="+todate+"&"+ Math.random());
			$("#afterid").load(S_ROOT+"express/afters?cateid="+cateid+"&godate="+godate+"&todate="+todate+"&"+ Math.random());
		}
	});
});

$(document).keydown(function(){
	if(event.keyCode == 13){  search(); }
});

function setype()
{
	var showed = $("#showed").val();
	if(showed=="lists"){
		$("#showed").attr("value","editall");
	}else{
		$("#showed").attr("value","lists");
	}
}


function editall()
{

	$("#editfrm").submit();
}

function search(showed)
{
	var cateid	 = $("#cateid").val();
	var ordersid = $("#ordersid").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var afterid	 = $("#afterid").val();
	var showed	= $("#showed").val();
	var urlto = "cateid="+cateid+"&ordersid="+ordersid+"&godate="+godate+"&todate="+todate+"&afterid="+afterid;
	if(showed=="editall"){
		urlto = S_ROOT + "express/editall?to=lists&" + urlto;
	}else{
		urlto = S_ROOT + "express/charge?to=lists&" + urlto;
	}
	frmlist.location.href = urlto;
}

function xls()
{
	var cateid	 = $("#cateid").val();
	var ordersid = $("#ordersid").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var afterid	 = $("#afterid").val();
	var xlstype  = $("#xlstype").val();
	var urlto = "cateid="+cateid+"&ordersid="+ordersid+"&xlstype="+xlstype+"&godate="+godate+"&todate="+todate+"&afterid="+afterid;
	frmlist.location.href = S_ROOT + "express/xls?" + urlto;
}