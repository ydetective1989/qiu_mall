function viewfiles(id)
{
	window.open(S_ROOT+"orders/upload?do=views&id="+id);
}

function ordersupload(ordersid)
{
	openDialog("上传订单附件",S_ROOT+"orders/upload?ordersid="+ordersid+"&"+ Math.random());

}

function editfiles(filesid)
{
	openDialog("编辑附件批注",S_ROOT+"orders/upload?do=detail&id="+filesid+"&"+ Math.random());
}




function orders_upfiled()
{
	var type = $("#type").val();
	var files_upload = $("#files_upload").val();
	if(type==""){ msgshow("文件类型不能为空!");return; }
	if(files_upload==""){ msgshow("请选择上传文件!");return; }

	$("#btned").attr("value","正在上传..");			//锁定按钮
	$("#btned").attr("disabled","disabled");		//锁定按钮
	$("#upfileto").submit();
}




function filesinfo()
{
	var id = $("#files_id").val();
	var type = $("#files_type").val();
	var detail = $("#files_detail").val();
	if(detail==""){ msgbox("请填写批注信息！");return; }
	$.ajax({
	    type: "POST",
		async: false,
	    url: S_ROOT+"orders/upload?do=detail&id="+id,
	    data: "type="+type+"&detail="+detail,
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
		    	fileslist(1);
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    }
	});
}

function delfiles(filesid)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要删除这个附件吗？(一旦删除不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定删除',
	    ok: function(){
			$.ajax({
			    type: "GET",
				async: false,
			    url: S_ROOT+"orders/upload?do=del&id="+filesid,
			    data: "",
			    success: function(rows){
			    	if(rows=="1"){
				    	msgshow("操作成功");
				    	fileslist(1);
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

//附件记录
function fileslist(page)
{
	//alert(2);
	var id = $("#files_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/files?id="+id+"&page="+page+"&"+ Math.random(),"#files_list");
}
