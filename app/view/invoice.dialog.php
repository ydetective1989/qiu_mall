<?php if($type=="invoiceinfo"){?>

<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo base64_encode($info["id"])?>">
<table width="550" class="table">
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td width="130" height="30" class="tdright">订单类型：</td>
    <td><input type="radio" name="invoice_type" value="0" <?php if((int)$info["type"]=="0"){ echo "checked"; }?> onclick="invoicetype(0)" > 增值税普通发票
    <input type="radio" name="invoice_type" value="1" <?php if((int)$info["type"]=="1"){ echo "checked"; }?> onclick="invoicetype(1)"> 增值税专用发票</td>
  </tr>
  <tr>
    <td height="30" class="tdright">开票单位：</td>
    <td><select name="invoice_cateid" id="invoice_cateid" class="select">
    <option value="">选择开票单位</option>
    <?php foreach($catetype AS $rs){?>
    <option value="<?php echo $rs["id"];?>" <?php if((int)$info["cateid"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select></td>
  </tr>
  <tr>
    <td height="30" class="tdright">发票抬头：</td>
    <td><input type="text" name="invoice_title" id="invoice_title" class="input" value="<?php echo ($info["title"])?$info["title"]:$ordersinfo["name"];?>" style="width:300px;"></td>
  </tr>
  <input type="hidden" name="invoice_priceno" id="invoice_priceno" value="<?php echo round($opennums,2);?>">
  <tr>
    <td height="30" class="tdright">开票金额：</td>
    <td><input type="text" name="invoice_price" id="invoice_price" class="input" value="<?php echo ($info["price"])?$info["price"]:$opennums;?>" style="width:100px;"> 元 (已开金额:<span class='red'><?php echo round($countnums,2);?></span>元，可开<span class='red'><?php echo round($opennums,2);?></span>元)</td>
  </tr>
  <tr>
    <td height="2" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td height="30" class="tdright">开票内容：</td>
    <td><textarea name="invoice_detail" id="invoice_detail" class="textarea" style="width:350px;height:100px;"><?php echo $info["detail"];?></textarea><br>发票项目请填写：产品名称、数量、单价、金额，内容。<br>如果填写不完整，将拒绝开据，不作任何解释！<br>如不清楚，请仔细阅读<a href="<?php echo $S_ROOT;?>upfile/invoice.doc" target="_blank">《发票开据流程规范》</a></td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td height="30" class="tdright">是否需要邮寄：</td>
    <td><input type="radio" name="invoice_posted" value="0" <?php if((int)$info["posted"]=="0"){ echo "checked"; }?> onclick="invoicepost(0)" > 不需要
    <input type="radio" name="invoice_posted" value="1" <?php if((int)$info["posted"]=="1"){ echo "checked"; }?> onclick="invoicepost(1)"> 需要</td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
</table>

  <table width="550" class="table" id="edtypes">
    <tr class="bgheader">
      <td colspan="2" height="30" class="tdcenter">企业开具发票下面信息必须填写</td>
    </tr>
    <tr>
      <td height="5" class="tdright"></td>
      <td></td>
    </tr>
    <tr>
      <td height="30" width="130" class="tdright">公司名称：</td>
      <td><input name="invoice_corpname" id="invoice_corpname" type="text" class="input" value="<?php echo $info["corpname"]?>" style="width:300px;"></td>
    </tr>
    <tr>
      <td height="30" class="tdright">公司地址：</td>
      <td><input name="invoice_corpaddress" id="invoice_corpaddress" type="text" class="input" value="<?php echo $info["corpaddress"]?>" style="width:300px;"></td>
    </tr>
    <tr>
      <td height="30" class="tdright">公司电话：</td>
      <td><input name="invoice_corptel" id="invoice_corptel" type="text" class="input" value="<?php echo $info["corptel"]?>" style="width:300px;"></td>
    </tr>
    <tr>
      <td height="30" class="tdright">公司税号：</td>
      <td><input name="invoice_corpnums" id="invoice_corpnums" type="text" class="input" value="<?php echo $info["corpnums"]?>" style="width:300px;"></td>
    </tr>
    <tr>
      <td height="30" class="tdright">开户信息：</td>
      <td><input name="invoice_corpbank" id="invoice_corpbank" type="text" class="input" value="<?php echo $info["corpbank"]?>" style="width:300px;"></td>
    </tr>
    <tr>
      <td height="5" class="tdright"></td>
      <td class="red">* 如中国银行吉林省分行220802*****</td>
    </tr>
    <tr>
      <td height="5" class="tdright"></td>
      <td></td>
    </tr>
  </table>


  <table width="550" class="table" id="posttypes" style="<?php if(!(int)$info["posted"]){ echo "display:none;"; }?>">
    <tr class="bgheader">
      <td colspan="2" height="30" class="tdcenter">邮寄地址</td>
    </tr>
    <tr>
      <td height="5" class="tdright"></td>
      <td></td>
    </tr>
  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/areas"></script>
  <script type="text/javascript">var provid='<?php echo (int)$info["provid"];?>';var cityid='<?php echo (int)$info["cityid"];?>';var areaid='<?php echo (int)$info["areaid"];?>';</script>
  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.areas.js"></script>
  <tr>
    <td height="30" width="130" class="tdright">收件人姓名：</td>
    <td><input name="invoice_postname" id="invoice_postname" type="text" class="input" value="<?php echo ($info["postname"])?$info["postname"]:$ordersinfo["name"];?>" style="width:300px;"></td>
  </tr>
  <tr>
    <td class="tdright">寄往城市：</td>
    <td colspan="3"><input type="text" name="invoice_cityname" id="invoice_cityname" class="input" style="width:150px;" value="<?php echo ($info["cityname"])?$info["cityname"]:$ordersinfo["cityname"]." ".$ordersinfo["areaname"];?>"> * 填写格式为：{城市}+空格+{区县}</td>
  </tr>
  <tr>
    <td height="30" class="tdright">邮寄地址：</td>
    <td><input name="invoice_postaddress" id="invoice_postaddress" type="text" class="input" value="<?php echo ($info["postaddress"])?$info["postaddress"]:$ordersinfo["address"];?>" style="width:300px;"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">联系电话：</td>
    <td><input name="invoice_postphone" id="invoice_postphone" type="text" class="input" value="<?php echo ($info["postphone"])?$info["postphone"]:$ordersinfo["mobile"]." ".$ordersinfo["phone"];?>" style="width:300px;"></td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
</table>

<table width="550" class="table">
  <tr>
    <td width="130" height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="invoicebtn" onclick="invoiced()" value="<?php echo ($info)?"修改":"提交";?>发票申请">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="invoice"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="80" class="tdleft">申请编号</td>
		<td class="tdleft">开票单位/发票抬头</td>
		<td width="60" class="tdleft">开票金额</td>
		<td width="80" class="tdleft">申请时间</td>
		<td width="60" class="tdleft">申请人</td>
		<td width="60" class="tdleft">审核</td>
		<td width="60" class="tdleft">出票</td>
		<?php if(!$editno){?>
		<td width="90" class="tdleft">操作</td>
		<?php }?>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdleft"><a href="<?php echo $S_ROOT?>invoice/views?id=<?php echo base64_encode($rs["id"]);?>"><?php echo $rs["id"];?></a></td>
		<td class="tdleft"><?php echo $rs["title"];?> <span class="gray"><?php echo $catetype[(int)$rs["cateid"]]["name"];?></span></td>
		<td class="tdleft red"><?php echo $rs["price"];?></td>
		<td class="tdleft"><?php echo date("Y-m-d",$rs["dateline"]);?></td>
		<td class="tdleft"><?php echo $rs["addname"];?></td>
		<td class="tdleft"><?php echo $checktype[(int)$rs["checked"]]["name"];?></td>
		<td class="tdleft"><?php echo $worktype[(int)$rs["worked"]]["name"];?></td>
		<?php if(!$editno){?>
		<td class="tdleft"><span class="pointer" onclick="editinvoice('<?php echo base64_encode($rs["id"]);?>')">[修改]</span><span class="pointer" onclick="delinvoice('<?php echo base64_encode($rs["id"]);?>')">[删除]</span></td>
		<?php }?>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="8" class="tdcenter"><?php echo $page = str_replace("page(","invoicelist(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="8" class="tdcenter">暂无申请记录</td>
	</tr>
	<?php }?>
</table>


<?php }elseif($type=="checked"){?>

<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo base64_encode($info["id"])?>">
<input type="hidden" name="invoice_ordersid" id="invoice_ordersid" value="<?php echo base64_encode($info["ordersid"])?>">
<table width="420" class="table">
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td width="100" height="30" class="tdright">审核选项：</td>
    <td><?php foreach($checktype AS $rs){?>
    <input type="radio" name="invoice_checked" value="<?php echo $rs["id"]?>" <?php if((int)$info["checked"]==$rs["id"]){ echo "checked"; }?> onclick="checktype()"> <?php echo $rs["name"]?>
    <?php }?></td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
  <tr id="workdetails" <?php if((int)$info["checked"]!=2){ echo "style=\"display:none;\""; }?>>
    <td height="30" class="tdright">处理批注：</td>
    <td><textarea name="invoice_workinfo" id="invoice_workinfo" class="textarea" style="min-width:280px;height:120px;"><?php echo $info["workinfo"];?></textarea></td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="checkbtnd" onclick="checkedo()" value="审核处理">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>


<?php }elseif($type=="opened"){?>

<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo base64_encode($info["id"])?>">
<input type="hidden" name="invoice_ordersid" id="invoice_ordersid" value="<?php echo base64_encode($info["ordersid"])?>">
<table width="550" class="table">
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td height="30" class="tdright">发票编号：</td>
    <td><input type="text" name="invoice_worknums" id="invoice_worknums" class="input" value="<?php echo $info["worknums"]?>" style="width:200px;"> <span class="red">* 此为开具的发票编号</span></td>
  </tr>
  <tr>
    <td height="30" class="tdright">操作批注：</td>
    <td><textarea name="invoice_workinfo" id="invoice_workinfo" class="textarea" style="width:350px;height:100px;"><?php echo ($info["worked"]=="1")?$info["workinfo"]:"";?></textarea></td>
  </tr>
  <tr>
    <td height="8" class="tdright"></td>
    <td></td>
  </tr>
  <tr class="bgheader">
    <td colspan="2" height="30" class="tdcenter">发票信息</td>
  </tr>
  <tr>
    <td width="130" height="30" class="tdright">订单类型：</td>
    <td><input type="radio" name="invoice_type" value="0" <?php if((int)$info["type"]=="0"){ echo "checked"; }?> onclick="invoicetype(0)" > 增值税普通发票
    <input type="radio" name="invoice_type" value="1" <?php if((int)$info["type"]=="1"){ echo "checked"; }?> onclick="invoicetype(1)"> 增值税专用发票</td>
  </tr>
  <tr>
    <td height="30" class="tdright">开票单位：</td>
    <td><select name="invoice_cateid" id="invoice_cateid" class="select">
    <option value="">选择开票单位</option>
    <?php foreach($catetype AS $rs){?>
    <option value="<?php echo $rs["id"];?>" <?php if((int)$info["cateid"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select></td>
  </tr>
  <tr>
    <td height="30" class="tdright">发票抬头：</td>
    <td><input type="text" name="invoice_title" id="invoice_title" class="input" value="<?php echo ($info["title"])?$info["title"]:$ordersinfo["name"];?>" style="width:300px;"></td>
  </tr>
  <input type="hidden" name="invoice_priceno" id="invoice_priceno" value="<?php echo round($opennums,2);?>">
  <tr>
    <td height="30" class="tdright">开票金额：</td>
    <td><input type="text" name="invoice_price" id="invoice_price" class="input" value="<?php echo ($info["price"])?$info["price"]:round($opennums,2);?>" style="width:100px;"> 元 (已开金额:<span class='red'><?php echo round($countnums,2);?></span>元，可开<span class='red'><?php echo round($opennums,2);?></span>元)</td>
  </tr>
  <tr>
    <td height="2" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td height="30" class="tdright">开票内容：</td>
    <td><textarea name="invoice_detail" id="invoice_detail" class="textarea" style="width:350px;height:100px;"><?php echo $info["detail"];?></textarea><br>发票项目请填写：产品名称、数量、单价、金额，内容。<br>如果填写不完整，将拒绝开据，不作任何解释！<br>如不清楚，请仔细阅读<a href="upfile/invoice.doc" target="_blank">《发票开据流程规范》</a></td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
</table>

<table width="550" class="table" id="edtypes">
  <tr class="bgheader">
    <td colspan="2" height="30" class="tdcenter">企业开具发票下面信息必须填写</td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td height="30" width="130" class="tdright">公司名称：</td>
    <td><input name="invoice_corpname" id="invoice_corpname" type="text" class="input" value="<?php echo $info["corpname"]?>" style="width:300px;"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">公司地址：</td>
    <td><input name="invoice_corpaddress" id="invoice_corpaddress" type="text" class="input" value="<?php echo $info["corpaddress"]?>" style="width:300px;"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">公司电话：</td>
    <td><input name="invoice_corptel" id="invoice_corptel" type="text" class="input" value="<?php echo $info["corptel"]?>" style="width:300px;"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">公司税号：</td>
    <td><input name="invoice_corpnums" id="invoice_corpnums" type="text" class="input" value="<?php echo $info["corpnums"]?>" style="width:300px;"></td>
  </tr>
  <tr>
    <td height="30" class="tdright">开户信息：</td>
    <td><input name="invoice_corpbank" id="invoice_corpbank" type="text" class="input" value="<?php echo $info["corpbank"]?>" style="width:300px;"></td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td class="red">* 如中国银行吉林省分行220802*****</td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
</table>

<table width="550" class="table">
  <tr>
    <td width="130" height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="invoicebtn" onclick="invoiceopend()" value="开票操作">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="killed"){?>

<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo base64_encode($info["id"])?>">
<input type="hidden" name="invoice_ordersid" id="invoice_ordersid" value="<?php echo base64_encode($info["ordersid"])?>">
<table width="490" class="table">
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td width="120" height="30" class="tdright">项目类别：</td>
    <td><input type="radio" name="invoice_worked" value="2" <?php if($info["worknums"]==""){ echo "checked"; }?>> 申请取消
    <input type="radio" name="invoice_worked" value="3" <?php if($info["worknums"]!=""){ echo "checked"; }?>> 申请作废</td>
  </tr>
  <?php if($info["worknums"]){?>
  <tr>
    <td width="120" height="30" class="tdright">已开发票编号：</td>
    <td><?php echo $info["worknums"]?> <span class="red">* 此为开具的发票编号</span></td>
  </tr>
  <?php }?>
  <tr>
    <td height="30" class="tdright">操作批注：</td>
    <td><textarea name="invoice_workinfo" id="invoice_workinfo" class="textarea" style="width:320px;height:100px;"><?php echo ($info["worked"]=="2"||$info["worked"]=="3")?$info["workinfo"]:"";?></textarea><br> <span class="red">* 请先将开出的发票收回后，并在批注中标注作废说明</span></td>
  </tr>
</table>
<table width="490" class="table">
  <tr>
    <td width="120" height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="invoicebtn" onclick="invoicekilled()" value="开票作废">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }else{?>

null

<?php }?>
