$(function() {
	

	$("#jobs_workdate").die().live("focus",function(){
		$("#jobs_workdate").datepicker({
			dateFormat: "yy-mm-dd"
		});
	});
	
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
	
	$("#afterid").change(function(){
		var afterid	= $("#afterid").val();
		//alert(afterid);
		if(afterid){
			$("#afteruserid").load(S_ROOT+"teams/users?type=3&teamid="+afterid+"&"+ Math.random());
		}else{
			$("#afteruserid").load(S_ROOT+"teams/users?type=3&no=1&"+ Math.random());
		}
	});
});

function search()
{
	var ordersid = $("#ordersid").val();
	var jobsid	 = $("#jobsid").val();
	var afterarea= $("#afterarea").val();
	var afterid	 = $("#afterid").val();
	var afteruserid	 = $("#afteruserid").val();
	var type	 = $("#type").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var urlto = "ordersid="+ordersid+"&jobsid="+jobsid+"&afterarea="+afterarea+"&afterid="+afterid+"&afteruserid="+afteruserid+"&type="+type+"&godate="+godate+"&todate="+todate;
	frmlist.location.href = S_ROOT + "jobs/calladm?show=lists&" + urlto;
}

function calladm(id)
{
	openDialog("回单确认信息",S_ROOT+"jobs/workjobs?id="+id+"&"+ Math.random());
}

function chargetype(worked)
{
	if(worked=="1"){
		var price		= $("#jobs_chargeprice").val();
		$("#jobs_charge").attr("value",price);
	}else{
		$("#jobs_charge").attr("value",'0');
	}
}


$(function() {
	
	$("#jobs_ptype").die().live("change",function(){ 
		var ptypeid	= $("#jobs_ptype").val();
		$("#jobs_payid").load(S_ROOT+"charge/gettype?id="+ptypeid+"&"+ Math.random());
	});
	
});

function worked()
{
	var jobsid		= $("#jobs_id").val();
	var worktype	= $(":radio[name='jobs_worktype']:checked").val();
	if(worktype==""){ msgbox("请选择回执类型！"); return; }
	var datetime	= $("#jobs_workdate").val();
	if(datetime==""){ msgbox("请选择完成时间！"); return; }
	var detail		= $("#jobs_detail").val();
	if(detail==""){ msgbox("请填写回执批注！"); return; }
	var cates	= $("#jobs_cates").val();
	var payid	= $("#jobs_payid").val();
	var source	= $("#jobs_source").val();
	
	var jobstype	= $("#jobs_type").val();
	if(jobstype!="8"){
		
		var price = $("#jobs_price").val();
		if(price!=""){ 
			
			if(!isMoneyNums(price)){ 
				msgbox("错误，回款格式不正确！<br>入款格式应为正数，如：10、100或100.00"); 
				return; 
			}
				
		}
		
		if(price!=""&&price!="0"){

			if(cates==""){
				msgbox("请选择费用类型！"); return;
			}
			
			if(payid==""){
				msgbox("请选择收支帐号！"); return;
			}
		}
		
		var charge	= $("#jobs_charge").val();
		var chargeinfo 	= $("#jobs_chargeinfo").val();
		if(charge!=""){
			if(!isMoney(charge)){ msgbox("错误，结算费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
			if(chargeinfo==""){ msgbox("结算费用批注不能为空！"); return; }
		}
		
	}

	$("#workbtn").attr("value","正在提交..");			//锁定按钮
	$("#workbtn").attr("disabled","disabled");		//锁定按钮	
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"jobs/workjobs?source=calladm",
	    data: "id="+jobsid+"&type="+worktype+"&datetime="+datetime+"&cates="+cates+"&payid="+payid+"&price="+price+"&detail="+detail+"&charge="+charge+"&chargeinfo="+chargeinfo,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
		    	location.reload();
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    }
	});
	
}







