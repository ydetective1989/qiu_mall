<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/maps.jobs.js?<?php echo date("Ymd");?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.jobs.js?<?php echo date("Ymd");?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/baidu.maps.js?<?php echo date("YmdH")?>"></script>
<style type="text/css">
body{ margin:0px; padding:0px; } 
.map_container{width:100%;height:100%; index-z:5;}
</style>
</head>
<body>


<body scroll="no">

<?php if($show=="maps"){?>

<div class="map_container" id="container"></div>

<script type="text/javascript">



    <?php 
    $point_lng = ($row["pointlng"])?$row["pointlng"]:"116.404";
    $point_lat = ($row["pointlat"])?$row["pointlat"]:"39.915";
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
	//初始化地图位置
	map.centerAndZoom(point,12);

	var vpoint = map.getBounds();
	var vp1 = vpoint.getSouthWest();
	var vp2 = vpoint.getNorthEast();
	var pointarrs = vp1.lng +"||"+ vp2.lng +"||"+ vp1.lat +"||"+ vp2.lat;
	showinfo(pointarrs);
	
	//发生操作事件时，独发信息
	map.addEventListener("dragend",function(e){
		//alert("地图移动操作");
		var b = map.getBounds();
		var p1 = b.getSouthWest();
		var p2 = b.getNorthEast();
		var pointarra = p1.lng +"||"+ p2.lng +"||"+ p1.lat +"||"+ p2.lat;
		//alert(pointarr);
		showinfo(pointarra);
	});
	
	map.addEventListener("zoomend",function(e){
		//alert("地图放大操作");
		var b = map.getBounds();
		var p1 = b.getSouthWest();
		var p2 = b.getNorthEast();
		var pointarrb = p1.lng +"||"+ p2.lng +"||"+ p1.lat +"||"+ p2.lat;
		//alert(pointarrb);
		showinfo(pointarrb);
	});
	
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
		 enableMassClear: false,
		 raiseOnDrag: true,
		 icon: myIcon
	});
	map.addOverlay(marker);
	
	//标注点数组
	function showinfo(pointarr)
	{
		if(pointarr){
			//alert("<?php echo $S_ROOT;?>maps/jobs?show=lists&afterid=<?php echo (int)$_GET["afterid"];?>&datetime=<?php echo $_GET["datetime"];?>&pointarr="+pointarr);
			//alert(<?php echo (int)$_GET["afterid"];?>);
			$.get("<?php echo $S_ROOT;?>maps/jobs?show=lists&afterid=<?php echo (int)$_GET["afterid"];?>&datetime=<?php echo $_GET["datetime"];?>&pointarr="+pointarr, function(result){
                if(result){
        	    		var markerArr = jQuery.parseJSON(result);
        	    		addMarker(markerArr);
                }else{
					msgbox("没有查到当日工单信息！");
                }
			});
		}
	}
	
	//创建marker
	function addMarker(data){
		map.clearOverlays();
		for(var i=0;i<data.length;i++){
			var json = data[i];
			var p0 = json.point.split("|")[0];
			var p1 = json.point.split("|")[1];
			var point = new BMap.Point(p0,p1);
			var iconImg = createIcon(json.icon);
			var marker = new BMap.Marker(point,{icon:iconImg});
			var iw = createInfoWindow(i);
		    var label = new BMap.Label(json.ordersid,{"offset":new BMap.Size(-14,0)});
		    marker.setLabel(label);
			map.addOverlay(marker);
	        label.setStyle({
                borderColor:json.bgcolor,
                backgroundColor:json.bgcolor,
                color:json.color,
                cursor:"pointer"
   			});

			(function(){
				var _json = json;
				var _iw = createInfoWindow(_json);
				var _marker = marker;
				_marker.addEventListener("click",function(e){
					revise(""+_json.id+"");
					//this.openInfoWindow(_iw,map.getCenter());	
						
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
		   width : 250,     // 信息窗口宽度  
		   height: 80,     // 信息窗口高度  
		   title : json.title  // 信息窗口标题  
		}
		var iw = new BMap.InfoWindow('', opts);  // 创建信息窗口对象
		iw.setContent(json.content);
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


<?php }else{?>

<table width="100%" height="100%">
  <tr>
    <td colspan="3" align="center">
	<div class="forms">
      <table width="100%" >
		  <tr>
		    <td height="40" class="bold">&nbsp;工单地图</td>
		    <td class="tdright">
		    <input type="text" name="datetime" id="datetime" class="input" value="<?php echo date("Y-m-d",time()+86400);?>"  style="width:100px;text-align:center;">
			  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?level=1&type=3&val=afterTeams"></script><!-- level=1& -->
			  <script type="text/javascript">var afterarea='0';var afterid='0';var afteruserid='';</script>
			  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.after.js"></script>
	          <select name="afterarea" id="afterarea" style="width:150px;" class="select" ></select>
		      <select name="afterid" id="afterid" style="width:150px;" class="select" ></select>
	          <input type="button" class="button" value="查看工单" onclick="search();" >
	        </td>
		  </tr>
      </table>
	</div>
    </td>
  </tr>
  <tr>
    <td colspan="3" class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td height="100%">
        <iframe src="<?php echo $S_ROOT;?>maps/jobs?show=maps" width="100%" height="100%" name="frmlist" id="frmlist" scrolling="auto" noresize="noresize" frameborder="no" style="" /></iframe>
    </td>
  </tr>
</table>

<?php }?>

</body>
</html>