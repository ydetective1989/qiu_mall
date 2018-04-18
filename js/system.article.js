function showtype(id)
{
	if(id=="1"){
		$("#islinks").show();
		$("#iscontent").hide();
	}else{
		$("#islinks").hide();
		$("#iscontent").show();
	}
}

function editinfo()
{
	var title = $("#title").val();
	if(title==""){ msgbox("内容标题不能为空！");return; }
	
	var type	= $("input:radio[name=type]:checked").val();
	var urlto	= $("#urlto").val();
	if(type=="1"){
		if(urlto==""){ msgbox("你没有填写链接地址！");return; }	
	}else{
		
	}
	var dateline = $("#dateline").val();
	if(dateline==""){
		msgbox("时间不能为空");return;
	}else{
		if(!strDateTime(dateline)){ msgbox("时间格式错误，正确格式为 2011-11-11 11:11:11"); return; }
	}
	editor.sync("content");
	$("#editinfod").attr("value","正在提交..");			//锁定按钮
	$("#editinfod").attr("disabled","disabled");		//锁定按钮
	$("#editfrm").submit();
}

function search()
{
	var keys = $("#keys").val();
	var cateid = $("#cateid").val();
	var urlto = "keys="+keys+"&cateid="+cateid;
	frminfo.location.href = S_ROOT + "article/lists?show=1&" + urlto;

}