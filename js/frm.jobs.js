function jobstabs(showId,num,bgItemName,clsName)
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

	$("#afterid").change(function(){
		var afterid	= $("#afterid").val();
		//alert(afterid);
		if(afterid){
			$("#afteruserid").load(S_ROOT+"teams/users?type=3&teamid="+afterid+"&"+ Math.random());
		}else{
			$("#afteruserid").load(S_ROOT+"teams/users?type=3&no=1&"+ Math.random());
		}
	});

});

$(document).keydown(function(){
	if(event.keyCode == 13){  search(''); }
});

function viewlist()
{
	var views = $("#views").val();
	if(views=="0"){
		location.href= S_ROOT+'pages/jobs?views=1';
	}else{
		location.href= S_ROOT+'pages/jobs';
	}
}

function jobsxls()
{
	var worked	 = $("#worked").val();
	var ordersid = $("#ordersid").val();
	var jobsid	 = $("#jobsid").val();
	var contract	 = $("#contract").val();
	var salesarea = $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var afterarea	 = $("#afterarea").val();
	var afterid	 = $("#afterid").val();
	var afteruserid	 = $("#afteruserid").val();
	var type	 = $("#type").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var checked	 = $("#checked").val();
	var ochecked = $("#ochecked").val();
	var otype	 = $("#otype").val();
	var urlto = "worked="+worked+"&ordersid="+ordersid+"&contract="+contract+"&salesarea="+salesarea+"&salesid="+salesid+"&jobsid="+jobsid+"&afterarea="+afterarea+"&afterid="+afterid+"&afteruserid="+afteruserid+"&type="+type+"&godate="+godate+"&todate="+todate+"&checked="+checked+"&ochecked="+ochecked+"&otype="+otype;
	frmlist.location.href = S_ROOT + "jobs/xls?" + urlto;
}

function search(worked)
{
	var worked	 = worked;
	$("#worked").attr("value",worked);
	var ordersid = $("#ordersid").val();
	var jobsid	 = $("#jobsid").val();
	var contract	 = $("#contract").val();
	var salesarea = $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var afterarea	 = $("#afterarea").val();
	var afterid	 = $("#afterid").val();
	var afteruserid	 = $("#afteruserid").val();
	var type	 = $("#type").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var checked	 = $("#checked").val();
	var ochecked = $("#ochecked").val();
	var otype	 = $("#otype").val();
	var views = $("#views").val();
	var urlto = "views="+views+"&worked="+worked+"&contract="+contract+"&ordersid="+ordersid+"&salesarea="+salesarea+"&salesid="+salesid+"&jobsid="+jobsid+"&afterarea="+afterarea+"&afterid="+afterid+"&afteruserid="+afteruserid+"&type="+type+"&godate="+godate+"&todate="+todate+"&checked="+checked+"&ochecked="+ochecked+"&otype="+otype;
	frmlist.location.href = S_ROOT + "jobs/lists?" + urlto;
}

function backdate()
{
	var datetime	=	$("#todate").val();
	$.ajax({
	    type: "GET",
		async: false,
	    url: S_ROOT+"jobs/getdate?do=back&datetime="+datetime,
	    data: "",
	    success: function(rows){
	    	var datetime = rows;
	    	$("#godate").attr("value",datetime);
	    	$("#todate").attr("value",datetime);
	    }
	});
}

function nextdate()
{
	var datetime	=	$("#todate").val();
	$.ajax({
	    type: "GET",
		async: false,
	    url: S_ROOT+"jobs/getdate?do=next&datetime="+datetime,
	    data: "",
	    success: function(rows){
	    	var datetime = rows;
	    	$("#godate").attr("value",datetime);
	    	$("#todate").attr("value",datetime);
	    }
	});
}

function jobslist()
{
	var the_timeout = setTimeout("jobreload();",1000);//每5分钟提醒一次
}

function jobreload()
{
	location.reload();
}
