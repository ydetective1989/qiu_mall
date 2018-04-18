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

$(function() {
	var dates = $("#godate,#todate").datepicker({
		defaultDate: "+1w",
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "godate" ? "minDate" : "maxDate",
				instance = $(this).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not(this).datepicker( "option", option, date);
		}
	});
});

$(document).keydown(function(){
	if(event.keyCode == 13){  search(''); }
});

function checkbtn()
{
	var id	= $("#id").val();
	art.dialog({
		title:'审核操作',
		content: '<font class="red">确定要进行审核/取消操作吗？</font>',
		lock: true,
		fixed: true,
	    okValue: '确定操作',
	    ok: function(){
			$.ajax({  
			    type: "GET",  
				async: false,
			    url: S_ROOT+"assets/checked?id="+id,
			    data: "",             
			    success: function(rows){ 
			    	if(rows=="1"){
			    		parent.frmlist.location.reload();
			    		location.reload();
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

function search(checked)
{
	$("#checked").attr("value",checked);
	var sokey 	= $("#sokey").val();
	var fixed	= $("#fixed").val();
	var type	= $("#type").val();
	var purchase= $("#purchase").val();
	var employ	= $("#employ").val();
	var urlto = "checked="+checked+"&sokey="+sokey+"&fixed="+fixed+"&type="+type+"&purchase="+purchase+"&employ="+employ;
	frmlist.location.href = S_ROOT + "assets/admin?" + urlto;
}

function xls()
{
	var checked = $("#checked").val();
	var sokey 	= $("#sokey").val();
	var fixed	= $("#fixed").val();
	var type	= $("#type").val();
	var purchase= $("#purchase").val();
	var employ	= $("#employ").val();
	var urlto = "checked="+checked+"&sokey="+sokey+"&fixed="+fixed+"&type="+type+"&purchase="+purchase+"&employ="+employ;
	frmlist.location.href = S_ROOT + "assets/xls?" + urlto;
}