function editbrand()
{
	var name = $("#name").val();
	if(name==""){ msgshow("品牌名称不能为空"); return; }
	var tags = $("#tags").val();
	if(name==""){ msgshow("品牌英文标签不能为空"); return; }
	$("#editbtn").attr("value","正在提交...");		//锁定按钮
	$("#editbtn").attr("disabled","disabled");		//锁定按钮
	$("#editfrm").submit();
}

function editcates()
{
	var name = $("#name").val();
	if(name==""){ msgshow("分类名称不能为空"); return; }
	var tags = $("#tags").val();
	if(tags==""){ msgshow("分类英文标签不能为空"); return; }
	$("#editbtn").attr("value","正在提交...");		//锁定按钮
	$("#editbtn").attr("disabled","disabled");		//锁定按钮
	$("#editfrm").submit();
}

function searched()
{
		var sotype = $("#sotype").val();
		var keyval = $("#keyval").val();
		var categoryid = $("#categoryid").val();
		var brandid = $("#brandid").val();
		var checked = $("#checked").val();
		var urlto = "sotype="+sotype+"&keyval="+keyval+"&categoryid="+categoryid+"&brandid="+brandid+"&checked="+checked;
		frminfo.location.href = S_ROOT + "cpinfo/product?show=lists&" + urlto;
}

function editproduct()
{
		var title = $("#title").val();
		if(title==""){ msgshow("商品名称不能为空"); return; }
		var erpname = $("#erpname").val();
		if(erpname==""){ msgshow("ERP名称不能为空"); return; }
		var encoded = $("#encoded").val();
		if(encoded==""){ msgshow("商品编码不能为空"); return; }
		var models = $("#models").val();
		if(models==""){ msgshow("商品型号不能为空"); return; }
		var categoryid = $("#categoryid").val();
		if(categoryid==""){ msgshow("请选择商品分类"); return; }
		var brandid = $("#brandid").val();
		if(brandid==""){ msgshow("请选择商品品牌"); return; }
		var price_users_a = $("#price_users_a").val();
		if(price_users_a==""){
			msgshow("请填写市场价格"); return;
		}else{
			if(!isWhiteWpace(price_users_a)){ msgshow("市场价格中包括空格，请重新填写！"); return; }
			if(!isMoney(price_users_a)){ msgshow("错误，市场价格不正确！<br>正确格式：100或100.00"); return; }
			if(!isMoneyNums(price_users_a)){ msgshow("错误，市场价格不能为负数！"); return; }
		}
		var price_users_c = $("#price_users_c").val();
		if(price_users_c==""){
			msgshow("请填写销售价格"); return;
		}else{
			if(!isWhiteWpace(price_users_c)){ msgshow("销售价格中包括空格，请重新填写！"); return; }
			if(!isMoney(price_users_c)){ msgshow("错误，销售价格不正确！<br>正确格式：100或100.00"); return; }
			if(!isMoneyNums(price_users_c)){ msgshow("错误，销售价格不能为负数！"); return; }
		}
		$("#editbtn").attr("value","正在提交...");		//锁定按钮
		$("#editbtn").attr("disabled","disabled");		//锁定按钮
		$("#editfrm").submit();
}
function editinvoice()
{
	var name = $("#name").val();
	if(name==""){ msgshow("公司名称不能为空"); return; }
	var encoded = $("#encoded").val();
	if(encoded==""){ msgshow("公司编码不能为空"); return; }
	$("#editbtn").attr("value","正在提交...");		//锁定按钮
	$("#editbtn").attr("disabled","disabled");		//锁定按钮
	$("#editfrm").submit();
}
