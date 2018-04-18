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

function search()
{
	$("#frminfo").contents().find('#showed').empty();
	$("#frminfo").contents().find('#showed').append("<div style=\"text-align:center;color:red;\"><br>正在搜索日志......</div>");
	var godate		= $("#godate").val();
	if(!strDate(godate)){ msgbox("开始时间格式错误！如：2011-11-11"); return; }
	var todate		= $("#todate").val();
	if(!strDate(todate)){ msgbox("结束时间格式错误！如：2011-11-11"); return; }
	var keyword		= $("#keyword").val();
	var cateid		= $("#cateid").val();
	var name		= $("#name").val();
	var urlto = S_ROOT+"tools/logs?show=1&godate="+godate+"&todate="+todate+"&name="+name+"&cateid="+cateid+"&keyword="+keyword;
	frminfo.location.href = urlto;
}

function xls()
{
	$("#frminfo").contents().find('#showed').empty();
	$("#frminfo").contents().find('#showed').append("<div style=\"text-align:center;color:red;\"><br>正在搜索日志......</div>");
	var godate		= $("#godate").val();
	if(!strDate(godate)){ msgbox("开始时间格式错误！如：2011-11-11"); return; }
	var todate		= $("#todate").val();
	if(!strDate(todate)){ msgbox("结束时间格式错误！如：2011-11-11"); return; }
	var keyword		= $("#keyword").val();
	var cateid		= $("#cateid").val();
	var name		= $("#name").val();
	var urlto = S_ROOT+"tools/logs?show=3&godate="+godate+"&todate="+todate+"&name="+name+"&cateid="+cateid+"&keyword="+keyword;
	frminfo.location.href = urlto;
}

function views(id)
{
	openDialog("查看操作日志",S_ROOT+"tools/logs?show=2&id="+id+"&"+ Math.random());
}