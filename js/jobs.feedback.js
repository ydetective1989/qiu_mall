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
	if(event.keyCode == 13){  search(); }
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
	//var phone  = $("#phone").val();
	var type   = $("#type").val();
	var keywords = $("#keywords").val();
	var urlto = "status="+status+"&godate="+godate+"&todate="+todate+"&type="+type+"&keywords="+keywords;
	frmlist.location.href = S_ROOT + "jobs/feedback?mo=lists&" + urlto;
}

function xlsed()
{
	var status = $("#status").val();
	var godate = $("#godate").val();
	var todate = $("#todate").val();
	var urlto = "status="+status+"&godate="+godate+"&todate="+todate;
	frminfo.location.href = S_ROOT + "xls/feedback?show=xls&" + urlto;
}

function checkede(id)
{

	openDialog("受理预约操作",S_ROOT+"jobs/feedback?do=checked&id="+id+"&"+ Math.random());

}

function checkdo()
{
	var id		= $("#dialog_id").val();
	var checked	= $(":radio[name='dialog_checked']:checked").val();
	var detail	= $("#dialog_detail").val();
	if(detail==""){ msgbox("受理批注不能为空！"); return; }
	$("#infoed").attr("value","正在提交..");			//锁定按钮
	$("#infoed").attr("disabled","disabled");		//锁定按钮

	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"jobs/feedback?do=checked&id="+id,
	    data: "checked="+checked+"&detail="+detail,
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
	    		parent.msgshow(msg);
	    		parent.frminfo.location.reload();
	    		parent.frmlist.location.reload();
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    }
	});
}
