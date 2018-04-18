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
	$("#afterarea").change(function(){
		var afterarea	= $("#afterarea").val();
		//alert(afterid);
		if(afterarea){
			$("#afteruserid").load(S_ROOT+"teams/users?type=3&parentid="+afterarea+"&"+ Math.random());
		}else{
			$("#afteruserid").load(S_ROOT+"teams/users?type=3&"+ Math.random());
		}
	});
	$("#afterid").change(function(){
		var afterarea	= $("#afterarea").val();
		var afterid	= $("#afterid").val();
		if(afterid){
			$("#afteruserid").load(S_ROOT+"teams/users?type=3&teamid="+afterid+"&"+ Math.random());
		}else{
			if(afterarea){
				$("#afteruserid").load(S_ROOT+"teams/users?type=3&parentid="+afterarea+"&"+ Math.random());
			}else{
				$("#afteruserid").load(S_ROOT+"teams/users?type=3&"+ Math.random());
			}
		}
	});
});

$(document).keydown(function(){
	if(event.keyCode == 13){  search(); }
});

function viewlist()
{
	var views = $("#views").val();
	if(views=="0"){
		location.href= S_ROOT+'jobs/charge?views=1';
	}else{
		location.href= S_ROOT+'jobs/charge';
	}
}

$(function() {
	
	$("#charge_ptype").die().live("change",function(){ 
		var ptypeid	= $("#charge_ptype").val();
		$("#charge_payid").load(S_ROOT+"charge/gettype?id="+ptypeid+"&"+ Math.random());
	});
	
});

function focustabs(showId,num,bgItemName,clsName)
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

function search(checked)
{
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var salesarea= $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var afterarea= $("#afterarea").val();
	var afterid	 = $("#afterid").val();
	var afteruserid	 = $("#afteruserid").val();
	var ordersid	 = $("#ordersid").val();
	var pricetype = $("#pricetype").val();
	$("#checked").attr("value",checked);
	var views = $("#views").val();
	var urlto = "views="+views+"&godate="+godate+"&todate="+todate+"&pricetype="+pricetype+"&salesarea="+salesarea+"&salesid="+salesid+"&afterarea="+afterarea+"&afterid="+afterid+"&afteruserid="+afteruserid+"&ordersid="+ordersid+"&checked="+checked;
	frmlist.location.href = S_ROOT + "jobs/charge?do=lists&" + urlto;
}

function xls()
{
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var checked	 = $("#checked").val();
	var salesarea= $("#salesarea").val();
	var salesid	 = $("#salesid").val();
	var afterarea= $("#afterarea").val();
	var afterid	 = $("#afterid").val();
	var afteruserid	 = $("#afteruserid").val();
	var ordersid	 = $("#ordersid").val();
	//alert(checked);return;
	var urlto = "godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&afterarea="+afterarea+"&afterid="+afterid+"&afteruserid="+afteruserid+"&ordersid="+ordersid+"&checked="+checked;
	frmlist.location.href = S_ROOT + "jobs/charge?do=xls&" + urlto;
}

function encharge(id)
{
    $.ajax({
        type: "GET",
        async: false,
        url: S_ROOT+"jobs/charge?do=checked&id="+id+"&"+ Math.random(),
        data: "",
        success: function(rows){
            art.dialog({
                id: 'dialog_yws',
                //esc: false,,
                lock: true,
                drag:false,
                title: '服务结算审核',
                content: rows,
                padding: '5px'
            })
        }
    });
    /*
    var address = $("#jobs_address").val();
    var city = $("#jobs_city").val();
    var urlto = "http://fuwu.shui.cn/maps/getaddr?address="+address+"&city="+city+"&"+ Math.random();
    $("#maps_getdist").load(urlto);*/
}

function getaddnums()
{
    var address = $("#jobs_address").val();
    var city = $("#jobs_city").val();
    var urlto = "http://fuwu.shui.cn/maps/getaddr?address="+address+"&city="+city+"&"+ Math.random();
    $("#maps_getdist").load(urlto);
}


function enplus(id)
{
	openDialog("服务补贴结算",S_ROOT+"jobs/charge?do=plus&id="+id+"&"+ Math.random());
}

function enfuwu(id)
{
	openDialog("供应商结算",S_ROOT+"jobs/charge?do=fuwu&id="+id+"&"+ Math.random());
}

function encharged()
{
	var id			= $("#jobs_id").val();
	var ordersid	= $("#jobs_ordersid").val();
    var salespid    = $("#jobs_salespid").val();
	var checked		= $(":radio[name='jobs_checked']:checked").val();
	var plus		= $("#jobs_plus").val();
	var plusinfo	= $("#jobs_plusinfo").val();
	var encharge	= $("#jobs_encharge").val();
	var enchargeinfo= $("#jobs_enchargeinfo").val();

	if(encharge!=""){
		if(!isMoney(encharge)){ msgbox("错误，其它费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
	}
	if(enchargeinfo==""){
		msgbox("结算批注不能为空！"); return;
	}
    if(plus!=""){
        if(!isMoney(plus)){ msgbox("错误，服务补贴费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
        if(plusinfo==""){
            msgbox("错误，服务补贴说明不能为空"); return;
        }
    }
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"jobs/charge?do=checked&id="+id+"&ordersid="+ordersid,//&ensetup="+ensetup+"&enlong="+enlong+"
	    data: "id="+id+"&checked="+checked+"&encharge="+encharge+"&enchargeinfo="+enchargeinfo+"&plus="+plus+"&plusinfo="+plusinfo,
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
	    		parent.frmlist.location.reload();
	    		//location.reload();
	    	}else{
	    		var msg = rows;
	    	}
            msgshow(msg);
	    }
	});
}

function jobs_enplused()
{
	var id			= $("#jobs_id").val();
	var ordersid	= $("#jobs_ordersid").val();
	var plus		= $("#jobs_plus").val();
	var plusinfo	= $("#jobs_plusinfo").val();
	if(plus!=""){
		if(!isMoney(plus)){ 
			msgbox("错误，补贴费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return;
		}
		if(plusinfo==""){
			msgbox("错误，补贴原因及说明不能为空！"); return;
		}
	}else{
		msgbox("服务补贴费用不能为空！"); return;
	}
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"jobs/charge?do=plus&id="+id+"&ordersid="+ordersid,//&ensetup="+ensetup+"&enlong="+enlong+"
	    data: "plus="+plus+"&plusinfo="+plusinfo,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
	    		parent.frmlist.location.reload();
	    		//location.reload();
	    	}else{
	    		var msg = rows;
	    	}
            msgshow(msg);
	    }
	});
}

function jobs_enfuwu()
{
	var id			= $("#jobs_id").val();
	var ordersid	= $("#jobs_ordersid").val();
    var fuwued		= $(":radio[name='jobs_fuwued']:checked").val();
    var fuwu		= $("#jobs_fuwu").val();
	var fuwuinfo	= $("#jobs_fuwuinfo").val();
	if(fuwu!=""){
		if(!isMoney(fuwu)){ 
			msgbox("错误，附加费用金额格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return;
		}
		if(fuwuinfo==""){
			msgbox("错误，附加费用描述不能为空！"); return;
		}
	}else{
		msgbox("附加费用不能为空！"); return;
	}
    //alert("fuwued="+fuwued+"&fuwu="+fuwu+"&fuwuinfo="+fuwuinfo);return;
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"jobs/charge?do=fuwu&id="+id+"&ordersid="+ordersid,//&ensetup="+ensetup+"&enlong="+enlong+"
	    data: "fuwued="+fuwued+"&fuwu="+fuwu+"&fuwuinfo="+fuwuinfo,
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
	    		parent.frmlist.location.reload();
	    	}else{
	    		var msg = rows;
	    	}
	    	msgshow(msg);
	    }
	});
}


function jobs_allchecked()
{

	art.dialog({
		title:'操作确认',
		content: '你确认要进行批量审核吗？',
		lock: true,
		fixed: true,
	    okValue: '确定审核',
	    ok: function(){
	    	
	    	var chk_arr =[];  
	    	$('input[name="selected"]:checked').each(function(){  
	    		chk_arr.push($(this).val());  
	    	});
	    	if(chk_arr.length==0){ msgshow('请选择要审核的结算内容');return; }
			$.ajax({
			    type: "POST",  
				async: false,
			    url: S_ROOT+"jobs/charge?do=allchecked",
			    data: "id="+chk_arr,             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	msgshow("操作成功");
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









