
$(function() {

  $('.tag-my .tag').live("click",function(){ 
     if($(this).hasClass("disable")){
         return false;
     }
     var ordersid = $("#tags_ordersid").val();
     var id = $(this).attr('alt');  //用户php删除数据库中的此人的此标签
     $.ajax({  
		    type: "GET",  
			async: false,
	        url:S_ROOT+"customs/tags?do=del&tagid="+id+"&ordersid="+ordersid+"&customsid="+tag_customsid,
		    data: "",             
		    success: function(rows){}
	 });
     $(this).remove();
     load_tabtag();
  });

  $('.tag-list .tag').live("click",function(){
     if($(this).hasClass("disable")){
       return false;
     }
     //var str = $(this).text();
     var ordersid = $("#tags_ordersid").val();
     var id = $(this).attr('alt'); 
     //var text = str.substring(1,str.length); 
     //var str = '<a href="javascript:void()" class="tag" alt="'+id+'"><span>'+text+'<em class="icon-close">x</em></span></a>'
     //$('.tag-my').append(str);
	$.ajax({  
		type: "GET",  
		async: false,
		url:S_ROOT+"customs/tags?do=add&tagid="+id+"&ordersid="+ordersid+"&customsid="+tag_customsid,
		data: "",             
		success: function(rows){}
	});
     $(this).addClass("disable");
     load_mytags();
  });
  
});

function load_mytags()
{
	$("#mytags_div").load(S_ROOT+"customs/tags?do=mytags&customsid="+tag_customsid+"&"+Math.random());
}

function load_tabtag()
{
	$("#tags_div").load(S_ROOT+"customs/tags?do=tagtab&customsid="+tag_customsid+"&"+Math.random());

}



