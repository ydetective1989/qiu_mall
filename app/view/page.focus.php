<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>YWS</title>
<?php require(VIEW."config.script.php");?></head>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/focus.js?<?php echo date("Ymd")?>"></script>
<body>
<div class="info">

<table width="100%" class="title">
<tr>
<td height="5"></td>
<td class="tdright"></td>
</tr>
<tr>
<td height="30" class="tdleft bold">&nbsp;我关注的订单：</td>
<td class="tdright"><input type="button" value="清除全部" onclick="focus_clear('dd')"></td>
</tr>
</table>

<div id="focus_orders_list">正在加载数据...</div>
<script type="text/javascript">focus_orders(1);</script>


<table width="100%" class="title">
<tr>
<td height="5"></td>
<td class="tdright"></td>
</tr>
<tr>
<td height="30" class="tdleft bold">&nbsp;我关注的工单：</td>
<td class="tdright"><input type="button" value="清除全部" onclick="focus_clear('gd')"></td>
</tr>
</table>

<div id="focus_jobs_list">正在加载数据...</div>
<script type="text/javascript">focus_jobs(1);</script>


<!--
<table width="100%" class="title">
<tr>
<td height="5"></td>
<td class="tdright"></td>
</tr>
<tr>
<td height="30" class="tdleft bold">&nbsp;我关注的投诉：</td>
<td class="tdright"><input type="button" value="清除全部" onclick="focus_clear('ts')"></td>
</tr>
</table>

<div id="focus_complaint_list">正在加载数据...</div>
<script type="text/javascript">focus_complaint(1);</script>
 -->


<table width="100%" class="title">
<tr>
<td height="5"></td>
<td class="tdright"></td>
</tr>
<tr>
<td height="30" class="tdleft bold">&nbsp;我关注的发票：</td>
<td class="tdright"><input type="button" value="清除全部" onclick="focus_clear('fp')"></td>
</tr>
</table>

<div id="focus_invoice_list">正在加载数据...</div>
<script type="text/javascript">focus_invoice(1);</script>


</div>
</body>
</html>
