function degreetabs(showId,num,bgItemName,clsName)
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

//操作记录
function logslist(page)
{
	var id = $("#ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/logs?id="+id+"&page="+page,"#logs_list");
}

function degreed()
{
	var id = $("#id").val();
	var jobsid = $("#jobsid").val();
	var ordersid = $("#ordersid").val();
	openDialog("满意度回访操作",S_ROOT+"service/degree?do=edit&id="+id+"&ordersid="+ordersid+"&jobsid="+jobsid+"&"+ Math.random());
}

function degreelist()
{
	parent.frmlist.location.reload();
}

function degreebtn()
{
	var id			= $("#degree_id").val();
	var ordersid	= $("#degree_ordersid").val();
	var jobsid		= $("#degree_jobsid").val();
	var datetime	= $("#degree_datetime").val();
	if(datetime==""){ msgbox("回访时间不能为空！"); return; }
	var sales		= $("#degree_sales").val();
	var salesinfo	= $("#degree_salesinfo").val();
	var after		= $("#degree_after").val();
	var afterinfo	= $("#degree_afterinfo").val();
	var detail		= $("#degree_detail").val();
	if(detail==""){ msgbox("回访批注不能为空！"); return; }
	
	var salesid		= $("#degree_salesid").val();
	var saleuserid	= $("#degree_saleuserid").val();
	var afterid		= $("#degree_afterid").val();
	var afteruserid	= $("#degree_afteruserid").val();
	
	var checked	= $(":radio[name='degree_checked']:checked").val();
	//alert(checked);return;

	$("#degreebto").attr("value","正在提交..");			//锁定按钮
	$("#degreebto").attr("disabled","disabled");		//锁定按钮
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"service/degree?do=edit&id="+id+"&ordersid="+ordersid+"&jobsid="+jobsid,
	    data: "checked="+checked+"&datetime="+datetime+"&sales="+sales+"&salesinfo="+salesinfo+"&after="+after+"&afterinfo="+afterinfo+"&detail="+detail+"&salesid="+salesid+"&saleuserid="+saleuserid+"&afterid="+afterid+"&afteruserid="+afteruserid,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    	degreelist();
	    }
	});
}

function degreetype()
{

	var degree_checked = $(":radio[name='degree_checked']:checked").val();
	if(degree_checked=="1"){
		$("#degree_infod").show();
	}else{
		$("#degree_infod").hide();
	}
}

function search(status)
{
	if(status=="undefined"||status==""){
		var status = $("#status").val();
	}else{
		$("#status").attr("value",status);
	}
	//alert(status);
	var type 		= $("#type").val();
	var ordersid 	= $("#ordersid").val();
	var godate	 	= $("#godate").val();
	var todate	 	= $("#todate").val();
	var salesarea	= $("#salesarea").val();
	var salesid	 	= $("#salesid").val();
	var urlto 		= "type="+type+"&status="+status+"&ordersid="+ordersid+"&godate="+godate+"&todate="+todate+"&&salesarea="+salesarea+"&salesid="+salesid;
	frmlist.location.href = S_ROOT + "service/degree?do=lists&" + urlto;
}
