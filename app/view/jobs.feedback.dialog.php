<input type="hidden" name="dialog_id" id="dialog_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">

<?php if($tpl=="checked"){?>

<table class="table" width="500">
  <tr>
    <td colspan="2" height="10"></td>
  </tr>
  <tr>
    <td width="100" class="tdright">受理情况：</td>
    <td class="">
    <input type="radio" name="dialog_checked" value="1" <?php if($info["checked"]=="1"||$info["checked"]=="0"){ echo "checked"; }?>>受理完成
    <input type="radio" name="dialog_checked" value="0">暂不受理
    <input type="radio" name="dialog_checked" value="2" <?php if($info["checked"]=="2"){ echo "checked"; }?>>取消受理<td>
  </tr>
  <tr>
    <td colspan="2" height="10"></td>
  </tr>
  <tr>
    <td class="tdright">反馈内容：</td>
    <td class=""><textarea name="dialog_detail" id="dialog_detail" class="textarea" style="width:350px;height:100px;"> <?php echo $info["checkinfo"];?></textarea><td>
  </tr>
  <tr>
    <td colspan="2" height="5"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="infoed" onclick="checkdo()" value="确认操作">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
  <tr>
    <td colspan="2" height="5"></td>
  </tr>
</table>



<?php }else{?>

null

<?php }?>
