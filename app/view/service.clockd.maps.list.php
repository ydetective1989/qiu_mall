<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/service.clockd.maps.js?<?php echo date("Ymd");?>"></script>
<style type="text/css">#container { width:100px; height:100px; }</style>
</head>
<body scroll="no">
<table width="100%" height="100%">
  <tr>
	<td height="100%" class="map_container" id="container"></td>
  </tr>
</table>

<script type="text/javascript" src="<?php echo $S_ROOT;?>js/baidu.maps.js?<?php echo date("YmdH")?>"></script>

<script type="text/javascript">

    <?php
    $point_lng = ($info["pointlng"])?$info["pointlng"]:"116.404";
    $point_lat = ($info["pointlat"])?$info["pointlat"]:"39.915";
    ?>

	var map = new BMap.Map("container");
	var point = new BMap.Point(<?php echo $point_lng;?>, <?php echo $point_lat;?>);
	//开启滚轮控制
	map.enableScrollWheelZoom();
	//添加控制栏
	var opts = {anchor: BMAP_ANCHOR_TOP_LEFT, offset: new BMap.Size(10, 10)};
	map.addControl(new BMap.NavigationControl(opts));
	//缩略图控件
	map.addControl(new BMap.OverviewMapControl());
	//地图类型
	//map.addControl(new BMap.MapTypeControl());
	//map.disableScrollWheelZoom()
	//初始化地图位置
	map.centerAndZoom(point,13);
	
	<?php if($info["pointlng"]&&$info["pointlat"]){?>
	//alert("2");
	var vpoint = map.getBounds();
	var vp1 = vpoint.getSouthWest();
	var vp2 = vpoint.getNorthEast();
	var pointarrs = vp1.lng +"||"+ vp2.lng +"||"+ vp1.lat +"||"+ vp2.lat;
	showinfo(pointarrs);
	<?php }?>
	
	//发生操作事件时，独发信息
	map.addEventListener("dragend",function(e){
		//alert("地图移动操作");
		var b = map.getBounds();
		var p1 = b.getSouthWest();
		var p2 = b.getNorthEast();
		var pointarra = p1.lng +"||"+ p2.lng +"||"+ p1.lat +"||"+ p2.lat;
		//alert(pointarra);
		showinfo(pointarra);
	});

	map.addEventListener("zoomend",function(e){
		//alert("地图放大操作");
		//var b = map.getBounds();
		//var p1 = b.getSouthWest();
		//var p2 = b.getNorthEast();
		//var pointarrb = p1.lng +"||"+ p2.lng +"||"+ p1.lat +"||"+ p2.lat;
		//alert(pointarrb);
		//showinfo(pointarrb);
	});	

    <?php if($info){?>
	var myIcon = new BMap.Icon("<?php echo $S_ROOT;?>images/destar.gif", new BMap.Size(25, 25), {  
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
	var marker = new BMap.Marker(point,{
		 icon: myIcon
	});
	var iw_opts = {  
	   width : 220,     // 信息窗口宽度  
	   height: 80,     // 信息窗口高度  
	   title : "<?php echo $info["datetime"]?> - 订单编号:<?php echo $info["ordersid"]?>"  // 信息窗口标题  
	}

	var infoWindow = new BMap.InfoWindow("<?php echo plugin::cutstr($info["clockinfo"],20,"")?> <a href=\"javascript:void(0)\" class=\"ured\" onclick=\"parent.parent.addTab('回访<?php echo (int)$info["ordersid"];?>','service/clockd?do=views&id=<?php echo base64_encode((int)$info["id"]);?>&ordersid=<?php echo base64_encode((int)$info["ordersid"]);?>','clockd')\">[立即提醒]</a>", iw_opts);  // 创建信息窗口对象
	
	//var infoWindow = new BMap.InfoWindow("<?php echo plugin::cutstr($info["clockinfo"],20,"")?> <a href='<?php echo $S_ROOT;?>service/clockd?do=views&id=<?php echo base64_encode((int)$info["id"]);?>&ordersid=<?php echo base64_encode((int)$info["ordersid"]);?>' class='ured' target='frminfo'>[立即提醒]</a>", iw_opts);  // 创建信息窗口对象
	map.openInfoWindow(infoWindow, map.getCenter());      // 打开信息窗口
	map.addOverlay(marker);
	<?php }else{?>
    msgbox("没有找到相关订单信息");
	<?php }?>
	
	//标注点数组
	function showinfo(pointarr)
	{
		//alert("<?php echo $S_ROOT;?>service/clockd?do=mapsrows&godate=<?php echo $godate;?>&todate=<?php echo $todate;?>&afterarea=<?php echo $afterarea;?>&afterid=<?php echo $afterid;?>&provid=<?php echo $provid;?>&cityid=<?php echo $cityid;?>&areaid=<?php echo $areaid;?>&alled=<?php echo $alled;?>&pointarr="+pointarr);
		if(pointarr){
			$.get("<?php echo $S_ROOT;?>service/clockd?do=mapsrows&ordersid=<?php echo $ordersid;?>&afterarea=<?php echo $afterarea;?>&afterid=<?php echo $afterid;?>&provid=<?php echo $provid;?>&cityid=<?php echo $cityid;?>&areaid=<?php echo $areaid;?>&alled=<?php echo $alled;?>&pointarr="+pointarr, function(result){
                if(result){
    	    		var markerArr = jQuery.parseJSON(result);
    	    		//alert(markerArr);
    	    		addMarker(markerArr);
                }
			});
		}
	}
	
	//创建marker
	function addMarker(data){
		//map.clearOverlays();
		for(var i=0;i<data.length;i++){
			var json = data[i];
			var p0 = json.point.split("|")[0];
			var p1 = json.point.split("|")[1];
			var point = new BMap.Point(p0,p1);
			var iconImg = createIcon(json.icon);
			var marker = new BMap.Marker(point,{icon:iconImg});
			var iw = createInfoWindow(i);
			map.addOverlay(marker);

			(function(){
				var _json = json;
				var _iw = createInfoWindow(_json);
				var _marker = marker;
				_marker.addEventListener("click",function(e){
					this.openInfoWindow(_iw,map.getCenter());		
				});
				//if(!!json.isOpen){
				//	//label.hide();
				//	map.panTo(new BMap.Point(p0, p1));
				//	_marker.openInfoWindow(_iw,map.getCenter());		
				//} 
			})()
		}
	}
	
	//创建InfoWindow
	function createInfoWindow(json){
	    //var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.content+"</div>");
		var opts = {  
		   width : 220,     // 信息窗口宽度  
		   height: 80,     // 信息窗口高度  
		   title : json.title  // 信息窗口标题  
		}
		var iw = new BMap.InfoWindow(json.content, opts);  // 创建信息窗口对象
	    return iw;
	}
	
	//创建一个Icon
	function createIcon(json){
		if(json.t == 1){
	    	var icon = new BMap.Icon("<?php echo $S_ROOT;?>images/1day.png", new BMap.Size(json.w,json.h),{offset:new BMap.Size(json.w,json.h)});
		}else if(json.t == 2){
		    var icon = new BMap.Icon("<?php echo $S_ROOT;?>images/2day.png", new BMap.Size(json.w,json.h),{offset:new BMap.Size(json.w,json.h)});
		}else{
	    	var icon = new BMap.Icon("<?php echo $S_ROOT;?>images/0day.png", new BMap.Size(json.w,json.h),{offset:new BMap.Size(json.w,json.h)});
		}
	    return icon;
	}
	
</script>

</body>
</html>