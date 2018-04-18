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
	var ordersid = $("#ordersid").val();
	var type	 = $("#type").val();
	var classed	 = $("#classed").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var salesarea= $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var afterarea= $("#afterarea").val();
	var afterid	 = $("#afterid").val();
	var afteruserid = $("#afteruserid").val();
	var urlto = "status="+status+"&ordersid="+ordersid+"&type="+type+"&classed="+classed+"&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&&afterarea="+afterarea+"&afterid="+afterid+"&afteruserid="+afteruserid;
	frmlist.location.href = S_ROOT + "complaint/lists?" + urlto;
}

function xls(status)
{
	if(status=="undefined"||status==""){
		var status = $("#status").val();
	}else{
		$("#status").attr("value",status);
	}
	//alert(status);
	var ordersid = $("#ordersid").val();
	var type	 = $("#type").val();
	var classed	 = $("#classed").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var salesarea= $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var afterarea= $("#afterarea").val();
	var afterid	 = $("#afterid").val();
	var urlto = "xls=1&status="+status+"&ordersid="+ordersid+"&type="+type+"&classed="+classed+"&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&&afterarea="+afterarea+"&afterid="+afterid;
	frmlist.location.href = S_ROOT + "complaint/lists?" + urlto;
}

function complaint_logslist(page)
{
	var id = $("#complaint_id").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"complaint/logs?id="+id+"&page="+page+"&"+ Math.random(),"#complaintlogs_list");
}

function complaint_addlogs(cid)
{
	openDialog("处理批注信息",S_ROOT+"complaint/logsinfo?do=add&cid="+cid+"&"+ Math.random());
}

function complaint_dellogs(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要删除这条投诉吗？(一旦删除不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定删除',
	    ok: function(){
			$.ajax({
			    type: "GET",
				async: false,
			    url: S_ROOT+"complaint/logsinfo?do=del&id="+id+"&"+ Math.random(),
			    data: "",
			    success: function(rows){
			    	if(rows=="1"){
			    		complaint_logslist(1);
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

function complaint_logsinfo()
{
	var cid		= $("#dialog_cid").val();
	var ordersid= $("#dialog_ordersid").val();
	var content = $("#content").val();
	if(content==""){ msgbox("处理批注不能为空！");return; }
	var urlto = S_ROOT+"complaint/logsinfo?do=add&cid="+cid+"&ordersid="+ordersid;
	$("#editinfod").attr("value","正在提交..");			//锁定按钮
	$("#editinfod").attr("disabled","disabled");		//锁定按钮
	$.ajax({
	    type: "POST",
		async: false,
	    url: urlto,
	    data: "content="+content,
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    	complaint_logslist(1);
	    }
	});

}


function complaint_worked(id)
{
	openDialog("处理投诉信息",S_ROOT+"complaint/worked?id="+id+"&"+ Math.random());
}

function complaint_called(id)
{

	openDialog("回访投诉信息",S_ROOT+"complaint/called?id="+id+"&"+ Math.random());

}

function complaint_workeb()
{

	var id		= $("#complaint_id").val();
	var worked	= $(":radio[name='worked']:checked").val();
	var workinfo		= $("#workinfo").val();
	if(workinfo==""){ msgbox("请填写处理批注！"); return; }
	//alert(worked);
	$("#editinfod").attr("value","正在提交..");			//锁定按钮
	$("#editinfod").attr("disabled","disabled");		//锁定按钮
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"complaint/worked?id="+id,
	    data: "worked="+worked+"&workinfo="+workinfo,
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
	    	}else{
	    		var msg = rows;
	    	}
	    	msgbox(msg);
	    }
	});

}

function complaint_calleb()
{
	var id		= $("#complaint_id").val();
	var called	= $(":radio[name='called']:checked").val();
	var callinfo		= $("#callinfo").val();
	if(callinfo==""){ msgbox("请填写回访批注！"); return; }

	$("#editinfod").attr("value","正在提交..");			//锁定按钮
	$("#editinfod").attr("disabled","disabled");		//锁定按钮
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"complaint/called?id="+id,
	    data: "called="+called+"&callinfo="+callinfo,
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

function complaint_msgalert(cid)
{
	var id	= $("#complaint_id").val();
	openDialog("发起投诉协助",S_ROOT+"complaint/msgalert?id="+id+"&"+ Math.random());
}

function complaint_userpages(page)
{
	if(page==""){ var page = 1; }
	var type = $("#dialog_type").val();
	var key = $("#dialog_keyword").val();
	ajaxurl(S_ROOT+"complaint/msgalert?show=lists&type="+type+"&key="+key+"&page="+page+"&"+ Math.random(),"#alertlists");
}

function complaint_sendusers(userid)
{
	var id			= $("#complaint_id").val();
	var ordersid	= $("#ordersid").val();
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"complaint/msgalert?show=send&id="+id+"&ordersid="+ordersid+"&userid="+userid,
	    data: "",
	    success: function(rows){
	    	if(rows=="1"){
	    		var msg = "操作成功！";
	    		msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgshow(msg);
	    	}
	    }
	});
}

$(function() {

	$("#afterarea").die().live("change",function(){
		var afterarea	= $("#afterarea").val();
		if(afterarea){
			$("#afterid").load(S_ROOT+"json/team?type=3&numberd=1&parentid="+afterarea+"&"+ Math.random());
		}else{
			$("#afterid").load(S_ROOT+"json/team?type=3&no=1&"+ Math.random());
		}
		$("#afteruserid").load(S_ROOT+"teams/users?type=3&no=1&"+ Math.random());
	});

	$("#afterid").die().live("change",function(){
		var afterarea	= $("#afterarea").val();
		var afterid	= $("#afterid").val();
		//alert(afterid);
		if(afterarea&&afterid){
			$("#afteruserid").load(S_ROOT+"teams/users?type=3&parentid="+afterarea+"&teamid="+afterid+"&"+ Math.random());
		}else{
			$("#afteruserid").load(S_ROOT+"teams/users?type=3&no=1&"+ Math.random());
		}
	});

});

function complaint_moveed(id)
{

	openDialog("转交投诉",S_ROOT+"complaint/moveed?id="+id+"&"+ Math.random());

}

function complaint_movedo()
{
	var id			= $("#complaint_id").val();
	var ordersid	= $("#complaint_ordersid").val();
	var afterid		= $("#afterid").val();
	var afteruserid	= $("#afteruserid").val();
	var detail		= $("#detail").val();
	if(afterid=="")		{ msgbox("请选择要移交的服务部门！");	return; }
	if(afteruserid=="")	{ msgbox("请选择要移交的服务人员！");	return; }
	if(detail=="")		{ msgbox("移交批注内容不能为空！");	return; }

	$("#editinfod").attr("value","正在提交..");			//锁定按钮
	$("#editinfod").attr("disabled","disabled");		//锁定按钮

	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"complaint/moveed?id="+id+"&"+ Math.random(),
	    data: "ordersid="+ordersid+"&afterid="+afterid+"&afteruserid="+afteruserid+"&detail="+detail,
	    success: function(rows){
	    	if(rows=="1"){
		    	closedialog();
		    	complaint_logslist(1);
	    		var msg = "操作成功！";
	    		msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgshow(msg);
	    	}
	    }
	});

}


function complaint_classed()
{
	var id	= $("#complaint_id").val();
	openDialog("调整投诉级别",S_ROOT+"complaint/classed?id="+id+"&"+ Math.random());
}


function complaint_classdo()
{
	var id			= $("#complaint_id").val();
	var ordersid	= $("#ordersid").val();
	var classed		= $(":radio[name='classed']:checked").val();
	var detail		= $("#detail").val();
	if(detail==""){ msgbox("调整批注不能为空！");return; }
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"complaint/classed?id="+id+"&ordersid="+ordersid,
	    data: "classed="+classed+"&detail="+detail,
	    success: function(rows){
	    	if(rows=="1"){
		    	closedialog();
		    	complaint_logslist(1);
	    		var msg = "操作成功！";
	    		msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgshow(msg);
	    	}
	    }
	});
}
