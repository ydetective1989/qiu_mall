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
function checkbtn(id){

	openDialog("审核订单",S_ROOT+"orders/checked?id="+id+"&" + Math.random());
}

function checkodo()
{
	var id	 = $("#dialog_ordersid").val();
	var item = $(":radio[name='checkval']:checked").val();
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"orders/checked",
	    data: "id="+id+"&checked="+item,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "操作成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    }
	});
}

//驳回
function outcheckbtn(id){
	openDialog("驳回订单",S_ROOT+"orders/checklist?show=outcheck&id="+id+"&" + Math.random());
}


function outcheckdo()
{
	var id	 = $("#checked_id").val();
	var detail	 = $("#checked_detail").val();
	if(detail==""){ msgbox("驳回批注不能为空！");return;  }
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"orders/checklist?show=outcheck&id="+id+"&"+ Math.random(),
	    data: "detail="+detail,             
	    success: function(rows){
	    	closedialog();
	    	if(rows=="1"){
	    		var msg = "驳回成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
	    		msgbox(msg);
	    	}
	    }
	});
}

$(function() {
	
	$("#datetime").datepicker({
		dateFormat: "yy-mm-dd"
	});

	
	$("#salesarea").change(
		function(){
			var salesarea = $("#salesarea").val();
			if(salesarea){
				$("#saleuserid").load(S_ROOT+"orders/users?type=1&salesarea="+salesarea+"&"+ Math.random());
			}else{
				$("#saleuserid").load(S_ROOT+"orders/users?type=1&"+ Math.random());
			}
		}
	);
	
	$("#salesid").change(
		function(){
			var salesarea = $("#salesarea").val();
			var salesid = $("#salesid").val();
			if(salesid){
				$("#saleuserid").load(S_ROOT+"orders/users?type=1&salesarea="+salesarea+"&salesid="+salesid+"&"+ Math.random());
			}else{
				$("#saleuserid").load(S_ROOT+"orders/users?type=1&salesarea="+salesarea+"&"+ Math.random());
			}
		}
	);
	
});

$(document).keydown(function(){
	if(event.keyCode == 13){  
		search();
	}
});

function search(status)
{
	var status = status;
	//alert(status);
	var ordersid = $("#ordersid").val();
	var checked = $("#checked").val();
	var salesarea = $("#salesarea").val();
	var salesid = $("#salesid").val();
	var saleuserid = $("#saleuserid").val();
	var urlto = "ordersid="+ordersid+"&checked="+checked+"&salesarea="+salesarea+"&salesid="+salesid+"&saleuserid="+saleuserid;
	frmlist.location.href = S_ROOT + "orders/checklist?show=lists&" + urlto;
}
