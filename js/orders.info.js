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
	$("#plansend").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#plansetup").datepicker({
		dateFormat: "yy-mm-dd"
	});

});

$(document).keydown(function(){
	if(event.keyCode == 13){ editinfo(); }
});

function editinfo()
{
	var name = $("#name").val();
	if(name==""){ msgshow("客户姓名不能为空！"); return; }
	$.blockUI();
	$("#sendto").submit();
}

//增加产品
function addinfo(){

	var parrids = new Array;
	$(".arrnums").each(function(){
		parrids.push($(this).val());
	});
	var productnums =  parrids.length;
	if(productnums >= 8){
		msgbox("错误，一个订单只允许添加8个产品");
		return;
	}


	openDialog("增加订购信息",S_ROOT+"product/dialog?"+ Math.random());

}

//搜索产品
function searchinfo()
{
	var title = $("#product_title").val();
	var encoded = $("#product_encoded").val();
	var categoryid = $("#product_categoryid").val();
	var brandid = $("#product_brandid").val();
	if(title==""&&encoded==""&&categoryid==""&&brandid==""){ msgbox("请设定搜索条件！");return; }
	$("#product_arr").load(S_ROOT+"product/dialogso?encoded="+encoded+"&title="+title+"&categoryid="+categoryid+"&brandid="+brandid);
}

function addproduct()
{
	var productarr = $("#productarr").attr("value")+1;
	var product_nums = $("#product_nums").attr("value");

	var parrids = new Array;
	$(".arrnums").each(function(){
		parrids.push($(this).val());
	});
	var productnums =  parrids.length;
	if(productnums >= 8){
		msgbox("错误，一个订单只允许添加8个产品");
		return;
	}

	var productvar = "";
	productvar = $("#product_arr").val();
	if(productvar == null){
		msgbox("请先选择一个产品");
		return true;
	}
	if(productvar.length > 1){
		msgbox("错误，您只能选择一个产品！");
		return true;
	}

	productvar = productvar + "";
	//var productarr = Array();
	productarrs = productvar.split("||");
	//alert(productarr[1]);
	var products_arr = new Array;
	$(".productsArr").each(function(){
		products_arr.push($(this).val());
	});
	//console.log(products_arr);
	for(var i = 0; i < products_arr.length; i++){
		//alert(productarr[1]);
		if(products_arr[i]==productarrs[0] && productarrs[1]!="000000"){
			msgbox("该产品已添加，请重复添加！");
			return;
		}
	}

	if(productarrs[1]=="000000"){
		addopts = '<tr class="datas" id="repeat">'+
		'<input type="hidden" name="products[]" class="arrnums" value="'+productarr+'">'+
		'<input type="hidden" name="productids['+productarr+']" class="productsArr" value="'+productarrs[0]+'">'+
		'<td class="tdcenter"><input type="hidden" name="encodeds['+productarr+']" class="tdcenter" value="'+productarrs[1]+'" style="width:98%;">'+productarrs[1]+'</td>'+
		'<td><input type="text" name="titles['+productarr+']" class="input" value="'+productarrs[3]+'"  style="width:240px;"></td>'+
		'<td><input type="text" name="details['+productarr+']" class="input tdcenter" value="" style="width:210px;"></td>'+
		'<td class="tdcenter"><input type="text" name="nums['+productarr+']" class="input tdcenter" value="'+product_nums+'" style="width:40px;"></td>'+
		'<td class="tdcenter"><input type="text" name="prices['+productarr+']" class="input tdcenter" value="0" style="width:70px;"></td>'+
		'<td class="tdcenter"><input type="button" class="button" id="delProduct" value="X" style="min-width:35px;"></td>'+
		'</tr>';
	}else{
		addopts = '<tr class="datas" id="repeat">'+
		'<input type="hidden" name="products[]" class="arrnums" value="'+productarr+'">'+
		'<input type="hidden" name="productids['+productarr+']" class="productsArr" value="'+productarrs[0]+'">'+
		'<td class="tdcenter"><input type="hidden" name="encodeds['+productarr+']" class="input tdcenter" value="'+productarrs[1]+'" style="width:98%;">'+productarrs[1]+'</td>'+
		'<td class="tdleft"><input type="text" name="titles['+productarr+']" class="input" value="'+productarrs[3]+'" readonly style="width:240px;"></td>'+
		'<td><input type="text" name="details['+productarr+']" class="tdcenter input" value="" style="width:210px;"></td>'+
		'<td class="tdcenter"><input type="text" name="nums['+productarr+']" class="input tdcenter" style="width:40px;" value="'+product_nums+'"></td>'+
		'<td class="tdcenter"><input type="text" name="prices['+productarr+']" class="input tdcenter" style="width:70px;" value="'+productarrs[2]+'"></td>'+
		'<td class="tdcenter"><input type="button" class="button" id="delProduct" value="X" style="min-width:35px;"></td>'+
		'</tr>';
	}

	$('#productlist tbody').append(addopts);
	$("#productlist #delProduct").click(function() {
		$(this).parents("#repeat").remove();
	});
	var productarr = $('#productarr').attr("value");
	productarr = productarr-0;
	productarr = productarr+1;
	//alert('序列：'+productarr);
	$("#productarr").attr("value",productarr);	//填充内容

	closedialog();
}


$(document).ready(function(){

	var saleuserid = $("#saleusered").val();
	$("#salesarea").change(
		function(){
			var salesarea = $("#salesarea").val();
			if(!salesarea){
				$("#saleuserid").load(S_ROOT+"teams/users?no=1&type=1&"+ Math.random());
			}
		}
	);

	$("#salesid").change(
		function(){
			var salesarea = $("#salesarea").val();
			var salesid = $("#salesid").val();
			if(salesid){
				$("#saleuserid").load(S_ROOT+"teams/users?type=1&parentid="+salesarea+"&teamid="+salesid+"&userid="+saleuserid+"&"+ Math.random());
			}else{
				$("#saleuserid").load(S_ROOT+"teams/users?no=1&type=1&parentid="+salesarea+"&"+ Math.random());
			}
		}
	);


	$("#productlist #delProduct").click(function() {
		$(this).parents("#repeat").remove();
	});


	$("#areaid").change(
		function(){
			var areaid = $("#areaid").val();
			var loops  = $("#loopsval").val();
			if(areaid>"0"){
				//$("#loops").load(S_ROOT+"orders/areas?areaid="+areaid+"&loops="+loops+"&"+ Math.random());
			}
		}
	);

});

function editinfo()
{

	var products_arr = new Array;
	$(".productsArr").each(function(){
		products_arr.push($(this).val());
	});
	//console.log(products_arr);
	for(var i = 0; i < products_arr.length; i++){
		if(products_arr[i]=="0"){
			var nums = i + 1;
			msgbox("第"+nums+"行产品订购数据内容异常，请删除重新录入！")
			return;
		}
	}

	var type = $("#type").val();
	if(type==""){ msgbox("请先选择订单类型！"); return; }

	var name = $("#name").val();
	if(name==""){ msgbox("客户姓名不能为空！"); return; }
	var provid = $("#provid").val();
	var cityid = $("#cityid").val();
	var areaid = $("#areaid").val();
	if(provid==""||cityid==""||areaid==""){ msgbox("请选择省份/城市/区镇"); return; }

	var address = $("#address").val();
	if(address==""){ msgbox("客户联系地址不能为空！"); return; }
	var mobile = $("#mobile").val();
	var phone = $("#phone").val();
	if(mobile==""&&phone==""){ msgbox("客户手机号码/联系电话需要填写一项"); return; }
	if(mobile!=""){
		if(!isWhiteWpace(mobile)){ msgbox("手机号码中有空格，请检查！"); return; }
		if(mobile.length!=11){ msgbox("手机号码长度不正确，请检查！"); return; }
		if(!isMobile(mobile)){ msgbox("手机号码格式不正确，请检查！"); return; }
	}
	if(phone!=""){
		if(phone.length>20){ msgbox("其它电话长度不能超过20位，请检查！"); return; }
	}
	if(phone==mobile){
		msgbox("手机号码和其它号码不能一样");return;
	}
	var email = $("#email").val();
	if(email!=""){
		if(!isWhiteWpace(email)){ msgbox("电子邮箱格式中有空格，请检查！"); return; }
		if(!checkEmail(email)){ msgbox("电子邮箱格式不正确，请检查！"); return; }
	}

	var closed = $("#closed").val();
	if(closed!="1"){

		var datetime = $("#datetime").val();
		if(datetime==""){ msgbox("请选择订购时间"); return; }

		var paytype = $("#paytype").val();
		if(paytype==""){ msgbox("请选择付款方式"); return; }

		var delivertype = $("#delivertype").val();
		if(delivertype==""){ msgbox("请选择送货方式"); return; }

		var setuptype = $("#setuptype").val();
		if(setuptype==""){ msgbox("请选择安装方式"); return; }

		var plansend = $("#plansend").val();
		if(plansend==""){ msgbox("请选择计划送货时间"); return; }

		var plansetup = $("#plansetup").val();
		if(plansetup==""){ msgbox("请选择计划安装时间"); return; }

		var salesid = $("#salesid").val();
		if(salesid==""){ msgbox("请选择销售网点"); return; }
		//var saleuserid = $("#saleuserid").val();
		var saleuserid = $("input[name='saleuserid']").val();
		var othersalesuserid = $("#othersalesuserid").val();
		if(saleuserid==""&&othersalesuserid==""){ msgbox("请选择一个销售人员"); return; }

		var parrids = new Array;
		$(".arrnums").each(function(){
			parrids.push($(this).val());
		});
		var productnums =  parrids.length;
		if(productnums == 0){
			msgbox("错误，你没有增加产品订购信息");
			return;
		}
		var price_setup = $("#price_setup").val();
		if(price_setup!=""){
			if(!isWhiteWpace(price_setup)){ msgbox("安装费用格式中包括空格，请重新填写！"); return; }
			if(!isMoney(price_setup)){ msgbox("错误，安装费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
			if(!isMoneyNums(price_setup)){ msgbox("错误，安装费用不能为负数！"); return; }
		}
		var price_deliver = $("#price_deliver").val();
		if(price_deliver!=""){
			if(!isWhiteWpace(price_deliver)){ msgbox("送货费用格式中包括空格，请重新填写！"); return; }
			if(!isMoney(price_deliver)){ msgbox("错误，送货费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
			if(!isMoneyNums(price_deliver)){ msgbox("错误，送货费用不能为负数！"); return; }
		}
		var price_minus = $("#price_minus").val();
		if(price_minus!=""){
			if(!isWhiteWpace(price_minus)){ msgbox("优惠费用格式中包括空格，请重新填写！"); return; }
			if(!isMoney(price_minus)){ msgbox("错误，优惠费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
			//if(!isMoneyDims(price_deliver)){ msgbox("错误，优惠费用必须为负数！"); return; }
		}
		var price_other = $("#price_other").val();
		if(price_other!=""){
			if(!isWhiteWpace(price_other)){ msgbox("其它费用格式中包括空格，请重新填写！"); return; }
			if(!isMoney(price_other)){ msgbox("错误，其它费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
			if(!isMoneyNums(price_other)){ msgbox("错误，其它费用不能为负数！"); return; }
		}
	}
	$("#editinfod").attr("value","正在提交..");			//锁定按钮
	$("#editinfod").attr("disabled","disabled");			//锁定按钮
	pageload();
	$("#sendto").submit();
}

function editpinfo()
{
	var products_arr = new Array;
	$(".productsArr").each(function(){
		products_arr.push($(this).val());
	});
	//console.log(products_arr);
	for(var i = 0; i < products_arr.length; i++){
		if(products_arr[i]=="0"){
			var nums = i + 1;
			msgbox("第"+nums+"行产品订购数据内容异常，请删除重新录入！")
			return;
		}
	}

	var salesid = $("#salesid").val();
	if(salesid==""){ msgbox("请选择销售网点"); return; }
	var saleuserid = $("#saleuserid").val();
	var othersalesuserid = $("#othersalesuserid").val();
	if(saleuserid==""&&othersalesuserid==""){ msgbox("请选择一个销售人员"); return; }

	var parrids = new Array;
	$(".arrnums").each(function(){
		parrids.push($(this).val());
	});
	var productnums =  parrids.length;
	if(productnums == 0){
		msgbox("错误，你没有增加产品订购信息");
		return;
	}

	var datetime = $("#datetime").val();
	if(datetime==""){ msgbox("请选择订购时间"); return; }

	var paytype = $("#paytype").val();
	if(paytype==""){ msgbox("请选择付款方式"); return; }

	var delivertype = $("#delivertype").val();
	if(delivertype==""){ msgbox("请选择送货方式"); return; }

	var setuptype = $("#setuptype").val();
	if(setuptype==""){ msgbox("请选择安装方式"); return; }

	var plansend = $("#plansend").val();
	if(plansend==""){ msgbox("请选择计划送货时间"); return; }

	var plansetup = $("#plansetup").val();
	if(plansetup==""){ msgbox("请选择计划安装时间"); return; }

	var salesid = $("#salesid").val();
	if(salesid==""){ msgbox("请选择销售网点"); return; }
	var saleuserid = $("#saleuserid").val();
	var othersalesuserid = $("#othersalesuserid").val();
	if(saleuserid==""&&othersalesuserid==""){ msgbox("请选择一个销售人员"); return; }

	var price_setup = $("#price_setup").val();
	if(price_setup!=""){
		if(!isWhiteWpace(price_setup)){ msgbox("安装费用格式中包括空格，请重新填写！"); return; }
		if(!isMoney(price_setup)){ msgbox("错误，安装费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
		if(!isMoneyNums(price_setup)){ msgbox("错误，安装费用不能为负数！"); return; }
	}
	var price_deliver = $("#price_deliver").val();
	if(price_deliver!=""){
		if(!isWhiteWpace(price_deliver)){ msgbox("送货费用格式中包括空格，请重新填写！"); return; }
		if(!isMoney(price_deliver)){ msgbox("错误，送货费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
		if(!isMoneyNums(price_deliver)){ msgbox("错误，送货费用不能为负数！"); return; }
	}
	var price_minus = $("#price_minus").val();
	if(price_minus!=""){
		if(!isWhiteWpace(price_minus)){ msgbox("优惠费用格式中包括空格，请重新填写！"); return; }
		if(!isMoney(price_minus)){ msgbox("错误，优惠费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
		//if(!isMoneyDims(price_deliver)){ msgbox("错误，优惠费用必须为负数！"); return; }
	}
	var price_other = $("#price_other").val();
	if(price_other!=""){
		if(!isWhiteWpace(price_other)){ msgbox("其它费用格式中包括空格，请重新填写！"); return; }
		if(!isMoney(price_other)){ msgbox("错误，其它费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
		if(!isMoneyNums(price_other)){ msgbox("错误，其它费用不能为负数！"); return; }
	}

	$("#editinfod").attr("value","正在提交..");				//锁定按钮
	$("#editinfod").attr("disabled","disabled");			//锁定按钮
	pageload();
	$("#sendto").submit();

}
