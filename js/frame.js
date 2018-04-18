$(function(){
  $("#leftTree .par").bind('click',function(){
       var chdement = $(this).parent().find('.menuChild');
       if(chdement.length==0){return false;}
       if(chdement.css('display')=='none'){
          chdement.show();
     }else{
        chdement.hide();
     }

  });
});

function delTab(){
	var tab = $('#tt').tabs('getSelected');
	if(tab){
		var index = $('#tt').tabs('getTabIndex',tab);
		$('#tt').tabs('close',index);
	}
}

//动态选择菜单添加新窗口
function addTab(title,url,pid){
    var href = S_ROOT+""+url;
    var tabs = $('#tt').tabs("tabs");
    if (url){
        var content = '<iframe scrolling="auto"  frameborder="0"  src="'+href+'" width="100%" height="99%"></iframe>';
    } else {
        var content = '<div>抱歉，工程师正在建设中....</div>';
    }
    for(var i=1;i<tabs.length;i++){
        var tabc = tabs[i].panel('options');
        if(tabc.id == pid){
            var uptab = $('#tt').tabs('select',tabs[i].panel('options').title);
            $('#tt').tabs('update', {
                tab: tabs[i],
                options: {
                    id:pid,
                    title: title,
                    closable:true,
                    content:  content
                }
            });
            return false;
        }
    }
    $('#tt').tabs('add',{
        id:pid,
        title:title,
        closable:true,
        content:content
    });
}

function frmtest()
{
	alert("2222");
}


function frmtabs(urlto,showId,num,bgItemName,clsName)
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
	if(urlto!=""){
		parent.maininfo.location.href = urlto;
	}
}

function notes()
{
	var img = "";
  var num = "";
	var notenums = "";
	$.ajax({
	    type: "GET",
		async: false,
	    url: S_ROOT+"note/nums?"+Math.random(),
	    data: "",
	    success: function(rows){ notenums = rows; }
	});
	if(notenums>0){
		img+="<img src='"+S_ROOT+"images/new.gif' align='absmiddle'>";
    num+="(<font class='white bold'>"+notenums+"</font>)";
	}else{
		img+="";
  	num+="";
	}
	$("#note_img").html(img);
	$("#note_num").html(num);
	var the_timeout = setTimeout("notes();",900000);
}
//var the_timeout = setTimeout("notes();",3000);

function openie()
{
	//$("#errorie").show();
}

function closeie()
{
	//$("#errorie").hide();
	//var the_timeout = setTimeout("openie();",900000);
}
