function teamtoed()
{
    var name	    = $("#name").val();
    var type        = $('input:radio[name=parentid]:checked').val();
    var encoded     = $("#encoded").val();
    var provid      = $("#provid").val();
    var cityid      = $("#cityid").val();
    var areaid      = $("#areaid").val();
    var address     = $("#address").val();
    var phone       = $("#phone").val();
    if(name=="")    { msgbox("名称不能为空！"); return; }
    if(encoded=="") { msgbox("客户编码不能为空！"); return; }
    //if(cityid=="")  { msgbox("省/市必须选择");return; }
    //alert(urlto);return;
    $("#btned").attr("value","正在提交..");			//锁定按钮
    $("#btned").attr("disabled","disabled");		//锁定按钮
    $("#sendto").submit();
}
function fuwu_xls()
{
	var keyid	    = $("#keyid").val();
	var keyname	    = $("#keyname").val();
	var usertype	= $("#usertype").val();
	var checked		= $("#checked").val();
	var weixin		= $("#weixin").val();
    frmlist.location.href= S_ROOT+"fuwu/users?do=xls&keyid="+keyid+"&keyname="+keyname+"&usertype="+usertype+"&checked="+checked+"&weixin="+weixin;
}