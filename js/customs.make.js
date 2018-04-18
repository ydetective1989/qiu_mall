function search()
{
	var type	 = $("#type").val();
	var name	 = $("#name").val();
	var mobile	 = $("#mobile").val();
	var phone	 = $("#phone").val();
	var company	 = $("#company").val();
	var urlto = "type="+type+"&name="+name+"&mobile="+mobile+"&phone="+phone+"&company="+company;
	frmlist.location.href = S_ROOT + "customs/make?do=lists&" + urlto;
}

function editinfo()
{
	var type	 = $("#type").val();
	var name	 = $("#name").val();
	var mobile	 = $("#mobile").val();
	var phone	 = $("#phone").val();
	var company	 = $("#company").val();
	var areaid	 = $("#areaid").val();
	if(type==""){ msgbox("类别选择不能为空！"); return; }
	if(areaid==""){ msgbox("请选择客户的省份城市！"); return; }
	if(name==""){ msgbox("联系人姓名不能为空！"); return; }
	if(phone==""&&mobile==""){
		msgbox("联系方式手机与座机必须填写一项"); return;
	}else{
		if(mobile!=""){
			if(!isWhiteWpace(mobile)){ 	msgbox("手机号码中有空格，请检查！"); return; }
			if(mobile.length!=11){ 		msgbox("手机号码长度不正确，请检查！"); return; }
			if(!isMobile(mobile)){ 		msgbox("手机号码格式不正确，请检查！"); return; }
		}
	}
	$("#sendto").submit();
	
}