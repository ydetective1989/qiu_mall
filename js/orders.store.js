
function addstore(id)
{
	openDialog("增加订单出库信息",S_ROOT+"store/add?id="+id+"&"+ Math.random());
	//openDialog("增加序列号记录",S_ROOT+"sn/add?id="+id+"&"+ Math.random());
	//parent.parent.addTab('增加订单出库信息','store/add?id='+id+'&'+ Math.random(),'storeinfo');
}


function editstore(id)
{
	openDialog("修改订单出库信息",S_ROOT+"store/edit?id="+id+"&"+ Math.random());
	//parent.parent.addTab('修改订单出库信息','store/edit?id='+id+'&'+ Math.random(),'storeinfo');
}

function checkstore(id)
{
	//parent.parent.addTab('复核出库信息','store/checked?id='+id+'&'+ Math.random(),'storeinfo');
	openDialog("确认出库信息",S_ROOT+"store/checked?id="+id+"&"+ Math.random());
}

function viewstore(id)
{
	parent.parent.addTab('查看出库信息','store/views?id='+id+'&'+ Math.random(),'storeviews');
	//openDialog("查看出库信息",S_ROOT+"store/views?id="+id+"&"+ Math.random());
}

function deliverstore(id)
{
	location.href= S_ROOT+"store/deliver?id="+id+"&"+ Math.random();
}

//取消出库
function delstore(id)
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你确定要取消这条记录吗？(一旦取消不可恢复)</font>',
		lock: true,
		fixed: true,
	    okValue: '确定删除',
	    ok: function(){
			$.ajax({
			    type: "GET",
				async: false,
			    url: S_ROOT+"store/del?id="+id+"&"+ Math.random(),
			    data: "",
			    success: function(rows){
			    	if(rows=="1"){
				    	msgshow("操作成功");
				    	storelist(1);
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

function storedeliver()
{

	var store_arr = new Array;
	$(".storedarr").each(function(){
		store_arr.push($(this).val());
	});
	var ischk = 0;
	//console.log(products_arr);
	var msg = "";
	for(var i = 0; i < store_arr.length; i++){
		var pid = store_arr[i];
		var encoded		= $("#encoded_"+pid).val();
		var barcode		= $("#serial_"+pid).val();
		var enbarcode	= $("#enbarcode_"+pid).val().replace(/<[^>].*?>/g,"");
		//alert(encodeURIComponent(barcode));
		//alert(encodeURIComponent(enbarcode));
		if(enbarcode!=""){
			if(barcode==""){
				msgbox('<font class="red">['+encoded+']商品的条码出库复核时不能为空！</font>');
				return;
			}
			if(enbarcode!=barcode)
			{
				var ischk = 1;
				var msg = msg + '<font class="red">['+encoded+']商品条码出库校验不正确，请重新检查！</font><br>';
			}
		}
	}
	if(ischk==1){
		var content = msg+"<br>请确认是否进行复核提交操作吗？";
	}else{
		var content = '<font class="red">你确定要复核出库信息吗？</font><br>提交后，出库信息商品内容不可修改！';
	}
	art.dialog({
		title:'操作确认',
		content: content,
		lock: true,
		fixed: true,
	    okValue: '确定提交',
	    ok: function(){
			$("#sendto").submit();
	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});
}

function checkinfod()
{
	art.dialog({
		title:'操作确认',
		content: '<font class="red">你需要确认这条出库信息吗？</font><br>提交后，将根据库房分拆单据，内容将不可修改！',
		lock: true,
		fixed: true,
	    okValue: '确定提交',
	    ok: function(){
	    	var ordersid	= $("#dialog_ordersid").val();
	    	var id			= $("#dialog_id").val();
	    	var erpnum		= $("#dialog_erpnum").val();
	    	//if(erpnum==""){ 	msgshow("ERP编号不能为空！"); return; }
	    	$("#btned").attr("value","正在提交..");			//锁定按钮
	    	$("#btned").attr("disabled","disabled");		//锁定按钮
	    	$.ajax({
	    	    type: "POST",
	    		async: false,
	    	    url: S_ROOT+"store/checked?id="+id+"&"+ Math.random(),
	    	    data: "erpnum="+erpnum,
	    	    success: function(rows){
	    	    	if(rows=="1"){
	    	    		var msg = "操作成功！";
	    		    	msgshow(msg);
	    		    	closedialog();
	    	    	}else{
	    	    		var msg = rows;
	    		    	msgbox(msg);
	    	    		$("#btned").attr("value","确认单据");		//锁定按钮
	    	    		$("#btned").attr("disabled","");		//锁定按钮
	    	    	}
	    	    	storelist(1);
	    	    }
	    	});
	    },
	    cancelValue: '取消',
	    cancel: function(){}
	});
}

function verifed(id)
{
	$.ajax({
	    type: "GET",
		async: false,
	    url: S_ROOT+"store/verifed?id="+id+"&"+ Math.random(),
	    data: "",
	    success: function(rows){
	    	if(rows!="1"){
	    		msgbox(rows);
	    		return;
	    	}
	    }
	});

}

function storeinfod()
{
	var ordersid	= $("#dialog_ordersid").val();
	var id			= $("#dialog_id").val();
	var erpnum		= $("#dialog_erpnum").val();
	var type	 	= $('input:radio[name=dialog_type]:checked').val();
	//if(erpnum==""){ 	msgshow("ERP编号不能为空！"); return; }

	//库房取值
	var infoarr = [];
	var msginfo = "";
	$(".dialog_pid").each(function(i,itm){
		var arr = {};
		var id  = $(this).attr("id");
		arr['id']		= id;
		var erpname		= $("#erpname_"+id).val();
		arr['erpname']	= erpname;
		//alert($("#encoded_"+id).val());
		var encoded		= $("#encoded_"+id).val();
		arr['encoded']	= encoded;
		arr['storeid']	= $("#storeid_"+id).val();
		arr['productid']= $("#productid_"+id).val();
		var maxnums		= parseInt($("#maxnums_"+id).val());
		arr['maxnums']	= maxnums;
		var storenums	= parseInt($("#storenums_"+id).val());
		arr['storenums']= storenums;
		var nums		= parseInt($("#nums_"+id).val());
		if(nums!=""&&nums!="0")
		{
			if(type=="1"){
				if(maxnums < nums){
					//alert(maxnums+"||"+nums);
					msginfo = "["+encoded+"]出库数量不能大于可出数量！"; return false;
				}
			}
			/*
			else{
				msginfo = storenums-nums;return false;
				if((storenums-nums)<0){
					msginfo = "["+encoded+"]退库数量不能大于已出数量！"; return false;
				}
			}*/
			if(!isWhiteWpace(nums)){ msginfo = "["+encoded+"]数量中包括空格，请重新填写！"; return false;  }
			if(type=="1"||type=="2"){
				if(!isNumber(nums)){ msginfo = "["+encoded+"]错误，出库数量必须为正数！"; return false;  }
			}else{
				if(!isFNumber(nums)){ msginfo = "["+encoded+"]错误，退出数量必须是负数！"; return false; }
			}
			arr['nums']		= nums;
		}
		infoarr.push(arr);
	});
	if(msginfo!=""){
		msgshow(msginfo);return;
	}

	$("#btned").attr("value","正在提交..");			//锁定按钮
	$("#btned").attr("disabled","disabled");		//锁定按钮

	if(id==""){
		var urlto = S_ROOT+"store/add?id="+ordersid+"&"+ Math.random();
	}else{
		var urlto = S_ROOT+"store/edit?id="+id+"&"+ Math.random()
	}

	$.ajax({
	    type: "POST",
		async: false,
	    url: urlto,
	    data: {erpnum:erpnum,type:type,infoarr:infoarr},
	    success: function(rows){
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
		    	closedialog();
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    		$("#btned").attr("value","提交信息");		//锁定按钮
	    		$("#btned").attr("disabled","");		//锁定按钮
	    	}
	    	storelist(1);
	    }
	});
}

//工单记录
function storelist(page)
{
	var id = $("#store_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"store/lists?id="+id+"&page="+page+"&"+ Math.random(),"#store_list");
}


function search()
{
	var erpnum  	= $("#erpnum").val();
	var ordersid	= $("#ordersid").val();
	if(erpnum==""&&ordersid==""){ msgshow("搜索条件不能为空，必须选定一项"); return; }
	var urlto = "erpnum="+erpnum+"&ordersid="+ordersid;
	frmlist.location.href = S_ROOT + "store/search?show=lists&" + urlto;
}

function charge()
{
	var status	 = $("#status").val();
	var ordersid = $("#ordersid").val();
	var erpnum	 = $("#erpnum").val();
	var storeid	 = $("#storeid").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var deliver	 = $("#deliver").val();
	var urlto = "do="+status+"&show=lists&godate="+godate+"&todate="+todate+"&ordersid="+ordersid+"&erpnum="+erpnum+"&storeid="+storeid+"&deliver="+deliver;
	frmlist.location.href = S_ROOT + "store/charge?" + urlto;
}

function xls()
{
	var status	 = $("#status").val();
	var ordersid = $("#ordersid").val();
	var erpnum	 = $("#erpnum").val();
	var storeid	 = $("#storeid").val();
	var godate	 = $("#godate").val();
	var todate	 = $("#todate").val();
	var deliver	 = $("#deliver").val();
	var urlto = "do="+status+"&show=xls&godate="+godate+"&todate="+todate+"&ordersid="+ordersid+"&erpnum="+erpnum+"&storeid="+storeid+"&deliver="+deliver;
	frmlist.location.href = S_ROOT + "store/charge?" + urlto;
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
