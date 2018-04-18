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

	$("#datetime").datepicker({
		dateFormat: "yy-mm-dd"
	});
	
});

function search()
{
	var numbers = $("#numbers").val();
	var urlto = "numbers="+numbers;
	frmlist.location.href = S_ROOT + "areamoves/lists?" + urlto;
}

function charge()
{
	var library = $("#library").val();
	var source  = $("#source").val();
	var numbers = $("#numbers").val();
	var urlto = "show=lists&numbers="+numbers+"&library="+library+"&source="+source;
	frmlist.location.href = S_ROOT + "areamoves/charge?" + urlto;
}

function editinfo()
{
	var datetime 	= $("#datetime").val();
	var salesid 	= $("#salesid").val();
	var library 	= $("#library").val();
	var source  	= $("#source").val();
	var detail  	= $("#detail").val();
	var notation  	= $("#notation").val();
	if(datetime==""){ msgbox("调拨时间不能为空！"); return; }
	if(salesid==""){ msgbox("请选择调往区域！"); return; }
	if(library==""){ msgbox("请选择调往库房！"); return; }
	if(source ==""){ msgbox("请选择调拨来源！"); return; }
	if(detail ==""){ msgbox("请填写调拨需求，信息不能为空！"); return; }
	if(notation ==""){ msgbox("请填写调拨批注，信息不能为空！"); return; }
	$("#sendto").submit();
}

function checkedb(id)
{

	openDialog("审核调拨信息",S_ROOT+"areamoves/charge?do=checked&id="+id+"&"+ Math.random());

}

function checkedbtn()
{
	var id 		   = $("#areamoves_id").val();
	var checked	   = $(":radio[name='areamoves_checked']:checked").val();
	var source  	= $("#areamoves_source").val();
	var effectnums = $("#areamoves_effectnums").val();
	var effectinfo = $("#areamoves_effectinfo").val();
	if(source ==""){ msgbox("请选择调拨来源库房！"); return; }
	if(effectnums==""){ msgbox("实际调拨单号不能为空！");return; }
	if(effectinfo==""){ msgbox("实际调拨信息不能为空！");return; }
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"areamoves/charge?do=checked&id="+id,
	    data: "checked="+checked+"&source="+source+"&effectnums="+effectnums+"&effectinfo="+effectinfo,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "审核操作成功！";
	    	}else{
	    		var msg = rows;
	    	}
	    	msgbox(msg);
	    }
	});	
}

function sendgood(id)
{
	openDialog("审核调拨信息",S_ROOT+"areamoves/charge?do=sendgood&id="+id+"&"+ Math.random());
}

function goodsendbtn()
{
	var id 		 = $("#areamoves_id").val();
	var sendgood = $(":radio[name='areamoves_sendgood']:checked").val();
	var goodinfo = $("#areamoves_goodinfo").val();
	if(goodinfo==""){ msgbox("发货批注信息不能为空！");return; }
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"areamoves/charge?do=sendgood&id="+id,
	    data: "sendgood="+sendgood+"&goodinfo="+goodinfo,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "发货操作成功！";
	    	}else{
	    		var msg = rows;
	    	}
	    	msgbox(msg);
	    }
	});	
}

function confirmd(id)
{
	art.dialog({
		title:'收货确认',
		content: '<font class="red">你确定已经收到调拨了吗？</font>',
		lock: true,
		fixed: true,
	    okValue: '确定',
	    ok: function(){
			$.ajax({  
			    type: "GET",  
				async: false,
			    url: S_ROOT+"areamoves/charge?do=confirmd&id="+id,
			    data: "",             
			    success: function(rows){ 
			    	msgbox("操作完成");
			    }
			});
	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});
}






