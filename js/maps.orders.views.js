
var map = new BMap.Map("markers_container");
var point = new BMap.Point(116.403974, 39.913935);
//开启滚轮控制
map.enableScrollWheelZoom();
//添加控制栏
var opts = {anchor: BMAP_ANCHOR_TOP_LEFT, offset: new BMap.Size(10, 10)};
map.addControl(new BMap.NavigationControl(opts));
//缩略图控件
map.addControl(new BMap.OverviewMapControl());
//地图类型
//map.addControl(new BMap.MapTypeControl());

//初始化地图位置
map.centerAndZoom(point,15);
//map.addEventListener("tilesloaded",function(){alert("地图加载完毕");});

//alert(panTopoint);
//map.centerAndZoom(panTopoint,15);

var myIcon = new BMap.Icon("markets.gif", new BMap.Size(25, 25), {  
// 指定定位位置。  
// 当标注显示在地图上时，其所指向的地理位置距离图标左上  
   // 角各偏移10像素和25像素。您可以看到在本例中该位置即是  
   // 图标中央下端的尖角位置。  
    offset: new BMap.Size(25, 25)
   // 设置图片偏移。  
   // 当您需要从一幅较大的图片中截取某部分作为标注图标时，您  
   // 需要指定大图的偏移位置，此做法与css sprites技术类似。  
   //imageOffset: new BMap.Size(0,0-index*25)   // 设置图片偏移  
 });   
// 创建标注对象并添加到地图

//var panTopoint_lng = $("#mapmarkers_lng").val();
//var panTopoint_lat = $("#mapmarkers_lat").val();
//if(panTopoint_lat&&panTopoint_lng){
//    var point = new BMap.Point(panTopoint_lng, panTopoint_lat);
//    map.panTo(point);
//}

var marker = new BMap.Marker(point,{
	 enableMassClear: false,
	 raiseOnDrag: true//,
	 //icon: myIcon
});
map.addOverlay(marker);

var gc = new BMap.Geocoder();
//坐标选择
map.addEventListener("click", function(e){
	if(!(e.overlay)){
		var ep = e.point;
		//map.clearOverlays();
		marker.show();
		marker.setPosition(ep);
		//反解析地址信息
	    gc.getLocation(ep, function(rs){
	        var addComp = rs.addressComponents;
	        var marker_title = ""+addComp.province;
	        var market_address = "" + addComp.city + "" + addComp.district + "" + addComp.street + "" + addComp.streetNumber;
			//移到新中心点
			map.panTo(new BMap.Point(e.point.lng, e.point.lat));
			var opts = {  
				 width : 250,			// 信息窗口宽度  
				 height: 80,			// 信息窗口高度  
				 title : marker_title   // 信息窗口标题
			}  
			var infoWindow = new BMap.InfoWindow(market_address, opts);		// 创建信息窗口对象  
			marker.openInfoWindow(infoWindow,map.getCenter());				// 打开信息窗口
	    });
		setResult(e.point.lng, e.point.lat);
	}

});

function search()
{
	var address = $("#markers_keyword").val();
	var local = new BMap.LocalSearch("全国",{  
		 renderOptions: {  
		   map: map,  
		   autoViewport: true,  
		   selectFirstResult: false  
		 },  
		 pageCapacity: 8  
	});
	local.setSearchCompleteCallback(function(results){
		if(local.getStatus() !== BMAP_STATUS_SUCCESS){
			msgbox("没有查询到相关结果，请重新修改搜索条件！");
		}else{
			marker.hide();
		}
	});	
	local.search(address);
}

//记录坐标
function setResult(lng, lat){
	var mapmarks = lng + ", " + lat;
	$("#markers_point").attr("value",mapmarks);
}

function mapsbutton()
{
	var id = $("#mapmarkers_ordersid").val();
	//alert(id);return;
	var point = $("#markers_point").val();
	if(point==""){ msgbox("坐标没有选择好！");return; }
	var address = $("#markers_address").val();
	if(address==""){ msgbox("地址信息不能为空！");return; }
	$("#mapbtnd").attr("value","正在提交..");			//锁定按钮
	$("#mapbtnd").attr("disabled","disabled");		//锁定按钮
	//return;
	$.ajax({
	    type: "POST",  
		async: false,
	    url: S_ROOT+"maps/orders?show=views&id="+id,
	    data: "point="+point+"&address="+address,             
	    success: function(rows){
	    	if(rows=="1"){
	    		var msg = "坐标设置操作成功！";
	    	}else{
	    		var msg = rows;
	    	}
	    	msgbox(msg);
	    	parent.frmlist.location.reload();
	    }
	});
}



