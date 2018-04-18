
$(function() {

	$("#jobs_datetime").die().live("focus",function(){
		var minDate = $("#jobs_maxdate").val();
		$("#jobs_datetime").datepicker({
			minDate	: minDate,
			dateFormat: "yy-mm-dd"
		});
	});//

	$("#jobs_workdate").die().live("focus",function(){
		$("#jobs_workdate").datepicker({
			dateFormat: "yy-mm-dd"
		});
	});
	$("#revise_datetime").die().live("focus",function(){
		var minDate = $("#revise_minday").val();
		$("#revise_datetime").datepicker({
			minDate	: minDate,
			dateFormat: "yy-mm-dd"
		});
	});

});


function showjobs(id)
{
	$("#showjobs_"+id).show();
}

//工单记录
function jobslist(page)
{
	var id = $("#jobs_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/jobs?id="+id+"&page="+page+"&"+ Math.random(),"#jobs_list");
}

function addtourge(id)
{
	openDialog("增加催单信息",S_ROOT+"jobs/tourge?do=add&id="+id+"&"+ Math.random());

}

function addjobs(id)
{
	openDialog("增加工单信息",S_ROOT+"jobs/add?id="+id+"&"+ Math.random());

}


function editjobs(id)
{
	openDialog("修改工单信息",S_ROOT+"jobs/edit?id="+id+"&"+ Math.random());
}

function revise(id)
{
	openDialog("调整工单信息",S_ROOT+"jobs/revise?id="+id+"&"+ Math.random());
}


function tofuwu(id)
{
	openDialog("提交无忧服务",S_ROOT+"jobs/tofuwu?id="+id+"&"+ Math.random());
}

function tofuwued()
{
	var id 				= $("#jobs_id").val();
	var datetime	= $("#jobs_datetime").val();
	var detail 		= $("#jobs_detail").val();
	$.ajax({
			type: "POST",
			async: false,
			url: S_ROOT+"jobs/tofuwu?id="+id,
			data: "datetime="+datetime+"&detail="+detail,
			success: function(rows){
				if(rows=="1"){
					msgshow("派单成功");
					closedialog();
				}else{
					msgbox(rows);
				}
			}
	});
}

function deljobs(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要删除这条工单吗？(一旦删除不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定删除',
	    ok: function(){
			$.ajax({
			    type: "GET",
				async: false,
			    url: S_ROOT+"jobs/del?id="+id,
			    data: "",
			    success: function(rows){
			    	if(rows=="1"){
				    	msgshow("操作成功");
				    	jobslist(1);
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

function checkjobs(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你要确认这条工单吗？</font>',
		lock: true,
		fixed: true,
	    okValue: '确定',
	    ok: function(){
			$.ajax({
			    type: "GET",
					async: false,
			    url: S_ROOT+"jobs/checked?id="+id,
			    data: "",
			    success: function(rows){
			    	if(rows=="1"){
				    	msgshow("操作成功");
				    	jobslist(1);
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

function workjobs(id)
{
	openDialog("回执工单信息",S_ROOT+"jobs/workjobs?id="+id+"&"+ Math.random());
}

function reviseed()
{
	var jobsid		= $("#jobs_id").val();
	var afterid		= $("#jobs_afterid").val();
	var afteruserid	= $("#revise_afteruserid").val();
	var datetime	= $("#revise_datetime").val();
	var detail		= $("#revise_detail").val();
	if(datetime==""){
		msgbox("时间不能为空！"); return;
	}else{
		if(!strDate(datetime)){
			msgbox("错误，日期格式不正确！<br>正确格式：2012-01-01");
			return;
		}
	}
	if(afteruserid==""){ msgbox("请选择服务人员！"); return; }
	if(detail==""){ msgbox("工单内容不能为空！"); return; }

	//最大工单量判断
	var maxplan = 0;
	$.ajax({
	    type: "GET",
		async: false,
	    url: S_ROOT+"jobs/checkedplan?id="+jobsid+"&datetime="+datetime+"&afterid="+afterid+"&"+ Math.random(),
	    data: "",
	    success: function(rows){
	    	maxplan = rows;
	    }
	});
	//alert(maxplan); return;
	if(maxplan=="1"){
		msgbox("抱歉，无法增加工单！服务站该日期已超过最大工单量！");
		return;
	}

	$("#revisebtn").attr("value","正在提交..");			//锁定按钮
	$("#revisebtn").attr("disabled","disabled");		//锁定按钮

	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"jobs/revise",
	    data: "id="+jobsid+"&datetime="+datetime+"&afteruserid="+afteruserid+"&detail="+detail,
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    	jobslist(1);
	    }
	});

}

function jobsed()
{
	var ordersid	= $("#jobs_ordersid").val();
	var jobsid		= $("#jobs_id").val();
	var type			= $("#jobs_type").val();
	var afterid		= $("#jobs_afterid").val();
	var datetime	= $("#jobs_datetime").val();
	var detail		= $("#jobs_detail").val();
	if(type==""){ msgbox("请选择工单类别！"); return; }
	if(datetime==""){
		msgbox("时间不能为空！"); return;
	}else{
		if(!strDate(datetime)){
			msgbox("错误，日期格式不正确！<br>正确格式：2012-01-01");
			return;
		}
	}
	if(afterid==""){ msgbox("请选择服务中心！"); return; }
	if(detail==""){ msgbox("工单内容不能为空！"); return; }

	if(jobsid!=""){
		urlto = S_ROOT+"jobs/edit";
	}else{
		urlto = S_ROOT+"jobs/add";
	}

	$("#jobsbtn").attr("value","正在提交..");			//锁定按钮
	$("#jobsbtn").attr("disabled","disabled");		//锁定按钮
	$.ajax({
	    type: "POST",
		async: false,
	    url: urlto,
	    data: "id="+jobsid+"&ordersid="+ordersid+"&type="+type+"&datetime="+datetime+"&afterid="+afterid+"&detail="+detail,
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    	jobslist(1);
	    }
	});
}

$(function() {
	$("#jobs_afterarea").die().live("change",function(){
		var afterarea	= $("#jobs_afterarea").val();
		var userid		= $("#jobs_afterusered").val();
		//alert(afterarea+"&"+teamid);
		if(afterarea){
			$("#jobs_afterid").load(S_ROOT+"json/team?type=3&numberd=1&parentid="+afterarea+"&"+ Math.random());
		}else{
			//alert(afterarea);
			$("#jobs_afterid").load(S_ROOT+"json/team?type=3&no=1&"+ Math.random());
		}
		$("#jobs_afteruserid").load(S_ROOT+"teams/users?type=3&no=1&"+ Math.random());
	});
	$("#jobs_afterid").die().live("change",function(){
		var parentid	= $("#jobs_afterarea").val();
		var teamid		= $("#jobs_afterid").val();
		var userid		= $("#jobs_afterusered").val();
		//alert(parentid+"&"+teamid);
		if(parentid&&teamid){
			$("#jobs_afteruserid").load(S_ROOT+"teams/users?type=3&parentid="+parentid+"&teamid="+teamid+"&"+ Math.random());
		}else{
			$("#jobs_afteruserid").load(S_ROOT+"teams/users?type=3&no=1&"+ Math.random());
		}
	});
});

function worked()
{
	var jobsid		= $("#jobs_id").val();
	var worktype	= $(":radio[name='jobs_worktype']:checked").val();
	if(worktype==""){ msgbox("请选择回执类型！"); return; }
	//var datetime	= $("#jobs_workdate").val();
	//if(datetime==""){ msgbox("请选择完成时间！"); return; }
	var detail		= $("#jobs_detail").val();
	if(detail==""){ msgbox("请填写回执批注！"); return; }

	$("#workbtn").attr("value","正在提交..");			//锁定按钮
	$("#workbtn").attr("disabled","disabled");		//锁定按钮
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"jobs/workjobs",
	    data: "id="+jobsid+"&type="+worktype+"&detail="+detail,
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    	jobslist(1);
	    }
	});

}

function addtourched()
{
	var jobsid		= $("#dialog_jobsid").val();
	var detail		= $("#dialog_detail").val();
	if(detail==""){ msgbox("催单说明不能为空");return; }

	$("#workbtn").attr("value","正在提交..");			//锁定按钮
	$("#workbtn").attr("disabled","disabled");		//锁定按钮
	$.ajax({
		type: "POST",
		async: false,
		url: S_ROOT+"jobs/tourge?do=add&id="+jobsid,
		data: "detail="+detail,
		success: function(rows){
			closedialog();
			if(rows=="1"){
				var msg = "操作成功！";
				msgshow(msg);
			}else{
				var msg = rows;
				msgbox(msg);
			}
			tourgelist(1);
		}
	});
}

function tourgedel(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要删除这条催单吗？(一旦删除不可恢复)</font>',
		lock: true,
		fixed: true,
		okValue: '确定删除',
		ok: function(){
			$.ajax({
				type: "GET",
				async: false,
				url: S_ROOT+"jobs/tourge?do=del&id="+id,
				data: "",
				success: function(rows){
					if(rows=="1"){
						msgshow("操作成功");
						tourgelist(1);
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

function tourgelist(page){

	var id = $("#tourge_jobsid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"jobs/tourge?id="+id+"&page="+page+"&"+ Math.random(),"#tourge_list");
}


function tofuwuTabs(showId,nums)
{
	for(i=1;i<=nums;i++)
	{
		document.getElementById("jobsafter"+i).style.display = "none";
		if(i==showId)
		{
			document.getElementById("jobsafter"+i).style.display = "";
		}
	}
}
