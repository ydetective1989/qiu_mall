(function() {
/*
var msgOptions = {
	modal: false,
	buttons:{
		'OK': function(ev) {
			$(this).dialog('close');
		},
		'CLOSE': function() {
			top.location.href= S_ROOT+'orders';
		}
	}
};
*/
	
	//alert消息提示
	jQuery.alert = function(message, options){
	
		settings = jQuery.extend({
			id: 'alert',				//消息窗口自定义ID
			title: '信息提示',			//消息窗口标题
			buttons:{
				'确定': function(ev) {
					//这里可以调用其他公共方法。
					$(this).dialog('close');
				}/*,
				'取消': function() {
					//这里可以调用其他公共方法。
					$(this).dialog('close');
				}*/
			},
			autoOpen:	true,
			modal:		true,			//是否未模态窗口，默认为false
			show:		'blind',		//打开消息窗口效果，默认为 blind OR null
			hide:		'explode',		//关闭消息窗口效果，默认为 explode OR null
			position:	'center',		//消息窗口位置，默认为 center
			draggable:	false,			//是否可以托动
			stack:		true,			//是否可以覆盖其它对话框。默认为true。
			resizable:	false,			//设置对话框是否可以重置大小。
			minHeight:	'100',			//最小消息高度
			minWidth:	'300',			//最小消息杠默宽度
			lineHeight:	'26px',
			fontSize:	'14px',
			textAlign:	'center',
			fontWeight:	'bold',
			closeOnEscape:false,			//禁止Esc键
			close	:	function(event, ui) {  $(this).dialog("destroy"); } // 关闭时销毁
		},options);
	
	    dialogdiv = $("<div style=\"padding-top:10px;\"><p></p></div>");//这部分可根据情况自定义
	    //todo:图标、高度、宽度、弹出模式等都应该可以设置。
	    dialogdiv.css({
			'text-align':settings.textAlign,
			'font-size':settings.fontSize,
			'line-height':settings.lineHeight,
			'font-weight':settings.fontWeight
	    });
	
		$dialogs = dialogdiv.clone();
		$dialogs.children().filter("p").html(dialogdiv.children().filter("p").html() + message); //增加自定义消息
		$dialogs.dialog({
			autoOpen:	true,
			title:		settings.title,
			buttons:	settings.buttons,
			modal:		settings.modal,
			show:		settings.show,
			hide:		settings.hide,
			position:	settings.position,
			draggable:	settings.draggable,
			stack:		settings.stack,
			resizable:	settings.resizable,
			minHeight:	settings.minHeight,
			minWidth:	settings.minWidth,
			closeOnEscape:settings.closeOnEscape,
			close	:	settings.close
		});
	
		$('a.ui-dialog-titlebar-close').hide();
	
	}
	
	//dialog urlto
	jQuery.dialog = function(title,urlto,options){
	
		settings = jQuery.extend({
			id: 'showdialog',		//消息窗口自定义ID
			title: title,			//消息窗口标题
			buttons:{
				'确定': function(ev) {
					//这里可以调用其他公共方法。
					$(this).dialog('close');
				}/*,
				'取消': function() {
					//这里可以调用其他公共方法。
					$(this).dialog('close');
				}*/
			},
			autoOpen:	true,
			modal:		true,			//是否未模态窗口，默认为false
			show:		'blind',		//打开消息窗口效果，默认为 blind OR null
			hide:		'explode',		//关闭消息窗口效果，默认为 explode OR null
			position:	'center',		//消息窗口位置，默认为 center
			draggable:	true,			//是否可以托动
			stack:		true,			//是否可以覆盖其它对话框。默认为true。
			resizable:	false,			//设置对话框是否可以重置大小。
			minHeight:	'100',			//最小消息高度
			minWidth:	'300',			//最小消息杠默宽度
			width	:	'auto',
			height	:	'auto',
			lineHeight:	'26px',
			fontSize:	'14px',
			textAlign:	'center',
			fontWeight:	'bold',
			closeOnEscape:true,			//禁止Esc键
			close	:	function(event, ui) {  $(this).dialog("destroy"); } // 关闭时销毁
			
		},options);
		//alert(urlto);


	    dlgDiv = $("<div style=\"padding-top:0px;\"><p></p></div>");//这部分可根据情况自定义
	    //todo:图标、高度、宽度、弹出模式等都应该可以设置。
		dlgDiv.css({		'text-align':settings.textAlign,
			'font-size':settings.fontSize,
			'line-height':settings.lineHeight,
			'font-weight':settings.fontWeight
	    });
	
		$dialogs = dlgDiv.clone();

		//dialog
		$.ajax({
			type:	"GET",
			async:	false,
			url:	urlto,
			data: 	"",
			success:function(data){
				content = data;
			}
		});
	
		$dialogs.children().filter("p").html(dlgDiv.children().filter("p").html() + content); //增加自定义消息
		$dialogs.dialog({
			autoOpen:	settings.autoOpen,
			title:		settings.title,
			buttons:	settings.buttons,
			modal:		settings.modal,
			show:		settings.show,
			hide:		settings.hide,
			position:	settings.position,
			draggable:	settings.draggable,
			stack:		settings.stack,
			resizable:	settings.resizable,
			minHeight:	settings.minHeight,
			minWidth:	settings.minWidth,
			width	:	'auto',
			height	:	'auto',
			closeOnEscape:settings.closeOnEscape,			//禁止Esc键
		    close	: 	settings.close
		});
	
		$('a.ui-dialog-titlebar-close').hide();
	
	}

//--对话框辅助对象-en
})(jQuery);