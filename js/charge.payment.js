function chargetabs(showId,num,bgItemName,clsName)
{
	var clsNameArr=new Array(2)
	if(clsName.indexOf("|")<=0){
		clsNameArr[0]=clsName
		clsNameArr[1]=""
	}else{
		clsNameArr[0]=clsName.split("|")[0]
		clsNameArr[1]=clsName.split("|")[1]
	}
	
	for(i=1;i<=num;i++)
	{
		if(document.getElementById(bgItemName+i)!=null)
			document.getElementById(bgItemName+i).className=clsNameArr[1]
		if(i==showId)
		{
			if(document.getElementById(bgItemName+i)!=null)
				document.getElementById(bgItemName+i).className=clsNameArr[0]
		}
	}
}

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
	var ordersid = $("#ordersid").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var service	 = $("#service").val();
	var urlto = "ordersid="+ordersid+"&godate="+godate+"&todate="+todate+"&service="+service;
	frmlist.location.href = S_ROOT + "charge/payment?do=lists&" + urlto;
}

function xls()
{
	var ordersid = $("#ordersid").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var service	 = $("#service").val();
	var urlto = "ordersid="+ordersid+"&godate="+godate+"&todate="+todate+"&service="+service;
	frmlist.location.href = S_ROOT + "charge/payment?do=xls&" + urlto;
}