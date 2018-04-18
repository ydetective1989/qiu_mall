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

			var godate = $("#godate").val();
			var todate = $("#todate").val();
			$("#calluserid").load(S_ROOT+"counts/degree?show=2&godate="+godate+"&todate="+todate+"&"+ Math.random());

		}
	});
});

function countsd()
{
	$("#frminfo").contents().find('#showed').empty();
	$("#frminfo").contents().find('#showed').append("<div style=\"text-align:center;color:red;\"><br>正在统计数据......</div>");
	var godate		= $("#godate").val();
	if(!strDate(godate)){ msgbox("开始时间格式错误！如：2011-11-11"); return; }
	var todate		= $("#todate").val();
	if(!strDate(todate)){ msgbox("结束时间格式错误！如：2011-11-11"); return; }
	var calluserid	= $("#calluserid").val();
	$("#frminfo").contents().find('#showed').load(S_ROOT+"counts/degree?show=1&godate="+godate+"&todate="+todate+"&userid="+calluserid);

}

function xlsed()
{
	$("#frminfo").contents().find('#showed').empty();
	$("#frminfo").contents().find('#showed').append("<div style=\"text-align:center;color:red;\"><br>正在统计数据......</div>");
	var godate		= $("#godate").val();
	if(!strDate(godate)){ msgbox("开始时间格式错误！如：2011-11-11"); return; }
	var todate		= $("#todate").val();
	if(!strDate(todate)){ msgbox("结束时间格式错误！如：2011-11-11"); return; }
	var calluserid	= $("#calluserid").val();
	var urlto = "godate="+godate+"&todate="+todate;
	frminfo.location.href = S_ROOT + "xls/degree?show=xls&" + urlto;
}





