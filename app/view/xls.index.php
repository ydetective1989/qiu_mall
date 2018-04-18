<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>json/teams?type=1&val=salesTeams"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/xls.js?<?php echo date("Ymd");?>"></script>
</head>
<body>
<div class="info">

<table width="100%">
  <tr>
    <td height="30" class="tdcenter bgfocus">导出结算信息</td>
  </tr>
</table>

<table width="100%" class="table">
  <tr>
    <td width="30" class="tdright"></td>
    <td height="1" class="tdright"></td>
  </tr>
  <tr>
    <td class="tdright"></td>
    <td class="">
    <input type="text" name="jobs_godate" id="jobs_godate" value="<?php echo $ngodate?>" class="input" style="width:100px;" >
    <input type="text" name="jobs_todate" id="jobs_todate" value="<?php echo $ntodate?>" class="input" style="width:100px;" >
    <select name="jobs_salesarea" id="jobs_salesarea" class="select"></select>
	<select name="jobs_salesid" id="jobs_salesid" class="select"></select>
    <select name="jobs_brandid" id="jobs_brandid" class="select">
    <option value="">选择品牌</option>
    <?php foreach($brand AS $rs){?>
    <option value="<?php echo $rs["brandid"];?>"><?php echo $rs["name"];?></option>
    <?php }?>
    </select>
    <input type="text" name="jobs_encoded" id="jobs_encoded" class="input" value="">
	</td>
  </tr>
  <tr>
    <td class="tdright"></td>
    <td class=""><input type="button" value="导出数据" class="button" onclick="xls_jobs();">
    </td>
  </tr>
</table>


<table width="100%">
    <tr>
        <td height="30" class="tdcenter bgfocus">导出订购信息</td>
    </tr>
</table>

<table width="100%" class="table">
    <tr>
        <td width="30" class="tdright"></td>
        <td height="1" class="tdright"></td>
    </tr>
    <tr>
        <td class="tdright"></td>
        <td class="">
            <input type="text" name="sales_godate" id="sales_godate" value="<?php echo $ngodate?>" class="input" style="width:100px;" >
            <input type="text" name="sales_todate" id="sales_todate" value="<?php echo $ntodate?>" class="input" style="width:100px;" >
            <select name="sales_salesarea" id="sales_salesarea" class="select"></select>
            <select name="sales_salesid" id="sales_salesid" class="select"></select>
            <select name="sales_brandid" id="sales_brandid" class="select">
                <option value="">选择品牌</option>
                <?php foreach($brand AS $rs){?>
                    <option value="<?php echo $rs["brandid"];?>"><?php echo $rs["name"];?></option>
                <?php }?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="tdright"></td>
        <td class=""><input type="button" value="导出数据" class="button" onclick="xls_sales();">
        </td>
    </tr>
</table>



<table width="100%">
    <tr>
        <td height="30" class="tdcenter bgfocus">导出产品销售(中怡康)</td>
    </tr>
</table>

<table width="100%" class="table">
    <tr>
        <td width="30" class="tdright"></td>
        <td height="1" class="tdright"></td>
    </tr>
    <tr>
        <td class="tdright"></td>
        <td class="">
            <input type="text" name="product_godate" id="product_godate" value="<?php echo $ngodate?>" class="input" style="width:100px;" >
            <input type="text" name="product_todate" id="product_todate" value="<?php echo $ntodate?>" class="input" style="width:100px;" >
        </td>
    </tr>
    <tr>
        <td class="tdright"></td>
        <td class=""><input type="button" value="导出数据" class="button" onclick="xls_product();">
        </td>
    </tr>
</table>

<iframe align="center" width="100%" height="35" name="xlsfrm" crolling="no" noresize="noresize" id="xlsfrm" style="border:0px;overflow:none;"></iframe>

</div>
</body>
</html>
