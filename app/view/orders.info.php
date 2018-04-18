<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/orders.info.js?<?php echo date("Ymd");?>"></script>
</head>
<body>


<div class="info">

<table width="100%" class="title">
	<tr>
		<td class="tdleft bold">&nbsp;<?php echo ($_GET["ac"]=="edit")?"修改":"增加";?><?php if($_GET["ac"]=="add"&&$_GET["id"]){ echo "[".$info["id"]."]子"; }?>订单</td>
		<td class="tdright"></td>
	</tr>
</table>

<table width="100%">
  <tr>
    <td colspan="3" class="headerfocus bgfocus"></td>
  </tr>
</table>
<form name="sendto" id="sendto" action="" method="post">
<input type="hidden" name="parentid" id="parentid" value="<?php echo ($_GET["ac"]=="add"&&$_GET["id"])?base64_decode($_GET["id"]):"0";?>" >
<input type="hidden" name="closed" id="closed" value="<?php echo (int)$closed;?>" >
<!-- 百度地图API -->
<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=EC1bb4d2591cdc482c712b0626f63066&s=1"></script>

<table width="100%" class="table">

  <?php if(!$closed){ ?>
  <?php
  if(($_GET["ac"]=="add"&&$_GET["id"])||($_GET["ac"]=="edit"&&$info["parentid"])){
  //if(($_GET["ac"]=="add")||($_GET["ac"]=="edit"&&$info["parentid"])){
  ?>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">订单属性</td>
  </tr>
  <tr>
    <td width="15%" class="tdright">订单类型：</td>
    <td width="35%"><select name="type" id="type" class="select">
    <option value="">选择类型</option>
    <?php foreach($ordertype AS $rs){?>
    <?php if(($_GET["ac"]=="add"&&$_GET["id"])||($_GET["ac"]=="edit"&&$info["parentid"]))
    {
    	if($rs["type"]=="1"||$rs["type"]=="3"||$rs["type"]=="2"){ continue; }
    }else{
		if($rs["type"]=="0"||$rs["type"]=="3"||$rs["type"]=="2"){ continue; }
	}?>
    <option value="<?php echo $rs["id"];?>" <?php if($info["type"]==$rs["id"]){ echo "selected"; } ?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select></td>
    <td width="15%" class="tdright"></td>
    <td width="35%"></td>
  </tr>
  <input type="hidden" name="ctype" id="ctype" value="0" />

  <?php }else{?>

  <input type="hidden" name="type" id="type" value="<?php if($_GET["ac"]=="add"){ echo "1"; }else{ echo $info["type"]; } ?>" />
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">订单属性</td>
  </tr>
  <tr>
    <td width="15%" class="tdright">销售类型：</td>
    <td width="35%"><select name="ctype" id="ctype" class="select">
    <?php foreach($customstype AS $rs){
	//if($rs["type"]!="1"){ continue; }
    ?>
    <option value="<?php echo $rs["id"];?>" <?php if($info["ctype"]==$rs["id"]){ echo "selected"; } ?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select></td>
    <td width="15%" class="tdright"></td>
    <td width="35%"></td>
  </tr>
  <?php }?>
  <?php }?>

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">客户信息</td>
  </tr>
  <tr>
    <td class="tdright">客户姓名：</td>
    <td><input type="text" name="name" id="name" class="input" value="<?php echo $info["name"];?>"></td>
    <td class="tdright"></td>
    <td ></td>
  </tr>
  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/areas"></script>
  <script type="text/javascript">var provid='<?php echo (int)$info["provid"];?>';var cityid='<?php echo (int)$info["cityid"];?>';var areaid='<?php echo (int)$info["areaid"];?>';</script>
  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.areas.js"></script>
  <tr>
    <td class="tdright">所在城市：</td>
    <td colspan="3"><select name="provid" id="provid" class="select" style="width:150px;"></select>
	<select name="cityid" id="cityid" class="select" style="width:150px;"></select>
	<select name="areaid" id="areaid" class="select" style="width:150px;"></select></td>
  </tr>
  <tr>
    <td class="tdright">联系地址：</td>
    <td colspan="3"><input type="text" name="address" id="address" class="input" value="<?php echo $info["address"];?>" style="width:80%;"></td>
  </tr>

  <tr>
    <td class="tdright">邮政编码：</td>
    <td><input type="text" name="postnum" id="postnum" class="input" value="<?php echo $info["postnum"];?>"></td>
    <td class="tdright"></td>
    <td></td>
  </tr>

  <tr>
    <td class="tdright">手机号码：</td>
    <td><input type="text" name="mobile" id="mobile" class="input" value="<?php echo $info["mobile"];?>"></td>
    <td class="tdright">其它电话：</td>
    <td><input type="text" name="phone" id="phone" class="input" value="<?php echo $info["phone"];?>" style="width:90%;"></td>
  </tr>
  <tr>
    <td class="tdright">QQ号码：</td>
    <td><input type="text" name="qq" id="qq" class="input" value="<?php echo $info["qq"];?>"></td>
    <td class="tdright">旺旺号：</td>
    <td><input type="text" name="wangwang" id="wangwang" class="input" value="<?php echo $info["wangwang"];?>"></td>
  </tr>
  <tr>
    <td class="tdright">其它IM：</td>
    <td><input type="text" name="im" id="im" class="input" value="<?php echo $info["im"];?>"></td>
    <td class="tdright">电子邮箱：</td>
    <td><input type="text" name="email" id="email" class="input" value="<?php echo $info["email"];?>" style="width:90%;"></td>
  </tr>

  <?php if(!$closed){ ?>
  <tr class="bgheader">
    <td colspan="4" class="tdcenter">订单信息</td>
  </tr>
  <tr>
    <td class="tdright">合同编号：</td>
    <td><input type="text" name="contract" id="contract" class="input" value="<?php echo ($info["contract"]&&$_GET["ac"]=="edit")?$info["contract"]:"";?>"></td>
    <td class="tdright"></td>
    <td></td>
  </tr>
  <tr>
    <td class="tdright">订购时间：</td>
    <td><input type="text" name="datetime" id="datetime" class="input" readonly value="<?php echo ($info["datetime"]&&$_GET["ac"]=="edit")?$info["datetime"]:date("Y-m-d");?>"></td>
    <td class="tdright">支付方式：</td>
    <td><select name="paytype" id="paytype" class="select">
    <option value="">选择支付方式</option>
    <?php foreach($paytype AS $rs){?>
    <option value="<?php echo $rs["id"];?>" <?php if($info["paytype"]==$rs["id"]&&$_GET["ac"]=="edit"){ echo "selected"; } ?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select></td>
  </tr>

  <tr>
    <td class="tdright">送货方式：</td>
    <td><select name="delivertype" id="delivertype" class="select">
    <option value="">选择送货方式</option>
    <?php foreach($delivertype AS $rs){?>
    <option value="<?php echo $rs["id"];?>" <?php if($info["delivertype"]==$rs["id"]&&$_GET["ac"]=="edit"){ echo "selected"; } ?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select></td>
    <td class="tdright">安装方式：</td>
    <td><select name="setuptype" id="setuptype" class="select">
    <option value="">选择安装方式</option>
    <?php foreach($setuptype AS $rs){?>
    <option value="<?php echo $rs["id"];?>" <?php if($info["setuptype"]==$rs["id"]&&$_GET["ac"]=="edit"){ echo "selected"; } ?>><?php echo $rs["name"];?></option>
    <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="tdright">计划送货时间：</td>
    <td><input type="text" name="plansend" id="plansend" class="input" readonly value="<?php echo ($info["plansend"]&&$_GET["ac"]=="edit")?$info["plansend"]:date("Y-m-d",time()+86400*2);?>"></td>
    <td class="tdright">计划安装时间：</td>
    <td><input type="text" name="plansetup" id="plansetup" class="input" readonly value="<?php echo ($info["plansetup"]&&$_GET["ac"]=="edit")?$info["plansetup"]:date("Y-m-d",time()+86400*5);?>"></td>
  </tr>
  <tr>
    <td class="tdright">订单备注：</td>
    <td colspan="3"><textarea name="detail" id="detail" class="textarea" style="width:90%;height:50px;"><?php echo ($info["detail"]&&$_GET["ac"]=="edit")?$info["detail"]:"";?></textarea></td>
  </tr>
  <?php }?>


  <?php if(!$closed){ ?>
  <script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=1&val=salesTeams&level=1"></script>
  <script type="text/javascript">var salesarea='<?php echo ($_GET["ac"]=="edit")?$info["salesarea"]:"0";?>';var salesid='<?php echo ($_GET["ac"]=="edit")?$info["salesid"]:"0";?>';var saleuserid='';</script>
  <script type="text/javascript" src="<?php echo $S_ROOT;?>js/ajax.sales.js"></script>
  <tr>
    <td class="tdright">指定销售人员：</td>
    <td colspan="3"><select name="salesarea" id="salesarea" class="select" ></select>
      <select name="salesid" id="salesid" class="select" ></select>
      <select name="saleuserid" id="saleuserid" class="select" >
        <option value="">选择销售人员</option>
      </select></td>
  </tr>
  <?php }?>

  <?php if(!$closed){ ?>
  <tr>
    <td colspan="4" class="tdcenter">
		<input type="hidden" name="productarr" id="productarr" value="<?php echo @count($orders_product);?>" >
		<input type="hidden" name="productnums" id="productnums" value="<?php echo @count($orders_product);?>" >
        <table width="100%" class="parinfo" id="productlist">
        	<thead>
    		<tr class="bgheader">
    			<td width="80" class="tdcenter">产品编号</td>
    			<td class="tdcenter">产品名称</td>
    			<td width="250" class="tdcenter">批注</td>
    			<td width="50" class="tdcenter">数量</td>
    			<td width="80" class="tdcenter">单价</td>
    			<td width="40" class="tdcenter">删除</td>
    		</tr>
		  <thead>
		  <tbody>
	 	  <?php if($orders_product){ $i = 1; ?>
	 	  <?php if($closed=="0"){?>
		  <?php foreach($orders_product AS $rs){?>
    		<tr class="datas" id="repeat">
    			<input type="hidden" name="products[]" class="arrnums" value="<?php echo $i;?>">
    			<input type="hidden" name="productids[<?php echo $i;?>]" class="productsArr" value="<?php echo (int)$rs["productid"];?>">
    			<td class="tdcenter"><input type="hidden" name="encodeds[<?php echo $i;?>]" value="<?php echo ($rs["encoded"])?$rs["encoded"]:"000000";?>"><?php echo ($rs["encoded"])?$rs["encoded"]:"000000";?></td>
		    	<?php if($rs["encoded"]=="000000"){?>
    			<td><input type="text" name="titles[<?php echo $i;?>]" class="input tdcenter" value="<?php echo $rs["title"];?>" style="width:98%;"></td>
    			<?php }else{?>
    			<input type="hidden" name="titles[<?php echo $i;?>]" class="input tdcenter" value="<?php echo $rs["title"];?>" style="width:98%;">
    			<td class="tdleft"><?php echo $rs["title"];?></td>
    			<?php }?>
    			<td><input type="text" name="details[<?php echo $i;?>]" class="input tdcenter" value="<?php echo $rs["detail"];?>" style="width:240px;"></td>
    			<td class="tdcenter"><input type="text" name="nums[<?php echo $i;?>]" class="input tdcenter" value="<?php echo $rs["nums"];?>" style="width:40px;"></td>
    			<td class="tdcenter"><input type="text" name="prices[<?php echo $i;?>]" class="input tdcenter" value="<?php echo round($rs["price"],2);?>" style="width:70px;"></td>
    			<td class="tdcenter"><input type="button" class="button" id="delProduct" value="X" style="min-width:35px;"></td>
    		</tr>
		  <?php $i++; }?>
		  <?php }else{?>
		  <?php foreach($orders_product AS $rs){?>
    		<tr class="datas" id="repeat">
    			<td class="tdcenter"><?php echo ($rs["encoded"])?$rs["encoded"]:"000000";?></td>
    			<td class="tdleft"><?php echo $rs["title"];?></td>
    			<td><?php echo $rs["detail"];?></td>
    			<td class="tdcenter"><?php echo $rs["nums"];?></td>
    			<td class="tdcenter"><?php echo round($rs["price"],2);?></td>
    			<td class="tdcenter"></td>
    		</tr>
		  <?php $i++; }?>
		  <?php }?>
		  <?php }else{?>
    		<tr class="datas">
    			<td colspan="6" class="tdcenter">没有相关产品</td>
    		</tr>
		  <?php }?>
		  </tbody>
    	</table>

    </td>
  </tr>

  <tr>
    <td colspan="4" class="tdcenter"><input type="button" class="btnorange" onclick="addinfo()" value="添加产品"></td>
  </tr>

  <tr class="bgheader">
    <td colspan="4" class="tdcenter">订单信息</td>
  </tr>
  <tr>
    <td class="tdright">安装费用：</td>
    <td><input type="text" name="price_setup" id="price_setup" class="input" value="<?php echo ($info["price_setup"]&&$_GET["ac"]=="edit")?$info["price_setup"]:"";?>"></td>
    <td class="tdright">快递费用：</td>
    <td><input type="text" name="price_deliver" id="price_deliver" class="input" value="<?php echo ($info["price_deliver"]&&$_GET["ac"]=="edit")?$info["price_deliver"]:"";?>"></td>
  </tr>
  <tr>
    <td class="tdright">优惠费用：</td>
    <td><input type="text" name="price_minus" id="price_minus" class="input" value="<?php echo ($info["price_minus"]&&$_GET["ac"]=="edit")?$info["price_minus"]:"";?>"></td>
    <td class="tdright">其它费用：</td>
    <td><input type="text" name="price_other" id="price_other" class="input" value="<?php echo ($info["price_other"]&&$_GET["ac"]=="edit")?$info["price_other"]:"";?>"></td>
  </tr>
  <tr>
    <td class="tdright">费用备注：</td>
    <td colspan="3"><textarea name="price_detail" id="price_detail" class="textarea" style="width:90%;height:50px;"><?php echo ($info["price_detail"]&&$_GET["ac"]=="edit")?$info["price_detail"]:"";?></textarea></td>
  </tr>

  <?php }?>

  <tr>
    <td colspan="4" class="tdcenter">
    <input type="button" class="button" id="editinfod" onclick="editinfo()" value="保存订单">
    <input type="button" value="返回上页" class="btnviolet" onclick="pageload();location.href='<?php echo $S_ROOT;?>orders/views?id=<?php echo base64_encode($info["id"]);?>'" />

    </td>
  </tr>
</table>

</form>

</div>
</body>
</html>
