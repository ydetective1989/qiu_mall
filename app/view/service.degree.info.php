<?php if($type=="edit"){?>
<input type="hidden" name="degree_id" id="degree_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):"0";?>" />
<input type="hidden" name="degree_ordersid" id="degree_ordersid" value="<?php echo ((int)$ordersinfo["id"])?base64_encode((int)$ordersinfo["id"]):"0";?>" />
<input type="hidden" name="degree_jobsid" id="degree_jobsid" value="<?php echo ((int)$jobsinfo["id"])?base64_encode((int)$jobsinfo["id"]):"0";?>" />
<input type="hidden" name="degree_saleuserid" id="degree_saleuserid" value="<?php echo (int)$ordersinfo["saleuserid"];?>" />
<input type="hidden" name="degree_salesid" id="degree_salesid" value="<?php echo (int)$ordersinfo["salesid"];?>" />
<input type="hidden" name="degree_afteruserid" id="degree_afteruserid" value="<?php echo (int)$jobsinfo["afteruserid"];?>" />
<input type="hidden" name="degree_afterid" id="degree_afterid" value="<?php echo (int)$jobsinfo["afterid"];?>" />
<table width="550" class="table">
  <tr>
    <td width="100" height="35" class="tdright">操作：</td>
    <td class=""><input type="radio" name="degree_checked" id="degree_checked" checked value="1" onclick="degreetype()"> 正常 <input type="radio" name="degree_checked" id="degree_checked" value="2" onclick="degreetype()"> 无法回访 <input type="radio" name="degree_checked" id="degree_checked" value="0" onclick="degreetype()"> 无需回访</td>
  </tr>
  <tr>
    <td width="100" height="35" class="tdright">时间：</td>
    <td class=""><input type="text" name="degree_datetime" id="degree_datetime" class="input" style="width:100px;" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>" readonly onclick="return Calendar('degree_datetime')"></td>
  </tr>
</table>
<table id="degree_infod">
  <?php if($jobsinfo["type"]=="2"||!$jobsinfo){ ?>
  <tr>
    <td width="100" height="35" class="tdright">销售评分：</td>
    <td class=""><select name="degree_sales" id="degree_sales" class="select">
    	<option value="0" <?php if($info["sales"]=="0"){ echo "selected"; };?>>不满意</option>
    	<option value="1" <?php if($info["sales"]=="1"){ echo "selected"; };?>>一般</option>
    	<option value="2" <?php if($info["sales"]=="2"){ echo "selected"; };?>>满意</option>
    	<option value="3" <?php if($info["sales"]=="3"||$info["sales"]==""){ echo "selected"; };?>>非常满意</option>
    </select></td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td width="100" class="tdright">销售评价：</td>
    <td class=""><textarea name="degree_salesinfo" id="degree_salesinfo" class="textarea" style="width:450px;height:60px;"><?php echo $info["salesinfo"];?></textarea><td>
  </tr>
  <?php }else{?>
  <tr>
    <td colspan="2"><input type="hidden" name="degree_sales" id="degree_sales" value="0" /><td>
  </tr>
  <?php }?>
  <tr>
    <td width="100" height="35" class="tdright">服务评分：</td>
    <td class=""><select name="degree_after" id="degree_after" class="select">
    	<option value="0" <?php if($info["after"]=="0"){ echo "selected"; };?>>不满意</option>
    	<option value="1" <?php if($info["after"]=="1"){ echo "selected"; };?>>一般</option>
    	<option value="2" <?php if($info["after"]=="2"){ echo "selected"; };?>>满意</option>
    	<option value="3" <?php if($info["after"]=="3"||$info["sales"]==""){ echo "selected"; };?>>非常满意</option>
    </select></td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td width="100" class="tdright">服务评价：</td>
    <td class="">
      工服：<input type="radio" name="afterinfo_gf" value="是" checked>是 <input type="radio" name="afterinfo_gf" value="否">否<br>
      鞋套：<input type="radio" name="afterinfo_xt" value="是" checked>是 <input type="radio" name="afterinfo_xt" value="否">否<br>
      卫生：<input type="radio" name="afterinfo_ws" value="是" checked>是 <input type="radio" name="afterinfo_ws" value="否">否<br>
      标签：<input type="radio" name="afterinfo_bq" value="是" checked>是 <input type="radio" name="afterinfo_bq" value="否">否<br>
      态度：<input type="radio" name="afterinfo_td" value="是" checked>是 <input type="radio" name="afterinfo_td" value="否">否<br>
    <td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
</table>
<table>
  <tr>
    <td width="100" class="tdright">回访批注：</td>
    <td class=""><textarea name="degree_detail" id="degree_detail" class="textarea" style="width:450px;height:60px;"><?php echo $info["detail"];?></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="degreebto" onclick="degreebtn()" value="提交回访信息">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>


<?php }else{?>

null

<?php }?>
