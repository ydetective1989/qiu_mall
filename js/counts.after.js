

function countsd()
{
	$("#frminfo").contents().find('#showed').empty();
	$("#frminfo").contents().find('#showed').append("<div style=\"text-align:center;color:red;\"><br>正在统计数据......</div>");

	var afterarea	= $("#afterarea").val();
	var afterid		= $("#afterid").val();
	$("#frminfo").contents().find('#showed').load(S_ROOT+"counts/after?show=1&afterarea="+afterarea+"&afterid="+afterid);
}


