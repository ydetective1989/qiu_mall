function chargetabs(showId,num,bgItemName,clsName)
{
	var clsNameArr=new Array(2)
	if(clsName.indexOf("|")<=0){
		clsNameArr[0]=clsName
		clsNameArr[1]=""
	}else{
		clsNameArr[0]=clsName.split("|")[0]
		clsNameArr[1]=clsName.split("|")[1]
	}
	
	for(i=1;i<=num;i++)
	{
		if(document.getElementById(bgItemName+i)!=null)
			document.getElementById(bgItemName+i).className=clsNameArr[1]
		if(i==showId)
		{
			if(document.getElementById(bgItemName+i)!=null)
				document.getElementById(bgItemName+i).className=clsNameArr[0]
		}
	}
}

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
			$("#userid").load(S_ROOT+"charge/orders?show=users&godate="+godate+"&todate="+todate+"&"+ Math.random());

			var salesarea = $("#salesarea").val();
			var salesid = $("#salesid").val();
			if(salesid){
				$("#saleuserid").load(S_ROOT+"orders/users?type=1&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&"+ Math.random());
			}else{
				$("#saleuserid").load(S_ROOT+"orders/users?type=1&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&"+ Math.random());
			}
			
		}
	});
});

$(function() {	
	$("#salesarea").change(
		function(){
			var godate = $("#godate").val();
			var todate = $("#todate").val();
			var salesarea = $("#salesarea").val();
			if(salesarea){
				$("#saleuserid").load(S_ROOT+"orders/users?type=1&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&"+ Math.random());
			}else{
				$("#saleuserid").load(S_ROOT+"orders/users?type=1&godate="+godate+"&todate="+todate+"&"+ Math.random());
			}
		}
	);
	
	$("#salesid").change(
		function(){
			var godate = $("#godate").val();
			var todate = $("#todate").val();
			var salesarea = $("#salesarea").val();
			var salesid = $("#salesid").val();
			if(salesid){
				$("#saleuserid").load(S_ROOT+"orders/users?type=1&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&"+ Math.random());
			}else{
				$("#saleuserid").load(S_ROOT+"orders/users?type=1&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&"+ Math.random());
			}
		}
	);
});


function charge_allchecked()
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">需要批量确认选中的入款记录吗？</font>',
		lock: true,
		fixed: true,
	    okValue: '确定记录',
	    ok: function(){

	    	var chk_arr =[];  
	    	$('input[name="selected"]:checked').each(function(){  
	    		chk_arr.push($(this).val());  
	    	});
	    	if(chk_arr.length==0){ msgshow('请选择要确认的记录');return; }
	    	
			$.ajax({  
			    type: "POST",  
				async: false,
			    url: S_ROOT+"charge/checked",
			    data: "id="+chk_arr,             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	location.reload();
			    	}else{
			    		msgbox(rows);
			    	}
			    }
			});
	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});
}

function charge_checked(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">需要确认这条入款记录吗？</font>',
		lock: true,
		fixed: true,
	    okValue: '确定记录',
	    ok: function(){
			$.ajax({  
			    type: "POST",  
				async: false,
			    url: S_ROOT+"charge/checked",
			    data: "id="+id,             
			    success: function(rows){ 
			    	if(rows=="1"){ 
			    		location.reload();
			    	}else{
			    		msgbox(rows);
			    	}
			    }
			});
	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});


}

$(function(){
	$("#ptype").change(function(){
		var ptypeid	= $("#ptype").val();
		$("#payid").load(S_ROOT+"charge/gettype?id="+ptypeid+"&"+ Math.random());
	});
});

$(document).keydown(function(){
	if(event.keyCode == 13){  search(); }
});

function search(type)
{
	var checked  = $("#checked").val();
	var type 	 = $("#type").val();
	var ordersid = $("#ordersid").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var salesarea= $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var ptype	 = $("#ptype").val();
	var payid	 = $("#payid").val();
	var userid	 = $("#userid").val();
	var saleuserid=$("#saleuserid").val();
	var urlto = "checked="+checked+"&type="+type+"&ordersid="+ordersid+"&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&ptype="+ptype+"&payid="+payid+"&userid="+userid+"&saleuserid="+saleuserid;
	frmlist.location.href = S_ROOT + "charge/orders?show=lists&" + urlto;
}

function xls()
{
	var checked  = $("#checked").val();
	var type 	 = $("#type").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var salesarea= $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var ptype	 = $("#ptype").val();
	var payid	 = $("#payid").val();
	var userid	 = $("#userid").val();
	var saleuserid=$("#saleuserid").val();
	var urlto = "checked="+checked+"&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&type="+type+"&ptype="+ptype+"&payid="+payid+"&userid="+userid+"&saleuserid="+saleuserid;
	frmlist.location.href = S_ROOT + "xls/charge?show=xls&" + urlto;
}

function orders()
{
	var checked  = $("#checked").val();
	var type 	 = $("#type").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var salesarea= $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var ptype	 = $("#ptype").val();
	var payid	 = $("#payid").val();
	var userid	 = $("#userid").val();
	var saleuserid=$("#saleuserid").val();
	var urlto = "checked="+checked+"&godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&type="+type+"&ptype="+ptype+"&payid="+payid+"&userid="+userid+"&saleuserid="+saleuserid;
	frmlist.location.href = S_ROOT + "xls/ocharge?show=xls&" + urlto;
}

