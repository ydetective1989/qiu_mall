function menutabs(showId,num,bgItemName,clsName)
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
	if(event.keyCode == 13){  search(''); }
});

function expresslist()
{
	location.reload();
}

function expxls()
{
	var checked	 = $("#checked").val();
	var ordersid = $("#ordersid").val();
	var expnumbers = $("#expnumbers").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var urlto = "checked="+checked+"&ordersid="+ordersid+"&expnumbers="+expnumbers+"&godate="+godate+"&todate="+todate;
	frmlist.location.href = S_ROOT + "express/checklist?show=xls&" + urlto;
}

function search(checked)
{
	if(checked!=''){ $("#checked").attr("value",checked); }
	var checked	 = $("#checked").val();
	var ordersid = $("#ordersid").val();
	var expnumbers = $("#expnumbers").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var urlto = "checked="+checked+"&ordersid="+ordersid+"&expnumbers="+expnumbers+"&godate="+godate+"&todate="+todate;
	frmlist.location.href = S_ROOT + "express/checklist?show=lists&" + urlto;
}




