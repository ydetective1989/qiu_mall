function editlists()
{
	$("#editbtn").attr("value","正在提交...");			//锁定按钮
	$("#editbtn").attr("disabled","disabled");			//锁定按钮
	$("#editlist").submit();
}

function editinfo()
{
	var username = $("#username").val();
	if(username==""){ tipmsg("用户帐号不能为空，请检查"); return; }
	var name = $("#name").val();
	if(name==""){ tipmsg("姓名不能为空，请检查"); return; }
	var worknum = $("#worknum").val();
	if(worknum==""){ tipmsg("员工编号不能为空，请检查"); return; }
	var mobile = $("#mobile").val();
	if(mobile!=""){ 
		if(!isWhiteWpace(mobile)){ tipmsg("手机号码中有空格，请检查！"); return; }
		if(mobile.length!=11){ tipmsg("手机号码长度不正确，请检查！"); return; }
		if(!isMobile(mobile)){ tipmsg("手机号码格式不正确，请检查！"); return; }
	}
	var email = $("#email").val();
	if(email!=""){
		if(!isWhiteWpace(email)){ tipmsg("电子邮箱格式中有空格，请检查！"); return; }
		if(!checkEmail(email)){ tipmsg("电子邮箱格式不正确，请检查！"); return; }
	}	
	$("#editbtn").attr("value","正在提交...");		//锁定按钮
	$("#editbtn").attr("disabled","disabled");		//锁定按钮
	$("#editfrm").submit();
}

function userslock()
{
	var disabled = $("#username").attr("disabled");
	if(disabled=="disabled"){
	  　　$('#username').removeAttr("disabled");//去除input元素的disabled属性
	}else{
		 $('#username').attr("disabled","disabled")//将input元素设置为disabled
	}
}

function grouped(userid,groupid)
{
	//alert(S_ROOT);
	$("#levelspace").load(S_ROOT+"system/users?do=level&userid="+userid+"&groupid="+groupid+"&"+Math.random());
}



/**
var tel = $(“input#phone”).val();
var patrn=/^[0-9]{11}$/;
if(patrn.test(tel)){
alert(“手机号正确”);
}else{
alert(“手机号错误”);
}

var email = $(“input#email “).val();
reg=/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/gi;
if(reg.test(email)){
	alert(” 邮箱正确”);
}else{
	alert(“邮箱错误”);
}
**/