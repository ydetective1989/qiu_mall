<?php if($type=="clocklist"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="100" class="tdcenter">提醒时间</td>
		<td width="80" class="tdleft">提醒级别</td>
		<td class="tdleft">提醒内容</td>
		<td width="130" class="tdright">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter"><?php echo $rs["datetime"];?></td>
		<td class="tdleft"><?php switch($rs["stars"]){
			case "2": echo "★★☆☆☆"; break;
			case "3": echo "★★★☆☆"; break;
			case "4": echo "★★★★☆"; break;
			case "5": echo "★★★★★"; break;
			default : echo "★☆☆☆☆";
		}?></td>
		<td class="tdleft"><?php echo $rs["clockinfo"]?></td>
		<td class="tdright"><span class="pointer" onclick="clocked('<?php echo base64_encode($rs["id"]);?>')">[回访]</span><span class="pointer" onclick="clockdinfo('<?php echo base64_encode($rs["id"]);?>')">[修改]</span><span class="pointer" onclick="delclockd('<?php echo base64_encode($rs["id"]);?>')">[删除]</span></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<?php if($worked=="0"){ $workstr = "clockdlogslist("; }else{ $workstr = "clockdlist("; }?>
		<td colspan="8" class="tdcenter"><?php echo $page = str_replace("page(",$workstr,$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="8" class="tdcenter">暂无相关记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="clockedclose"){?>

<input type="hidden" name="clockd_ordersid" id="clockd_ordersid" value="<?php echo ((int)$orderinfo["id"])?base64_encode((int)$orderinfo["id"]):"0";?>" />

<table width="470" class="table">
  <tr>
    <td class="tdcenter" colspan="2" height="8"></td>
  </tr>
  <tr>
    <td width="120" height="35" class="tdright">操作批注：</td>
    <td class=""><textarea name="clockd_detail" id="clockd_detail" class="textarea" style="width:300px;height:60px;"></textarea></td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
</table>
<table width="470" class="table">
  <tr>
    <td width="120" height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="btn" onclick="clockedclosed()" value="确认操作">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="callinfo"){?>

<input type="hidden" name="clockd_id" id="clockd_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):"0";?>" />
<input type="hidden" name="clockd_ordersid" id="clockd_ordersid" value="<?php echo ((int)$ordersinfo["id"])?base64_encode((int)$ordersinfo["id"]):"0";?>" />
<input type="hidden" name="clockd_worked" id="clockd_worked" value="<?php echo (int)$info["worked"];?>" >

<table width="470" class="table">
  <tr>
    <td class="tdcenter" colspan="2" height="8"></td>
  </tr>
  <tr>
    <td width="100" height="35" class="tdright">提醒批注：</td>
    <td class=""><textarea name="clockd_workdetail" id="clockd_workdetail" class="textarea" style="width:300px;height:60px;"><?php echo $info["workdetail"];?></textarea></td>
  </tr>
<?php if(!(int)$info["worked"]){?>
  <tr style="display:none;">
    <td width="100" height="35" class="tdright">提醒设置：</td>
    <td class=""><input type="checkbox" name="clockd_closed" id="clockd_closed" onclick="closebtn()" value="1" /> 不再提醒 </td>
  </tr>
</table>

<table width="470" class="table" id="degree_nextinfo">
  <tr>
    <td class="tdcenter" colspan="2" height="3"></td>
  </tr>
  <tr>
  	<td colspan="2"><hr></td>
  </tr>
  <tr>
    <td width="100" height="35" class="tdright">下次提醒：</td>
    <td class=""><select name="clockd_cycle" id="clockd_cycle" class="select" style="width:110px;">
    	<option value="">选择周期</option>
			<option value="1" <?php if($info["cycle"]=="1"){ echo "selected"; };?>>1天
			<option value="3" <?php if($info["cycle"]=="3"){ echo "selected"; };?>>3天
			<option value="7" <?php if($info["cycle"]=="7"){ echo "selected"; };?>>7天
    	<option value="30" <?php if($info["cycle"]=="30"){ echo "selected"; };?>>30天</option>
    	<option value="60" <?php if($info["cycle"]=="60"){ echo "selected"; };?>>60天</option>
    	<option value="90" <?php if($info["cycle"]=="90"){ echo "selected"; };?>>90天</option>
    	<option value="180" <?php if($info["cycle"]=="180"){ echo "selected"; };?>>180天</option>
    	<option value="365" <?php if($info["cycle"]=="365"){ echo "selected"; };?>>365天</option>
    </select></td>
  </tr>
  <tr>
    <td height="35" class="tdright">提醒级别：</td>
    <td class=""><select name="clockd_stars" id="clockd_stars" class="select" style="width:110px;">
		<option value="1" <?php if((int)$info["stars"]=="1"){ echo "selected"; };?>>★☆☆☆☆</option>
		<option value="2" <?php if((int)$info["stars"]=="2"){ echo "selected"; };?>>★★☆☆☆</option>
		<option value="3" <?php if((int)$info["stars"]=="3"){ echo "selected"; };?>>★★★☆☆</option>
		<option value="4" <?php if((int)$info["stars"]=="4"){ echo "selected"; };?>>★★★★☆</option>
		<option value="5" <?php if((int)$info["stars"]=="5"){ echo "selected"; };?>>★★★★★</option>
		</select></td>
  </tr>
  <tr>
    <td class="tdright">预提醒信息：</td>
    <td class=""><textarea name="clockd_clockinfo" id="clockd_clockinfo" class="textarea" style="width:300px;height:60px;"></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
<?php }?>
</table>
<table width="470" class="table">
  <tr>
    <td width="120" height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="calledbtn" onclick="called()" value="回执提醒记录">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="logslist"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
		<td width="80" class="tdcenter">提醒时间</td>
		<td width="80" class="tdleft">提醒级别</td>
		<td class="tdleft">提醒内容</td>
		<td width="60" class="tdright">提醒人员</td>
		<td width="90" class="tdright">操作日期</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas">
		<td class="tdcenter"><?php echo $rs["datetime"];?></td>
		<td class="tdleft"><?php switch($rs["stars"]){
			case "2": echo "★★☆☆☆"; break;
			case "3": echo "★★★☆☆"; break;
			case "4": echo "★★★★☆"; break;
			case "5": echo "★★★★★"; break;
			default : echo "★☆☆☆☆";
		}?></td>
		<td class="tdleft"><?php echo $rs["workdetail"]?></td>
		<td class="tdright"><?php echo $rs["workuname"]?></td>
		<td class="tdright"><?php echo date("Y-m-d",$rs["workdate"])?></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<?php if($worked=="1"){ $workstr = "clockdlogslist("; }else{ $workstr = "clockdlist("; }?>
		<td colspan="8" class="tdcenter"><?php echo $page = str_replace("page(",$workstr,$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="8" class="tdcenter">暂无相关记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="info"){?>

<input type="hidden" name="clockd_id" id="clockd_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):"0";?>" />
<input type="hidden" name="clockd_ordersid" id="clockd_ordersid" value="<?php echo ((int)$ordersinfo["id"])?base64_encode((int)$ordersinfo["id"]):"0";?>" />

<table width="450" class="table">
    <?php if($info){?>
    <tr>
    <td height="35" class="tdright">下次日期：</td>
    <td class=""><?php echo $info["datetime"]?></td>
    </tr><?php }?>
  <tr>
    <td height="35" class="tdright">提醒周期：</td>
    <td class=""><select name="clockd_cycle" id="clockd_cycle" class="select" style="width:110px;">
        <?php if($info){?>
        <option value="0">日期不调整</option>
        <?php }else{?>
        <option value="">选择周期</option>
        <?php }?>
    	<option value="30" <?php if($info["cycle"]==""){ echo "selected"; };?>>30天</option>
    	<option value="60" >60天</option>
    	<option value="90" >90天</option>
    	<option value="180">180天</option>
    </select></td>
  </tr>
  <tr>
    <td height="35" class="tdright">提醒级别：</td>
    <td class=""><select name="clockd_stars" id="clockd_stars" class="select" style="width:110px;">
		  <option value="1" <?php if((int)$info["stars"]=="1"){ echo "selected"; };?>>★☆☆☆☆</option>
          <option value="2" <?php if((int)$info["stars"]=="2"){ echo "selected"; };?>>★★☆☆☆</option>
          <option value="3" <?php if((int)$info["stars"]=="3"){ echo "selected"; };?>>★★★☆☆</option>
          <option value="4" <?php if((int)$info["stars"]=="4"){ echo "selected"; };?>>★★★★☆</option>
          <option value="5" <?php if((int)$info["stars"]=="5"){ echo "selected"; };?>>★★★★★</option>
	</select></td>
  </tr>
  <tr>
    <td height="35" class="tdright">提醒内容：</td>
    <td class=""><input type="text" name="clockd_clockinfo" id="clockd_clockinfo" class="input" value="<?php echo $info["clockinfo"];?>" style="width:300px;"></td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td class="tdright">备注批注：</td>
    <td class=""><textarea name="clockd_detail" id="clockd_detail" class="textarea" style="width:300px;height:60px;"><?php echo $info["detail"];?></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="clockdbtb" onclick="clockbtn()" value="保存提醒记录">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }else{?>

null

<?php }?>
