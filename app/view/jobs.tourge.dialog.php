<?php if($pagetype=="lists"){?>



<table width="100%" class="parinfo">
    <?php if($rows){?>
        <tr class="bgtips">
            <td width="120" class="tdleft">催单时间</td>
            <td class="tdleft">催单内容</td>
            <td width="80" class="tdleft">操作人</td>
            <td width="80" class="tdleft">操作</td>
        </tr>
        <?php foreach($rows AS $rs){?>
            <tr class="datas pointer" onclick="showjobs('<?php echo $rs['id'];?>')">
                <td class="tdleft"><?php echo date("Y-m-d H:i",$rs["dateline"]);?></td>
                <td class="tdleft"><?php echo $rs["detail"]?></td>
                <td class="tdleft"><?php echo $rs["addname"];?></td>
                <td class="tdleft"><span class="pointer" onclick="tourgedel('<?php echo base64_encode($rs["id"]);?>')">[删除]</span></td>
            </tr>
        <?php }?>
    <?php }else{?>
        <tr class="datas">
            <td colspan="8" class="tdcenter">暂无催单记录</td>
        </tr>
    <?php }?>
</table>


<?php }elseif($pagetype=="tourgeinfo"){?>

<input type="hidden" name="dialog_jobsid" id="dialog_jobsid" value="<?php echo base64_encode($info["id"]);?>">
<table width="400" class="table">
    <tr>
        <td class="tdcenter" height="10"></td>
    </tr>
    <tr>
        <td width="80" class="tdright">催单内容：</td>
        <td class=""><input type="text" name="dialog_detail" id="dialog_detail" class="input" style="width:280px;"><td>
    </tr>
    <tr>
        <td class="tdcenter" colspan="2" height="6"></td>
    </tr>
    <tr>
        <td height="35" class="tdright"></td>
        <td class="">
            <input type="button" class="button" id="btn" onclick="addtourched()" value="增加催单信息">
            <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
    </tr>
    <tr>
        <td class="tdcenter" height="10"></td>
    </tr>
</table>

<?php }else{?>

null

<?php }?>