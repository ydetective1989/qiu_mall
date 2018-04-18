//操作记录
function logslist(page)
{
	var id = $("#clock_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/logs?id="+id+"&page="+page,"#logs_list");
}

function clockdalllist(page)
{
	var ordersid = $("#clock_ordersid").val();
	if(page==""){ var page = 1; }
	//alert(S_ROOT+"service/clockd?do=logs&worked=0,1&ordersid="+ordersid+"&page="+page);
	ajaxurl(S_ROOT+"service/clockd?do=logs&worked=0,1&ordersid="+ordersid+"&page="+page,"#clockd_list");
}

function clockdlist(page)
{
	var ordersid = $("#clock_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"service/clockd?do=logs&worked=0&ordersid="+ordersid+"&page="+page,"#clockd_list");
}

function clockdlogslist(page)
{
	var ordersid = $("#clock_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"service/clockd?do=logs&worked=1&ordersid="+ordersid+"&page="+page,"#clockd_logslist");
}

//子订记录
function parentlist(page)
{
	var id = $("#parent_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/parents?id="+id+"&page="+page+"&"+ Math.random(),"#parent_list");
}

function closebtn()
{

	if($("#clockd_closed").attr('checked')==undefined){
		$("#degree_nextinfo").show();
	}else{
		$("#degree_nextinfo").hide();
	}
}

function clocked(id)
{
	openDialog("提醒处理操作",S_ROOT+"service/clockd?do=call&id="+id+"&"+ Math.random());
}

function clockedclose(id)
{
	openDialog("关闭订单提醒",S_ROOT+"service/clockd?do=close&id="+id+"&"+ Math.random());
}

function clockedclosed()
{
	var ordersid	= $("#clockd_ordersid").val();
	var detail		= $("#clockd_detail").val();

	if(detail==""){
			msgshow("关闭批注不能为空");
			return;
	}
	$("#btn").attr("value","正在提交..");			//锁定按钮
	$("#btn").attr("disabled","disabled");		//锁定按钮
	//alert(ordersid); return;
	$.ajax({
	    type: "POST",
			async: false,
	    url: S_ROOT+"service/clockd?do=close&id="+ordersid,
	    data: "detail="+detail,
	    success: function(rows){
		    	//alert(rows);return;
		    	closedialog();
		    	if(rows=="1"){
		    		var msg = "操作成功！";
		    	}else{
		    		var msg = rows;
		    	}
		    	msgshow(msg);
	    }
	});
}

$(function() {

	$("#clockd_datetime").die().live("focus",function(){
		$("#clockd_datetime").datepicker({
			dateFormat: "yy-mm-dd"
		});
	});

});

function called()
{

	var workdetail	= $("#clockd_workdetail").val();
	if(workdetail==""){
		msgbox("提醒回访批注不能为空！");
		return;
	}
	var worked		= $("#clockd_worked").val();
	var id			= $("#clockd_id").val();
	var ordersid	= $("#clockd_ordersid").val();
	var cycle		= $("#clockd_cycle").val();
	var stars		= $("#clockd_stars").val();
	var clockinfo	= $("#clockd_clockinfo").val();

	var closeed = 1;
	if(worked==0){
		if($("#clockd_closed").attr('checked')==undefined){
			if(cycle==""){
				msgbox("固定提醒周期必须设定一项！");
				return;
			}
			var closeed = 0;
		}
	}

	$("#calledbtn").attr("value","正在提交..");			//锁定按钮
	$("#calledbtn").attr("disabled","disabled");		//锁定按钮
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"service/clockd?do=call&id="+id+"&ordersid="+ordersid,
	    data: "worked="+worked+"&closeed="+closeed+"&workdetail="+workdetail+"&cycle="+cycle+"&stars="+stars+"&clockinfo="+clockinfo,
	    success: function(rows){
	    	//alert(rows);return;
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "提醒回执，操作成功！";
	    		msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    	clockdlist(1);
	    }
	});
}

function clockdinfo(id)
{
	var ordersid = $("#clock_ordersid").val();
	openDialog("设置提醒记录",S_ROOT+"service/clockd?do=info&id="+id+"&ordersid="+ordersid+"&"+ Math.random());

}

function delclockd(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要删除这条提醒吗？(一旦删除不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定删除',
	    ok: function(){
			$.ajax({
			    type: "GET",
				async: false,
			    url: S_ROOT+"service/clockd?do=del&id="+id,
			    data: "",
			    success: function(rows){
			    	if(rows=="1"){
							msgshow("操作成功");
			    		clockdlist(1);
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

function clockbtn()
{
	var id			= $("#clockd_id").val();
	var ordersid	= $("#clockd_ordersid").val();
	var cycle		= $("#clockd_cycle").val();
	var stars		= $("#clockd_stars").val();
	var clockinfo	= $("#clockd_clockinfo").val();
	var detail		= $("#clockd_detail").val();

	if(cycle==""){
		msgbox("固定提醒周期必须设定一项！");
		return;
	}
	if(clockinfo==""){
		msgbox("提醒内容不能为空！");
		return;
	}

	$("#clockdbtb").attr("value","正在提交..");			//锁定按钮
	$("#clockdbtb").attr("disabled","disabled");		//锁定按钮
	//alert(ordersid); return;
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"service/clockd?do=info&id="+id+"&ordersid="+ordersid,
	    data: "cycle="+cycle+"&stars="+stars+"&clockinfo="+clockinfo+"&detail="+detail,
	    success: function(rows){
	    	//alert(rows);return;
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
					msgshow("操作成功");
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    	clockdlist(1);
	    }
	});
}
