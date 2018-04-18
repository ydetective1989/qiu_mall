<?php
class chargeAction extends Action
{

	Public function app()
	{
		$this->users->onlogin();	//登录判断
	}

	//确认款项记录
	Public function checked()
	{
		extract($_GET);
		$this->users->dialoglogin();	//登录判断
		$this->users->dialoglevel();	//登录判断
		$charge = getModel("charge");
		if(isset($_POST)&&!empty($_POST))
		{
			$msg = $charge->checked();
			if($msg=="1"){
				echo 1;exit;
			}else{
				echo $msg;exit;
			}
		}else{
			echo "没有选择要确认的款项！";exit;
		}
	}

	//收支方式
	Public function gettype()
	{
		extract($_GET);
		$charge = getModel("charge");

		$str = "<option value=''>选择收支帐号</option>";
		if($id){
			$payptype = $charge->paytype("id=$id");
			if($payptype){
				foreach($payptype AS $rs){
					$str.= "<option value='".$rs["id"]."'>".$rs["name"]."</option>";
				}
			}
		}
		echo $str;
	}

	//订单入款管理
	Public function orders()
	{
		extract($_GET);
		$this->users->onlogin();	//登录判断
		$charge = getModel("charge");
		$orders = getModel("orders");
		$chargetype = $orders->chargetype();
		$this->tpl->set("chargetype",$chargetype);
		$cates = $charge->cates();
		$this->tpl->set("cates",$cates);
		if($_GET["show"]=="lists"){

			$this->users->pagelevel();	//权限判断
			if($godate&&$todate){
				$godate = $godate;
				$todate = $todate;
			}else{
				$date = plugin::getTheMonth(date("Y-m",time()));
				$godate = $date[0];
				$todate = $date[1];
			}
			$list = $orders->charge("page=1&order=datetime&desc=DESC&checkuserid=$checkuserid&checked=$checked&ordersid=$ordersid&type=$type&ptype=$ptype&payid=$payid&nums=20&godate=$godate&todate=$todate&checked=$checked&userid=$userid&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$this->tpl->set("list",$list["record"]);
			$this->tpl->set("page",$list["pages"]);
			$this->tpl->display("charge.orders.list.php");


		}elseif($_GET["show"]=="users"){
			if($godate&&$todate){
				$godate = $godate;
				$todate = $todate;
			}
			$list = $charge->users("godate=$godate&todate=$todate");
			$str.="<option value=\"\">选择入款人员</option>";
			if($list){
				foreach($list AS $rs){
					$str.="<option value=\"".$rs["userid"]."\">".$rs["worknum"]."_".$rs["name"]."</option>";
				}
			}
			echo $str;exit;
		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$userlist = $charge->users("godate=$godate&todate=$todate");
			$this->tpl->set("userlist",$userlist);

			$charge = getModel("charge");
			$payptype = $charge->paytype("id=0");
			$this->tpl->set("payptype",$payptype);

			$this->tpl->display("charge.orders.php");
		}
	}
	
}
?>
