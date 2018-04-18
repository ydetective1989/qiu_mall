<?php if($type=="jobs"){?>

<table width="100%" class="parinfo">
	<?php if($list){?>
	<tr class="bgtips">
    <td width="100" class="tdcenter">工单ID</td>
		<td width="80" class="tdleft">预约时间</td>
		<td width="40" class="tdleft">类型</td>
		<td width="160" class="tdleft">归属服务站</td>
		<td class="tdleft">工单内容</td>
		<td width="60" class="tdleft">确认状态</td>
		<td width="60" class="tdleft">回执状态</td>
		<td width="120" class="tdleft">操作</td>
	</tr>
	<?php foreach($list AS $rs){?>
	<tr class="datas pointer" onclick="showjobs('<?php echo $rs['id'];?>')">
    <td class="tdcenter" onclick="parent.parent.addTab('查看工单[<?php echo $rs['id'];?>]','jobs/views?id=<?php echo base64_encode($rs['id']);?>','viewjobs');" class="ublue"><?php echo $rs["id"];?></td>
    <td class="tdleft"><?php echo $rs["datetime"];?></td>
		<td class="tdleft"><?php echo $jobstype[$rs["type"]]["name"]?></td>
		<td class="tdleft"><?php echo plugin::cutstr($rs["afters"],10,"..");?></td>
		<td class="tdleft"><?php echo $rs["detail"]?></td>
		<td class="tdleft"><?php echo ($rs["checked"])?"已确认":"<span onclick='checkjobs(\"".base64_encode($rs['id'])."\")' class='red pointer'>等待确认</span>";?></td>
		<td class="tdleft"><span onclick="workjobs('<?php echo base64_encode($rs['id']);?>')" class='pointer'><?php echo $worktype[$rs["worked"]]["name"];?></span></td>
		<td class="tdleft"><span class="pointer" onclick="editjobs('<?php echo base64_encode($rs["id"]);?>')">[修改]</span><span class="pointer" onclick="deljobs('<?php echo base64_encode($rs["id"]);?>')">[删除]</span></td>
	</tr>
	<tr class="datas bgwhite" id="showjobs_<?php echo $rs['id'];?>" style="display:none;">
		<td class="tdleft" colspan="8">派工录入：<?php echo ($rs["addname"])?$rs["addname"]:"系统默认";?>(<?php echo date("Y-m-d H:i",$rs["dateline"]);?>)<br>
		指定服务：<?php echo ($rs["aftername"])?$rs["aftername"]:"系统默认";?><br><?php echo ($rs["worked"])?$rs["workdate"].":".$rs["workdetail"]."<br>回执人：".$rs["workuname"]." 回执时间：".date("Y-m-d H:i:s",$rs["workdateline"]):"回执状态：暂无回复";?></td>
	</tr>
	<?php }?>
	<tr class="pagenav">
		<td colspan="8" class="tdcenter"><?php echo $page = str_replace("page(","jobslist(",$page);?></td>
	</tr>
	<?php }else{?>
	<tr class="datas">
		<td colspan="8" class="tdcenter">暂无派工记录</td>
	</tr>
	<?php }?>
</table>

<?php }elseif($type=="jobsinfo"){?>

<input type="hidden" name="jobs_id" id="jobs_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<input type="hidden" name="jobs_ordersid" id="jobs_ordersid" value="<?php echo ((int)$info["ordersid"])?base64_encode((int)$info["ordersid"]):$_GET["id"]?>">
<input type="hidden" name="jobs_provid" id="jobs_provid" value="<?php echo (int)$provid;?>">

<table class="table">
  <tr>
    <td width="560">
		<table width="100%" class="table">
		  <tr>
		    <td width="105" height="25" class="tdright">项目：</td>
		    <td class="">
		    <select name="jobs_type" id="jobs_type" class="select">
		    <?php foreach($jobstype AS $rs){?>
		    <option value="<?php echo $rs["id"];?>" <?php echo ($rs["id"]==$info["type"])?"selected":"";?>><?php echo $rs["name"];?></option>
		    <?php }?>
		    </select>
		    </td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright">时间：</td>
		    <td class=""><input type="hidden" id="jobs_maxdate" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>"><input type="text" name="jobs_datetime" id="jobs_datetime" class="input" style="width:100px;" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>" readonly></td>
		  </tr>
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td class="tdright">内容及要求：</td>
		    <td class=""><textarea name="jobs_detail" id="jobs_detail" class="textarea" style="width:380px;height:50px;"><?php echo $info["detail"];?></textarea><td>
		  </tr>
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright"></td>
		    <td class="">
		    <input type="button" class="button" id="jobsbtn" onclick="jobsed()" value="<?php echo ($_GET["ac"]=="add")?"添加":"修改";?>工单记录">
		    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
		  </tr>
		</table>
	</td>
  </tr>
</table>

<?php }elseif($type=="tofuwu"){?>

<input type="hidden" name="jobs_id" id="jobs_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">

<table class="table" width="500">
  <tr>
    <td>

		<table width="100%" class="table">
		  <tr>
		    <td width="100" height="5" class="tdright"></td>
		    <td class=""></td>
		  </tr>
		  <tr>
		    <td height="30" class="tdright">服务中心：</td>
		    <td class=""><?php echo $info["afters"]?></td>
		  </tr>

		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td height="25" class="tdright">预约时间：</td>
		    <td class=""><input type="hidden" id="jobs_maxdate" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>"><input type="text" name="jobs_datetime" id="jobs_datetime" class="input" style="width:100px;" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>" readonly></td>
		  </tr>
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td class="tdright">服务内容：</td>
		    <td class=""><textarea name="jobs_detail" id="jobs_detail" class="textarea" style="width:320px;height:50px;"><?php echo $info["detail"];?></textarea><td>
		  </tr>
		  <tr>
		    <td class="tdcenter" colspan="2" height="6"></td>
		  </tr>
		  <tr>
		    <td height="35" class="tdright"></td>
		    <td class="">
		    <input type="button" class="button" id="jobsbtn" onclick="tofuwued()" value="推送无忧服务">
		    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
		  </tr>
		</table>
	</td>
  </tr>
</table>

<?php }elseif($type=="toall"){?>

<input type="hidden" name="jobs_id" id="jobs_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<input type="hidden" name="jobs_ordersid" id="jobs_ordersid" value="<?php echo ((int)$info["ordersid"])?base64_encode((int)$info["ordersid"]):$_GET["id"]?>">
<input type="hidden" name="jobs_cityid" id="jobs_cityid" value="<?php echo (int)$cityid;?>">

<table class="table" width="500">
    <tr>
        <td>

            <table width="100%" class="table">
                <tr>
                    <td width="100" height="25" class="tdright">工单类别：</td>
                    <td class=""><?php echo $jobstype[$info["type"]]["name"];?></td>
                </tr>
                <tr>
                    <td class="tdcenter" colspan="2" height="3"></td>
                </tr>
                <tr>
                    <td class="tdright">调整网点至：</td>
                    <td class="">
                        <input type="radio" name="jobs_teamtype" id="jobs_teamtype" value="0" onclick="tofuwuTabs(1,2)" checked> 无需变更
                        <input type="radio" name="jobs_teamtype" id="jobs_teamtype" value="1" onclick="tofuwuTabs(2,2)"> 直营网点
                </tr>
                <tr>
                    <td class="tdcenter" colspan="2" height="6"></td>
                </tr>
                <tr>
                    <td height="30" class="tdright">服务中心：</td>
                    <td class="">
                        <div id="jobsafter1"><?php echo $info["afters"]?></div>
                        <div id="jobsafter2" style="display:none"><select name="jobs_afterarea" id="jobs_afterarea" class="select" style="width:160px;">
                                    <option value="">请选择服务范围</option>
                                    <?php foreach($afterarea AS $rs){?>
                                        <option value="<?php echo $rs["id"];?>"><?php echo $rs["name"];?></option>
                                    <?php }?>
                                </select>
                                <select name="jobs_afterid" id="jobs_afterid" class="select" style="width:160px;">
                                    <option value="">请选择服务中心</option>
                                </select>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="tdcenter" colspan="2" height="6"></td>
                </tr>
                <tr>
                    <td height="25" class="tdright">预约时间：</td>
                    <td class=""><input type="hidden" id="jobs_maxdate" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>"><input type="text" name="jobs_datetime" id="jobs_datetime" class="input" style="width:100px;" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>" readonly></td>
                </tr>
                <tr>
                    <td class="tdcenter" colspan="2" height="6"></td>
                </tr>
                <tr>
                    <td class="tdright">工单内容：</td>
                    <td class=""><textarea name="jobs_detail" id="jobs_detail" class="textarea" style="width:320px;height:50px;"><?php echo $info["detail"];?></textarea><td>
                </tr>
                <tr>
                    <td class="tdcenter" colspan="2" height="6"></td>
                </tr>
                <tr>
                    <td class="tdcenter" colspan="2" height="6"></td>
                </tr>
                <tr>
                    <td height="35" class="tdright"></td>
                    <td class="">
                        <input type="button" class="button" id="jobsbtn" onclick="toalled()" value="调整确认">
                        <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>


<?php }elseif($type=="reviseinfo"){?>

<input type="hidden" name="jobs_id" id="jobs_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<input type="hidden" name="jobs_ordersid" id="jobs_ordersid" value="<?php echo ((int)$info["ordersid"])?base64_encode((int)$info["ordersid"]):$_GET["id"]?>">
<input type="hidden" name="jobs_afterid" id="jobs_afterid" value="<?php echo (int)$info["afterid"];?>">

<table width="450" class="table">
  <tr>
    <td width="100" height="25" class="tdright">工单类别：</td>
    <td class=""><?php echo $jobstype[$info["type"]]["name"];?></td>
  </tr>
  <tr>
    <td height="35" class="tdright">预约时间：</td>
    <td class=""><input type="text" name="revise_datetime" id="revise_datetime" class="input" style="width:100px;" value="<?php echo ($info["datetime"])?$info["datetime"]:date("Y-m-d");?>" readonly><input type="hidden" name="revise_minday" id="revise_minday" value="<?php echo $minday;?>"></td>
  </tr>		  <tr>
    <td height="35" class="tdright">服务人员：</td>
    <td class=""><select name="revise_afteruserid" id="revise_afteruserid" class="select" style="width:160px;">
    <option value="">请选择服务人员</option>
    <?php if($afteruserinfo){?>
    <option value="<?php echo (int)$afteruserinfo["userid"]?>" <?php if($info["afteruserid"]==$afteruserinfo["userid"]){ echo "selected"; }?>><?php echo $afteruserinfo["worknum"];?>_<?php echo $afteruserinfo["name"];?></option>
    <?php }?>
    <?php foreach($afterusers AS $rs){?>
    <option value="<?php echo $rs["userid"];?>" <?php if($info["afteruserid"]==$rs["userid"]){ echo "selected"; }?>><?php echo $rs["worknum"]."_".$rs["name"];?></option>
    <?php }?>
   </select>
    <input type="hidden" name="revise_afterusered" id="revise_afterusered" value="<?php echo (int)$afteruserinfo["userid"]?>" ></td>
  </tr>
  <tr>
    <td height="35" class="tdright">工单统计：</td>
    <td class=""><?php echo (int)$dayplan;?>/<?php echo (int)$maxplan;?> <span class='red'>*当日派工量/最大派工量</span><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td class="tdright">工单内容：</td>
    <td class=""><textarea name="revise_detail" id="revise_detail" class="textarea" style="width:320px;height:100px;"><?php echo $info["detail"];?></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="revisebtn" onclick="reviseed()" value="调整工单信息">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="transfer"){?>

<input type="hidden" name="jobs_id" id="jobs_id" value="<?php echo ((int)$info["id"])?base64_encode((int)$info["id"]):""?>">
<input type="hidden" name="jobs_ordersid" id="jobs_ordersid" value="<?php echo ((int)$info["ordersid"])?base64_encode((int)$info["ordersid"]):$_GET["id"]?>">

<table width="450" class="table">
  <tr>
    <td width="100" height="25" class="tdright">项目：</td>
    <td class=""><?php echo $jobstype[$info["type"]]["name"];?></td>
  </tr>
  <tr>
    <td height="35" class="tdright">移交服务站：</td>
    <td class=""><select name="jobs_afterid" id="jobs_afterid" class="select">
    <?php foreach($afters AS $rs){?>
    <option value="<?php echo $rs["id"];?>" <?php if($info["afterid"]==$rs["id"]){ echo "selected"; }?>><?php echo $rs["name"];?></option>
    <?php }?>
   </select>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td class="tdright">操作备注：</td>
    <td class=""><textarea name="jobs_detail" id="jobs_detail" class="textarea" style="width:320px;height:100px;"></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="revisebtn" onclick="transfered()" value="确认移交工单">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="workjobs"){?>

<input type="hidden" name="jobs_id" id="jobs_id" value="<?php echo base64_encode((int)$info["id"])?>">
<input type="hidden" name="jobs_type" id="jobs_type" value="<?php echo (int)$info["type"]?>">
<table width="520" class="table">
  <tr>
    <td width="120" height="25" class="tdright">回执状态：</td>
    <td class="">
    <?php foreach($worktype AS $rs){ if($rs["hide"]=="0"){ continue; } ?>
    <input type="radio" name="jobs_worktype" value="<?php echo $rs["id"];?>" <?php echo ($rs["id"]==(int)$info["worked"])?"checked":"";?> onclick="chargetype('<?php echo $rs["id"];?>');"> <?php echo $rs["name"];?>
    <?php }?>
    </td>
  </tr>
  <tr style="display:none">
    <td height="35" class="tdright">完成时间：</td>
    <td class=""><input type="text" name="jobs_workdate" id="jobs_workdate" class="input" style="width:100px;" value="<?php echo ($info["workdate"])?$info["workdate"]:date("Y-m-d",time());?>" readonly ></td>
  </tr>

  <tr>
    <td></td>
    <td class="red" height="8"></td>
  </tr>
  <tr>
    <td class="tdright">回执批注：</td>
    <td class=""><textarea name="jobs_detail" id="jobs_detail" class="textarea" style="width:360px;min-height:60px;"><?php echo $info["workdetail"];?></textarea><td>
  </tr>
  <tr>
    <td class="tdcenter" colspan="2" height="6"></td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="workbtn" onclick="worked()" value="回执工单">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="checked"){?>

<input type="hidden" name="jobs_id" id="jobs_id" value="<?php echo base64_encode((int)$info["id"])?>">
<input type="hidden" name="jobs_type" id="jobs_type" value="<?php echo (int)$info["type"];?>">
<input type="hidden" name="mapmarkers_lng" id="mapmarkers_lng" value="<?php echo ($ordersinfo["pointlng"])?htmlspecialchars($ordersinfo["pointlng"]):"";?>">
<input type="hidden" name="mapmarkers_lat" id="mapmarkers_lat" value="<?php echo ($ordersinfo["pointlat"])?htmlspecialchars($ordersinfo["pointlat"]):"";?>">
<input type="hidden" name="jobs_cityname" id="jobs_cityname" value="<?php echo $ordersinfo["provname"];?> <?php echo $ordersinfo["cityname"];?>">
<input type="hidden" name="jobs_address" id="jobs_address" value="<?php echo $ordersinfo["address"];?>">

<table width="600" class="table">
  <tr <?php if($info["type"]!="8"){ echo "style='display:none;'"; }?>>
    <td width="120" height="25" class="tdright">工单编号：</td>
    <td class=""><span class="red bold"><?php echo $info["ordersid"];?></span></td>
  </tr>
  <?php if($info["type"]=="8"){?>
  <input type="hidden" name="jobs_point" id="jobs_point" class="input" readonly style="width:200px;" value="<?php if($ordersinfo["pointlng"]&&$ordersinfo["pointlat"]){ echo $ordersinfo["pointlng"].", ".$ordersinfo["pointlat"]; }?>">
  <input type="hidden" name="jobs_sms" id="jobs_sms" value="0">
  <?php }else{?>
  <tr>
    <td height="35" class="tdright">客户地址：</td>
    <td class=""><input type="text" name="markers_keyword" id="markers_keyword" value="<?php echo $ordersinfo["address"];?>" class="input" style="width:300px;" /><input type="button" class="button" id="search_button" value="查找位置"></td>
  </tr>
  <tr>
	<td colspan="2"><div class="markers_orders" id="markers_container"></div></td>
  </tr>
  <tr>
	<td height="35" class="tdright">取得坐标：</td>
    <td class=""><input type="text" name="jobs_point" id="jobs_point" class="input" readonly style="width:200px;" value="<?php if($ordersinfo["pointlng"]&&$ordersinfo["pointlat"]){ echo $ordersinfo["pointlng"].", ".$ordersinfo["pointlat"]; }?>"> <span class="red">双击地图上的正确位置选取坐标</span></td>
  </tr>
  <input type="hidden" name="jobs_sms" id="jobs_sms" value="1">
  <?php }?>
  <tr>
    <td height="2" class="tdright"></td>
    <td class=""></td>
  </tr>
  <tr>
    <td height="20" class="tdcenter" colspan="2"><input type="button" class="button" id="chargebtn" onclick="job_checkdo()" value="确认工单">
    <input type="button" class="btnred" onclick="closedialog()" value="取消操作"></td>
  </tr>
  <tr>
    <td height="2" class="tdright"></td>
    <td class=""></td>
  </tr>
</table>

<?php }elseif($type=="encharge"){?>

<input type="hidden" name="jobs_id" id="jobs_id" value="<?php echo base64_encode((int)$info["id"])?>">
<input type="hidden" name="jobs_ordersid" id="jobs_ordersid" value="<?php echo base64_encode((int)$info["ordersid"])?>">
<input type="hidden" name="jobs_salespid" id="jobs_salespid" value="<?php echo $info["salespid"]?>">

<table width="550" class="table">
  <tr>
    <td width="120" height="35" class="tdright">订单编号：</td>
    <td class=""><span class="red bold"><?php echo $info["ordersid"];?></span></td>
  </tr>
  <tr>
    <td height="25" class="tdright">结算审核：</td>
    <td class="">
    <input type="radio" name="jobs_checked" value="1" checked> 已审核
    <input type="radio" name="jobs_checked" value="0"> 取消审核
    </td>
  </tr>
  <tr>
    <td height="35" class="tdright">申请结算金额：</td>
    <td class=""><span class="red"><?php echo $info["charge"];?></span>元</td>
  </tr>
    <?php if($fuwuinfo["chargeinfo"]){?>
    <tr class="detailbg">
        <td height="35" class="tdright">合作结算提示：</td>
        <td class=""><?php echo $fuwuinfo["chargeinfo"];?></td>
    </tr>
    <?php }?>
  <tr>
    <td height="35" class="tdright">服务结算金额：</td>
    <td class=""><input type="text" name="jobs_encharge" id="jobs_encharge" class="input" style="width:100px;" value="<?php echo ($info["encharge"])?$info["encharge"]:$info["charge"];?>"> 元</td>
  </tr>
  <tr>
    <td height="35" class="tdright">服务审核批注：</td>
    <td class=""><textarea name="jobs_enchargeinfo" id="jobs_enchargeinfo" class="textarea" style="width:400px;min-height:28px;"><?php echo ($info["enchargeinfo"])?$info["enchargeinfo"]:"";?></textarea><td>
  </tr>
    <tr>
        <td height="30" class="tdright">客户地址：</td>
        <td class=""><?php echo $orderinfo["address"];;?></span></td>
    </tr>
    <tr>
        <td height="30" class="tdright">中心区域距离：</td>
        <td class=""><?php echo $mapsnums;?></td>
    </tr>
    <tr>
        <td height="35" class="tdright">服务补贴金额：</td>
        <td class=""><input type="text" name="jobs_plus" id="jobs_plus" class="input" style="width:100px;" value="<?php echo ($info["plus"])?$info["plus"]:"";?>"> 元</td>
    </tr>
  <tr>
    <td class="tdright">服务补贴说明：</td>
    <td class=""><textarea name="jobs_plusinfo" id="jobs_plusinfo" class="textarea" style="width:400px;min-height:28px;"><?php echo ($info["plusinfo"])?$info["plusinfo"]:"";?></textarea><td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="chargebtn" onclick="encharged()" value="结算操作">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="plusinfo"){?>

<input type="hidden" name="jobs_id" id="jobs_id" value="<?php echo base64_encode((int)$info["id"])?>">
<input type="hidden" name="jobs_ordersid" id="jobs_ordersid" value="<?php echo base64_encode((int)$info["ordersid"])?>">
<table width="460" class="table">
  <tr>
    <td width="120" height="35" class="tdright">工单编号：</td>
    <td class=""><span class="red bold"><?php echo $info["id"];?></span></td>
  </tr>
  <tr class="detailbg">
    <td height="30" colspan="2" class="tdcenter"><span class="red">以下是给服务人员的补贴费用，非工单结算金额</span></td>
  </tr>
  <tr>
    <td height="35" class="tdright">补贴金额：</td>
    <td class=""><input type="text" name="jobs_plus" id="jobs_plus" class="input" style="width:100px;" value="<?php echo ($info["plus"])?$info["plus"]:"";?>"> 元</td>
  </tr>
  <tr>
    <td class="tdright">补贴说明：</td>
    <td class=""><textarea name="jobs_plusinfo" id="jobs_plusinfo" class="textarea" style="width:300px;min-height:50px;"><?php echo ($info["plusinfo"])?$info["plusinfo"]:"";?></textarea><td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="chargebtn" onclick="jobs_enplused()" value="补贴操作">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }elseif($type=="fuwuinfo"){?>

<input type="hidden" name="jobs_id" id="jobs_id" value="<?php echo base64_encode((int)$info["id"])?>">
<input type="hidden" name="jobs_ordersid" id="jobs_ordersid" value="<?php echo base64_encode((int)$info["ordersid"])?>">
<table width="460" class="table">
  <tr>
    <td width="120" height="35" class="tdright">工单编号：</td>
    <td class=""><span class="red bold"><?php echo $info["id"];?></span></td>
  </tr>
    <tr>
        <td height="25" class="tdright">供应商结算：</td>
        <td class="">
            <input type="radio" name="jobs_fuwued" value="1" checked> 已审核
            <input type="radio" name="jobs_fuwued" value="0"> 取消审核
        </td>
    </tr>
<?php if($fuwuinfo["chargeinfo"]){?>
    <tr class="detailbg">
        <td height="35" class="tdright">结算提示：</td>
        <td class=""><?php echo $fuwuinfo["chargeinfo"];?></td>
    </tr>
<?php }?>
  <tr class="detailbg">
    <td height="30" class="tdright">已付服务金额：</td>
    <td class=""><span class="red"><?php echo @round($info["fuwued"]);?></span>元 * 注：此为通过服务平台已结算的基本费用</td>
  </tr>
  <tr>
    <td height="35" class="tdright">附加服务金额：</td>
    <td class=""><input type="text" name="jobs_fuwu" id="jobs_fuwu" class="input" style="width:100px;" value="<?php echo ($info["fuwu"])?$info["fuwu"]:"";?>"> 元</td>
  </tr>
  <tr>
    <td class="tdright">附加费用说明：</td>
    <td class=""><textarea name="jobs_fuwuinfo" id="jobs_fuwuinfo" class="textarea" style="width:300px;min-height:50px;"><?php echo ($info["fuwuinfo"])?$info["fuwuinfo"]:$info["fuwuinfo"];?></textarea><td>
  </tr>
  <tr>
    <td height="35" class="tdright"></td>
    <td class="">
    <input type="button" class="button" id="chargebtn" onclick="jobs_enfuwu()" value="结算操作">
    <input type="button" class="btnred" onclick="closedialog()" value="取消"></td>
  </tr>
</table>

<?php }else{?>

null

<?php }?>
