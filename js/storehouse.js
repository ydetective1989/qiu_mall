function editinvoice()
{
	var name = $("#name").val();
	if(name==""){ msgshow("库房名称不能为空"); return; }
	var encoded = $("#encoded").val();
	if(encoded==""){ msgshow("库房编码不能为空"); return; }
	$("#editbtn").attr("value","正在提交...");		//锁定按钮
	$("#editbtn").attr("disabled","disabled");		//锁定按钮
	$("#editfrm").submit();
}
