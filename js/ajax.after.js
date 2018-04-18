var aftervar = {
	s1:'afterarea',
	s2:'afterid',
	v1:afterarea,
	v2:afterid
};
$(function(){
	threeAfter(aftervar);
});
function threeAfter(config){
	var $s1=$("#"+config.s1);
	var $s2=$("#"+config.s2);
	var v1=config.v1?config.v1:null;
	var v2=config.v2?config.v2:null;
	$.each(afterTeams,function(k,v){
		appendOptionTo($s1,k,v.val,v1);
	});
	$s1.change(function(){
		$s2.html("");
		if(this.selectedIndex==-1) return;
		var s1_curr_val = this.options[this.selectedIndex].value;
		$.each(afterTeams,function(k,v){
			if(s1_curr_val==v.val){
				if(v.items){
					$.each(v.items,function(k,v){
						appendOptionTo($s2,k,v.val,v2);
					});
				}
			}
		});
		if($s2[0].options.length==0){appendOptionTo($s2,"选择售后网点","0",v2);}
		$s2.change();
	}).change();
	function appendOptionTo($o,k,v,d){
		var $opt=$("<option>").text(k).val(v);
		if(v==d){$opt.attr("selected", "selected")}
		$opt.appendTo($o);
	}
}