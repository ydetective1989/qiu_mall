function viewmaps(id)
{
	$.ajax({  
	    type: "GET",  
		async: false,
	    url: S_ROOT+"orders/viewmaps?"+ Math.random(),
	    data: "",             
	    success: function(rows){ 
	    	art.dialog({
	    		id: 'dialog_yws',
	    		//esc: false,
	    		lock: true,
	    		fixed: true,
	    		title: '查看地图信息',
	    	    content: rows,
	    	    padding: '5px'
	    	})
	    }
	});
	maploader();
}

function maploader()
{
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
	
	var panTopoint_lng = $("#mapmarkers_lng").val();
	var panTopoint_lat = $("#mapmarkers_lat").val();
	if(panTopoint_lat&&panTopoint_lng){
	    var point = new BMap.Point(panTopoint_lng, panTopoint_lat);
	    map.panTo(point);
	}
	
	var marker = new BMap.Marker(point,{
		 enableMassClear: false,
		 raiseOnDrag: true//,
		 //icon: myIcon
	});
	map.addOverlay(marker);


}