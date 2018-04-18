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
	//var ordersid = $("#ordersid").val();
	var contract = $("#contract").val();
	var urlto = "status="+status+"&contract="+contract;
	frmlist.location.href = S_ROOT + "opens/tmalltasks?do=lists&" + urlto;
}

function checkede(id)
{
	openDialog("受理工单操作",S_ROOT+"opens/tmalltasks?do=checked&id="+id+"&"+ Math.random());
}

function checkdo()
{
	var id		= $("#dialog_id").val();
	var checked	= $(":radio[name='dialog_checked']:checked").val();
	var detail	= $("#dialog_detail").val();
	if(detail==""){ msgbox("受理反馈信息不能为空！"); return; }
	$("#infoed").attr("value","正在提交..");			//锁定按钮
	$("#infoed").attr("disabled","disabled");		//锁定按钮	

	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"opens/tmalltasks?do=checked&id="+id,
	    data: "checked="+checked+"&detail="+detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
	    		msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    }
	});
}

function worked(id)
{
	openDialog("工单执行操作",S_ROOT+"opens/tmalltasks?do=worked&id="+id+"&"+ Math.random());
}

function workdo()
{
	var id		= $("#dialog_id").val();
	var worked	= $(":radio[name='dialog_worked']:checked").val();
	var detail	= $("#dialog_detail").val();
	if(detail==""){ msgbox("执行反馈信息不能为空！"); return; }
	$("#infoed").attr("value","正在提交..");			//锁定按钮
	$("#infoed").attr("disabled","disabled");		//锁定按钮	
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"opens/tmalltasks?do=worked&id="+id,
	    data: "worked="+worked+"&detail="+detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
	    		msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    }
	});
}

function called(id)
{

	openDialog("回执工单信息",S_ROOT+"opens/tmalltasks?do=called&id="+id+"&"+ Math.random());
	
}

function calldo()
{
	var id		= $("#dialog_id").val();
	var called	= $(":radio[name='dialog_called']:checked").val();
	var detail	= $("#dialog_detail").val();
	if(detail==""){ msgbox("回执反馈信息不能为空！"); return; }
	$("#infoed").attr("value","正在提交..");			//锁定按钮
	$("#infoed").attr("disabled","disabled");		//锁定按钮
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"opens/tmalltasks?do=called&id="+id,
	    data: "called="+called+"&detail="+detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
	    		msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    }
	});
}
