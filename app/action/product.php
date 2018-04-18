<?php
class productAction extends Action
{

	Public function app()
	{
		$this->users->onlogin();	//登录判断

	}

	//产品dialog
	Public function dialog()
	{
		$this->users->onlogin();	//登录判断
		$product = getModel("product");
		//分类
		$category = $product->category();
		$this->tpl->set("category",$category);
		//品牌
		$brand = $product->brand();
		$this->tpl->set("brand",$brand);

		$this->tpl->set("type","product");
		$this->tpl->display("orders.dialog.php");
	}

	//产品分类
	Public function category()
	{
		extract($_GET);	//分裂数组
		$this->users->onlogin();	//登录判断
		$product = getModel("product");
		$rows = $product->category();
		$val = "";
		$val.= "<option value=\"\">选择产品分类</option>";
		if($rows){
			foreach($rows AS $rs){
				$val.= "<option value=\"".$rs["categoryid"]."\">".$rs["name"]."</option>";
			}
		}
		echo $val;
	}

	//产品品牌
	Public function brand()
	{
		extract($_GET);	//分裂数组
		$this->users->onlogin();	//登录判断
		$product = getModel("product");
		$rows = $product->brand("categoryid=$categoryid");
		$val = "";
		$val.= "<option value=\"\">选择产品品牌</option>";
		if($rows){
			foreach($rows AS $rs){
				//$val.= "<option value=\"".$rs["brandid"]."\">".$rs["name"]."</option>";
			}
		}
		echo $val;
	}

	//产品搜索
	Public function dialogso()
	{
		extract($_GET);	//分裂数组
		$this->users->onlogin();	//登录判断
		$product = getModel("product");
		$rows = $product->getrows("title=$title&encoded=$encoded&categoryid=$categoryid&brandid=$brandid");
		if($rows){
			$msg = "";
			foreach($rows AS $rs){
				$msg.="<option value=\"".$rs["productid"]."||".$rs["encoded"]."||".$rs["price"]."||".$rs["title"]."\">".$rs["encoded"]." || ".$rs["title"]."</option>";
			}
		}else{
			$msg = "<option value=\"\">没有找到相关产品</option>";
		}
		echo $msg;
	}

}
?>
