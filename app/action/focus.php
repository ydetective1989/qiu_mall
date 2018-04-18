<?php
class focusAction extends Action
{

	Public function status()
	{
		$this->users->onlogin();	//登录判断
		$cates	= $_GET["cates"];
		$id		= base64_decode($_GET["id"]);
		$focus = getModel("focus");
		$checked = $focus->status("cates=$cates&id=$id");
		//print_r($checked);
		$this->tpl->set("checked",$checked);
		$this->tpl->set("type","status");
		$this->tpl->display("focus.dialog.php");
	}

  Public function cleard()
  {
      $this->users->dialoglogin();
      $cates	= $_POST["cates"];
      $focus = getModel("focus");
      $msg = $focus->cleard("cates=$cates");
      echo $msg;
  }

	Public function addfav()
	{
		$this->users->onlogin();	//登录判断
		$cates	= $_POST["cates"];
		$id		= base64_decode($_POST["id"]);
		$focus = getModel("focus");
		$msg = $focus->addfav("cates=$cates&id=$id");
		echo $msg;
	}

	Public function channel()
	{
		$this->users->onlogin();	//登录判断
		$cates	= $_POST["cates"];
		$id		= base64_decode($_POST["id"]);
		$focus = getModel("focus");
		$msg = $focus->channel("cates=$cates&id=$id");
		echo $msg;
	}

	Public function orders()
	{
		$this->users->onlogin();	//登录判断

		$orders = getModel("orders");
		//订单类型
		$ordertype = $orders->ordertype();
		$this->tpl->set("ordertype",$ordertype);
		//付款状态
		$paystatetype = $orders->paystatetype();
		$this->tpl->set("paystatetype",$paystatetype);
		//审核状态
		$checktype = $orders->checktype();
		$this->tpl->set("checktype",$checktype);
		//订单进度
		$statustype = $orders->statustype();
		$this->tpl->set("statustype",$statustype);
		//支付方式
		$paytype = $orders->paytype();
		$this->tpl->set("paytype",$paytype);

		$focus = getModel("focus");
		$rows  = $focus->orders();
		$list  = $rows["record"];
		$page  = $rows["pages"];
		$this->tpl->set("list",$list);
		$this->tpl->set("page",$page);
		$this->tpl->set("type","orders");
		$this->tpl->display("focus.dialog.php");
	}

	Public function invoice()
	{
		$this->users->onlogin();	//登录判断

		$orders = getModel("orders");
		//订单进度
		$statustype = $orders->statustype();
		$this->tpl->set("statustype",$statustype);


		$invoice = getModel("invoice");
		//发票审核
		$checktype = $invoice->checktype();
		$this->tpl->set("checktype",$checktype);
		//开票状态
		$worktype = $invoice->worktype();
		$this->tpl->set("worktype",$worktype);

		$focus = getModel("focus");
		$rows  = $focus->invoice();
		$list  = $rows["record"];
		$page  = $rows["pages"];
		$this->tpl->set("list",$list);
		$this->tpl->set("page",$page);

		$this->tpl->set("type","invoice");
		$this->tpl->display("focus.dialog.php");
	}

	Public function jobs()
	{
		$this->users->onlogin();	//登录判断

		$orders = getModel("orders");
		//订单进度
		$statustype = $orders->statustype();
		$this->tpl->set("statustype",$statustype);


		$jobs = getModel("jobs");
		//发票审核
		$jobstype = $jobs->jobstype();
		$this->tpl->set("jobstype",$jobstype);
		//开票状态
		$worktype = $jobs->worktype();
		$this->tpl->set("worktype",$worktype);

		$focus = getModel("focus");
		$rows  = $focus->jobs();
		//print_r($rows);
		$list  = $rows["record"];
		$page  = $rows["pages"];
		$this->tpl->set("list",$list);
		$this->tpl->set("page",$page);

		$this->tpl->set("type","jobs");
		$this->tpl->display("focus.dialog.php");
	}

	Public function complaint()
	{
		$this->users->onlogin();	//登录判断

		$orders = getModel("orders");

		$focus = getModel("focus");
		$rows  = $focus->complaint();
		//print_r($rows);
		$list  = $rows["record"];
		$page  = $rows["pages"];
		$this->tpl->set("list",$list);
		$this->tpl->set("page",$page);

		$this->tpl->set("type","complaint");
		$this->tpl->display("focus.dialog.php");
	}


}
?>
