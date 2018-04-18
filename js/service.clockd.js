function clockdtabs(showId,num,bgItemName,clsName)
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

	$("#areaid").change(
		function(){
			var areaid = $("#areaid").val();
			if(areaid>"0"){
				//$("#loops").load(S_ROOT+"orders/areas?areaid="+areaid+"&"+ Math.random());
			}
		}
	);

});

$(document).keydown(function(){
	if(event.keyCode == 13){  search(""); }
});

function search(status)
{
	if(status=="undefined"||status==""){
		var status = $("#status").val();
	}else{
		$("#status").attr("value",status);
	}
	//alert(status);
	var godate = $("#godate").val();
	var todate = $("#todate").val();
	var ordersid = $("#ordersid").val();
	var stars	 	 = $("#stars").val();
	var salesarea= $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var provid	 = $("#provid").val();
	var cityid	 = $("#cityid").val();
	var areaid	 = $("#areaid").val();
	var address	 = $("#address").val();
	var alled    = $("#alled").val();
	var encoded	 = $("#encoded").val();
	var brandid	 = $("#brandid").val();
	var urlto = "godate="+godate+"&todate="+todate+"&status="+status+"&stars="+stars+"&encoded="+encoded+"&brandid="+brandid+"&ordersid="+ordersid+"&salesarea="+salesarea+"&salesid="+salesid+"&provid="+provid+"&cityid="+cityid+"&areaid="+areaid+"&address="+address+"&alled="+alled;
	frmlist.location.href = S_ROOT + "service/clockd?do=lists&" + urlto;
}
