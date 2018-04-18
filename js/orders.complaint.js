
$(function() {
	
	$("#complaint_datetime").die().live("focus",function(){
		$("#complaint_datetime").datepicker({
			dateFormat: "yy-mm-dd"
		});
	});
	
});


//投诉记录
function complaintlist(page)
{
	var id = $("#complaint_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/complaint?id="+id+"&page="+page+"&"+ Math.random(),"#complaint_list");
}

function addcomplaint(id)
{
	//var id = $("#ordersid").val();
	openDialog("增加投诉信息",S_ROOT+"complaint/add?id="+id+"&" + Math.random());
}


function editcomplaint(id)
{
	openDialog("修改投诉信息",S_ROOT+"complaint/edit?id="+id+"&" + Math.random());
}

function delcomplaint(id)
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
			    url: S_ROOT+"complaint/del?id="+id,
			    data: "",             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	msgshow("操作成功");
				    	complaintlist(1);
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


function complainted()
{
	var ordersid	= $("#dialog_ordersid").val();
	var id			= $("#dialog_id").val();
	var classed		= $("#classed").val();
	var type		= $("#type").val();
	var datetime	= $("#complaint_datetime").val();
	var afterid		= $("#afterid").val();
	var afteruserid	= $("#afteruserid").val();
	//alert(afteruserid); return;
	var content		= $("#content").val();
	var notation	= $("#notation").val();
	if(type==""){ msgbox("请选择投诉类型！"); return; }
	if(datetime==""){ 
		msgbox("时间不能为空！"); return;
	}else{
		if(!strDate(datetime)){
			msgbox("错误，日期格式不正确！<br>正确格式：2012-01-01"); 
			return; 
		}
	}
	if(afterid==""){ msgbox("请选择提交服务部门！"); return; }
	if(afteruserid==""){ msgbox("请选择受理服务人员！"); return; }
	if(content==""){ msgbox("客户投诉内容不能为空！"); return; }
	if(content==""){ msgbox("内部受理批注不能为空！"); return; }
	if(id=="0"){
		urlto = S_ROOT+"complaint/add?id="+ordersid;
	}else{
		urlto = S_ROOT+"complaint/edit?id="+id;
	}

	$("#editinfod").attr("value","正在提交..");			//锁定按钮
	$("#editinfod").attr("disabled","disabled");		//锁定按钮	
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: urlto,
	    data: "id="+id+"&ordersid="+ordersid+"&classed="+classed+"&type="+type+"&datetime="+datetime+"&afterid="+afterid+"&afteruserid="+afteruserid+"&content="+content+"&notation="+notation,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    	complaintlist(1);
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










