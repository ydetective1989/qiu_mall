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
/*
			var godate = $("#godate").val();
			var todate = $("#todate").val();
			var salesarea = $("#salesarea").val();
			var salesid = $("#salesid").val();
			$("#saleuserid").load(S_ROOT+"counts/postjob?show=users&salesarea="+salesarea+"&salesid="+salesid+"&"+ Math.random());
*/
		}
	});
});

$("#salesarea,#salesid").die().live("change",function(){ 
	var salesarea = $("#salesarea").val();
	var salesid = $("#salesid").val();
	if(salesarea==""&&salesid==""){
		$("#saleuserid").load(S_ROOT+"counts/postjob?show=users&"+ Math.random());
	}else{
		$("#saleuserid").load(S_ROOT+"counts/postjob?show=users&salesarea="+salesarea+"&salesid="+salesid+"&"+ Math.random());
	}
});



function countsd()
{
	$("#frminfo").contents().find('#showed').empty();
	$("#frminfo").contents().find('#showed').append("<div style=\"text-align:center;color:red;\"><br>正在统计数据......</div>");
	var godate		= $("#godate").val();
	if(!strDate(godate)){ msgbox("开始时间格式错误！如：2011-11-11"); return; }
	var todate		= $("#todate").val();
	if(!strDate(todate)){ msgbox("结束时间格式错误！如：2011-11-11"); return; }
	var salesarea	= $("#salesarea").val();
	var salesid		= $("#salesid").val();
	var saleuserid	= $("#saleuserid").val();
	$("#frminfo").contents().find('#showed').load(S_ROOT+"counts/postjob?show=info&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&saleuserid="+saleuserid);
}


