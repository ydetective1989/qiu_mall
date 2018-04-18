function invoicetype(val)
{
	if(val=="1"){
		$("#edtypes").show();
	}else{
		$("#edtypes").hide();
	}
}

function invoicepost(val)
{
	if(val=="1"){
		$("#posttypes").show();
	}else{
		$("#posttypes").hide();
	}
}

//发票记录
function invoicelist(page)
{
	var id = $("#invoice_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/invoice?id="+id+"&page="+page+"&"+ Math.random(),"#invoice_list");
}

function invoice(ordersid)
{
	openDialog("发票申请",S_ROOT+"invoice/add?ordersid="+ordersid+"&"+ Math.random());
}

function editinvoice(id)
{
	openDialog("修改发票申请",S_ROOT+"invoice/edit?id="+id+"&"+ Math.random());
}

function delinvoice(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要删除这条申请吗？(一旦删除不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定删除',
	    ok: function(){
			$.ajax({  
			    type: "GET",  
				async: false,
			    url: S_ROOT+"invoice/del?id="+id,
			    data: "",             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	invoicelist(1);
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

function invoiced()
{
	
	var ordersid	= $("#ordersid").val();
	var invoiceid	= $("#invoice_id").val();
	var type		= $(":radio[name='invoice_type']:checked").val();
	var cateid		= $("#invoice_cateid").val();
	var title		= $("#invoice_title").val();
	var price		= $("#invoice_price").val();
	var priceno		= $("#invoice_priceno").val();
	var detail		= $("#invoice_detail").val();
	var cityname	= $("#invoice_cityname").val();
	var posted		= $(":radio[name='invoice_posted']:checked").val();
	var postname	= $("#invoice_postname").val();
	var postaddress	= $("#invoice_postaddress").val();
	var postphone	= $("#invoice_postphone").val();
	var corpname	= $("#invoice_corpname").val();
	var corpaddress	= $("#invoice_corpaddress").val();
	var corptel		= $("#invoice_corptel").val();
	var corpnums	= $("#invoice_corpnums").val();
	var corpbank	= $("#invoice_corpbank").val();
	
	if(type=="")	{ msgbox("请选择发票类型！"); return; }
	if(cateid=="")	{ msgbox("请选择开票单位！"); return; }
	if(title=="")	{ msgbox("请填写发票抬头！"); return; }
	if(price==""){ 
		msgbox("请填写开票金额！"); return; 
	}else{
		if(!isMoney(price)){ 
			msgbox("错误，金额格式不正确！<br>正确格式：100，-100或100.00，-100.00"); 
			return; 
		}
		//alert(price);
		//alert(priceno);
		var price 	= price-0;
		var priceno = priceno-0;
		if(price > priceno){
			msgbox("发票可开金额不得超过订单入款金额！"); 
			return; 
		}
	}
	if(detail==""){ msgbox("发票内容不能为空！"); return; }
	
	if(type=="1"){
		if(corpname=="")	{ msgbox("请填写公司名称！"); return; }
		if(corpaddress=="")	{ msgbox("请填写公司地址！"); return; }
		if(corptel=="")		{ msgbox("请填写公司电话！"); return; }
		if(corpnums=="")	{ msgbox("请填写公司税号！"); return; }
		if(corpbank=="")	{ msgbox("请填写开户信息！"); return; }
	}
	if(posted=="1"){
		if(postname=="")	{ msgbox("请填写收件人姓名！"); return; }
		if(postaddress=="")	{ msgbox("请填写收件人地址！"); return; }
		if(postphone=="")	{ msgbox("请填写收件人电话！"); return; }
	}
	
	if(invoiceid!=""){
		urlto = S_ROOT+"invoice/edit";
	}else{
		urlto = S_ROOT+"invoice/add";
	}

	$("#invoicebtn").attr("value","正在提交..");			//锁定按钮
	$("#invoicebtn").attr("disabled","disabled");		//锁定按钮	
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: urlto,
	    data: "ordersid="+ordersid+"&id="+invoiceid+"&type="+type+"&cateid="+cateid+"&title="+title+"&price="+price+"&detail="+detail+"&cityname="+cityname+"&posted="+posted+"&postname="+postname+"&postaddress="+postaddress+"&postphone="+postphone+"&corpname="+corpname+"&corpaddress="+corpaddress+"&corptel="+corptel+"&corpnums="+corpnums+"&corpbank="+corpbank,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    	invoicelist(1);
	    }
	});
}

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

$(document).keydown(function(){
	if(event.keyCode == 13){  search(''); }
});

function invoice_search(status)
{
	$("#status").attr("value",status);
	var sotype	= $("#sotype").val();
	var sokey	= $("#sokey").val();
	var type	= $("#type").val();
	var cateid	= $("#cateid").val();
	var urlto = "status="+status+"&sotype="+sotype+"&sokey="+sokey+"&type="+type+"&cateid="+cateid;
	frmlist.location.href = S_ROOT + "invoice/lists?" + urlto;
}

function invoice_xls()
{
	var status	= $("#status").val();
	var sotype	= $("#sotype").val();
	var sokey	= $("#sokey").val();
	var type	= $("#type").val();
	var cateid	= $("#cateid").val();
	var urlto = "status="+status+"&sotype="+sotype+"&sokey="+sokey+"&type="+type+"&cateid="+cateid;
	frmlist.location.href = S_ROOT + "invoice/xls?" + urlto;
}

function invoicechecked()
{
	var id			= $("#id").val();
	//var ordersid	= $("#ordersid").val();
	openDialog("审核发票信息",S_ROOT+"invoice/checked?id="+id+"&"+ Math.random());
	
}

function checktype()
{
	var checked	= $(":radio[name='invoice_checked']:checked").val();
	if(checked=="2"){
		$("#workdetails").css("display","");
	}else{
		$("#workdetails").css("display","none");
	}
}

function checkedo()
{
	var id			= $("#invoice_id").val();
	var ordersid	= $("#invoice_ordersid").val();
	var checked	= $(":radio[name='invoice_checked']:checked").val();
	if(checked=='2'){
		var workinfo = $("#invoice_workinfo").val();
		if(workinfo==""){ msgbox("处理批注不能为空！"); return; }
	}else{
		var workinfo = "";
	}
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"invoice/checked?id="+id+"&ordersid="+ordersid,
	    data: "checked="+checked+"&workinfo="+workinfo,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "审核操作成功！";
		    	parent.frmlist.location.reload();
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    }
	});	
}

function opensbtn()
{
	var id			= $("#id").val();
	openDialog("发票开票操作",S_ROOT+"invoice/opened?id="+id+"&"+ Math.random());
}

function invoiceopend()
{
	var ordersid	= $("#invoice_ordersid").val();
	var id			= $("#invoice_id").val();
	var worknums	= $("#invoice_worknums").val();
	var workinfo	= $("#invoice_workinfo").val();
	var type		= $(":radio[name='invoice_type']:checked").val();
	var cateid		= $("#invoice_cateid").val();
	var title		= $("#invoice_title").val();
	var price		= $("#invoice_price").val();
	var detail		= $("#invoice_detail").val();
	var cityname	= $("#invoice_cityname").val();
	var corpname	= $("#invoice_corpname").val();
	var corpaddress	= $("#invoice_corpaddress").val();
	var corptel		= $("#invoice_corptel").val();
	var corpnums	= $("#invoice_corpnums").val();
	var corpbank	= $("#invoice_corpbank").val();

	if(worknums=="")	{ msgbox("发票编号不能为空！"); return; }
	if(workinfo=="")	{ msgbox("开票批注不能为空！"); return; }
	if(type=="")	{ msgbox("请选择发票类型！"); return; }
	if(cateid=="")	{ msgbox("请选择开票单位！"); return; }
	if(title=="")	{ msgbox("请填写发票抬头！"); return; }
	if(price==""){ 
		msgbox("请填写开票金额！"); return; 
	}else{
		if(!isMoney(price)){ 
			msgbox("错误，金额格式不正确！<br>正确格式：100，-100或100.00，-100.00"); 
			return; 
		}
	}
	if(detail==""){ msgbox("发票内容不能为空！"); return; }
	if(type=="1"){
		if(corpname=="")	{ msgbox("请填写公司名称！"); return; }
		if(corpaddress=="")	{ msgbox("请填写公司地址！"); return; }
		if(corptel=="")		{ msgbox("请填写公司电话！"); return; }
		if(corpnums=="")	{ msgbox("请填写公司税号！"); return; }
		if(corpbank=="")	{ msgbox("请填写开户信息！"); return; }
	}

	$("#invoicebtn").attr("value","正在提交..");			//锁定按钮
	$("#invoicebtn").attr("disabled","disabled");		//锁定按钮
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"invoice/opened?id="+id+"&ordersid="+ordersid,
	    data: "worknums="+worknums+"&workinfo="+workinfo+"&type="+type+"&cateid="+cateid+"&title="+title+"&price="+price+"&detail="+detail+"&corpname="+corpname+"&corpaddress="+corpaddress+"&corptel="+corptel+"&corpnums="+corpnums+"&corpbank="+corpbank,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	parent.frmlist.location.reload();
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    }
	});	

}

function killsbtn()
{

	var id			= $("#id").val();
	openDialog("发票开票操作",S_ROOT+"invoice/killed?id="+id+"&"+ Math.random());
}

function invoicekilled()
{
	var ordersid	= $("#invoice_ordersid").val();
	var id			= $("#invoice_id").val();
	var workinfo	= $("#invoice_workinfo").val();
	var worked		= $(":radio[name='invoice_worked']:checked").val();
	if(workinfo==""){ msgbox("处理批注不能为空！"); return; }
	$("#invoicebtn").attr("value","正在提交..");			//锁定按钮
	$("#invoicebtn").attr("disabled","disabled");		//锁定按钮
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"invoice/killed?id="+id+"&ordersid="+ordersid,
	    data: "worked="+worked+"&workinfo="+workinfo,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	parent.frmlist.location.reload();
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    }
	});		
}










