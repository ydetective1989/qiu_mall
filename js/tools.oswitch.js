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

$(function(){ 
	
	var afteruserid = $("#afterusered").val();
	
	$("#afterarea").change(
		function(){
			var afterarea = $("#afterarea").val();
			if(!afterarea){
				$("#afteruserid").load(S_ROOT+"teams/users?no=1&type=2&"+ Math.random());
			}
		}
	);
	
	$("#afterid").change(
		function(){
			var afterarea = $("#afterarea").val();
			var afterid = $("#afterid").val();
			if(afterid){
				$("#afteruserid").load(S_ROOT+"teams/users?type=2&parentid="+afterarea+"&teamid="+afterid+"&"+ Math.random());
			}else{
				$("#afteruserid").load(S_ROOT+"teams/users?no=1&type=2&parentid="+afterarea+"&"+ Math.random());
			}
		}
	);
	
});

function editinfo()
{
	var provid		= $("#provid").val();
	var cityid		= $("#cityid").val();
	var areaid		= $("#areaid").val();
	var source		= $("#source").val();
	var godate		= $("#godate").val();
	var todate 		= $("#todate").val();
	var olduserid	= $("#olduserid").val();
	var afterarea 	= $("#afterarea").val();
	var afterid		= $("#afterid").val();
	var afteruserid = $("#afteruserid").val();
	if(provid==""&&source==""&&godate==""&&todate==""&&olduserid==""){
		msgbox("请选择一个转移源条件！"); return;
	}
	if(afterarea==""||afterid==""||afterid=="0"){
		msgbox("请选择要转移的服务中心！"); return;
	}
	if(afteruserid==""||afteruserid=="0"){
		msgbox("请选择要转移的服务人员！"); return;
	}
	//$("#editbtn").attr("value","正在转移....");			//锁定按钮
	//$("#editbtn").attr("disabled","disabled");			//锁定按钮

	$("#msgswitch").append("<font style=\"color:red;\">正在转换......</font>");
	
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"tools/oswitch",
	    data: "provid="+provid+"&cityid="+cityid+"&areaid="+areaid+"&source="+source+"&godate="+godate+"&todate="+todate+"&olduserid="+olduserid+"&afterarea="+afterarea+"&afterid="+afterid+"&afteruserid="+afteruserid,             
	    success: function(rows){
	    	if(rows=="1"){
	    		//msgbox("转移完毕！");
	    		$("#msgswitch").empty();
	    		$('#msgswitch').append("<font style=\"color:green;\">转换完毕..."+Math.random()+"</font>");
	    	}else{
	    		msgbox(rows);
	    		$("#msgswitch").empty();
	    		$('#msgswitch').append(rows);
	    	}
	    	//$("#editbtn").attr("value","转移订单");			//锁定按钮
	    	//$("#editbtn").attr("disabled","");			//锁定按钮
	    }
	});

}







