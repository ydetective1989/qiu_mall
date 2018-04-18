<?php if($type=="lists"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="120" class="tdleft">时间</td>
		<td width="100" class="tdleft">类型</td>
		<td width="120" class="tdleft">单号</td>
		<td class="tdleft">批注内容</td>
		<td width="60" class="tdleft">状态</td>
		<td width="60" class="tdleft">录入人</td>
		<td width="130" class="tdleft">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdleft"><?php echo date("Y-m-d H:i",$rs["dateline"]);?></td>
		<td class="tdleft"><?php echo $rs["expname"]?></td>
		<td class="tdleft"><span class="pointer" onclick="viewexpress('<?php echo base64_encode($rs["id"]);?>')"><?php echo $rs["numbers"]?></span></td>
		<td class="tdleft"><font class="blue">[<?php echo $expresstype[(int)$rs["type"]]["name"]?>]</font> <?php echo $rs["detail"]?></td>
		<td class="tdleft"><?php echo $expstate[(int)$rs["finished"]]["name"]?></td>
		<td class="tdleft"><?php echo $rs["addname"];?></td>
		<td class="tdleft"><span class="pointer" onclick="editexpress('<?php echo base64_encode($rs["id"]);?>')">[修改]</span><?php if($rs["checked"]=="1"){?><span class="gray">[确认]</span><?php }else{?><span class="pointer red" onclick="checkexpress('<?php echo base64_encode($rs["id"]);?>')">[确认]</span><?php }?><span class="pointer" onclick="delexpress('<?php echo base64_encode($rs["id"]);?>')">[删除]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="8" class="tdcenter"><?php echo $page = str_replace("page(","expresslist(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="8" class="tdcenter">暂无物流记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="info"){?>

<input type="hidden" name="express_id" id="express_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<input type="hidden" name="express_ordersid" id="express_ordersid" value="<?php echo ((int)$info["ordersid"])?base64_encode((int)$info["ordersid"]):$_GET["id"]?>">

<table class="table">
  <tr>
    <td width="450">

		<table width="100%" class="table">
		  <tr>
		    <td width="100" height="25" class="tdright">物流类型：</td>
		    <td class="">
		    <select name="express_cateid" id="express_cateid" class="select">
		    <option value="">选择物流公司</option>
		    <?php foreach($cates AS $rs){?>
		    <option value="<?php echo $rs["id"];?>" <?php echo ($rs["id"]==$info["cateid"]||$_GET["cateid"]==$rs["id"])?"selected":"";?>><?php echo $rs["name"];?></option>
		    <?php }?>
		    </select>
		    <select name="express_type" id="express_type" class="select">
		    <option value="">选择包裹内容</option>
		    <?php foreach($expresstype AS $rs){?>
		    <option value="<?php echo $rs["id"];?>" <?php echo ($rs["id"]==$info["type"]||($_GET["ac"]=="add"&&$_GET["type"]==$rs["id"]))?"selected":"";?>><?php echo $rs["name"];?></option>
		    <?php }?>
		    </select>
		    </td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright">时间：</td>
		    <td class=""><input type="text" name="express_datetime" id="express_datetime" class="input" style="width:100px;" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>" readonly></td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright">物流单号：</td>
		    <td class=""><input type="text" name="express_numbers" id="express_numbers" class="input" style="width:150px;" value="<?php echo ($info["numbers"])?$info["numbers"]:$_GET["numbers"];?>"></td>
		  </tr>
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td class="tdright">批注内容：</td>
		    <td class=""><textarea name="express_detail" id="express_detail" class="textarea" style="width:320px;height:100px;"><?php echo ($info["detail"])?$info["detail"]:$definfo;?></textarea><td>
		  </tr>
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright"></td>
		    <td class="">
		    <input type="button" class="button" id="infoed" onclick="exp_infod()" value="<?php echo ($_GET["ac"]=="add")?"添加":"修改";?>物流记录">
		    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
		  </tr>
		</table>
	</td>
  </tr>
</table>

<?php }elseif($type=="checked"){?>

<input type="hidden" name="express_id" id="express_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<input type="hidden" name="express_ordersid" id="express_ordersid" value="<?php echo ((int)$info["ordersid"])?base64_encode((int)$info["ordersid"]):$_GET["id"]?>">

<table class="table">
  <tr>
    <td width="450">

		<table width="100%" class="table">
		  <tr>
		    <td width="100" height="25" class="tdright">物流类型：</td>
		    <td class="">
		    <select name="express_cateid" id="express_cateid" class="select">
		    <option value="">选择物流公司</option>
		    <?php foreach($cates AS $rs){?>
		    <option value="<?php echo $rs["id"];?>" <?php echo ($rs["id"]==$info["cateid"])?"selected":"";?>><?php echo $rs["name"];?></option>
		    <?php }?>
		    </select>
		    </td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright">时间：</td>
		    <td class=""><input type="text" name="express_datetime" id="express_datetime" class="input" style="width:100px;" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>" readonly ></td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright">物流单号：</td>
		    <td class=""><input type="text" name="express_numbers" id="express_numbers" class="input" style="width:150px;" value="<?php echo $info["numbers"];?>"></td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright">快递重量：</td>
		    <td class=""><input type="text" name="express_weight" id="express_weight" class="input" style="width:100px;" value="<?php echo ($info["weight"])?$info["weight"]:"";?>"> kg</td>
		  <tr>
		    <td height="35" class="tdright">快递费用：</td>
		    <td class=""><input type="text" name="express_price" id="express_price" class="input" style="width:100px;" value="<?php echo ($info["price"])?$info["price"]:"";?>"> 元</td>
		  </tr>
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td class="tdright">批注内容：</td>
		    <td class=""><textarea name="express_detail" id="express_detail" class="textarea" style="width:320px;height:100px;"><?php echo $info["detail"];?></textarea><td>
		  </tr>
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright"></td>
		    <td class="">
		    <input type="button" class="button" id="infoed" onclick="checkdo()" value="确认物流记录">
		    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
		  </tr>
		</table>
	</td>
  </tr>
</table>  

<?php }else{?>

null

<?php }?>
