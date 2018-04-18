function yunctabs(showId,num,bgItemName,clsName) {
    var clsNameArr = new Array(2)
    if (clsName.indexOf("|") <= 0) {
        clsNameArr[0] = clsName
        clsNameArr[1] = ""
    } else {
        clsNameArr[0] = clsName.split("|")[0]
        clsNameArr[1] = clsName.split("|")[1]
    }

    for (i = 1; i <= num; i++) {
        if (document.getElementById(bgItemName + i) != null)
            document.getElementById(bgItemName + i).className = clsNameArr[1]
        if (i == showId) {
            if (document.getElementById(bgItemName + i) != null)
                document.getElementById(bgItemName + i).className = clsNameArr[0]
        }
    }
}

function yun_search(id)
{
    $("#charge_status").attr("value",id);
    var status = $("#charge_status").val();
    var ordersid = $("#charge_ordersid").val();
    var ctype = $("#charge_ctype").val();
    var type = $("#charge_type").val();
    var urlto = "status="+status+"&ordersid="+ordersid+"&ctype="+ctype+"&type="+type;
    frmlist.location.href = S_ROOT + "yun/clockd?show=lists&" + urlto;

}

function statusyun(id)
{
    openDialog("业务激活状态",S_ROOT+"yun/status?id="+id+"&"+ Math.random());
}


function statusyuned()
{
    var id			= $("#yun_id").val();
    var yun_status	= $(":radio[name='yun_status']:checked").val();
    var yun_detail	= $("#yun_detail").val();

    if(yun_status==""){
        msgbox("请选择激活状态");
        return;
    }

    $("#yunbtn").attr("value","正在提交..");				//锁定按钮
    $("#yunbtn").attr("disabled","disabled");			//锁定按钮

    $.ajax({
        type: "POST",
        async: false,
        url: S_ROOT+"yun/status?id="+id,
        data: "status="+yun_status+"&detail="+yun_detail,
        success: function(rows){
            closedialog();
            if(rows=="1"){
                var msg = "操作成功！";
                msgshow(msg);
                location.reload();
            }else{
                var msg = rows;
                msgbox(msg);
            }
        }
    });

    return;
}