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
			var salesarea = $("#salesarea").val();
			var salesid = $("#salesid").val();
			$("#saleuserid").load(S_ROOT+"counts/orders?show=2&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&"+ Math.random());
		}
	});
});

$(function(){ 
		
	$("#salesarea").change(
		function(){
			var godate = $("#godate").val();
			var todate = $("#todate").val();
			var salesarea = $("#salesarea").val();
			$("#saleuserid").load(S_ROOT+"counts/orders?show=2&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&"+ Math.random());
		}
	);
	
	$("#salesid").change(
		function(){
			var godate = $("#godate").val();
			var todate = $("#todate").val();
			var salesarea = $("#salesarea").val();
			var salesid = $("#salesid").val();
			$("#saleuserid").load(S_ROOT+"counts/orders?show=2&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&"+ Math.random());
		}
	);
	
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
	$("#frminfo").contents().find('#showed').load(S_ROOT+"counts/orders?show=1&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&saleuserid="+saleuserid);
}


function xlsed()
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
	var urlto = "godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&saleuserid="+saleuserid;
	location.href = S_ROOT + "xls/orders?show=xls&" + urlto;

	//$("#frminfo").contents().find('#showed').load(S_ROOT + "xls/orders?show=xls&" + urlto);

}






