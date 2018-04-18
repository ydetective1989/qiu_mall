<?php if($type=="iframe"){?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/cpinfo.js?<?php echo date("Ymd");?>"></script>
</head>
<body scroll="no">
<table width="100%" height="100%" >
  <tr>
    <td height="40" class="bold">&nbsp;商品管理</td>
    <td align="right">
        <span><select name="sotype" id="sotype" class="select">
        <option value="encoded">产品编码</option>
        <option value="title">产品名称</option>
      </select> <input type="text" name="keyval" id="keyval" class="input" ></span>
        <span><select name="categoryid" id="categoryid" class="select">
        <option value="">所有类目</option>
        <?php foreach($cates AS $rs){?>
        <option value="<?php echo $rs["categoryid"]?>" <?php if($rs["categoryid"]==$info["categoryid"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
        <?php }?>
       </select></span>
        <span><select name="brandid" id="brandid" class="select">
        <option value="">所有品牌</option>
        <?php foreach($brands AS $rs){?>
        <option value="<?php echo $rs["brandid"]?>" <?php if($rs["brandid"]==$info["brandid"]){ echo "selected"; }?>><?php echo $rs["name"]?></option>
        <?php }?>
       </select></span>
        <span><select name="checked" id="checked" class="select">
        <option value="">审核状态</option>
        <option value="1">正常状态</option>
        <option value="0">下架状态</option>
       </select></span>
       <span><input type="button" value="搜索商品" class="button" onclick="searched()" /></span>
	     <span><input type="button" value="增加商品" class="button" onclick="frminfo.location.href='<?php echo $S_ROOT;?>cpinfo/product?do=add'" />&nbsp;&nbsp;</span>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="bgfocus headerfocus"></td>
  </tr>
  <tr>
    <td colspan="2" height="100%">
    <iframe src="<?php echo $S_ROOT;?>cpinfo/product?show=lists" width="100%" height="100%" name="frminfo" scrolling="auto" noresize="noresize" id="frminfo" frameborder="no" style="" /></iframe>
    </td>
  </tr>
</table>
</body>
</html>

<?php }elseif($type=="lists"){?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title></title>
<?php require(VIEW."config.script.php");?>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/cpinfo.js?<?php echo date("Ymd");?>"></script>
</head>
<body>

<div class="forms">

  <table width="100%" class="tdcenter">
  	<tr class="bgheader white">
  		<td width="140" class="" height="30">商品类目</td>
  		<td class="">[商品编码]商品名称/ERP名称</td>
      <td width="150" class="">商品品牌</td>
      <td width="80" class="">状态</td>
  		<td width="150" class="">操作</td>
  	</tr>
  	<?php if($list){?>
  	<?php foreach($list AS $rs){?>
  	<tr class="datas">
  		<td class="" height="30"><?php echo $rs["catename"];?></td>
  		<td class="tdleft">[<?php echo $rs["encoded"];?>] <?php echo $rs["title"];?><span class="gray">(<?php echo $rs["erpname"];?>)</span></td>
  		<td class=""><?php echo $rs["brandname"];?></td>
  		<td class=""><a href="<?php echo $S_ROOT;?>cpinfo/product?do=checked&id=<?php echo $rs["productid"];?>"><?php if($rs["checked"]=="1"){?>有效<?php }else{?><span class='red'>停用</span></a><?php }?></td>
  		<td class="gray"><a href="<?php echo $S_ROOT;?>cpinfo/product?do=edit&id=<?php echo $rs["productid"];?>">[修改]</a>
      <a href="<?php echo $S_ROOT;?>cpinfo/product?do=del&id=<?php echo $rs["productid"];?>" onclick="javascript:{if(!confirm('确定要删除操作吗？\n一旦取消，不可恢复！')){return false;};}" >[删除]</a></td>
  	</tr>
  	<?php }?>
    	<tr>
    		<td class="tdcenter" height="30"></td>
    	</tr>
  	<?php }else{?>
  	<tr class="datas">
  		<td colspan="10" height="30" class="tdcenter">无</td>
  	</tr>
  	<?php }?>
  </table>

  <?php if($page){ ?>
  <div class="bottom_tools">
  <table width="100%" class="pagenav bgheader">
  	<tr>
  		<td class="tdcenter"><?php echo $page;?></td>
  	</tr>
  </table>
  </div>
  <?php }?>

</div>

</body>
</html>

<?php }else{?>

NULL

<?php }?>
