
$(function() {
	
	$("#cslogs_datetime").die().live("focus",function(){
		$("#cslogs_datetime").datepicker({
			dateFormat: "yy-mm-dd"
		});
	});
	
});


//服务记录
function cslogslist(page)
{
	var id = $("#cslogs_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/cslogs?id="+id+"&page="+page+"&"+ Math.random(),"#cslogs_list");
}

function addcslogs()
{
	var id = $("#ordersid").val();
	openDialog("增加操作记录",S_ROOT+"orders/cslogs?do=add&id="+id+"&" + Math.random());
}

function editcslogs(id)
{
	openDialog("修改操作记录",S_ROOT+"orders/cslogs?do=edit&id="+id+"&" + Math.random());
}

function delcslogs(id)
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
			    url: S_ROOT+"orders/cslogs?do=del&id="+id,
			    data: "",             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	msgshow("操作成功");
				    	cslogslist(1);
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

function cslogsed()
{
	var ordersid	= $("#ordersid").val();
	var id			= $("#cslogs_id").val();
	var type		= $("#cslogs_type").val();
	var datetime	= $("#cslogs_datetime").val();
	var detail		= $("#cslogs_detail").val();
	if(type==""){ msgbox("请选择服务类别！"); return; }
	if(datetime==""){ 
		msgbox("时间不能为空！"); return;
	}else{
		if(!strDate(datetime)){
			msgbox("错误，日期格式不正确！<br>正确格式：2012-01-01"); 
			return; 
		}
	}
	if(detail==""){ msgbox("服务批注不能为空！"); return; }
	if(id!=""){
		urlto = S_ROOT+"orders/cslogs?do=edit";
	}else{
		urlto = S_ROOT+"orders/cslogs?do=add";
	}
	$("#cslogsbtn").attr("value","正在提交..");			//锁定按钮
	$("#cslogsbtn").attr("disabled","disabled");		//锁定按钮
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: urlto,
	    data: "ordersid="+ordersid+"&id="+id+"&type="+type+"&datetime="+datetime+"&detail="+detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    	cslogslist(1);
	    }
	});
}
