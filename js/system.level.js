function editlists()
{
	$("#editbtn").attr("value","正在提交...");			//锁定按钮
	$("#editbtn").attr("disabled","disabled");			//锁定按钮
	$("#editlist").submit();
}

function editinfo()
{
	var name = $("#name").val();
	if(name==""){ msgshow("权限名称不能为空，请检查"); return; }
	var parentid = $("#parentid option:selected").val();
	var naved = $('input:radio[name="naved"]:checked').val();
	if(parentid!='0'&&naved=='1'){
		var urlto = $("#urlto").val();
		if(urlto==""){ msgshow("菜单链接地址不能为空"); return; }
	}
	$("#editbtn").attr("value","正在提交...");		//锁定按钮
	$("#editbtn").attr("disabled","disabled");		//锁定按钮
	$("#editfrm").submit();
}

$(function() {

	$("#list .deleted").click(function() {
		$(this).parents("#repeat").remove();   
	});

	$("#add").click(function() {
		var parentid = $("#parentid").val();
		var alllevel = $('#alllevel').attr("value");
		alllevel = alllevel-0;
		ilevel = alllevel+1;
		//alert(ilevel);
		addopts = "<tr class=\"datas\" id=\"repeat\">";
		addopts += '<td height=\"30\">'+ilevel+'<input type=\"hidden\" name=\"new_ids[]\" value=\"'+ilevel+'\"><\/td>';
		addopts += "<td><input type=\"text\" name=\"new_name["+ilevel+"]\" style=\"width:150px;\" class=\"tdcenter\"><\/td>";
		if(parentid > 0){
			addopts += "<td><input type=\"text\" name=\"new_reqmod["+ilevel+"]\" value=\"\" style=\"width:90px;\" class=\"tdcenter\"><\/td>";
			addopts += "<td><input type=\"text\" name=\"new_reqac["+ilevel+"]\" value=\"\" style=\"width:90px;\" class=\"tdcenter\"><\/td>";
			addopts += "<td><input type=\"text\" name=\"new_reqdo["+ilevel+"]\" value=\"\" style=\"width:90px;\" class=\"tdcenter\"></td>";
			addopts += "<td><input type=\"text\" name=\"new_urlto["+ilevel+"]\" value=\"\" style=\"width:100%;\" class=\"\"><\/td>";
			addopts += "<td><\/td>";
			addopts += "<td><\/td>";
		}else{
			addopts += "<td colspan=\"4\" class=\"tdcenter\">无<\/td>";
			addopts += "<td colspan=\"2\" class=\"tdcenter\"><\/td>";
		}
		addopts += "<td><input type=\"text\" name=\"new_orderd["+ilevel+"]\" maxlength=\"3\" value=\"0\" style=\"width:80px;\" class=\"tdcenter\"><\/td>";
		addopts += "<td class=\"tdcenter\"><span class=\"pointer deleted\">[删除]</span><\/td>";
		addopts += "<\/tr>";
		$('#list tbody').append(addopts);
		$("#list .deleted").click(function() {
			$(this).parents("#repeat").remove();
		});
		newlevel = alllevel+1;
		$("#alllevel").attr("value",newlevel);//填充内容
	});

});