<script type="text/javascript" src="<?php echo $S_ROOT;?>js/maps.views.js?<?php echo date("YmdHi");?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/message.js?<?php echo date("YmdH");?>"></script>

<script type="text/javascript">
//商品信息
function productlist(id)
{
	ajaxurl(S_ROOT+"orders/products?id="+id+"&"+ Math.random(),"#product_lists");
}

//子订记录
function parentlist(page)
{
	var id = $("#parent_ordersid").val();
	if(page==""){ var page = 1; }
	ajaxurl(S_ROOT+"orders/parents?id="+id+"&page="+page+"&"+ Math.random(),"#parent_list");
}
</script>

<div class="orderdivs">

<table width="100%" class="table">
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">客户信息</td>
  </tr>
  <tr>
    <td width="15%" class="tdright">客户姓名：</td>
    <td><?php echo $orderinfo["name"];?></td>
    <td width="15%" class="tdright">所在地区：</td>
    <td><?php echo $orderinfo["provname"];?> <?php echo $orderinfo["cityname"];?> <?php echo $orderinfo["areaname"];?></td>
  </tr>
  <tr>
    <td class="tdright">联系地址：</td>
    <td colspan="3"><?php echo $orderinfo["address"];?><?php if($orderinfo["loops"]){ echo  "（".$looptype[$orderinfo["areaid"]]["lists"][$orderinfo["loops"]]["name"]."）"; }?> <?php echo ($orderinfo["postnum"])?"邮编：".$orderinfo["postnum"]."":"";?><?php if($orderinfo["pointlng"]&&$orderinfo["pointlat"]){?><input type="button" value="查看地图"  onclick="viewmaps('<?php echo base64_encode($orderinfo["id"]);?>');" /><input type="hidden" name="mapmarkers_lng" id="mapmarkers_lng" value="<?php echo ($orderinfo["pointlng"])?htmlspecialchars($orderinfo["pointlng"]):"";?>"><input type="hidden" name="mapmarkers_lat" id="mapmarkers_lat" value="<?php echo ($orderinfo["pointlat"])?htmlspecialchars($orderinfo["pointlat"]):"";?>"><?php }?></td>
  </tr>

  <tr>
    <td class="tdright">手机号码：</td>
    <td><?php echo $orderinfo["mobile"];?><?php if(IS_SMSED=="1"){?><?php if($orderinfo["mobile"]){?> <img src="<?php echo $S_ROOT;?>images/smsicon.jpg" onclick="sendsms('<?php echo $orderinfo["mobile"]?>','');" class="pointer" align="absmiddle"><?php }?><?php }?></td>
    <td class="tdright">其它电话：</td>
    <td><?php echo $orderinfo["phone"];?></td>
  </tr>
  <tr>
    <td class="tdright">QQ/旺旺：</td>
    <td><?php if($orderinfo["qq"]){?><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo htmlspecialchars($orderinfo["qq"])?>&site=qq&menu=yes"><img border="0" src="<?php echo $S_ROOT;?>images/qqface.gif" alt="<?php echo htmlspecialchars($orderinfo["qq"])?>" title="<?php echo htmlspecialchars($orderinfo["qq"])?>" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;&nbsp;<?php }?><?php if($orderinfo["wangwang"]){?><a target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&uid=<?php echo htmlspecialchars($orderinfo["wangwang"])?>&s=1&charset=UTF-8" ><img border="0" src="<?php echo $S_ROOT;?>images/aliface.gif" alt="<?php echo htmlspecialchars($orderinfo["wangwang"])?>"  align="absmiddle"/></a> <?php echo htmlspecialchars($orderinfo["wangwang"])?> <?php }?></td>
    <td class="tdright">其它IM：</td>
    <td><?php echo $orderinfo["im"];?></td>
  </tr>

  <tr class="detailbg">
    <td width="15%" class="tdright">订单备注：</td>
    <td colspan="3"><?php echo $orderinfo["detail"];?></td>
  </tr>

  <tr>
    <td colspan="4" style="padding:0px;" id="product_lists">Loading...</td>
  </tr>
  <script>productlist('<?php echo base64_encode($orderinfo["id"])?>');</script>

  <tr class="detailbg">
    <td width="15%" class="tdright">费用备注：</td>
    <td colspan="3"><?php echo $orderinfo["price_detail"];?></td>
  </tr>
  <tr class="bgtips">
    <td colspan="4" class="tdcenter">总价:<span class='red'><?php echo $orderinfo["price_all"];?></span>元、安装:<span class='red'><?php echo $orderinfo["price_setup"];?></span>元、物流:<span class='red'><?php echo $orderinfo["price_deliver"];?></span>元、优惠:<span class='red'><?php echo $orderinfo["price_minus"];?></span>元、其它:<span class='red'><?php echo $orderinfo["price_other"];?></span>元、已付:<span class='red'><?php echo round($paycharge,2);?></span>元、实收:<span class='red'><?php echo $orderinfo["price"];?></span>元、应付:<span class='red'><?php echo round($orderinfo["price"]-round($paycharge,2),2);?></span>元</td>
  </tr>
</table>

<?php if(IS_STORE=="1"){?>
<table width="100%" class="table">
  <input type="hidden" name="store_ordersid" id="store_ordersid" value="<?php echo base64_encode($orderinfo["id"]);?>">
  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.store.js?<?php echo date("Ymd")?>"></script>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">商品出库记录 <span class="pointer uwhite" onclick="addstore('<?php echo base64_encode($orderinfo["id"]);?>');">[+]</span></td>
  </tr>
  <tr>
    <td colspan="4" class="tdcenter" style="padding:0px;" id="store_list">正在载入数据，请稍候...</td>
  </tr>
  <script type="text/javascript">storelist(1);</script>
</table>
<?php }?>

<table width="100%" class="table">

	<?php if(IS_JOBS=="1"){?>
  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.jobs.js?<?php echo date("YmdHi")?>"></script>
  <input type="hidden" name="jobs_ordersid" id="jobs_ordersid" value="<?php echo base64_encode($orderinfo["id"]);?>">
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">工单记录 <span class="pointer uwhite" onclick="addjobs('<?php echo base64_encode($orderinfo["id"]);?>');">[+]</span></td>
  </tr>
  <tr>
    <td colspan="4" class="tdcenter" style="padding:0px;" id="jobs_list"><br>正在载入数据，请稍候...<br></td>
  </tr>
  <script type="text/javascript">jobslist(1);</script>
	<?php }?>

	<?php if(IS_UPFILE=="1"){?>
	<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.files.js?<?php echo date("YmdHi")?>"></script>
	<input type="hidden" name="files_ordersid" id="files_ordersid" value="<?php echo base64_encode($orderinfo["id"])?>">
	  <tr class="bgheader">
	    <td colspan="4" class="tdcenter">附件文件 <span class="pointer uwhite" onclick="ordersupload('<?php echo base64_encode($orderinfo["id"])?>');">[+]</span></td>
	  </tr>
	  <tr>
	    <td colspan="4" class="tdcenter" style="padding:0px;" id="files_list"><br>正在载入数据，请稍候...<br></td>
	  </tr>
	<script type="text/javascript">fileslist(1);</script>
	<?php }?>
	
	<?php if(IS_INVOICE=="1"){?>
  <input type="hidden" name="invoice_ordersid" id="invoice_ordersid" value="<?php echo base64_encode($orderinfo["id"])?>">
  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/invoice.js?<?php echo date("YmdHi")?>"></script>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">发票记录 <span class="pointer uwhite" onclick="invoice('<?php echo base64_encode($orderinfo["id"])?>');">[+]</span></td>
  </tr>
  <tr>
    <td colspan="4" class="tdcenter" style="padding:0px;" id="invoice_list"><br>正在载入数据，请稍候...<br></td>
  </tr>
  <script type="text/javascript">invoicelist(1);</script>
  <?php }?>

  <!-- <input type="hidden" name="charge_ordersid" id="charge_ordersid" value="<?php echo base64_encode($orderinfo["id"]);?>">
  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.charge.js?<?php echo date("YmdHi")?>"></script>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">支付记录 <span class="pointer uwhite" onclick="addcharge('<?php echo base64_encode($orderinfo["id"]);?>');">[+]</span></td>
  </tr>
  <tr>
    <td colspan="4" class="tdcenter" style="padding:0px;" id="charge_list"><br>正在载入数据，请稍候...<br></td>
  </tr>
  <script type="text/javascript">chargelist(1);</script> -->

	<?php if(IS_EXPRESS=="1"){?>
  <input type="hidden" name="exp_ordersid" id="exp_ordersid" value="<?php echo base64_encode($orderinfo["id"])?>">
  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.express.js?<?php echo date("YmdHi")?>"></script>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">物流记录 <span class="pointer uwhite" onclick="addexpress('<?php echo base64_encode($orderinfo["id"])?>');">[+]</span></td>
  </tr>
  <tr>
    <td colspan="4" class="tdcenter" style="padding:0px;" id="express_list"><br>正在载入数据，请稍候...<br></td>
  </tr>
  <script type="text/javascript">expresslist(1);</script>
	<?php }?>

	<?php if(IS_CLOCKD=="1"&&(int)$hideclockd=="0"){?>
	<input type="hidden" name="clock_ordersid" id="clock_ordersid" value="<?php echo ($orderinfo["id"])?base64_encode($orderinfo["id"]):"";?>" />
	<script type="text/javascript" src="<?php echo $S_ROOT;?>js/clockd.js?<?php echo date("Ymd");?>"></script>
	<tr class="bgheader">
		<td colspan="4" class="tdcenter">回访记录 <span onclick="clockdinfo();" class="pointer">[+]</span></td>
	</tr>
	<tr>
		<td colspan="4" class="tdcenter" style="padding:0px;" id="clockd_list"><br>正在载入数据，请稍候...<br><br><script>clockdalllist(1);</script></td>
	</tr>
	<?php }?>

	<tr class="bgheader">
 	 <td colspan="4" class="tdcenter">历史订单</td>
  </tr>
	<input type="hidden" name="parent_ordersid" id="parent_ordersid" value="<?php echo ($orderinfo["parentid"])?base64_encode($orderinfo["parentid"]):base64_encode($orderinfo["id"]);?>">
	<tr>
		<td colspan="4" class="tdcenter" style="padding:0px;" id="parent_list"><br>正在载入数据，请稍候...<br></td>
	</tr>
	<script type="text/javascript">parentlist(1);</script>

	<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.logs.js?<?php echo date("YmdHi")?>"></script>
	 <input type="hidden" name="logs_ordersid" id="logs_ordersid" value="<?php echo base64_encode($orderinfo["id"])?>">
	 <tr class="bgheader">
		 <td colspan="4" class="tdcenter">操作记录<span class="pointer uwhite" class="uwhite" onclick="addlogs('<?php echo base64_encode($orderinfo["id"])?>');">[+]</span></td>
	 </tr>
	 <tr>
		 <td colspan="4" class="tdcenter" style="padding:0px;" id="logs_list"><br>正在载入数据，请稍候...<br></td>
	 </tr>
	 <script type="text/javascript">logslist(1);</script>

</table>

<!-- 百度地图API -->
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/baidu.maps.js?<?php echo date("YmdH")?>"></script>
