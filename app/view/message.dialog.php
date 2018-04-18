<?php if($type=="sendsms"){?>

<input type="hidden" name="cards_ordersid" id="cards_ordersid" value="<?php echo $ordersid;?>">

<table width="400" class="table">
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td width="100" height="30" class="tdright">发送号码：</td>
    <td><input type="text" name="msg_mobile" id="msg_mobile" class="input" <?php if(!$islevel){ echo "readonly";}?> value="<?php echo $mobile;?>" style="width:150px;"></td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td height="30" class="tdright">发送内容：</td>
    <td><textarea name="msg_content" id="msg_content" class="textarea" style="width:250px;height:100px;"><?php echo $message;?></textarea></td>
  </tr>
  <tr>
    <td height="5" class="tdright"></td>
    <td></td>
  </tr>
</table>

<table width="400" class="table">
  <tr>
    <td width="100" height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="btned" onclick="sendsmsd()" value="发送短信">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="closecards"){?>


<?php }else{?>

null

<?php }?>
