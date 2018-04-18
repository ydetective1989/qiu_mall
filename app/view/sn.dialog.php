<?php if($type=="lists"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="100" class="tdleft">来源</td>
		<td width="150" class="tdleft">序列号</td>
		<td class="tdleft">备注</td>
		<td width="80" class="tdleft">操作人</td>
		<td width="120" class="tdleft">更新日期</td>
		<td width="90" class="tdleft">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdleft"><?php echo $rs["tags"];?></td>
		<td class="tdleft"><?php echo $rs["sn"];?></td>
		<td class="tdleft gray"><?php echo $rs["detail"]?></td>
		<td class="tdleft"><?php echo ($rs["addname"])?$rs["addname"]:"系统默认";?></td>
		<td class="tdleft"><?php echo date("Y-m-d H:i",$rs["dateline"])?></td>
		<td class="tdleft"><span class="pointer" onclick="editsn('<?php echo base64_encode($rs["id"]);?>')">[修改]</span><span class="pointer" onclick="delsn('<?php echo base64_encode($rs["id"]);?>')">[删除]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="8" class="tdcenter"><?php echo $page = str_replace("page(","snlist(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="8" class="tdcenter">暂无序列记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="info"){?>

<input type="hidden" name="dialog_id" id="dialog_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<input type="hidden" name="dialog_ordersid" id="dialog_ordersid" value="<?php echo ((int)$info["ordersid"])?base64_encode((int)$info["ordersid"]):$_GET["id"];?>">

<table class="table">
  <tr>
    <td width="450">
    
		<table width="100%" class="table">
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
          <?php if($taskjobs){?>
            <tr>
              <td height="35" class="tdright">工单任务：</td>
              <td class=""><select name="charge_jobsid" id="charge_jobsid" class="select">
                  <option value="0">选择工单任务</option>
                  <?php foreach($taskjobs AS $rs){?>
                    <option value="<?php echo $rs["id"]?>"><?php echo $rs["id"]?></option>
                  <?php }?>
                </select></td>
            </tr>
          <?php }else{?>
            <input type="hidden" name="charge_jobsid" id="charge_jobsid" value="0">
          <?php }?>
		  <tr>
		    <td width="100" height="25" class="tdright">序列号：</td>
		    <td class=""><input name="dialog_sn" id="dialog_sn" class="input" style="width:180px;" value="<?php echo $info["sn"];?>"></td>
		  </tr>
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td class="tdright">采集备注：</td>
		    <td class=""><textarea name="dialog_detail" id="dialog_detail" class="textarea" style="width:320px;height:60px;"><?php echo $info["detail"];?></textarea><td>
		  </tr>
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright"></td>
		    <td class="">
		    <input type="button" class="button" id="btned" onclick="<?php echo ($_GET["ac"]=="edit")?"sn_edited":"sn_added";?>()" value="确定提交">
		    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
		  </tr>
		</table>
	</td>
  </tr>
</table>  



<?php }elseif($show=="checked"){?>

<input type="hidden" name="spare_id" id="spare_id" value="<?php echo base64_encode((int)$info["id"])?>">
<input type="hidden" name="spare_ordersid" id="spare_ordersid" value="<?php echo base64_encode((int)$info["ordersid"])?>">
<table width="460" class="table">
  <tr>
    <td width="120" height="35" class="tdright">订单编号：</td>
    <td class=""><span class="red bold"><?php echo $info["ordersid"];?></span></td>
  </tr>
  <tr>
    <td height="25" class="tdright">使用性质：</td>
    <td class="">
    <select name="spare_cateid" id="spare_cateid" class="select">
    <?php foreach($cates AS $rs){?>
    <option value="<?php echo $rs["id"];?>" <?php echo ($rs["id"]==$info["cateid"])?"selected":"";?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="25" class="tdright">审核：</td>
    <td class="">
    <input type="radio" name="spare_checked" value="1" checked> 正常
    <input type="radio" name="spare_checked" value="3"> 异常
    <input type="radio" name="spare_checked" value="0"> 等待审核
    </td>
  </tr>
  <tr>
    <td height="8" class="tdright"></td>
    <td class=""></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="btned" onclick="spare_checkdo()" value="审核操作">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="addspare"){?>
<input type="hidden" name="spare_ordersid" id="spare_ordersid" value="<?php echo base64_encode($ordersid);?>" >
<table width="550" class="table">
  <tr>
    <td height="35" colspan="4" class="tdright">配件名称：<input type="text" name="spare_title" id="spare_title" class="input" style="width:140px;"> 产品编码：<input type="text" name="spare_encoded" id="spare_encoded" class="input" style="width:140px;">
    <input type="hidden" name="spare_categoryid" id="spare_categoryid" value="14" >
    <input type="hidden" name="spare_brandid" id="spare_brandid" value="">
    <input type="button" class="btnwhite" value="查找配件" onclick="searchinfo()">
    </td>
  </tr>
  <tr>
    <td height="35" colspan="4" class="tdcenter">
		<select name="product_arr" id="product_arr" multiple="multiple" class="select" style="width:100%;height:180px;">
			<option value="">请填入有效条件进行搜索......</option>
		</select>
    
    </td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright">使用批注：</td>
    <td colspan="3" class="tdleft"><input type="text" name="spare_detail" id="spare_detail"  class="input" value = "" style="width:460px;"></select>
    </td>
  </tr>
  <tr>
    <td height="35" class="tdright">使用数量：</td>
    <td class="" colspan="2"><input type="text" name="spare_nums" id="spare_nums"  class="input" value = "1" style="width:50px;">
    <select name="spare_cateid" id="spare_cateid" class="select">
    <option value="" selected>请选择性质类别</option>
    <?php foreach($cates AS $rs){?>
    <option value="<?php echo $rs["id"];?>" <?php echo ($rs["id"]==$info["cateid"])?"selected":"";?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select></td>
    <td class="tdright">
    <input type="button" class="button" id="buttoned" onclick="sparelog_add()" value="添加备件记录"></td>
  </tr>
</table>

<?php }else{?>

null

<?php }?>