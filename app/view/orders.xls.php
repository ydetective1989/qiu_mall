<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
</head>
<script type="text/javascript">
  function xls_view(){
        var url = S_ROOT+"xls/import?do=views";//获取地址
        //alert(url);
        $.ajax({
                type:'post',//传值方式
                url:url,//传值地址
                data: {dingdan:$("#dingdan").val()},
                success:function(data){
                    $("#showed").html(data);//成功:将data数据赋给ID　showed
                }
        })
        return false;
   }
   function xls_import()
   {
       var salesid = $("#salesid").val();
       if(salesid==""||salesid=="0"){ msgbox("请选择销售编码");return; }
       var dingdan = $("#dingdan").val();
       if(dingdan==""){ msgbox("订单数据不能为空");return; }
       art.dialog({
         title:'操作确认',
         content: '你确认要导入订单记录吗？',
         lock: true,
         fixed: true,
           okValue: '确认导入',
           ok: function(){
              $("#editfrm").submit();
           },
           cancelValue: '取消导入',
           cancel: function(){}
       });
   }

</script>
<body scroll="no">

  <?php if($do=="views"){?>
   <?php if($date){?>
   <div style='width:2900px;overflow-x:scroll;'>
    <table class='table table-bordered' border="1">
        <tr>
                  <th width='100'>客户姓名</th>
                  <th>手机号码</th>
                  <th width='100'>固话</th>
                  <th width='100'>省</th>
                  <th width='100'>市</th>
                  <th width='100'>区</th>
                  <th>客户地址</th>
                  <th width='100'>产品编码</th>
                  <th>产品型号</th>
                  <th width='100'>数量</th>
                  <th width='100'>金额</th>
                  <th width='150'>淘宝订单号</th>
                  <th width='100'>旺旺</th>
                  <th width='300'>客户留言</th>
                  <th>备注</th>
          </tr>
          <?php foreach($date AS $rs){
            $row = explode("	",$rs);
            //print_r($row);exit;
            $name		  = $row[0];
            $mobile		= $row[1];
            $phone		= $row[2];
            //$addr = explode(" ",$row[4]);
            //print_r($addr);exit;
            $provname	= trim($row[3]);
            $cityname	= trim($row[4]);
            $areaname	= trim($row[5]);
            $address	= trim($row[6]);
            $pcode		= ($row[7])?trim($row[7]):"000000";
            $nums		  = (int)$row[9];
            $pname		= $row[8];
            $price		= @round($row[10],2);
            $contract	= $row[11];
            $wangwang	= $row[12];
            $detail		= $row[14];
            $datetime	= $row[13];
            ?>
          <tr>
            <td class="tdcenter"><?php echo $name;?></td>
            <td class="tdcenter"><?php echo $mobile;?></td>
            <td class="tdcenter"><?php echo $phone;?></td>
            <td class="tdcenter"><?php echo $provname;?></td>
            <td class="tdcenter"><?php echo $cityname;?></td>
            <td class="tdcenter"><?php echo $areaname;?></td>
            <td class="tdcenter"><?php echo $address;?></td>
            <td class="tdcenter"><?php echo $pcode;?></td>
            <td class="tdcenter"><?php echo $pname;?></td>
            <td class="tdcenter"><?php echo $nums;?></td>
            <td class="tdcenter"><?php echo $price;?></td>
            <td class="tdcenter"><?php echo $contract;?></td>
            <td class="tdcenter"><?php echo $wangwang;?></td>
            <td class="tdcenter"><?php echo $datetime;?></td>
            <td class="tdcenter"><?php echo $detail;?></td>
          </tr>
          <?php } ?>
    </table>
  </div>
  <?php } ?>


  <?php }else{?>

    <table width="100%" height="100%"  class="table">

      <form role="form" method="post" name="editfrm" id="editfrm" action="">
        <tr width="100%">
          <td width="200" height="35" class="tdcenter">订单类型</td>
          <td>
            <select name="source" id="source" class="select">
                <option value="fuwu">fuwu</option>
                <option value="yws">yws</option>
                <option value="taobao">taobao</option>
            </select>
              <select name="type" id="type" class="select">
                  <?php foreach($ordertype AS $rs){?>
                  <option value="<?php echo $rs["id"]?>"><?php echo $rs["name"]?></option>
                  <?php }?>
              </select>
            <select name="ctype" id="ctype" class="select">
                <?php foreach($customstype AS $rs){?>
                <option value="<?php echo $rs["id"]?>"><?php echo $rs["name"]?></option>
                <?php }?>
            </select>
            <select name="checked" id="checked" class="select">
              <?php foreach($checktype AS $rs){?>
              <option value="<?php echo $rs["id"]?>"><?php echo $rs["name"]?></option>
              <?php }?>
            </select>
            <select name="status" id="status" class="select">
              <?php foreach($statustype AS $rs){?>
              <option value="<?php echo $rs["id"]?>" <?php if($rs["id"]=="1"){ echo "selected"; }?>><?php echo $rs["name"]?></option>
              <?php }?>
            </select>
            <select name="paystate" id="paystate" class="select">
              <option value="2">无需支付</option>
              <option value="1">已支付</option>
              <option value="0">未支付</option>
            </select>
          </td>
        </tr>

      <?php if($usertype<>"1"){ $inlevel="&level=1"; }?>
      <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?level=1&type=1&val=salesTeams<?php echo $inlevel;?>"></script>
      <script type="text/javascript">var salesarea='';var salesid='';var saleuserid='';</script>
      <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
      <tr>
        <td height="35" class="tdcenter">销售范围</td>
        <td>
          <select name="salesarea" id="salesarea" class="select"></select>
             <select name="salesid" id="salesid" class="select"></select>
        </td>
      </tr>
      <tr>
        <td height="35" class="tdcenter">订单数据</td>
        <td>
            <textarea name="dingdan" id="dingdan" class="select" style="height:150;width:95%;white-space: nowrap;" placeholder="请复制表格数据到此处"></textarea>
        </td>
      </tr>

      <tr>
        <td height="35" class="tdcenter"></td>
        <td>
          <button type="button" id="checked" class="button" onclick="xls_view();">预览检测</button>
          <button type="button" id="checked" class="btnred" onclick="xls_import();">导入数据</button>
          <!-- <button type="submit" class="button" onclick="javascript:{if(!confirm('确定要导入操作吗？\n你确认导入的表格内容正确吗？如有错误请先修改，否则后果自负！')){return false;};}">导入数据</button> -->
        </td>
      </tr>
    </form>

      <tr>
        <td colspan="2" class="bgfocus headerfocus"></td>
      </tr>
      <tr>
        <td colspan="2" height="100%">
          <div id="showed"></div>
        </td>
      </tr>

      </table>
    <?php }?>



</body>
</html>
