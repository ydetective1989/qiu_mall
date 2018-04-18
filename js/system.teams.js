function editlists()
{
	$("#editbtn").attr("value","正在提交...");			//锁定按钮
	$("#editbtn").attr("disabled","disabled");			//锁定按钮
	$("#editlist").submit();
}

function editinfo()
{
	var name = $("#name").val();
	if(name==""){ msgshow("机构名称不能为空，请检查"); return; }
	$("#editbtn").attr("value","正在提交...");		//锁定按钮
	$("#editbtn").attr("disabled","disabled");		//锁定按钮
	$("#editfrm").submit();
}