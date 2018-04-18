<?php if($show=="info"){?>

<div class="info">

<input type="hidden" name="dialog_id" id="dialog_id" value="<?php echo ($info["id"])?base64_encode($info["id"]):"";?>">
<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo base64_encode($orderinfo["id"]);?>">

<table width="600" class="table">

  <tr>
    <td width="15%" class="tdright">出库类别：</td>
    <td><input type="radio" name="dialog_type" id="dialog_type" value="1" <?php if((int)$info["type"]=="1"||$_GET["ac"]=="add"){ echo "checked"; }?>> 销售出库
    <input type="radio" name="dialog_type" id="dialog_type" value="0" <?php if($info["type"]=="0"){ echo "checked"; }?>> 销售退库</td>
    <td width="15%" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td class="tdright">ERP单据号：</td>
    <td><input type="text" name="dialog_erpnum" id="dialog_erpnum" class="input" value="<?php echo $info["erpnum"];?>" style="width:200px;"></td>
    <td class="tdright"></td>
    <td></td>
  </tr>

  <tr>
    <td colspan="4" class="tdcenter">

	<table width="100%" class="parinfo">
	<tr class="bgheader">
		<td width="80" class="tdcenter">产品编码</td>
		<td class="tdcenter">订购信息</td>
		<td width="160" class="tdcenter">库房/出库数</td>
	</tr>
	<?php if($product){?>
	<?php foreach($product AS $rs){?>
	<tr class="datas">
		<input type="hidden" class="dialog_pid" id="<?php echo $rs["id"]?>">
		<input type="hidden" id="erpname_<?php echo $rs["id"];?>" value="<?php echo ($rs["erpname"])?$rs["erpname"]:"#".$rs["encoded"]."] 商品";?>">
		<input type="hidden" id="productid_<?php echo $rs["id"];?>" value="<?php echo $rs["productid"]?>">
		<input type="hidden" id="encoded_<?php echo $rs["id"];?>" value="<?php echo $rs["encoded"]?>">
		<input type="hidden" id="maxnums_<?php echo $rs["id"];?>" value="<?php echo (int)$rs["nums"]-(int)$rs["storenums"]?>">
		<input type="hidden" id="storenums_<?php echo $rs["id"];?>" value="<?php echo (int)$rs["storenums"]?>">
		<td class="tdcenter"><?php echo $rs["encoded"]?></td>
		<td class="tdleft"><?php echo $rs["erpname"]?><br>出库金额：<span class="red"><?php echo round($rs["erpprice"],2)?></span> 元<br>销售数量：<span class="red"><?php echo (int)$rs["nums"]?></span> 件 / 可出数量：<span class="red"><?php echo (int)$rs["nums"]-(int)$rs["storenums"]?></span> 件</td>
		<td class="tdleft"><select id="storeid_<?php echo $rs["id"];?>" class="select" style="width:160px;text-align:center;">
		<?php foreach($stores AS $r){?>
		<option value="<?php echo $r["id"]?>" <?php if($rs["storeid"]==$r["id"]){ echo "selected"; }?>><?php echo $r["encoded"]?> <?php echo $r["name"]?></option>
		<?php }?>
		</select><br><input type="text" id="nums_<?php echo $rs["id"]?>" class="input" style="width:50px;text-align:center;" value="<?php echo ($_GET["ac"]=="edit")?$rs["editnums"]:(int)$rs["nums"]-(int)$rs["storenums"]?>"></td>
	</tr>
	<?php }?>
	<?php }else{?>
	<tr class="datas">
		<td colspan="4" class="tdcenter">暂无订购信息</td>
	</tr>
	<?php }?>
	</table>

    </td>
  </tr>

  <tr>
    <td colspan="4" class="tdcenter">
    <input type="button" class="button" id="btned" onclick="storeinfod()" value="提交单据">
    <input type="button" value="取消" class="btnviolet" onclick="closedialog();" />
    </td>
  </tr>
</table>

</div>

<?php }elseif($show=="lists"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="80" class="tdcenter">类型</td>
		<td width="140" class="tdleft">录单时间</td>
		<td width="80" class="tdleft">录单人</td>
		<td class="tdleft">ERP编号</td>
		<td width="80" class="tdleft">复核状态</td>
		<td width="130" class="tdleft">复核时间</td>
		<td width="80" class="tdleft">确认状态</td>
		<td width="150" class="tdleft">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter"><?php switch($rs["type"]){
      case "1" : echo "销售出库";break;
      // case "2" : echo "云净出库";break;
      // case "3" : echo "云净退库";break;
      default  : echo "销售退库";
    };?></td>
		<td class="tdleft"><?php echo date("Y-m-d H:i",$rs["dateline"]);?></td>
		<td class="tdleft"><?php echo ($rs["userid"])?$rs["addname"]:"系统默认";?></td>
		<td class="tdleft blue"><a href="javascript:void(0)" onclick="viewstore('<?php echo base64_encode($rs["id"]);?>')"><?php echo $rs["erpnum"];?></a></td>
		<td class="tdleft"><?php switch($rs["checked"]){
			case "1" : echo "<span class='green'>完成确认</span>";break;
			case "4" : echo "<span class='gray'>无需确认</span>";break;
			default  : echo "<span class='red'>等待确认</span>";
		}?></td>
		<td class="tdleft"><?php echo ($rs["checkdate"])?date("Y-m-d H:i",$rs["checkdate"]):"-";?></td>
		<td class="tdleft blue"><?php switch($rs["deliver"]){
			case "1" : echo "<span class='green'>完成复核</span>";break;
			case "4" : echo "<span class='gray'>取消出库</span>";break;
			default  : echo "<span class='red'>等待复核</span>";
		}?></td>
		<td class="tdleft"><a href="javascript:void(0)" onclick="viewstore('<?php echo base64_encode($rs["id"]);?>')">[查看]</a><span class="pointer" onclick="editstore('<?php echo base64_encode($rs["id"]);?>')">[修改]</span><span class="pointer" onclick="delstore('<?php echo base64_encode($rs["id"]);?>')">[取消]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="8" class="tdcenter"><?php echo $page = str_replace("page(","storelist(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="8" class="tdcenter">暂无出库记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($show=="checked"){?>

<div class="info">

<input type="hidden" name="dialog_id" id="dialog_id" value="<?php echo ($info["id"])?base64_encode($info["id"]):"";?>">
<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo base64_encode($orderinfo["id"]);?>">

<table width="660" class="table">

  <tr>
    <td width="15%" class="tdright">出库类别：</td>
    <td><?php switch($info["type"]){
      case "1" : echo "销售出库";break;
      default  : echo "销售退库";
    };?></td>
    <td width="15%" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td class="tdright">ERP单据号：</td>
    <td><input type="text" name="dialog_erpnum" id="dialog_erpnum" class="input" value="<?php echo $info["erpnum"];?>" style="width:200px;"></td>
    <td class="tdright"></td>
    <td></td>
  </tr>

  <tr>
    <td colspan="4" class="tdcenter">

	<table width="100%" class="parinfo">
	<tr class="bgheader">
		<td width="80" class="tdcenter">产品编码</td>
		<td class="tdcenter">商品信息</td>
		<td width="160" class="tdcenter">库房/出库数</td>
	</tr>
	<?php if($deliverinfo){?>
	<?php foreach($deliverinfo AS $rs){?>
	<tr class="datas">
		<td class="tdcenter"><?php echo $rs["encoded"]?></td>
		<td class="tdleft"><?php echo $rs["title"]?></td>
		<td class="tdleft"><?php echo $rs["storename"]?><br>数量：<span class="red"><?php echo (int)$rs["nums"]?></span></td>
	</tr>
	<?php }?>
	<?php }else{?>
	<tr class="datas">
		<td colspan="4" class="tdcenter">暂无出库信息</td>
	</tr>
	<?php }?>
	</table>

    </td>
  </tr>
  <tr>
    <td colspan="4" class="tdcenter red">注：出库一旦确认，不同库房的商品将分拆成多个单据。（将无法再进行修改及合并操作） </td>
  </tr>

  <tr>
    <td colspan="4" class="tdcenter">
    <input type="button" class="button" id="btned" onclick="checkinfod()" value="确认单据">
    <input type="button" value="取消" class="btnviolet" onclick="closedialog();" />
    </td>
  </tr>
</table>


</div>

<?php }else{?>

NULL

<?php }?>
