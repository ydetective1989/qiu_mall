
function xls_jobsmoitor()
{
    var godate		= $("#godate").val();
    var todate		= $("#todate").val();
    var provid		= $("#provid").val();
    var areaid		= $("#areaid").val();
    var cityid		= $("#cityid").val();
    var areaid		= $("#areaid").val();
    var salesarea		= $("#salesarea").val();
    var salesid		= $("#salesid").val();
    var afterarea		= $("#afterarea").val();
    var afterid		= $("#afterid").val();
    var urlto = "godate="+godate+"&todate="+todate;

  	$("#xlsbtn").attr("value","正在导出..");			//锁定按钮
  	$("#xlsbtn").attr("disabled","disabled");		//锁定按钮
    frminfo.location.href = S_ROOT + "xls/jobsmonitor?show=xls&" + urlto;

}
