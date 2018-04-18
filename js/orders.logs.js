
$(function() {
	
	$("#logs_datetime").die().live("focus",function(){
		$("#logs_datetime").datepicker({
			dateFormat: "yy-mm-dd"
		});
	});
	
});


//操作记录
function logslist(page)
{
	var id = $("#logs_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/logs?id="+id+"&page="+page+"&"+ Math.random(),"#logs_list");
}

function addlogs(id)
{
	openDialog("增加操作记录",S_ROOT+"orders/logs?do=add&id="+id+"&"+ Math.random());
}

function editlogs(id)
{
	openDialog("修改操作记录",S_ROOT+"orders/logs?do=edit&id="+id+"&"+ Math.random());
}

function dellogs(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要删除这条记录吗？(一旦删除不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定删除',
	    ok: function(){
			$.ajax({  
			    type: "GET",  
				async: false,
			    url: S_ROOT+"orders/logs?do=del&id="+id,
			    data: "",             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	logslist(1);
				    	msgshow("操作成功");
			    	}else{
			    		msgbox(rows);
			    	}
			    }
			});
	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});
}

function logsed()
{
	var ordersid	= $("#logs_ordersid").val();
	var logsid		= $("#logs_id").val();
	var type		= $("#logs_type").val();
	var datetime	= $("#logs_datetime").val();
	var detail		= $("#logs_detail").val();
	if(type==""){ msgbox("请选择操作记录类别！"); return; }
	if(datetime==""){ 
		msgbox("时间不能为空！"); return;
	}else{
		if(!strDate(datetime)){
			msgbox("错误，日期格式不正确！<br>正确格式：2012-01-01"); 
			return; 
		}
	}
	if(detail==""){ msgbox("操作批注不能为空！"); return; }
	if(logsid!=""){
		urlto = S_ROOT+"orders/logs?do=edit";
	}else{
		urlto = S_ROOT+"orders/logs?do=add";
	}
	$("#logsbtn").attr("value","正在提交..");			//锁定按钮
	$("#logsbtn").attr("disabled","disabled");		//锁定按钮
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: urlto,
	    data: "ordersid="+ordersid+"&id="+logsid+"&type="+type+"&datetime="+datetime+"&detail="+detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow("操作成功");
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    	logslist(1);
	    }
	});
}