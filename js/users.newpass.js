

function editinfo()
{
	var oldpasswd	= $("#oldpasswd").val();
	var password	= $("#password").val();
	var rpassword	= $("#rpassword").val();
	if(oldpasswd==password){ msgshow("新密码和旧密码不一致，请重新填写！！");return; }
	if(oldpasswd==""){ msgshow("当前密码不能为空！");return; }
	if(password!=""){
		if(password.length<6){ msgshow("为了帐户安全，密码长度应该大于6位！");return; }
		if(rpassword==""){ msgshow("更新密码时，确认密码不能为空！");return; }
		if(password!=rpassword){ msgshow("两次密码不一致？请重新输入！");return; }
	}
	$("#editbtn").attr("value","正在提交...");		//锁定按钮
	$("#editbtn").attr("disabled","disabled");		//锁定按钮
	$("#editfrm").submit();
}
