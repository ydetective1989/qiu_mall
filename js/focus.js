function focus_page()
{
	var id		= $("#focus_id").val();
	var cates	= $("#focus_cates").val();
	$("#focus_div").load(S_ROOT+"focus/status?id="+id+"&cates="+cates+"&"+ Math.random());
}

function focus_add()
{
	var id		= $("#focus_id").val();
	var cates	= $("#focus_cates").val();
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"focus/addfav",
	    data: "id="+id+"&cates="+cates,             
	    success: function(rows){
	    	focus_page();
	    	if(rows=="1"){
	    		var msg = "关注成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    }
	});
}

function focus_clear(cates)
{
    art.dialog({
        title:'操作确认',
        content: '<font class="red">你确定要消除全部吗？</font>',
        lock: true,
        fixed: true,
        okValue: '确定取消',
        ok: function(){
            $.ajax({
                type: "POST",
                async: false,
                url: S_ROOT+"focus/cleard",
                data: "cates="+cates,
                success: function(rows){
                    if(cates=="dd"){
                        focus_orders(1);
                    }else if(cates=="fp"){
                        focus_invoice(1);
                    }else if(cates=="ts"){
                        focus_complaint(1);
                    }else if(cates=="gd"){
                        focus_jobs(1);
                    }
                    if(rows=="1"){
                        var msg = "取消成功！";
                        msgshow(msg);
                    }else{
                        var msg = rows;
                        msgbox(msg);
                    }
                }
            });
        },
        cancelValue: '取消',
        cancel: function(){}
    });
}

function focus_delitem(cates,id)
{
    $.ajax({
        type: "POST",
        async: false,
        url: S_ROOT+"focus/channel",
        data: "id="+id+"&cates="+cates,
        success: function(rows){
            if(cates=="dd"){
                focus_orders(1);
            }else if(cates=="fp"){
                focus_invoice(1);
            }else if(cates=="ts"){
                focus_complaint(1);
            }else if(cates=="gd"){
                focus_jobs(1);
            }
            if(rows=="1"){
                var msg = "取消成功！";
                msgshow(msg);
            }else{
                var msg = rows;
                msgbox(msg);
            }
        }
    });
}

function focus_del(cates,id)
{
	$.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"focus/channel",
	    data: "id="+id+"&cates="+cates,             
	    success: function(rows){
	    	focus_page();
	    	if(rows=="1"){
	    		var msg = "取消成功！";
		    	msgshow(msg);
	    	}else{
	    		var msg = rows;
		    	msgbox(msg);
	    	}
	    }
	});
}

function focus_orders(page){
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"focus/orders?page="+page+"&"+ Math.random(),"#focus_orders_list");
}

function focus_jobs(page){
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"focus/jobs?page="+page+"&"+ Math.random(),"#focus_jobs_list");
}

function focus_invoice(page){
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"focus/invoice?page="+page+"&"+ Math.random(),"#focus_invoice_list");
}

function focus_complaint(page){
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"focus/complaint?page="+page+"&"+ Math.random(),"#focus_complaint_list");
}






function viewexpress(id)
{
	openDialog("查看物流信息",S_ROOT+"express/views?id="+id+"&" + Math.random());
}




