<?php if($type=="status"){?>

<input type="hidden" name="dialog_id" id="dialog_id" value="<?php echo $_GET["id"]?>">
<input type="hidden" name="dialog_type" id="dialog_type" value="<?php echo $_GET["cates"]?>">

<?php if($checked){?>
<a href="javascript:void(0)" onclick="focus_del('<?php echo $_GET["cates"]?>','<?php echo $_GET["id"]?>')" class="focusbtn focusbtn-unfocus"></a>
<?php }else{?>
<a href="javascript:void(0)" onclick="focus_add()" class="focusbtn focusbtn-focus"></a>
<?php }?>


<?php }elseif($type=="orders"){?>

<table width="100%" class="parinfo">
	<tr class="bgheader">
		<td width="10%" class="tdcenter">订单编号</td>
		<td width="10%" class="tdcenter">订单类型</td>
		<td width="10%" class="tdcenter">订购日期</td>
		<td width="10%" class="tdcenter">是否派工</td>
		<td width="10%" class="tdcenter">支付状态</td>
		<td width="10%" class="tdcenter">金额</td>
		<td width="10%" class="tdcenter">入款</td>
		<td width="10%" class="tdcenter">订单状态</td>
		<td width="15%" class="tdcenter">取消</td>
	</tr>
	<?php if($list){?>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter"><a href="javascript:void(0)" onclick="parent.parent.addTab('查看订单[<?php echo $rs["ordersid"];?>]','orders/views?id=<?php echo base64_encode($rs["ordersid"]);?>','orderview');"><?php echo $rs["ordersid"];?></td>
		<td class="tdcenter"><?php echo $ordertype[$rs["otype"]]["name"];?></td>
		<td class="tdcenter"><?php echo $rs["datetime"];?></td>
		<td class="tdcenter"><?php echo ($rs["jobsed"])?"已派工":"未派工";?></td>
		<td class="tdcenter"><?php echo ($rs["paystate"])?"已支付":"未支付";?></td>
		<td class="tdcenter"><span class="red"><?php echo round($rs["price"],2);?></span>元</td>
		<td class="tdcenter"><span class="red"><?php echo round($rs["charge"],2)?></span>元</td>
		<td class="tdcenter <?php echo $statustype[$rs["status"]]["color"]?>"><?php echo $statustype[$rs["status"]]["name"]?></td>
		<td class="tdcenter"><a href="javascript:void(0)" onclick="parent.parent.addTab('查看订单[<?php echo $rs["ordersid"];?>]','orders/views?id=<?php echo base64_encode($rs["ordersid"]);?>','orderview');">[查看]</a><span class="pointer" onclick="focus_delitem('dd','<?php echo base64_encode($rs["ordersid"]);?>')">[取消关注]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="10" class="tdcenter"><?php echo $page = str_replace("page(","focus_orders(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="10" height="30" class="tdcenter">暂无订单关注记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="invoice"){?>
<table width="100%" class="parinfo">
	<tr class="bgheader">
		<td width="10%" class="tdcenter">订单编号</td>
		<td width="10%" class="tdcenter">订单状态</td>
		<td width="10%" class="tdcenter">订单金额</td>
		<td width="10%" class="tdcenter">发票金额</td>
		<td width="10%" class="tdcenter">审核状态</td>
		<td width="10%" class="tdcenter">开票状态</td>
		<td width="20%" class="tdcenter">物流公司/快递单号</td>
		<td width="15%" class="tdcenter">操作</td>
	</tr>
	<?php if($list){?>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter"><a href="javascript:void(0)" onclick="parent.parent.addTab('查看发票[<?php echo $rs["id"];?>]','invoice/views?id=<?php echo base64_encode($rs["id"]);?>','invoiceview');"><?php echo $rs["ordersid"];?></td>
		<td class="tdcenter"><?php echo $statustype[$rs["status"]]["name"];?></td>
		<td class="tdcenter"><span class="red"><?php echo round($rs["oprice"],2);?></span>元</td>
		<td class="tdcenter"><span class="red"><?php echo round($rs["price"],2);?></span>元</td>
		<td class="tdcenter"><?php echo $checktype[$rs["checked"]]["name"];?></td>
		<td class="tdcenter"><?php echo $worktype[$rs["worked"]]["name"];?></td>
		<td class="tdcenter"><?php if($rs["express"]){?><?php echo $rs["express"]["expname"]?>：<span class="pointer blue" onclick="viewexpress('<?php echo base64_encode($rs["express"]["id"]);?>')"><?php echo $rs["express"]["numbers"]?></span><?php }else{?><span class="gray">没有记录</span><?php }?></td>
		<td class="tdcenter"><a href="javascript:void(0)" onclick="parent.parent.addTab('查看发票[<?php echo $rs["id"];?>]','invoice/views?id=<?php echo base64_encode($rs["id"]);?>','invoiceview');">[查看]</a><span class="pointer" onclick="focus_delitem('fp','<?php echo base64_encode($rs["id"]);?>')">[取消关注]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="10" class="tdcenter"><?php echo $page = str_replace("page(","focus_invoice(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="10" height="30" class="tdcenter">暂无发票关注记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="jobs"){?>
<!--
工单号 日期 订单号 订单状态 服务中心  工单状态  服务人员  派工人  取消
 -->
<table width="100%" class="parinfo">
	<tr class="bgheader">
		<td width="10%" class="tdcenter">工单编号</td>
		<td width="8%" class="tdcenter">工单类别</td>
		<td width="10%" class="tdcenter">预约日期</td>
		<td width="10%" class="tdcenter">订单编号</td>
		<td width="20%" class="tdcenter">服务中心</td>
		<td width="10%" class="tdcenter">服务人员</td>
		<td width="7%" class="tdcenter">派工人员</td>
		<td width="7%" class="tdcenter">完成状态</td>
		<td width="15%" class="tdcenter">操作</td>
	</tr>
	<?php if($list){?>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter"><a href="javascript:void(0)" onclick="parent.parent.addTab('查看工单[<?php echo $rs["jobsid"];?>]','jobs/views?id=<?php echo base64_encode($rs["jobsid"]);?>','jobsview');"><?php echo $rs["jobsid"];?></td>
		<td class="tdcenter"><?php echo $jobstype[$rs["type"]]["name"];?></td>
		<td class="tdcenter"><?php echo $rs["datetime"];?></td>
		<td class="tdcenter"><?php echo $rs["ordersid"];?></td>
		<td class="tdcenter"><?php echo $rs["aftername"];?></td>
		<td class="tdcenter"><?php echo $rs["afteruname"];?></td>
		<td class="tdcenter"><?php echo $rs["addname"];?></td>
		<td class="tdcenter"><?php echo $worktype[$rs["worked"]]["name"];?></td>
		<td class="tdcenter"><a href="javascript:void(0)" onclick="parent.parent.addTab('查看工单[<?php echo $rs["jobsid"];?>]','jobs/views?id=<?php echo base64_encode($rs["jobsid"]);?>','jobsview');">[查看]</a><span class="pointer" onclick="focus_delitem('gd','<?php echo base64_encode($rs["jobsid"]);?>')">[取消关注]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="10" class="tdcenter"><?php echo $page = str_replace("page(","focus_jobs(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="10" height="30" class="tdcenter">暂无发票关注记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="complaint"){?>
<!--
订单号 销售部门 城市 服务部门 处理人员 处理状态 最后更新 取消
 -->
<table width="100%" class="parinfo">
	<tr class="bgheader">
		<td width="10%" class="tdcenter">订单编号</td>
		<td width="15%" class="tdcenter">销售部门</td>
		<td width="15%" class="tdcenter">所在城市</td>
		<td width="15%" class="tdcenter">服务部门</td>
		<td width="10%" class="tdcenter">处理人员</td>
		<td width="7%" class="tdcenter">处理状态</td>
		<td width="13%" class="tdcenter">最后更新</td>
		<td width="15%" class="tdcenter">操作</td>
	</tr>
	<?php if($list){?>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter"><a href="javascript:void(0)" onclick="parent.parent.addTab('查看投诉[<?php echo $rs["id"];?>]','complaint/views?id=<?php echo base64_encode($rs["id"]);?>','complaintview');"><?php echo $rs["ordersid"];?></td>
		<td class="tdcenter"><?php echo $rs["salesname"];?></td>
		<td class="tdcenter"><?php echo $rs["provname"];?> - <?php echo $rs["cityname"];?></td>
		<td class="tdcenter"><?php echo $rs["aftername"];?></td>
		<td class="tdcenter"><?php echo $rs["afteruname"];?></td>
		<td class="tdcenter"><?php echo ($rs["worked"])?"<span class='green'>已处理</span>":"<span class='red'>处理中</span>";?></td>
		<td class="tdcenter"><?php echo ($rs["uptime"])?date("Y-m-d H:i",$rs["uptime"]):"无";?></td>
		<td class="tdcenter"><a href="javascript:void(0)" onclick="parent.parent.addTab('查看投诉[<?php echo $rs["id"];?>]','complaint/views?id=<?php echo base64_encode($rs["id"]);?>','complaintview');">[查看]</a><span class="pointer" onclick="focus_delitem('ts','<?php echo base64_encode($rs["id"]);?>')">[取消关注]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="10" class="tdcenter"><?php echo $page = str_replace("page(","focus_jobs(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="10" height="30" class="tdcenter">暂无发票关注记录</td>
	</tr>
	<?php }?>
</table>


<?php }else{?>

null

<?php }?>
