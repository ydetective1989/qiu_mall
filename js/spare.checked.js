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


function focustabs(showId,num,bgItemName,clsName)
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

function search(checked)
{
	$("#checked").attr("value",checked);
	var checked	 = $("#checked").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var afterarea= $("#afterarea").val();
	var afterid	 = $("#afterid").val();
	var urlto = "checked="+checked+"&godate="+godate+"&todate="+todate+"&afterarea="+afterarea+"&afterid="+afterid;
	frmlist.location.href = S_ROOT + "spare/checked?show=lists&" + urlto;
}

function xls()
{
	var godate	 = $("#godate").val();
	var checked	 = $("#checked").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var afterarea= $("#afterarea").val();
	var afterid	 = $("#afterid").val();
	var urlto = "checked="+checked+"&godate="+godate+"&todate="+todate+"&afterarea="+afterarea+"&afterid="+afterid;
	frmlist.location.href = S_ROOT + "spare/checked?show=xls&" + urlto;
}




function spare_checked(id)
{
	openDialog("查看操作日志",S_ROOT+"spare/checked?show=checked&id="+id+"&"+ Math.random());
}

function spare_checkdo()
{
	var id			= $("#spare_id").val();
	var ordersid	= $("#spare_ordersid").val();
	var cateid		= $("#spare_cateid").val();
	var checked		= $(":radio[name='spare_checked']:checked").val();
	//var detail		= $("#spare_detail").val();
	//if(detail==""){
	//	msgbox("批注不能为空！"); return;
	//}

	$("#btned").attr("value","正在提交..");			//锁定按钮
	$("#btned").attr("disabled","disabled");		//锁定按钮
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"spare/checked?show=checked&id="+id,
	    data: "ordersid="+ordersid+"&checked="+checked+"&cateid="+cateid,             
	    success: function(rows){
	    	if(rows=="1"){
	    		var msg = "操作成功！";
	    		msgshow(msg);
	    		location.reload();
	    	}else{
	    		var msg = rows;
	    	}
	    	msgbox(msg);
	    }
	});
}
