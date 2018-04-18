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
});

function countsd()
{
	$("#frminfo").contents().find('#showed').empty();
	$("#frminfo").contents().find('#showed').append("<div style=\"text-align:center;color:red;\"><br>正在统计数据......</div>");
	var godate		= $("#godate").val();
	if(godate==""){
		msgbox("请选择开始日期");return;
	}else{
		if(!strDate(godate)){ msgbox("开始时间格式错误！如：2011-11-11"); return; }
	}
	var todate		= $("#todate").val();
	if(todate==""){
		msgbox("请选择结束日期");return;
	}else{
		if(!strDate(todate)){ msgbox("结束时间格式错误！如：2011-11-11"); return; }
	}
	var sellercode	= $("#sellercode").val();
	//var countsid	= $("#countsid").val();
	$("#frminfo").contents().find('#showed').load(S_ROOT+"counts/seller?show=info&godate="+godate+"&todate="+todate+"&sellercode="+sellercode);
}