<?php
class invoiceAction extends Action
{

	Public function app()
	{
		$this->users->onlogin();	//登录判断
		$invoice = getModel("invoice");
		//发票类型
		$catetype = $invoice->catetype();
		$this->tpl->set("catetype",$catetype);
		$this->tpl->display("invoice.index.php");
	}

	Public function add()
	{
		$this->users->dialoglogin();		//登录判断
		$this->users->dialoglevel();		//权限判断
		$invoice = getModel("invoice");
		if(isset($_POST)&&!empty($_POST))
		{
			$ordersid = (int)base64_decode($_POST["ordersid"]);
			$invoice->ordersid = $ordersid;
			$invoice->add();
			echo "1";
		}else{
			$ordersid = (int)base64_decode($_GET["ordersid"]);
			//检查上次开票状态
			$msg = $invoice->checkjoin("ordersid=$ordersid");
			if($msg){ dialog("你已经提交过发票申请，请勿重复提交！"); }
			$orders = getModel("orders");
			$ordersinfo = $orders->getrow("id=$ordersid");
			$dateline = time()-86400*360;
			if($ordersinfo["type"]!="8"&&$ordersinfo["dateline"]<$dateline){ dialog("订购时间超过一年，无法申请发票！"); }
			if((int)$ordersinfo["status"]=="7"||(int)$ordersinfo["status"]=="-1"){ dialog("订单已取消，无法增加申请发票！"); }
			$this->tpl->set("ordersinfo",$ordersinfo);
			//已开金额
			$countnums = $invoice->opencount("ordersid=$ordersid");
			$countnums = round($countnums,2);
			$this->tpl->set("countnums",$countnums);
			//if($ordersinfo["type"]=="8"){
			//	$price = $ordersinfo["price"];	//入款金额
			//}else{
				$price = $ordersinfo["price"];
			//}
			$opennums = round($price-$countnums,2);
			$this->tpl->set("opennums",$opennums);
			if($countnums>=$price){ dialog("发票可开金额不得超过订单金额！"); }
			//发票类型
			$catetype = $invoice->catetype();
			$this->tpl->set("catetype",$catetype);
			$this->tpl->set("type","invoiceinfo");
			$this->tpl->display("invoice.dialog.php");
		}
	}

	Public function edit()
	{
		$this->users->dialoglogin();	//登录判断
		$invoice = getModel("invoice");
		if(isset($_POST)&&!empty($_POST))
		{
			$id = (int)base64_decode($_POST["id"]);
			$invoice->id = $id;
			$ordersid = (int)base64_decode($_POST["ordersid"]);
			$invoice->ordersid = $ordersid;
			$invoice->edit();
			echo "1";
		}else{
			$orders = getModel("orders");
			$id = (int)base64_decode($_GET["id"]);
			$info = $invoice->getrow("id=$id");
			$ordersid = (int)$info["ordersid"];
			$ordersinfo = $orders->getrow("id=$ordersid");
			$this->tpl->set("ordersinfo",$ordersinfo);
			//已开金额
			$countnums = $invoice->opencount("ordersid=$ordersid");
			$this->tpl->set("countnums",$countnums);
			//if($ordersinfo["type"]=="8"){
			//	$price = $orders->orders_charge("ordersid=$ordersid");	//入款金额
			//}else{
				$price = $ordersinfo["price"];
			//}
			$opennums = round($price-$countnums,2);
			$this->tpl->set("opennums",$opennums);
			//$opennums可开金额
			$userid = (int)$this->cookie->get("userid");
			$isadmin = $this->users->isadmin();				//判断是否管理员
			$islevel = $this->users->getlevel();			//判断页面权限
			if($info["checked"]=="1"){
				dialog("票据已审核，无法进行修改！");
			}
			if($info["userid"]!=$userid&&!$islevel&&!$isadmin){
				if($info["checked"]<>"2"){
					dialog("抱歉，你没有权限进行操作！");
				}
			}
			$this->tpl->set("info",$info);
			//发票类型
			$catetype = $invoice->catetype();
			$this->tpl->set("catetype",$catetype);
			$this->tpl->set("type","invoiceinfo");
			$this->tpl->display("invoice.dialog.php");
		}
	}

	Public function del()
	{
		$this->users->dialoglogin();			//登录判断
		$invoice = getModel("invoice");
		$id = (int)base64_decode($_GET["id"]);
		$info = $invoice->getrow("id=$id");
		$userid = (int)$this->cookie->get("userid");
		$isadmin = $this->users->isadmin();		//判断是否管理员
		$islevel = $this->users->getlevel();	//判断页面权限
		if($info["userid"]!=$userid&&$isadmin!=1&&!$islevel){
			dialog("抱歉，你没有权限进行操作！");
		}
		if($info["checked"]==1&&$isadmin!=1){
			dialog("抱歉，申请已通过审核，无法进行删除！");
		}
		if(!$info["worked"]&&$isadmin!=1){
			dialog("抱歉，发票申请已处理，无法进行删除！");
		}
		$invoice->id = $id;
		$invoice->ordersid = $info["ordersid"];
		$invoice->del();
		echo 1;
	}

	//发票信息
	Public function views()
	{
		$this->users->onlogin();		//登录判断
		$islevel = $this->users->getlevel();	//权限判断
		$invoice = getModel("invoice");
		$id = (int)base64_decode($_GET["id"]);
		$info = $invoice->getrow("id=$id");
		$this->tpl->set("islevel",$islevel);
		//if(!$islevel){
		//	$userid = (int)$this->cookie->get("userid");
		//	if($userid!=$info["userid"]){ msgbox("","抱歉，你没有权限访问本页面"); }
		//}
		if(!$info){ msgbox("","参数错误"); }
		$checktype = $invoice->checktype();
		$this->tpl->set("checktype",$checktype);
		$worktype = $invoice->worktype();
		$this->tpl->set("worktype",$worktype);
		// $catetype = $invoice->catetype();
		// $this->tpl->set("catetype",$catetype);
		$this->tpl->set("info",$info);
		$orders = getModel("orders");
		//订单信息
		$orderinfo = $orders->getrow("id=".$info["ordersid"]."");
		$this->tpl->set("orderinfo",$orderinfo);
		if($orderinfo["status"]=="-1"||$orderinfo["status"]=="7"){
			msgbox("","订单已取消，无法进行操作");
		}
		//已支付金额
		$paycharge = $orders->orders_charge("ordersid=".$info["ordersid"]."");
		$this->tpl->set("paycharge",$paycharge);
		//订购信息
		$orders_product = $orders->ordersinfo("ordersid=".$info["ordersid"]."&group=true");
		$this->tpl->set("orders_product",$orders_product);
		$this->tpl->display("invoice.views.php");
	}

	//发票审核
	Public function checked()
	{
		$this->users->dialoglogin();	//登录判断
		$this->users->dialoglevel();	//权限判断
		$invoice = getModel("invoice");
		$id = (int)base64_decode($_GET["id"]);

		$orders = getModel("orders");
		$ordersid = $info["ordersid"];
		$orderinfo = $orders->getrow("id=$ordersid");
		if($orderinfo["status"]=="-1"||$orderinfo["status"]=="7"){ dialog("订单已经取消，无法进行开票!"); }

		if(isset($_POST)&&!empty($_POST))
		{
			$invoice->id = $id;
			$invoice->ordersid = $ordersid;
			$invoice->checked();
			echo "1";
		}else{
			$info = $invoice->getrow("id=$id");
			//$isadmin = $this->users->isadmin();				//判断是否管理员
			$timeline = time()-21600;	//计算前一天
			//if($info["checked"]==1&&$info["checkdate"]<$timeline){
				//dialog("发票已审核，操作已超过有效时长，无法再进行操作！");
			//}
			if($info["hide"]=="0"){ dialog("记录已删除！"); }
			if($info["worked"]=="1"){ dialog("发票已开具，无法进行审核操作");	 }
			if($info["worked"]=="2"){ dialog("申请已取消，无法进行审核操作！"); }
			if($info["worked"]=="3"){ dialog("发票已作废，无法进行审核操作！"); }
			$checktype = $invoice->checktype();
			$this->tpl->set("checktype",$checktype);
			$this->tpl->set("info",$info);
			$this->tpl->set("type","checked");
			$this->tpl->display("invoice.dialog.php");
		}
	}

	//发票处理查询
	Public function status()
	{

		$this->users->onlogin();		//登录判断
		$this->users->pagelevel();		//权限判断

		extract($_GET);
		$invoice = getModel("invoice");

		if($show=="lists"){

			$isadmin = $this->users->isadmin();		//判断是否管理员
			if(!$isadmin){ $userid = (int)$this->cookie->get("userid"); }
			//$userid = 9;
			if($worknums!=""){
				$worknums = "&sotype=2&sokey=".$worknums;
			}
			$list = $invoice->getrows("page=1&nums=20&ordersid=$ordersid&contract=$contract&userid=$userid".$worknums);
			$this->tpl->set("list",$list["record"]);
			$this->tpl->set("page",$list["pages"]);
			$checktype = $invoice->checktype();
			$this->tpl->set("checktype",$checktype);
			$worktype = $invoice->worktype();
			$this->tpl->set("worktype",$worktype);
			// $catetype = $invoice->catetype();
			// $this->tpl->set("catetype",$catetype);

		}
		$this->tpl->set("show",$show);
		$this->tpl->display("invoice.status.php");

	}


	//发票开票
	Public function opened()
	{
		$this->users->dialoglogin();	//登录判断
		$this->users->dialoglevel();	//权限判断
		$invoice = getModel("invoice");
		$id = (int)base64_decode($_GET["id"]);
		$info = $invoice->getrow("id=$id");
		$ordersid = (int)base64_decode($info["ordersid"]);
		if(isset($_POST)&&!empty($_POST))
		{
			$invoice->id = $id;
			$invoice->ordersid = $ordersid;
			$invoice->opened();
			echo "1";
		}else{
			if($info["hide"]=="0"){ dialog("记录已删除！"); }
			if($info["checked"]!="1"){ dialog("申请没有审核，无法进行开票操作！"); }
			if($info["checked"]!="1"){ dialog("申请没有审核，无法进行开票操作！"); }
			$orders = getModel("orders");
			$ordersid = $info["ordersid"];
			$orderinfo = $orders->getrow("id=$ordersid");
			if($orderinfo["status"]=="-1"||$orderinfo["status"]=="7"){ dialog("订单已经取消，无法进行开票!"); }
			//$isadmin = $this->users->isadmin();				//判断是否管理员
			$timeline = time()-21600;	//计算前一天
			if($info["worked"]=="1"&&$info["workdate"]<$timeline){ dialog("开票已经超过有效时长，无法进行开票修正！"); }
			if($info["worked"]=="2"&&$info["workdate"]<$timeline){ dialog("取消已经超过有效时长，无法恢复开票修正！"); }
			if($info["worked"]=="3"){ dialog("发票申请已作废和取消，无法进行开票操作！"); }
			$checktype = $invoice->checktype();
			$this->tpl->set("checktype",$checktype);
			$worktype = $invoice->worktype();
			$this->tpl->set("worktype",$worktype);
			$catetype = $invoice->catetype();
			$this->tpl->set("catetype",$catetype);

			$orders = getModel("orders");
			//已开金额
			$countnums = $invoice->opencount("ordersid=$ordersid");
			$this->tpl->set("countnums",$countnums);
			$price = $orders->orders_charge("ordersid=$ordersid");	//入款金额
			$opennums = round($price-$countnums,2);
			$this->tpl->set("opennums",$opennums);

			$this->tpl->set("info",$info);
			$this->tpl->set("type","opened");
			$this->tpl->display("invoice.dialog.php");
		}
	}

	Public function killed()
	{
		$this->users->dialoglogin();	//登录判断
		$this->users->dialoglevel();	//权限判断
		$invoice = getModel("invoice");
		$id = (int)base64_decode($_GET["id"]);
		$info = $invoice->getrow("id=$id");
		$ordersid = (int)base64_decode($info["ordersid"]);
		if(isset($_POST)&&!empty($_POST))
		{
			$invoice->id = $id;
			$invoice->ordersid = $ordersid;
			$invoice->killed();
			echo "1";
		}else{
			if($info["hide"]=="0"){ dialog("记录已删除！"); }
			//$isadmin = $this->users->isadmin();				//判断是否管理员
			$timeline = time()-21600;	//计算前一天
			if($info["workdate"]<$timeline&&$info["worked"]==2){
				dialog("取消已经超过有效时长，无法进行作废修正！");
			}
			if($info["workdate"]<$timeline&&$info["worked"]==3){
				dialog("作废已经超过有效时长，无法进行作废修正！");
			}
			$this->tpl->set("info",$info);
			$this->tpl->set("type","killed");
			$this->tpl->display("invoice.dialog.php");
		}

	}

	Public function lists()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		extract($_GET);
		$invoice = getModel("invoice");
		$list = $invoice->getrows("page=1&nums=20&ochecked=1&status=$status&sotype=$sotype&sokey=$sokey&type=$type&cateid=$cateid");
		$this->tpl->set("list",$list["record"]);
		$this->tpl->set("page",$list["pages"]);
		$checktype = $invoice->checktype();
		$this->tpl->set("checktype",$checktype);
		$worktype = $invoice->worktype();
		$this->tpl->set("worktype",$worktype);
		// $catetype = $invoice->catetype();
		// $this->tpl->set("catetype",$catetype);
		$this->tpl->display("invoice.list.php");
	}

	Public function xls()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		extract($_GET);
		$invoice = getModel("invoice");
		$list = $invoice->getrows("xls=1&status=$status&sotype=$sotype&sokey=$sokey&type=$type&cateid=$cateid");
		$checktype = $invoice->checktype();
		$worktype = $invoice->worktype();
		$catetype = $invoice->catetype();
		if($list){
			$xls = getFunc("excel");
			$data = array();
			$data[] = array('购买日期','申请日期','订单编号','开票类别','金额','操作时间','申请人员','审核状态','审核时间','审核人员','开票状态','开票时间','开票人员');
			foreach($list AS $rs){
				$checked =  $checktype["checked"];
				$data[]=array(date("Y-m-d",$rs["odateline"]),date("Y-m-d",$rs["dateline"]),$rs["ordersid"],$rs["service"],$rs["price"],$rs["detail"],date("Y-m-d H:i:s",$rs["dateline"]),"系统自动");
			}
			$xls->addArray($data);
			$xls->generateXML($godate."-".$todate);
		}else{
			msgbox("","没有找到相关数据！");
		}
	}



	//打印物流单
	Public function printexp()
	{
		$this->users->onlogin();	//登录判断
		$show = $_GET["show"];
		$id = (int)base64_decode($_GET["id"]);
		$invoice = getModel("invoice");
		$express = getModel("express");
		$info = $invoice->getrow("id=$id");

		$usertype = $this->cookie->get("usertype");
		if($usertype!="1"){ msgbox("你没有权限进行操作!"); }

		$orders = getModel("orders");
		$ordersid = $info["ordersid"];
		$ordersinfo = $orders->getrow("id=$ordersid");

		$arr = array();
		$arr["id"]		=	$info["ordersid"];
		$arr["name"]	=	$info["postname"];
		$arr["address"] =	$info["postaddress"];
		$arr["mobile"]	=	$info["postphone"];
		$invocityname	=	$info["cityname"];
		if($invocityname){
			$cityarr = explode(" ",$invocityname);
			$arr["cityname"]	=	$cityarr[0];
			$arr["areaname"]	=	$cityarr[1];
		}

		$this->tpl->set("info",$arr);
		$this->tpl->set("exptype","2");

		$expaddress = $express->expaddress();
		$this->tpl->set("expaddress",$expaddress);
		$this->tpl->set("back",$this->cookie->get("views"));

		$cate = 0;
		$this->tpl->set("cate",$cate);

		if($show=="yto"){  			//圆通
			$this->tpl->display("express.print.yto.php");
		}elseif($show=="fedex"){	//联邦
			$this->tpl->display("express.print.fedex.php");
		}elseif($show=="zto"){		//中通
			$this->tpl->display("express.print.zto.php");
		}elseif($show=="sto"){		//中通
			$this->tpl->display("express.print.sto.php");
		}elseif($show=="yunda"){	//韵达
			$this->tpl->display("express.print.yunda.php");
		}elseif($show=="qfkd"){		//全峰
			$this->tpl->display("express.print.qfkd.php");
		}elseif($show=="htky"){		//汇通
			$this->tpl->display("express.print.htky.php");
		}elseif($show=="ttkd"){		//天天
			$this->tpl->display("express.print.ttkd.php");
		}elseif($show=="sf"){		//sf
			$this->tpl->display("express.print.sf.php");
		}elseif($show=="whehtky"){

			$mailno = $_GET["mailno"];
			if($mailno==""){
				$mdinfo = $express->huitong($arr);
				$mailno = $mdinfo["mailNo"];
				$this->tpl->set("mdinfo",$mdinfo);
			}else{
				$mailno = $mailno;
			}
			if(!is_numeric($mailno)){
				msgbox("","没在找到单据号码 ");
			}
			$this->tpl->set("mailno",$mailno);
			$this->tpl->display("express.print.whehtky.php");

		}elseif($show=="wheqf"){	//E全峰

			$mailno = $express->quanfeng();
			if(!is_numeric($mailno)){
				msgbox("",$mailno);
			}
			$this->tpl->set("mailno",$mailno);
			$this->tpl->display("express.print.wheqf.php");

		}elseif($show=="whesf"){		//E顺丰

            $sf = $express->shunfeng($arr);
            $this->tpl->set("destcode",$sf["destcode"]);
            $this->tpl->set("origincode",$sf["origincode"]);
            $this->tpl->set("mailno",$sf["mailno"]);
            $this->tpl->set("sfordersid",$sf["sfordersid"]);
            $this->tpl->display("express.print.whesf.php");

		}elseif($show=="wheyd"){	//武汉韵达电子面单

			$mailno = $_GET["mailno"];
			if($mailno==""){
				$mdinfo = $express->yundaex($ordersinfo);
				$mailno = $mdinfo["mail_no"];
				$this->tpl->set("mdinfo",$mdinfo);
			}else{
				$mailno = $mailno;
			}
			//echo $mailno;exit;
			if(!is_numeric($mailno)){
				msgbox("","没在找到单据号码 ");
			}
			$this->tpl->set("mailno",$mailno);
			$this->tpl->display("express.print.wheyd.php");

		}else{

		}
	}

}
?>
