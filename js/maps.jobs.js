
$(function() {

	$("#datetime").datepicker({
		dateFormat: "yy-mm-dd"
	});

});

function search()
{
	var datetime	 = $("#datetime").val();
	var afterid		 = $("#afterid").val();
	if(datetime==""){ 
		msgbox("时间不能为空！"); return;
	}else{
		if(!strDate(datetime)){
			msgbox("错误，日期格式不正确！<br>正确格式：2012-01-01"); 
			return; 
		}
	}	
	if(afterid==""){
		msgbox("请选择一个服务中心"); 
		return;
	}
	var urlto = "datetime="+datetime+"&afterid="+afterid;
	frmlist.location.href = S_ROOT + "maps/jobs?show=maps&" + urlto;

}