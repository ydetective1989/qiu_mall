
//导出结算单

$(function() {
	var dates = $("#jobs_godate,#jobs_todate").datepicker({
		defaultDate: "+1w",
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "jobs_godate" ? "minDate" : "maxDate",
				instance = $(this).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not(this).datepicker( "option", option, date);
		}
	});
});

var jobsvar = {
	s1:'jobs_salesarea',
	s2:'jobs_salesid',
	s3:'jobs_saleuserid',
	v1:"",
	v2:"",
	v3:""
};
$(function(){
	threeSales(jobsvar);
});
function threeSales(config){
	var $s1=$("#"+config.s1);
	var $s2=$("#"+config.s2);
	var $s3=$("#"+config.s3);
	var v1=config.v1?config.v1:null;
	var v2=config.v2?config.v2:null;
	var v3=config.v3?config.v3:null;
	$.each(salesTeams,function(k,v){
		appendOptionTo($s1,k,v.val,v1);
	});
	$s1.change(function(){
		$s2.html("");
		if(this.selectedIndex==-1) return;
		var s1_curr_val = this.options[this.selectedIndex].value;
		$.each(salesTeams,function(k,v){
			if(s1_curr_val==v.val){
				if(v.items){
					$.each(v.items,function(k,v){
						appendOptionTo($s2,k,v.val,v2);
					});
				}
			}
		});
		if($s2[0].options.length==0){appendOptionTo($s2,"选择销售中心","0",v2);}
		$s2.change();
	}).change();
	function appendOptionTo($o,k,v,d){
		var $opt=$("<option>").text(k).val(v);
		if(v==d){$opt.attr("selected", "selected")}
		$opt.appendTo($o);
	}
}

function xls_jobs()
{
	var godate		= $("#jobs_godate").val();
	var todate		= $("#jobs_todate").val();
	var salesarea	= $("#jobs_salesarea").val();
	var salesid		= $("#jobs_salesid").val();
    var brandid		= $("#jobs_brandid").val();
    var encoded		= $("#jobs_encoded").val();
	var urlto = "godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&brandid="+brandid+"&encoded="+encoded;
    xlsfrm.location.href = S_ROOT + "xls/jobs?show=xls&" + urlto;
}


//导出销售单
$(function() {
    var dates = $("#sales_godate,#sales_todate").datepicker({
        defaultDate: "+1w",
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            var option = this.id == "sales_godate" ? "minDate" : "maxDate",
                instance = $(this).data( "datepicker" ),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
            dates.not(this).datepicker( "option", option, date);
        }
    });
});

var salevar = {
    s1:'sales_salesarea',
    s2:'sales_salesid',
    s3:'sales_saleuserid',
    v1:"",
    v2:"",
    v3:""
};
$(function(){
    threeSales(salevar);
});
function threeSales(config){
    var $s1=$("#"+config.s1);
    var $s2=$("#"+config.s2);
    var $s3=$("#"+config.s3);
    var v1=config.v1?config.v1:null;
    var v2=config.v2?config.v2:null;
    var v3=config.v3?config.v3:null;
    $.each(salesTeams,function(k,v){
        appendOptionTo($s1,k,v.val,v1);
    });
    $s1.change(function(){
        $s2.html("");
        if(this.selectedIndex==-1) return;
        var s1_curr_val = this.options[this.selectedIndex].value;
        $.each(salesTeams,function(k,v){
            if(s1_curr_val==v.val){
                if(v.items){
                    $.each(v.items,function(k,v){
                        appendOptionTo($s2,k,v.val,v2);
                    });
                }
            }
        });
        if($s2[0].options.length==0){appendOptionTo($s2,"选择销售中心","0",v2);}
        $s2.change();
    }).change();
    function appendOptionTo($o,k,v,d){
        var $opt=$("<option>").text(k).val(v);
        if(v==d){$opt.attr("selected", "selected")}
        $opt.appendTo($o);
    }
}

function xls_sales()
{
    var godate		= $("#sales_godate").val();
    var todate		= $("#sales_todate").val();
    var salesarea	= $("#sales_salesarea").val();
    var salesid		= $("#sales_salesid").val();
    var brandid		= $("#sales_brandid").val();
    var urlto = "godate="+godate+"&todate="+todate+"&salesarea="+salesarea+"&salesid="+salesid+"&brandid="+brandid;
    //alert(urlto);
    xlsfrm.location.href = S_ROOT + "xls/sales?show=xls&" + urlto;
}

function xls_product()
{
    var godate		= $("#product_godate").val();
    var todate		= $("#product_todate").val();
    var urlto = "godate="+godate+"&todate="+todate;
    //alert(urlto);
    xlsfrm.location.href = S_ROOT + "xls/products?show=xls&" + urlto;
}
