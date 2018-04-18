function focustabs(showId,num,bgItemName,clsName)
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

$(document).keydown(function(){
	if(event.keyCode == 13){  search(''); }
});

function search(checked)
{
	$("#checked").attr("value",checked);
	var sokey 	= $("#sokey").val();
	var fixed	= $("#fixed").val();
	var type	= $("#type").val();
	var urlto = "checked="+checked+"&fixed="+fixed+"&sokey="+sokey+"&type="+type;
	frmlist.location.href = S_ROOT + "assets/lists?do=list&" + urlto;
}