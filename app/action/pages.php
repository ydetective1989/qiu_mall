<?php
class pagesAction extends Action
{

	Public function app()
	{
		$this->users->onlogin();	//登录判断
		$this->tpl->display("page.main.php");
	}

	Public function main()
	{
		$this->users->onlogin();	//登录判断
		$this->tpl->display("page.index.php");
	}

	Public function focus()
	{

		$this->tpl->display("page.focus.php");
	}

	public function noie()
	{
		$this->tpl->display("msgbox.noie.php");
	}


	//销售系统框架页
	Public function orders()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$orders = getModel("orders");

		//订单类型
		$ordertype = $orders->ordertype();
		$this->tpl->set("ordertype",$ordertype);
		//客户类型
		$customstype = $orders->customstype();
		$this->tpl->set("customstype",$customstype);
		//审核状态
		$checktype = $orders->checktype();
		$this->tpl->set("checktype",$checktype);
		//订单进度
		$statustype = $orders->statustype();
		$this->tpl->set("statustype",$statustype);

		$this->tpl->display("frm.orders.php");
	}

	//工单系统框架页
	Public function jobs()
	{
		$this->users->onlogin();	//登录判断
		$jobs = getModel("jobs");
		$orders = getModel("orders");
		//工单类型
		$jobstype = $jobs->jobstype();
		$this->tpl->set("jobstype",$jobstype);
		//工单情况
		$worktype = $jobs->worktype();
		$this->tpl->set("worktype",$worktype);
		//服务区域
		$aftergroup = $jobs->aftergroup();
		$this->tpl->set("aftergroup",$aftergroup);
		//订单类型
		$ordertype = $orders->ordertype();
		$this->tpl->set("ordertype",$ordertype);
		$islevel = $this->users->getlevel();	//登录判断
		$this->tpl->set("islevel",$islevel);
		$this->tpl->display("frm.jobs.php");
	}

	//财务系统框架页
	Public function caiwu()
	{
		$this->users->onlogin();	//登录判断
		$this->tpl->display("frm.caiwu.php");
	}

	//业务系统框架页
	Public function sales()
	{
		$this->users->onlogin();	//登录判断
		$this->tpl->display("frm.sales.php");
	}

	//服务系统框架页
	Public function service()
	{
		$this->users->onlogin();	//登录判断
		switch($_GET["do"]){
			case "clockd":
				$date = plugin::getTheMonth(date("Y-m",time()));
				$godate = $date[0];
				$todate = $date[1];
				$this->tpl->set("godate",$godate);
				$this->tpl->set("todate",$todate);
				$this->tpl->display("service.clockd.maps.php");
				break;
			default:
				$this->tpl->display("frm.service.php");
		}
	}

	//统计系统框架页
	Public function counts()
	{
		$this->users->onlogin();	//登录判断
		$this->tpl->display("frm.counts.php");
	}

	//系统设置框架页
	Public function system()
	{
		$this->users->onlogin();	//登录判断
		$this->tpl->display("frm.system.php");
	}

}
?>
