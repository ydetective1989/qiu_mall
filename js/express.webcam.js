	
function camersto(id)
{
	art.dialog({
		id: 'dialog_yws',
		//esc: false,
		lock: true,
		//fixed: true,
		title: '发货拍照',
	    content: "<div style='width:501px;height:320px;'><iframe width=\"100%\" style=\"height:100%;\" scrolling=\"no\" noresize=\"noresize\" frameborder=\"no\"  src=\""+S_ROOT+"express/camera?id="+id+"\"></iframe></div>",
	    padding: '0px'
	});
	
}

function prints(id)
{
	parent.parent.addTab("打印发货单","express/prints?id="+id+"&"+ Math.random(),"printexp");
	//window.open(S_ROOT+"express/prints?id="+id);
}


