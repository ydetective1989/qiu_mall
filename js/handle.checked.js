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

function tabs(showId,num,bgItemName,clsName)
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

function checkval(checked){
	$("#checked").attr("value",checked);
}

//审核状态
function checkhandle(id){

	openDialog("审核信息",S_ROOT+"handle/checked?id="+id+"&"+ Math.random());
	
}

function checkodo()
{
	var id		 = $("#dialog_id").val();
	var checked	 = $('input:radio[name=dialog_checked]:checked').val();
	//var checked	 = $("#dialog_checked").val();
	var detail	 = $("#dialog_detail").val();
	if(detail==""){ msgbox("批注内容不能为空");return; }
	$("#btned").attr("value","正在提交..");			//锁定按钮
	$("#btned").attr("disabled","disabled");		//锁定按钮
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"handle/checked?id="+id+"&"+ Math.random(),
	    data: "checked="+checked+"&detail="+detail,             
	    success: function(rows){
	    	if(rows=="1"){
	    		//alert(id);
	    		var msg = "操作成功！";
		    	msgshow(msg);
		    	handleinfo_check(id);
		    	parent.frmlist.location.reload();
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    	closedialog();
	    }
	});
}

//审核状态
function productdo(id){
	
	openDialog("产品调整",S_ROOT+"handle/product?id="+id+"&"+ Math.random());
	
}

function producted()
{
	var id		 = $("#dialog_id").val();
	var ordersid = $("#dialog_ordersid").val();
	var productarr = [];
	$(".dialog_nums").each(function(i,itm){
		var arr = {};
		//alert($(this).attr("id"));return;
		arr['id']   = $(this).attr("id");
		arr['nums'] = $(this).val();
		productarr.push(arr); 
	});
	//alert(JSON.stringify(productarr)); return;
	//alert(productarr[0][id]);return;
	$("#btned").attr("value","正在提交..");			//锁定按钮
	$("#btned").attr("disabled","disabled");		//锁定按钮
	$.ajax({  
	    type: "POST",
		async: false,
	    url:  S_ROOT+"handle/product?id="+id+"&"+ Math.random(),
	   // data: "productarr="+productarr,
	    data: {productarr:productarr},
	    success: function(rows){
	    	if(rows=="1"){
	    		//alert(id);
	    		var msg = "操作成功！";
		    	msgshow(msg);
		    	productlist(ordersid);
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    	closedialog();
	    }
	});
	  
}


$(document).keydown(function(){
	if(event.keyCode == 13){  
		search('');
	}
});

function search()
{
	var checked		= $("#checked").val();
	var ordersid	= $("#ordersid").val();
	var contract	= $("#contract").val();
	var express		= $("#express").val();
	var salesarea	= $("#salesarea").val();
	var salesid		= $("#salesid").val();
	var godate		= $("#godate").val();
	var todate		= $("#todate").val();
	var urlto = "checked="+checked+"&ordersid="+ordersid+"&express="+express+"&contract="+contract+"&salesarea="+salesarea+"&salesid="+salesid+"&godate="+godate+"&todate="+todate;
	frmlist.location.href = S_ROOT + "handle/checks?do=lists&" + urlto;
}

//审核记录
function handleinfo_check(id)
{
	ajaxurl(S_ROOT+"handle/checkpage?id="+id+"&"+ Math.random(),"#handle_checks");
}





