document.onkeydown = function()
{
	if(event.keyCode == 13)
	{
		login();
	}
}

function login()
{
	var username = $("#username").val();
	var password = $("#password").val();
	var authnum  = $("#authnum").val();
	if(username==""){ msgshow("错误，用户名不能为空！"); return; }
	if(password==""){ msgshow("错误，密码不能为空！"); return; }
	if(authnum=="") { msgshow("错误，验证码不能为空！"); return; }
	//$.blockUI();
	$("#loginsubmit").submit();

}

function getAuth()
{
	document.getElementById("authnums").src = S_ROOT+"authimg?" + Math.random();
}

function er(){
	$.ajax({
		type:	"POST",
		async:	false,
		url:	S_ROOT+"api/login",
		data: 	"username="+username+"&password="+password+"&authnum="+authnum,
		success:function(rows){
			msg = rows;
		}
	});
	if(msg == 1){
		top.location.href=S_ROOT;
	}else{
		$.unblockUI();
		getAuth();
		msgshow(msg);
	}
}