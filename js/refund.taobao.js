function otabs(showId,num,bgItemName,clsName)
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

function search()
{
	var godate	= $("#godate").val();
	var todate	= $("#todate").val();
	var contract	= $("#contract").val();
	var salesid		= $("#salesid").val();
	var status		= $("#status").val();
	var urlto	= "godate="+godate+"&todate="+todate+"&contract="+contract+"&salesid="+salesid+"&status="+status;
	frmlist.location.href= S_ROOT+'refund/taobao?show=lists&'+urlto;
}

function xls()
{
	var godate	= $("#godate").val();
	var todate	= $("#todate").val();
	var contract	= $("#contract").val();
	var salesid		= $("#salesid").val();
	var status		= $("#status").val();
	var urlto	= "godate="+godate+"&todate="+todate+"&contract="+contract+"&salesid="+salesid+"&status="+status;
	frmlist.location.href= S_ROOT+'refund/taobao?show=xls&'+urlto;
}










