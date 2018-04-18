function fuwuviews(urlto)
{
    parent.parent.addTab('查看信息',urlto+'&'+ Math.random(),'fuwuviews');
}

function fuwuchecked(id)
{
    openDialog("用户审核",S_ROOT+"fuwu/users?do=checked&id="+id+"&"+ Math.random());
}

function fuwucheckdo() {
    var id = $("#fuwu_userid").val();
    var cash = $("#fuwu_cash").val();
    if (cash != "") {
        if (!isMoneyNums(cash)) {
            msgbox("错误，保证金格式不正确！<br>款项格式应为正数，如：10、100或100.00");
            return;
        }
    }
    var charge = $("#fuwu_charge").val();
    if (charge != "") {
        if (!isMoneyNums(charge)) {
            msgbox("错误，标准费率格式不正确！<br>款项格式应为正数，如：10、100或100.00");
            return;
        }
    }
    var checked = $('input:radio[name=fuwu_checked]:checked').val();
    var teamid = $("#fuwu_teamid").val();
    if (checked == "1"){
        if (teamid == "") {
            msgbox("请选择用户要关联编码");
            return;
        }
    }
    var status     = $('input:radio[name=fuwu_status]:checked').val();
    var usertype   = $("#fuwu_usertype").val();
    var callname   = $("#fuwu_callname").val();
    var chargeinfo = $("#fuwu_chargeinfo").val();
    $("#btned").attr("value","正在提交..");			//锁定按钮
    $("#btned").attr("disabled","disabled");		//锁定按钮
    $.ajax({
        type: "POST",
        async: false,
        url: S_ROOT+"fuwu/users?do=checked&id="+id,
        data: "cash="+cash+"&charge="+charge+"&chargeinfo="+chargeinfo+"&teamid="+teamid+"&checked="+checked+"&status="+status+"&usertype="+usertype+"&callname="+callname,
        success: function(rows){
            closedialog();
            if(rows=="1"){
                var msg = "操作成功！";
                msgshow("操作成功，请刷新查看");
            }else{
                var msg = rows;
                msgbox(msg);
            }
            //location.reload();
        }
    });

}


function userbanks(page)
{
    var id = $("#bank_userid").val();
    if(page==""){ var page = 1; }
    ajaxurl(S_ROOT+"fuwu/users?do=banklist&id="+id+"&page="+page+"&"+ Math.random(),"#users_banks");
}

function fuwujobs(page)
{
    var id = $("#jobs_userid").val();
    if(page==""){ var page = 1; }
    ajaxurl(S_ROOT+"fuwu/jobs?id="+id+"&page="+page+"&"+ Math.random(),"#users_jobs");
}

function chargelogs(page)
{
    var id = $("#charge_userid").val();
    if(page==""){ var page = 1; }
    ajaxurl(S_ROOT+"fuwu/users?do=chargelogs&id="+id+"&page="+page+"&"+ Math.random(),"#users_charge");
}

function recharge(page)
{
    var id = $("#charge_userid").val();
    if(page==""){ var page = 1; }
    ajaxurl(S_ROOT+"fuwu/users?do=recharge&id="+id+"&page="+page+"&"+ Math.random(),"#users_recharge");
}

function chargeremove(page)
{
    var id = $("#charge_userid").val();
    if(page==""){ var page = 1; }
    ajaxurl(S_ROOT+"fuwu/users?do=chargeremove&id="+id+"&page="+page+"&"+ Math.random(),"#users_chargeremove");
}

function usercerts(page)
{
    var id = $("#charge_userid").val();
    if(page==""){ var page = 1; }
    ajaxurl(S_ROOT+"fuwu/users?do=usercerts&id="+id+"&page="+page+"&"+ Math.random(),"#users_usercerts");
}



function showjobs(id)
{
    $("#showjobs_"+id).show();
}

function fuwulogs(page)
{
    var id = $("#logs_userid").val();
    if(page==""){ var page = 1; }
    ajaxurl(S_ROOT+"fuwu/logs?id="+id+"&page="+page+"&"+ Math.random(),"#users_logs");
}

function addfuwucharge(id)
{
    openDialog("款项调整",S_ROOT+"fuwu/charge?do=add&id="+id+"&"+ Math.random());
}

function chargeadd()
{
    var userid	    = $("#fuwu_userid").val();
    var type	    = $("#fuwu_type").val();
    var price		= $("#fuwu_price").val();
    if(price=="") {
        msgbox("金额不能为空");return;
    }else{
        if(!isWhiteWpace(price)){ msgbox("费用格式中包括空格，请重新填写！"); return; }
        if(!isMoney(price)){ msgbox("错误，费用格式不正确！<br>正确格式：100，-100或100.00，-100.00"); return; }
        //if(!isMoneyNums(price)){ msgbox("错误，安装费用不能为负数！"); return; }
    }
    var redesc		= $("#fuwu_redesc").val();
    if(redesc==""){ msgbox("操作批注不能为空！"); return; }
    $("#btned").attr("value","正在提交..");			//锁定按钮
    $("#btned").attr("disabled","disabled");		//锁定按钮
    $.ajax({
        type: "POST",
        async: false,
        url: S_ROOT+"fuwu/charge?do=add&id="+userid,
        data: "type="+type+"&price="+price+"&redesc="+redesc,
        success: function(rows){
            closedialog();
            if(rows=="1"){
                var msg = "操作成功！";
                msgshow("操作成功");
            }else{
                var msg = rows;
                msgbox(msg);
            }
            chargelogs(1);
        }
    });
}

function addfuwulogs(id)
{
    openDialog("增加操作记录",S_ROOT+"fuwu/logs?do=add&id="+id+"&"+ Math.random());
}

function editfuwulogs(id)
{
    openDialog("修改操作记录",S_ROOT+"fuwu/logs?do=edit&id="+id+"&"+ Math.random());
}

function delfuwulogs(id)
{
    art.dialog({
        title:'操作确认',
        content: '<font class="red">你确定要删除这条记录吗？(一旦删除不可恢复)</font>',
        lock: true,
        fixed: true,
        okValue: '确定删除',
        ok: function(){
            $.ajax({
                type: "GET",
                async: false,
                url: S_ROOT+"fuwu/logs?do=del&id="+id,
                data: "",
                success: function(rows){
                    if(rows=="1"){
                        fuwulogs(1);
                        msgshow("操作成功");
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

function fuwulogsed()
{
    var userid	    = $("#fuwu_userid").val();
    var id		    = $("#fuwu_id").val();
    var detail		= $("#fuwu_detail").val();
    if(detail==""){ msgbox("操作批注不能为空！"); return; }
    if(id==""){
        var urlto = S_ROOT+"fuwu/logs?do=add&id="+userid;
    }else{
        var urlto = S_ROOT+"fuwu/logs?do=edit&id="+id;
    }
    //alert(urlto);return;
    $("#btned").attr("value","正在提交..");			//锁定按钮
    $("#btned").attr("disabled","disabled");		//锁定按钮
    $.ajax({
        type: "POST",
        async: false,
        url: urlto,
        data: "userid="+userid+"&detail="+detail,
        success: function(rows){
            closedialog();
            if(rows=="1"){
                var msg = "操作成功！";
                msgshow("操作成功");
            }else{
                var msg = rows;
                msgbox(msg);
            }
            fuwulogs(1);
        }
    });
}

function bankcheck(id)
{
    openDialog("银行卡审核",S_ROOT+"fuwu/users?do=bankcheck&id="+id+"&"+ Math.random());
}

function bankchecked()
{
    var id	    = $("#bank_id").val();
    var checked = $('input:radio[name=bank_checked]:checked').val();
    var urlto = S_ROOT+"fuwu/users?do=bankcheck&id="+id;
    $("#btned").attr("value","正在提交..");			//锁定按钮
    $("#btned").attr("disabled","disabled");		//锁定按钮
    $.ajax({
        type: "POST",
        async: false,
        url: urlto,
        data: "checked="+checked,
        success: function(rows){
            closedialog();
            if(rows=="1"){
                var msg = "操作成功！";
                msgshow("操作成功");
            }else{
                var msg = rows;
                msgbox(msg);
            }
            userbanks(1);
        }
    });
}









function usertypes(id)
{
    //alert(id);
    if(id=="1"){
        $("#usertype_1").hide();
        $("#usertype_2").show();
    }else{
        $("#usertype_1").show();
        $("#usertype_2").hide();
    }
}

function userfuwued()
{
    var certid      = $("#certid").val();
    var certnums    = $("#certnums").val();
    if(certnums==""){ msgbox("证件号码不能为空！"); }
    var callname    = $("#callname").val();
    if(callname==""){ msgbox("联系人姓名不能为空！"); }
    var provid      = $("#provid").val();
    var cityid      = $("#cityid").val();
    var areaid      = $("#areaid").val();
    if(areaid==""){ msgbox("省份/城市/区县需要正确设置！"); }
    var address     = $("#address").val();
    if(address==""){ msgbox("联系地址不能为空！"); }
    var mobile      = $("#mobile").val();
    if(mobile==""){ msgbox("手机号码不能为空！"); }
    if(mobile!=""){
        if(!isWhiteWpace(mobile)){ msgbox("手机号码中有空格，请检查！"); return; }
        if(mobile.length!=11){ msgbox("手机号码长度不正确，请检查！"); return; }
        if(!isMobile(mobile)){ msgbox("手机号码格式不正确，请检查！"); return; }
    }
    var qq          = $("#qq").val();
    var email       = $("#email").val();
    if(email!=""){
        if(!isWhiteWpace(email)){ msgbox("电子邮箱格式中有空格，请检查！"); return; }
        if(!checkEmail(email)){ msgbox("电子邮箱格式不正确，请检查！"); return; }
    }
    $("#editfrm").submit();
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
