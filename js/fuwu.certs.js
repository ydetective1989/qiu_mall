function jobstabs(showId,num,bgItemName,clsName)
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

function search(checked)
{
    var checked  = checked;
    $("#checked").attr("value",checked);
	var keyid    = $("#keyid").val();
	var keyname	 = $("#keyname").val();
	var cateid	 = $("#cateid").val();
	var worked	 = $("#worked").val();
    var type     = $("#type").val();
    var dateline = $("#dateline").val();
	var urlto = "keyid="+keyid+"&keyname="+keyname+"&checked="+checked+"&type="+type+"&dateline="+dateline;
	frmlist.location.href = S_ROOT + "fuwu/certs?show=lists&" + urlto;
}



function addchecked(id)
{
    openDialog("认证审核",S_ROOT+"fuwu/certs?do=checked&id="+id+"&"+ Math.random());
}


function dochecked()
{
    var id      = $("#certs_id").val();
    var checked = $('input:radio[name=certs_checked]:checked').val();
    $("#btned").attr("value","正在提交..");			//锁定按钮
    $("#btned").attr("disabled","disabled");		//锁定按钮
    $.ajax({
        type: "POST",
        async: false,
        url: S_ROOT+"fuwu/certs?do=checked&id="+id,
        data: "checked="+checked,
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
