<?php if($type=="paystate"){?>
<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo base64_encode($info["id"]);?>">
<table width="400" class="table">
  <tr>
    <td height="35" colspan="4" class="tdcenter">
    <?php foreach($paystatetype AS $rs){?>
	    <input type="radio" name="paystate" value="<?php echo $rs["id"];?>" <?php if((int)$info["paystate"]==$rs["id"]){ echo "checked"; }?>> <?php echo $rs["name"];?>
	<?php }?>
    </td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
  <tr>
    <td class="tdcenter">
    <input type="button" class="button" onclick="paystated()" value="确定"></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
</table>

<?php }elseif($type=="parents"){?>

<table width="100%" class="parinfo">
<tr class="bgtips">
	<td width="80" class="tdcenter">订单编号</td>
	<td class="tdcenter">订购内容</td>
	<td width="100" class="tdcenter">订购日期</td>
	<td width="80" class="tdcenter">销售人员</td>
	<td width="60" class="tdcenter">状态</td>
</tr>
<?php if($list){?>
<?php foreach($list AS $rs){?>
<tr class="datas">
	<td class="tdcenter"><a href="javascript:void(0)" onclick="parent.parent.addTab('查看订单[<?php echo $rs["id"];?>]','orders/views?id=<?php echo base64_encode($rs["id"]);?>','orderpview');"><?php echo $rs["id"]?></a></td>
	<td class="tdleft">
	<?php echo $rs["parents"][0]["title"]?><?php if($rs["parents"][1]){?> / <?php echo $rs["parents"][1]["title"]?></span><?php }?> ...	</td>
	<td class="tdcenter"><?php echo $rs["datetime"]?></td>
	<td class="tdcenter"><?php echo $rs["saleuname"]?></td>
	<td class="tdcenter"><?php echo $statustype[$rs["status"]]["name"];?></td>
</tr>
<?php }?>
<?php }else{?>
<tr class="datas">
	<td colspan="5" class="tdcenter">暂无子订单信息</td>
</tr>
<?php }?>
</table>

<?php }elseif($type=="plist"){?>

<table width="100%" class="parinfo">
<tr class="bgheader">
	<td width="80" class="tdcenter">产品编码</td>
	<td class="tdcenter">产品名称/产品SN/备注信息</td>
	<td width="50" class="tdcenter">数量</td>
	<td width="80" class="tdcenter">单价</td>
</tr>
<?php if($orders_product){?>
<?php foreach($orders_product AS $rs){?>
<tr class="datas">
	<td class="tdcenter"><?php echo $rs["encoded"]?></td>
	<td class="tdleft"><?php if($rs["serials"]){ echo "[<font class='gray'>".$rs["serials"]."] "; }?><?php echo $rs["title"]?><?php if($rs["erpname"]){ echo "(<font class='gray'>".$rs["erpname"].")"; }?></td>
	<td class="tdcenter"><?php echo (int)$rs["nums"]?></td>
	<td class="red tdcenter"><?php echo $rs["price"]?>元</td>
</tr>
<?php }?>
<?php }else{?>
<tr class="datas">
	<td colspan="4" class="tdcenter">暂无订购信息</td>
</tr>
<?php }?>
</table>

<?php }elseif($type=="superinfo"){?>

<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo base64_encode($info["id"]);?>">
<table width="500" class="table">
  <tr>
    <td width="15%" class="tdright">销售类型：</td>
    <td width="35%"><select name="dialog_ctype" id="dialog_ctype" class="select" style="width:120px;">
    <?php foreach($customstype AS $rs){ ?>
    <option value="<?php echo $rs["id"];?>" <?php if($info["ctype"]==$rs["id"]){ echo "selected"; } ?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select></td>
    <td width="15%" class="tdright"></td>
    <td width="35%"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">订单类型：</td>
    <td><select name="dialog_type" id="dialog_type" class="select" style="width:120px;"><?php foreach($ordertype AS $rs){?>
    <option value="<?php echo $rs["id"]?>" <?php if($info["type"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
    <?php }?></select></td>
    <td class="tdright">归主订单：</td>
    <td><input type="text" name="dialog_parentid" id="dialog_parentid" class="input" style="width:110px;" value="<?php echo (int)$info["parentid"];?>"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">审核状态：</td>
    <td><select name="dialog_checked" id="dialog_checked" class="select" style="width:120px;"><?php foreach($checktype AS $rs){?>
    <option value="<?php echo $rs["id"]?>" <?php if($info["checked"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
    <?php }?></select></td>
    <td class="tdright">订单进度：</td>
    <td><select name="dialog_status" id="dialog_status" class="select" style="width:120px;"><?php foreach($statustype AS $rs){?>
    <option value="<?php echo $rs["id"]?>" <?php if($info["status"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
    <?php }?></select></td>
  </tr>
  <tr>
    <td height="30" class="tdright">支付方式：</td>
    <td><select name="dialog_paytype" id="dialog_paytype" class="select" style="width:120px;"><?php foreach($paytype AS $rs){?>
    <option value="<?php echo $rs["id"]?>" <?php if($info["paytype"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
    <?php }?></select></td>
    <td class="tdright">支付状态：</td>
    <td><select name="dialog_paystate" id="dialog_paystate" class="select" style="width:120px;"><?php foreach($paystatetype AS $rs){?>
    <option value="<?php echo $rs["id"]?>" <?php if($info["paystate"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
    <?php }?></select></td>
  </tr>
  <tr>
    <td height="30" class="tdright">订单总价：</td>
    <td><input type="text" name="dialog_price_all" id="dialog_price_all" class="input" style="width:110px;" readonly value="<?php echo ($info["price_all"])?$info["price_all"]:"0";?>"></td>
    <td class="tdright">保证金：</td>
    <td><input type="text" name="dialog_price_cash" id="dialog_price_cash" class="input" style="width:110px;" value="<?php echo ($info["price_cash"])?$info["price_cash"]:"0";?>"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">安装费用：</td>
    <td><input type="text" name="dialog_price_setup" id="dialog_price_setup" class="input" style="width:110px;" value="<?php echo ($info["price_setup"])?$info["price_setup"]:"0";?>"></td>
    <td class="tdright">快递费用：</td>
    <td><input type="text" name="dialog_price_deliver" id="dialog_price_deliver" class="input" style="width:110px;" value="<?php echo ($info["price_deliver"])?$info["price_deliver"]:"0";?>"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">优惠费用：</td>
    <td><input type="text" name="dialog_price_minus" id="dialog_price_minus" class="input"  style="width:110px;" value="<?php echo ($info["price_minus"])?$info["price_minus"]:"0";?>"></td>
    <td class="tdright">其它费用：</td>
    <td><input type="text" name="dialog_price_other" id="dialog_price_other" class="input" style="width:110px;" value="<?php echo ($info["price_other"])?$info["price_other"]:"0";?>"></td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="4" height="10"></td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="4">
    <input type="button" class="button" id="btned" onclick="supered()" value="确定更新"></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
</table>


<?php }elseif($type=="priceadm"){?>
<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo base64_encode($info["id"]);?>">
<input type="hidden" name="oldprice" id="oldprice" value="<?php echo @round($info["price_setup"]+$info["price_deliver"]+$info["price_other"],2)?>">

<table width="380" class="table">
  <tr>
    <td width="100" height="30" class="tdright">安装费用：</td>
    <td><input type="text" name="price_setup" id="price_setup" class="input" style="width:150px;" value="<?php echo ($info["price_setup"])?$info["price_setup"]:"";?>"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">快递费用：</td>
    <td><input type="text" name="price_deliver" id="price_deliver" class="input" style="width:150px;" value="<?php echo ($info["price_deliver"])?$info["price_deliver"]:"";?>"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">其它费用：</td>
    <td><input type="text" name="price_other" id="price_other" class="input" style="width:150px;" value="<?php echo ($info["price_other"])?$info["price_other"]:"";?>"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">费用备注：</td>
    <td colspan="3"><textarea name="price_detail" id="price_detail" class="textarea" style="width:90%;height:50px;"><?php echo ($info["price_detail"])?$info["price_detail"]:"";?></textarea></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
    <td>
    <input type="button" class="button" onclick="priceadmed()" value="更新价格"></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
</table>

<?php }elseif($type=="upctype"){?>
<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo base64_encode($info["id"]);?>">

<table width="380" class="table">
  <tr>
    <td width="100" height="30" class="tdright">客户类别：</td>
    <td><select name="dialog_ctype" id="dialog_ctype" class="select" style="width:120px;">
        <?php foreach($customstype AS $rs){ ?>
          <option value="<?php echo $rs["id"];?>" <?php if($info["ctype"]==$rs["id"]){ echo "selected"; } ?>><?php echo $rs["name"];?></option>
        <?php }?>
      </select></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">操作备注：</td>
    <td colspan="3"><textarea name="dialog_detail" id="dialog_detail" class="textarea" style="width:90%;height:50px;"></textarea></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
  <tr>
    <td class="tdcenter"></td>
    <td>
      <input type="button" class="button" id="btned" onclick="upctyped()" value="更新类别"></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
</table>

<?php }elseif($type=="closed"){?>
<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo base64_encode($info["id"]);?>">


<table width="290" class="table">
  <tr>
    <td height="35" colspan="4"><textarea name="closed_detail" id="closed_detail" class="textarea" style="width:284px;"></textarea></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
  <tr>
    <td class="tdcenter">
    <input type="button" class="button" onclick="closedbtn()" value="提交操作"></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
</table>

<?php }elseif($type=="killed"){?>
<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo base64_encode($info["id"]);?>">


<table width="290" class="table">
  <tr>
    <td height="35" colspan="4"><textarea name="killed_detail" id="killed_detail" class="textarea" style="width:284px;"></textarea></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
  <tr>
    <td class="tdcenter">
    <input type="button" class="button" onclick="killedbtn()" value="提交操作"></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
</table>

<?php }elseif($type=="checked"){?>

<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo base64_encode($info["id"]);?>">
<table width="400" class="table">
  <tr>
    <td height="35" colspan="4" class="tdcenter">
  	<?php foreach($checktype AS $rs){?>
	    <input type="radio" name="checkval" value="<?php echo $rs["id"];?>" <?php if((int)$info["checked"]==$rs["id"]){ echo "checked"; }?>> <?php echo $rs["name"];?>
     <?php }?>
    </td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
  <tr>
    <td class="tdcenter">
    <input type="button" class="button" onclick="checkodo()" value="确定"></td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
</table>

<?php }elseif($type=="charge"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="85" class="tdleft">时间</td>
		<td width="50" class="tdleft">类别</td>
		<td width="80" class="tdleft">款项</td>
		<td class="tdleft">收支方式</td>
		<td class="tdleft">入款批注</td>
		<td width="70" class="tdleft">金额</td>
		<td width="80" class="tdleft">录入人</td>
		<td width="60" class="tdleft">确认</td>
		<?php if(!$editno){?>
		<td width="80" class="tdleft">操作</td>
		<?php }?>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdleft"><?php echo date("Y-m-d",$rs["dateline"]);?></td>
		<td class="tdleft"><?php echo $chargetype[(int)$rs["type"]]["name"]?></td>
		<td class="tdleft"><?php echo $cates[(int)$rs["cates"]]["name"]?></td>
		<td class="tdleft"><?php echo $rs["payname"]?></td>
		<td class="tdleft"><?php echo $rs["detail"]?></td>
		<td class="tdleft"><font class='red'><?php echo round($rs["price"],2);?></font></td>
		<td class="tdleft"><?php echo ($rs["addname"])?$rs["addname"]:"系统默认";?></td>
		<td class="tdleft pointer" <?php if($rs["checked"]){?>onclick="msgbox('于 <?php echo date("Y-m-d H:i",$rs["checkdate"]);?> 由 <?php echo ($rs["userid"])?$rs["checkuname"]:"系统默认";?> 确认');"<?php }?>><?php echo ($rs["checked"])?"<span class='green'>已确认</span>":"<span class='red'>未确认</span>";?></td>
		<?php if(!$editno){?>
		<td class="tdleft"><span class="pointer" onclick="editcharge('<?php echo base64_encode($rs["id"]);?>')">[修改]</span><span class="pointer" onclick="delcharge('<?php echo base64_encode($rs["id"]);?>')">[删除]</span></td>
		<?php }?>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="7" class="tdcenter"><?php echo $page = str_replace("page(","chargelist(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="7" class="tdcenter">暂无支付记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="viewmaps"){?>

<table width="650" style="margin:0px;" >
  <tr>
	<td><div class="markers_orders" id="markers_container"></div></td>
  </tr>
  <tr>
	<td class="tdcenter"><input type="button" class="button" onclick="closedialog()" value="关闭窗口"></td>
  </tr>
</table>

<?php }elseif($type=="chargeinfo"){?>
<input type="hidden" name="charge_id" id="charge_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<table width="450" class="table">
  <tr>
    <td width="100" height="25" class="tdright">项目：</td>
    <td class="">
    <input type="radio" name="charge_type" value="1" <?php echo ($info["type"]=="1"||$_GET["do"]=="add")?"checked":"";?>> 入款
    <input type="radio" name="charge_type" value="2" <?php echo ($info["type"]=="2")?"checked":"";?>> 退款
    </td>
  </tr>
  <tr>
    <td height="35" class="tdright">时间：</td>
    <td class=""><input type="text" name="charge_datetime" id="charge_datetime" class="input" style="width:100px;" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>" readonly ></td>
  </tr>
  <?php if($taskjobs){?>
  <tr>
    <td height="35" class="tdright">工单任务：</td>
    <td class=""><select name="charge_jobsid" id="charge_jobsid" class="select">
      <option value="0">选择工单任务</option>
      <?php foreach($taskjobs AS $rs){?>
        <option value="<?php echo $rs["id"]?>"><?php echo $rs["id"]?></option>
      <?php }?>
    </select> * 选择收款任务</td>
  </tr>
  <?php }else{?>
  <input type="hidden" name="charge_jobsid" id="charge_jobsid" value="0">
  <?php }?>
  <tr>
  	<td height="35" class="tdright">类型：</td>
  	<td ><select name="charge_cates" id="charge_cates" class="select">
  	<option value="">选择费用类型</option>
  	<?php foreach($cates AS $rs){?>
  	<option value="<?php echo $rs["id"]?>" <?php if($info["cates"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
  	<?php }?>
  	</select></td>
  </tr>
  <tr>
  	<td height="35" class="tdright">收支方式：</td>
  	<td><select name="charge_ptype" id="charge_ptype" class="select" style="width:70px;">
  	<option value="">选择类别</option>
  	<?php foreach($payptype AS $rs){?>
  	<option value="<?php echo $rs["id"]?>" <?php if($info["paytype"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
  	<?php }?>
  	</select> <select name="charge_payid" id="charge_payid" class="select" style="width:210px;">
  	<option value="">选择收支帐号</option>
  	<?php foreach($paytype AS $rs){?>
  	<option value="<?php echo $rs["id"]?>" <?php if($info["payid"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
  	<?php }?>
  	</select></td>
  </tr>
  <tr>
    <td height="35" class="tdright">金额：</td>
    <td class=""><input type="text" name="charge_price" id="charge_price" class="input" style="width:100px;" value="<?php echo $info["price"];?>"> 注：如退减款请写：-10</td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td class="tdright">批注：</td>
    <td class=""><textarea name="charge_detail" id="charge_detail" class="textarea" style="width:300px;height:60px;"><?php echo $info["detail"];?></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="chargebtn" onclick="charged()" value="<?php echo ($_GET["do"]=="add")?"添加":"修改";?>记录">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="logs"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="120" class="tdleft">时间</td>
		<td width="80" class="tdleft">类型</td>
		<td class="tdleft">操作记录</td>
		<td width="70" class="tdleft">操作人</td>
		<td width="90" class="tdleft">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdleft"><?php echo date("Y-m-d H:i",$rs["dateline"]);?></td>
		<td class="tdleft"><?php echo $logstype[$rs["type"]]["name"]?></td>
		<td class="tdleft"><?php if($rs["parentid"]){ echo "子订单:[".$rs["parentid"]."]:"; }?><?php echo $rs["detail"]?></td>
		<td class="tdleft"><?php echo ($rs["addname"])?plugin::cutstr($rs["addname"],"4",''):"系统默认";?></td>
		<td class="tdleft"><span class="pointer" onclick="editlogs('<?php echo base64_encode($rs["id"]);?>')">[修改]</span><span class="pointer" onclick="dellogs('<?php echo base64_encode($rs["id"]);?>')">[删除]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="7" class="tdcenter"><?php echo $page = str_replace("page(","logslist(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="7" class="tdcenter">暂无操作记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="logsinfo"){?>
<input type="hidden" name="logs_id" id="logs_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<table width="450" class="table">
  <tr>
    <td width="100" height="25" class="tdright">项目：</td>
    <td class="">
    <select name="logs_type" id="logs_type" class="select">
    <option value="">选择操作类别</option>
    <?php foreach($logstype AS $rs){ if($rs["id"]=="0"){ continue; } ?>
    <option value="<?php echo $rs["id"];?>" <?php echo ($rs["id"]==$info["type"])?"selected":"";?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select>
    </td>
  </tr>
  <tr>
    <td height="35" class="tdright">时间：</td>
    <td class=""><input type="text" name="logs_datetime" id="logs_datetime" class="input" style="width:100px;" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>" readonly></td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td class="tdright">操作批注：</td>
    <td class=""><textarea name="logs_detail" id="logs_detail" class="textarea" style="width:300px;height:100px;"><?php echo $info["detail"];?></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="logsbtn" onclick="logsed()" value="<?php echo ($_GET["do"]=="add")?"添加":"修改";?>记录">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="cslogs"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="80" class="tdleft">时间</td>
		<td width="100" class="tdleft">类型</td>
		<td class="tdleft">服务记录</td>
		<td width="60" class="tdleft">记录人</td>
		<td width="60" class="tdleft">回执</td>
		<td width="150" class="tdleft">记录时间</td>
		<td width="90" class="tdleft">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdleft"><?php echo $rs["datetime"];?></td>
		<td class="tdleft"><?php echo $cslogstype[$rs["type"]]["name"]?></td>
		<td class="tdleft"><?php echo $rs["detail"]?></td>
		<td class="tdleft"><?php echo ($rs["addname"])?$rs["addname"]:"用户";?></td>
		<td class="tdleft"><?php echo $cslogswork[(int)$rs["apply"]]["name"];?></td>
		<td class="tdleft"><?php echo date("Y-m-d H:i:s",$rs["dateline"])?></td>
		<td class="tdleft"><span class="pointer" onclick="editcslogs('<?php echo base64_encode($rs["id"]);?>')">[修改]</span><span class="pointer" onclick="delcslogs('<?php echo base64_encode($rs["id"]);?>')">[删除]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="7" class="tdcenter"><?php echo $page = str_replace("page(","cslogslist(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="7" class="tdcenter">暂无服务记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="cslogsinfo"){?>
<input type="hidden" name="cslogs_id" id="cslogs_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<table width="450" class="table">
  <tr>
    <td width="100" height="25" class="tdright">项目：</td>
    <td class="">
    <select name="cslogs_type" id="cslogs_type" class="select">
    <option value="">选择服务类别</option>
    <?php foreach($cslogstype AS $rs){?>
    <option value="<?php echo $rs["id"];?>" <?php echo ($rs["id"]==$info["type"])?"selected":"";?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select>
    </td>
  </tr>
  <tr>
    <td height="35" class="tdright">时间：</td>
    <td class=""><input type="text" name="cslogs_datetime" id="cslogs_datetime" class="input" style="width:100px;" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>" readonly></td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td class="tdright">服务批注：</td>
    <td class=""><textarea name="cslogs_detail" id="cslogs_detail" class="textarea" style="width:300px;height:100px;"><?php echo $info["detail"];?></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="cslogsbtn" onclick="cslogsed()" value="<?php echo ($_GET["do"]=="add")?"添加":"修改";?>记录">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="status"){?>

<table width="400" class="table">
<?php if($statustype){ ?>
  <tr>
  <?php $i=1; foreach($statustype AS $rs){?>
    <td height="25" class="tdleft<?php echo ($rs["color"])?" ".$rs["color"]:"";?>>">&nbsp;&nbsp;<input type="radio" name="status" id="status" value="<?php echo $rs["id"];?>" <?php if((int)$info["status"]==$rs["id"]){ echo "checked"; }?>> <?php echo $rs["name"];?>
    </td>
    <?php if($i%4=="0"){?></tr><tr><?php }?>
  <?php  $i++; }?>
  </tr>
  <tr>
    <td class="tdcenter" colspan="4" height="6"></td>
  </tr>

  <tr>
    <td colspan="4" class="tdcenter">
    <input type="button" class="button" onclick="statused()" value="确定"></td>
  </tr>
<?php }else{?>
  <tr>
    <td class="tdcenter" height="50">操作完成，无法再操作！</td>
  </tr>
  <tr>
    <td class="tdcenter">
    <input type="button" class="button" onclick="closedialog();" value="确定"></td>
  </tr>
<?php }?>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
</table>

<?php }elseif($type=="product"){?>

<table width="550" class="table">
  <tr>
    <td height="35" colspan="4" class="">
    <select name="product_categoryid" id="product_categoryid" class="select" style="width:225px;">
    <option value="">选择产品类目</option>
    <?php foreach($category AS $rs){?>
    <option value="<?php echo $rs["categoryid"];?>"><?php echo $rs["name"];?></option>
    <?php }?>
    </select>
    <select name="product_brandid" id="product_brandid" class="select" style="width:225px;">
    <option value="">选择产品品牌</option>
    <?php foreach($brand AS $rs){?>
    <option value="<?php echo $rs["brandid"];?>"><?php echo $rs["name"];?></option>
    <?php }?>
    </select>
    <input type="button" class="btnwhite" value="查找产品" onclick="searchinfo()">
    </td>
  </tr>
  <tr>
    <td height="35" class="tdright">产品名称：</td>
    <td class=""><input type="text" name="product_title" id="product_title" class="input" style="width:185px;"></td>
    <td class="tdright">产品编码：</td>
    <td class=""><input type="text" name="product_encoded" id="product_encoded" class="input" style="width:185px;"></td>
  </tr>
  <tr>
    <td height="35" colspan="4" class="tdcenter">
		<select name="product_arr" id="product_arr" multiple="multiple" class="select" style="width:100%;height:180px;">
			<option value="">请填入有效条件进行搜索..1231231231....</option>
		</select>

    </td>
  </tr>
  <tr>
    <td height="35" class="tdright">订购数量：</td>
    <td class=""><input type="text" name="product_nums" id="product_nums"  class="input" value = "1" style="width:50px;"></td>
    <td class="tdright"></td>
    <td class="tdright">
    <input type="button" class="button" onclick="addproduct()" value="添加产品"></td>
  </tr>
</table>

<?php }elseif($type=="printlogs"){?>

<table width="300" class="table">
<?php if($logs){?>
  <tr>
    <td class="size14 red" height="22"><b>订单已经被打印过<?php echo $printnums;?>次，最近3次打印记录:</b></td>
  </tr>
  <tr>
    <td class="tdcenter" height="5"></td>
  </tr>
  <tr>
    <td class="size14" height="22">
  	<?php $i=1; foreach($logs AS $rs){?>
  	[<?php echo $i;?>] <?php echo date("Y-m-d H:i:s",$rs["dateline"]);?> <?php echo $rs["printname"];?><br>
    <?php $i++;}?>
    </td>
  </tr>
  <tr>
    <td class="tdcenter" height="10"></td>
  </tr>
<?php }?>
  <tr>
    <td class="tdcenter">
    <input type="button" class="btnorange" onclick="printView();" value="打印订单">
    <input type="button" class="button" onclick="closedialog();" value="取消打印"></td>
  </tr>
</table>


<?php }elseif($type=="checkreg"){?>

<input type="hidden" name="checked_id" id="checked_id" value="<?php echo $_GET["id"];?>">
<table width="450" class="table">
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td width="100" class="tdright">操作批注：</td>
    <td class=""><textarea name="checked_detail" id="checked_detail" class="textarea" style="width:300px;height:100px;"><?php echo $info["detail"];?></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="checkbtn" onclick="checkregbtn()" value="提交审核请求">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="files"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
        <td width="100" class="tdcenter">类别</td>
		<td width="270" class="tdleft">文件 [点击可以查看]</td>
		<td class="tdleft">批注</td>
		<td width="60" class="tdleft">上传人</td>
		<td width="140" class="tdleft">时间</td>
		<td width="90" class="tdleft">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
        <td class="tdcenter"><?php echo $filetype[(int)$rs["type"]]["name"];?>
		<td class="tdleft ublue"><a class="pointer" onclick="viewfiles('<?php echo base64_encode($rs["id"]);?>');"><?php echo $rs["files"]?></a></td>
		<td class="tdleft gary"><?php echo ($rs["detail"])?$rs["detail"]:"无批注信息";?></td>
		<td class="tdleft"><?php echo $rs["addname"];?></td>
		<td class="tdleft"><?php echo date("Y-m-d H:i",$rs["dateline"]);?></td>
		<td class="tdleft"><span class="pointer" onclick="editfiles('<?php echo base64_encode($rs["id"]);?>')">[批注]</span><span class="pointer" onclick="delfiles('<?php echo base64_encode($rs["id"]);?>')">[删除]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="7" class="tdcenter"><?php echo $page = str_replace("page(","fileslist(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="7" class="tdcenter">暂无附件上传</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="filesviews"){?>

<img src="http://upfile.paas.shui.cn/<?php echo $info["files"]?>">
<?php }elseif($type=="filesinfo"){?>

<input type="hidden" name="files_id" id="files_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<table width="450" class="table">

  <tr>
    <td height="35" width="100" class="tdright">附件类型：</td>
    <td class=""> <select name="files_type" id="files_type" class="select">
        <option value="">请选择文件类型</option>
        <?php foreach($filetype AS $rs){?>
          <option value="<?php echo $rs["id"]?>" <?php if($rs["id"]==$info["type"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
        <?php }?>
      </select> </td>
  </tr>
  <tr>
    <td width="100" class="tdright">附件批注：</td>
    <td class=""><textarea name="files_detail" id="files_detail" class="textarea" style="width:300px;height:100px;"><?php echo $info["detail"];?></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="editinfod" onclick="filesinfo()" value="更新批注">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }else{?>

null

<?php }?>
