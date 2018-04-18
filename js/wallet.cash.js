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
	var urlto = "keyid="+keyid+"&keyname="+keyname+"&cateid="+cateid+"&checked="+checked+"&worked="+worked;
	frmlist.location.href = S_ROOT + "wallet/cash?show=lists&" + urlto;
}



function addchecked(id)
{
    openDialog("提现审核",S_ROOT+"wallet/cash?do=checked&id="+id+"&"+ Math.random());
}

function addpay(id)
{
    openDialog("提现付款",S_ROOT+"wallet/cash?do=pay&id="+id+"&"+ Math.random());
}

function addrebut(id)
{
    openDialog("提现驳回",S_ROOT+"wallet/cash?do=rebut&id="+id+"&"+ Math.random());
}

function dochecked()
{
    var id      = $("#charge_id").val();
    var checked = $('input:radio[name=charge_checked]:checked').val();
    //alert(checked);
    $("#btned").attr("value","正在提交..");			//锁定按钮
    $("#btned").attr("disabled","disabled");		//锁定按钮
    $.ajax({
        type: "POST",
        async: false,
        url: S_ROOT+"wallet/cash?do=checked&id="+id,
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
function dopay()
{
    var id      = $("#charge_id").val();
    //alert(id);
    var payed = $('input:radio[name=cash_payed]:checked').val();
    //alert(payed);
    var payinfo  = $("#payinfo").val();
    //alert(payinfo);
    $("#btned").attr("value","正在提交..");			//锁定按钮
    $("#btned").attr("disabled","disabled");		//锁定按钮
    $.ajax({
        type: "POST",
        async: false,
        url: S_ROOT+"wallet/cash?do=pay&id="+id,
        data: "payed="+payed+"&payinfo="+payinfo,
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



function dorebut()
{
  var id      = $("#charge_id").val();
  //alert(id);
  var checked = $('input:radio[name=cash_rebuted]:checked').val();
  //alert(rebuted);
  $("#btned").attr("value","正在提交..");			//锁定按钮
  $("#btned").attr("disabled","disabled");		//锁定按钮
  $.ajax({
      type: "POST",
      async: false,
      url: S_ROOT+"wallet/cash?do=rebut&id="+id,
      data: "checked="+checked,
      success: function(rows){
          closedialog();
          if(rows=="1"){
              var msg = "操作成功！";
              msgshow("操作成功，请刷新查看");
          }else{
              var msg = rows;
              alert(msg);
              msgbox(msg);
          }
          //location.reload();
      }
  });
}





function chargelogs_xls()
{
    var keyid       = $("#keyid").val();
    var keyname     = $("#keyname").val();
    var usertype    = $("#usertype").val();
    var type        = $("#type").val();
    var godate      = $("#godate").val();
    var todate      = $("#todate").val();
    frmlist.location.href= S_ROOT+"wallet/record?do=xls&keyid="+keyid+"&keyname="+keyname+"&usertype="+usertype+"&type="+type+"&godate="+godate+"&todate="+todate;
}
