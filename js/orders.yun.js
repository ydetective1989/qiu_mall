$(function() {

	$("#yun_godate,#yun_todate").die().live("focus",function(){
		
		var yun_mindate = $("#yun_mindate").val();
		
		$("#yun_godate").datepicker({
			dateFormat: "yy-mm-dd",
			maxDate : yun_mindate
		});
		
		var dates = $("#yun_todate").datepicker({
			defaultDate: "+1w",
			numberOfMonths: 1,
			minDate : yun_mindate,
			onSelect: function( selectedDate ) {
				var option = this.id == "yun_godate"?"minDate" : "",
					instance = $(this).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not(this).datepicker( "option", option, date);
			}
		});
		
	});
	
	$("#yun_month").die().live("change",function(){ 
		var yun_godate	= $("#yun_godate").val();
		var yun_month	= $("#yun_month").val();
		//$("#yun_todate").attr("value",yun_month); return;
		$.ajax({  
		    type: "GET",  
			async: false,
		    url: S_ROOT+"yun/addmonth",
		    data: "datetime="+yun_godate+"&month="+yun_month,             
		    success: function(rows){ 
		    	$("#yun_todate").attr("value",rows);
		    }
		});
	});
	
});


function showyun(id)
{
	var showed = $("#showyun_"+id).css('display');
	if(showed=="none"){
		$("#showyun_"+id).show();
	}else{
		$("#showyun_"+id).hide();
	}
}

function addyun()
{
	var id = $("#yun_ordersid").val();
	openDialog("增加云净业务记录",S_ROOT+"yun/add?id="+id+"&"+ Math.random());
}

function edityun(id)
{
	openDialog("修改云净业务记录",S_ROOT+"yun/edit?id="+id+"&"+ Math.random());
}

function delyun(id)
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
			    url: S_ROOT+"yun/del?id="+id,
			    data: "",             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	msgshow("操作成功");
				    	yunlist(1);
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



function statusyun(id)
{
	openDialog("业务激活状态",S_ROOT+"yun/status?id="+id+"&"+ Math.random());
}


function statusyuned()
{
	var id			= $("#yun_id").val();
	var yun_status	= $(":radio[name='yun_status']:checked").val();
	var yun_detail	= $("#yun_detail").val();
	
	if(yun_status==""){
		msgbox("请选择激活状态");
		return;
	}
	
	$("#yunbtn").attr("value","正在提交..");				//锁定按钮
	$("#yunbtn").attr("disabled","disabled");			//锁定按钮
	
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"yun/status?id="+id,
	    data: "status="+yun_status+"&detail="+yun_detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    	yunlist(1);
	    	chargelist(1);
	    }
	});
	
	return;
}

function yuned()
{
	var ordersid	= $("#yun_ordersid").val();
	var yun_id		= $("#yun_id").val();
	var yun_type	= $(":radio[name='yun_type']:checked").val();
	var yun_godate	= $("#yun_godate").val();
	var yun_todate  = $("#yun_todate").val();
	var yun_detail	= $("#yun_detail").val();
	
	if(yun_type==""){
		msgbox("请选择业务付费类型");
		return;
	}
	
	if(yun_godate==""){
		msgbox("请设定业务计费开始日期!");
		return;
	}
	
	if(yun_todate==""){
		msgbox("请设定本次业务计费结束日期!");
		return;
	}


	$("#yunbtn").attr("value","正在提交..");				//锁定按钮
	$("#yunbtn").attr("disabled","disabled");			//锁定按钮
	//alert(yun_id);
	if(yun_id==""){
		var urlto = "add?id="+ordersid;
	}else{
		var urlto = "edit?id="+yun_id;
	}
	//alert(urlto);return;
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"yun/"+urlto,
	    data: "type="+yun_type+"&godate="+yun_godate+"&todate="+yun_todate+"&detail="+yun_detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    	yunlist(1);
	    }
	});
	
}




//工单记录
function yunlist(page)
{
	var id = $("#yun_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"yun/lists?id="+id+"&page="+page+"&"+ Math.random(),"#yun_list");
}



