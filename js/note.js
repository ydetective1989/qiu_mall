
function checknote(id)
{
	$.ajax({  
	    type: "GET",  
		async: false,
	    url: S_ROOT+"note/checknote?id="+id,
	    data: "",             
	    success: function(rows){ 
	    	if(rows=="1"){ 
	    		location.reload();
	    	}else{
	    		msgbox(rows);
	    	}
	    }
	});
}

function note_allchecked()
{

	art.dialog({
		title:'操作确认',
		content: '你确认将所有未读信息标为已读吗？',
		lock: true,
		fixed: true,
	    okValue: '确定审核',
	    ok: function(){
			$.ajax({
			    type: "POST",  
				async: false,
			    url: S_ROOT+"note/allnote",
			    data: "",             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	msgshow("操作成功");
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

function note_checked()
{

	art.dialog({
		title:'操作确认',
		content: '你确认要进行批量标为已读吗？',
		lock: true,
		fixed: true,
	    okValue: '确定审核',
	    ok: function(){
	    	
	    	var chk_arr =[];  
	    	$('input[name="selected"]:checked').each(function(){  
	    		chk_arr.push($(this).val());  
	    	});
	    	if(chk_arr.length==0){ msgshow('请选择已读内容');return; }
			$.ajax({
			    type: "POST",  
				async: false,
			    url: S_ROOT+"note/selnote",
			    data: "id="+chk_arr,             
			    success: function(rows){ 
			    	if(rows=="1"){ 
				    	msgshow("操作成功");
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