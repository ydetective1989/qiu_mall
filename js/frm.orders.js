function ordertabs(showId,num,bgItemName,clsName)
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


	$("#areaid").change(
		function(){
			var areaid = $("#areaid").val();
			if(areaid>"0"){
				//$("#loops").load(S_ROOT+"orders/areas?areaid="+areaid+"&&"+ Math.random());
			}
		}
	);

});

$(document).keydown(function(){
	if(event.keyCode == 13){  search(''); }
});

function search(status)
{
	var status = status;
	//alert(status);
	if($("#showpid").attr("checked")){
		var showpid = 1;
	}else{
		var showpid = 0;
	}
	var ordersid	= $("#ordersid").val();
	var type			= $("#type").val();
	var ctype			= $("#ctype").val();
	var contract 	= $("#contract").val();
	var name 			= $("#name").val();
	var datetime 	= $("#datetime").val();
	var wangwang 	= $("#wangwang").val();
	var mobile 		= $("#mobile").val();
	//var phone 	= $("#phone").val();
	var address 	= $("#address").val();
	var checked 	= $("#checked").val();
	var provid 		= $("#provid").val();
	var cityid	 	= $("#cityid").val();
	var areaid 		= $("#areaid").val();
	var salesarea = $("#salesarea").val();
	var salesid 	= $("#salesid").val();
	var saleuserid= $("#saleuserid").val();
	var tagid = $("#tagid").val();
	var urlto = "status="+status+"&showpid="+showpid+"&ordersid="+ordersid+"&type="+type+"&ctype="+ctype+"&contract="+contract+"&name="+name+"&datetime="+datetime+"&mobile="+mobile+"&wangwang="+wangwang+"&address="+address+"&checked="+checked+"&provid="+provid+"&cityid="+cityid+"&areaid="+areaid+"&salesarea="+salesarea+"&salesid="+salesid+"&saleuserid="+saleuserid+"&tagid="+tagid;
	frmlist.location.href = S_ROOT + "orders/lists?" + urlto;
}
