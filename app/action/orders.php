<?php
class ordersAction extends Action
{

	Public function app()
	{
		$this->users->onlogin();	//登录判断
	}

	//订单列表
	Public function lists()
	{
		extract($_GET);

		$this->users->onlogin();	//登录判断
		//$this->users->pagelevel();	//权限判断

		$orders = getModel("orders");

		//订单类型
		$ordertype = $orders->ordertype();
		$this->tpl->set("ordertype",$ordertype);
		//客户类型
		$customstype = $orders->customstype();
		$this->tpl->set("customstype",$customstype);
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

		if($status!="1"&&$status!="-1"&&$status!=""){  $order = "id"; $desc = "ASC";  }

		$arr = "page=1&status=$status&showpid=$showpid&ordersid=$ordersid&customsid=$customsid&type=$type&ctype=$ctype&contract=$contract&name=$name&datetime=$datetime&phone=$phone&mobile=$mobile&wangwang=$wangwang&address=$address&checked=$checked&source=$source&provid=$provid&cityid=$cityid&areaid=$areaid&loops=$loops&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid&afterarea=$afterarea&afterid=$afterid&tagid=$tagid&mtype=$mtype&order=$order&desc=$desc";
		$list = $orders->getrows($arr);
		$this->tpl->set("list",$list["record"]);
		$this->tpl->set("page",$list["pages"]);

		$this->tpl->display("orders.list.php");

	}

	//订单操作
	Public function views()
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
		//付款状态
		$paystatetype = $orders->paystatetype();
		$this->tpl->set("paystatetype",$paystatetype);
		//订单进度
		$statustype = $orders->statustype();
		$this->tpl->set("statustype",$statustype);
		//支付方式
		$paytype = $orders->paytype();
		$this->tpl->set("paytype",$paytype);
		//送货方式
		$delivertype = $orders->delivertype();
		$this->tpl->set("delivertype",$delivertype);
		//安装方式
		$setuptype = $orders->setuptype();
		$this->tpl->set("setuptype",$setuptype);

		//处理订单ID
		$id = (int)base64_decode($_GET["id"]);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=query&ordersid=$id&name=订单操作[查看订单]&detail=查看订单[".$id."]&sqlstr=$logsarr");

		//订单信息
		$info = $orders->getrow("id=$id");
		if(!$info){ msgbox("","订单信息不正确！"); }
		$this->tpl->set("orderinfo",$info);

		if($info["parentid"]){
			$parentinfo = $orders->getrow("id=".(int)$info["parentid"]);
			$this->tpl->set("parentinfo",$parentinfo);
		}

		//已支付金额
		$paycharge = $orders->orders_charge("ordersid=$id");
		$this->tpl->set("paycharge",$paycharge);

		$userid = (int)$this->cookie->get("userid");
		$userinfo = $this->users->getrow("userid=$userid");

		$isadmin = $this->users->isadmin();
		$this->tpl->set("isadmin",$isadmin);

		$this->tpl->display("orders.views.php");
	}

	//增加普通订单
	Public function add()
	{
		$orders = getModel("orders");
		if(isset($_POST)&&!empty($_POST))
		{
			$id = base64_decode($_GET["id"]);
			$orders->id = (int)$id;
			$return = $orders->add_orders();
			if((int)$return>0){
				msgbox(S_ROOT."orders/views?id=".base64_encode($return),"增加订单成功，订单号：".$return."！");
			}else{
				msgbox("",$return);
			}
		}else{
			//订单类型
			$ordertype = $orders->ordertype();
			$this->tpl->set("ordertype",$ordertype);//customstype
			//客户类型
			$customstype = $orders->customstype();
			$this->tpl->set("customstype",$customstype);
			//审核状态
			$checktype = $orders->checktype();
			$this->tpl->set("checktype",$checktype);
			//订单进度
			$statustype = $orders->statustype();
			$this->tpl->set("statustype",$statustype);
			//支付方式
			$paytype = $orders->paytype();
			$this->tpl->set("paytype",$paytype);
			//送货方式
			$delivertype = $orders->delivertype();
			$this->tpl->set("delivertype",$delivertype);
			//安装方式
			$setuptype = $orders->setuptype();
			$this->tpl->set("setuptype",$setuptype);

			//处理订单ID
			$id = base64_decode($_GET["id"]);
			if($id){
				$info = $orders->getrow("id=$id");
				if($info["checked"]=="0"||$info["status"]=="7"||$info["status"]=="-1"){
					msgbox("","抱歉，此订单已取消和未审核状态，无法新增子订单！");
				}
				$row = $orders->checkrow("id=$id");
				if($row){ msgbox("","尚有子订单未处理完成，无法新增子订单！"); }
				$this->tpl->set("info",$info);
			}

			//用户列表
			$users = $this->users->getrows("checked=1&order=worknum&desc=ASC");
			$this->tpl->set("users",$users);
			$this->tpl->display("orders.info.php");
		}
	}

	//增加回访订单
	Public function add_small()
	{
		$orders = getModel("orders");
		if(isset($_POST)&&!empty($_POST))
		{
			$id = base64_decode($_GET["id"]);
			$orders->id		= (int)$id;
			$orders->source = $this->source;
			$return = $orders->add_orders();
			if((int)$return>0){
				msgbox(S_ROOT."orders/views?id=".base64_encode($return),"增加订单成功，订单号：".$return."！");
			}else{
				msgbox("",$return);
			}
		}else{
			$this->tpl->set("userid",$this->cookie->get("userid"));
			//环路
			$looptype = $orders->looptype();
			$this->tpl->set("looptype",$looptype);
			//处理订单ID
			$id = base64_decode($_GET["id"]);
			if($id){
				$info = $orders->getrow("id=$id");
			}
			$customsid = base64_decode($_GET["customsid"]);
			if($customsid){
				$info = $orders->getrow("customsid=$customsid");
			}
			//送货方式
			$delivertype = $orders->delivertype();
			$this->tpl->set("delivertype",$delivertype);
			//安装方式
			$setuptype = $orders->setuptype();
			$this->tpl->set("setuptype",$setuptype);
			//用户列表
			$users = $this->users->getrows("checked=1&usertype=1&order=worknum&desc=ASC");
			$this->tpl->set("users",$users);
			$this->tpl->set("info",$info);
			$this->tpl->display("orders.info.small.php");
		}
	}

	//编辑订单
	Public function edit()
	{

		$this->users->onlogin();	//登录判断
		$islevel = $this->users->getlevel();	//权限判断
		$orders = getModel("orders");
		//处理订单ID
		$id = (int)base64_decode($_GET["id"]);
		//订单信息
		$info = $orders->getrow("id=$id");
		if(!$info){ msgbox("","订单信息不存在！"); }
		$userid = $this->cookie->get("userid");

		if($info["status"]>="2"&&$info["status"]<"6"&&!$islevel)
		{
			msgbox("","抱歉，订单已进入处理状态。此时，无法修改订单信息！");
		}
		if($info["status"]=="1")
		{
			//msgbox("","抱歉，订单已完成，无法进行修改！");
		}
		if($info["status"]=="-1"||$info["status"]=="7")
		{
			msgbox("","抱歉，订单已取消。无法修改订单信息！");
		}

		if(isset($_POST)&&!empty($_POST))
		{

			$orders->id = $id;
			$return = $orders->edit();
			if((int)$return>0){
				//增加完成，返回订单页面
				msgbox(S_ROOT."orders/views?id=".base64_encode($id),"修改订单成功！");
			}else{
				msgbox("",$return);
			}

		}else{
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
			//支付方式
			$paytype = $orders->paytype();
			$this->tpl->set("paytype",$paytype);
			//送货方式
			$delivertype = $orders->delivertype();
			$this->tpl->set("delivertype",$delivertype);
			//安装方式
			$setuptype = $orders->setuptype();
			$this->tpl->set("setuptype",$setuptype);
			//订购信息
			$orders_product = $orders->ordersinfo("ordersid=$id&group=true");
			$this->tpl->set("orders_product",$orders_product);
			//用户列表
			$users = $this->users->getrows("checked=1&usertype=1&order=worknum&desc=ASC");
			$this->tpl->set("users",$users);
			//订单信息
			$this->tpl->set("info",$info);
			//订单锁定状态
			if((int)$info["checked"]!="1"){
				$closed = 0;
			}else{
				$closed = 1;
			}
			$this->tpl->set("closed",$closed);
			$this->tpl->display("orders.info.php");
		}
	}

	//高级更改
	Public function superinfo()
	{
		$this->users->onlogin();				//登录判断
		$islevel = $this->users->pagelevel();	//权限判断
		$orders = getModel("orders");
		$id = base64_decode($_GET["id"]);
		if(isset($_POST)&&!empty($_POST))
		{

			$orders->id	  = $id;
			$msg = $orders->superinfo();
			echo $msg;exit;

		}else{

			//订单信息
			$info = $orders->getrow("id=$id");
			//订单类型
			$ordertype = $orders->ordertype();
			$this->tpl->set("ordertype",$ordertype);
			//付款
			$paytype = $orders->paytype();
			$this->tpl->set("paytype",$paytype);
			//客户类型
			$customstype = $orders->customstype();
			$this->tpl->set("customstype",$customstype);
			//付款状态
			$paystatetype = $orders->paystatetype();
			$this->tpl->set("paystatetype",$paystatetype);
			//审核状态
			$checktype = $orders->checktype();
			$this->tpl->set("checktype",$checktype);
			//订单进度
			$statustype = $orders->statustype();
			$this->tpl->set("statustype",$statustype);

			$this->tpl->set("info",$info);
			$this->tpl->set("type","superinfo");
			$this->tpl->display("orders.dialog.php");
		}
	}

	//订单打印
	Public function prints()
	{
		$this->users->onlogin();	//登录判断
		$orders = getModel("orders");
		$do = $_GET["do"];
		if($do=="msglogs"){
			//$this->users->dialoglevel();
			//处理订单ID
			$id = base64_decode($_GET["id"]);
			$logs = $orders->print_logs("ordersid=$id&nums=3");
			$this->tpl->set("logs",$logs);
			$count = $orders->print_nums("ordersid=$id");
			$this->tpl->set("printnums",$count);
			$this->tpl->set("type","printlogs");
			$this->tpl->display("orders.dialog.php");
		}elseif($do=="logs"){
			//$this->users->dialoglevel();
			//处理订单ID
			$id = base64_decode($_GET["id"]);
			$orders->print_addlogs("id=$id");
		}elseif($do=="saveprint"){
			//$this->users->dialoglevel();
			$orders->print_saves();
			echo 1;
		}else{
			$this->users->pagelevel();	//权限判断
			$type = $_GET["type"];
			//处理订单ID
			$id = base64_decode($_GET["id"]);


			$jobsid = base64_decode($_GET["jobsid"]);
			if($jobsid){
				$jobs = getModel("jobs");
				$jobsinfo = $jobs->getrow("id=$jobsid");
			}


			//订单信息
			$info = $orders->getrow("id=$id");
			if(!$info){ msgbox("","订单信息不正确！"); }

			if($jobsinfo){
				$info["jobsid"]		=	$jobsinfo["id"];
				$info["jobsinfo"]	=	$jobsinfo["detail"];
			}

			$this->tpl->set("info",$info);

			$salesid = $info["salesid"];
			if($salesid!=SALES_NULL){
				if($info["checked"]!="1"){
					msgbox("","订单没有审核，不能打印订单！");
				}
			}
			//$S_ROOT."orders/views?id=".$_GET["id"]
			$this->tpl->set("back",plugin::retURL());

			//打印次数
			$pnums = $orders->print_nums("ordersid=$id");
			$this->tpl->set("pnums",$pnums);

			//订单类型
			$ordertype = $orders->ordertype();
			$this->tpl->set("ordertype",$ordertype);
			//审核状态
			$checktype = $orders->checktype();
			$this->tpl->set("checktype",$checktype);
			//付款状态
			$paystatetype = $orders->paystatetype();
			$this->tpl->set("paystatetype",$paystatetype);
			//订单进度
			$statustype = $orders->statustype();
			$this->tpl->set("statustype",$statustype);
			//支付方式
			$paytype = $orders->paytype();
			$this->tpl->set("paytype",$paytype);
			//送货方式
			$delivertype = $orders->delivertype();
			$this->tpl->set("delivertype",$delivertype);
			//安装方式
			$setuptype = $orders->setuptype();
			$this->tpl->set("setuptype",$setuptype);
			//订购信息
			$orders_product = $orders->ordersinfo("ordersid=$id&group=true");
			$this->tpl->set("orders_product",$orders_product);
			//已支付金额
			$paycharge = $orders->orders_charge("ordersid=$id");
			$this->tpl->set("paycharge",$paycharge);

			if($paycharge>$info["price"]){
				msgbox("","订单异常，入款金额大于订单应收金额，请检查和修正！~~~");
			}

			//操作员信息
			$userid = $this->cookie->get("userid");
			$userinfo = $this->users->getrow("userid=$userid");
			$this->tpl->set("userinfo",$userinfo);
			$show = $_GET["v"];

			if($show=="2"){
				$this->tpl->display("orders.print.v2.php");
			}else{
				$this->tpl->display("orders.print.v3.php");
			}


		}
	}

	//打印物流单
	Public function printexp()
	{
		$this->users->onlogin();	//登录判断
		$show = $_GET["show"];
		$ordersid	= $_GET["ordersid"];
		$orders		= getModel("orders");
		$express	= getModel("express");
		if($ordersid){
			$ordersid = (int)base64_decode($ordersid);
		}else{
			$jobs = getModel("jobs");
			$id = (int)base64_decode($_GET["jobsid"]);
			$row = $jobs->getrow("id=$id");
			$ordersid = (int)$row["ordersid"];
		}
		$ordersinfo = $orders->getrow("id=$ordersid");

		$usertype = $this->cookie->get("usertype");
		if($usertype!="1"){ msgbox("你没有权限进行操作!"); }

		$this->tpl->set("info",$ordersinfo);

		//B2B取得用户编号
		if($ordersinfo["source"]=="b2b"){
			if($ordersinfo["adduserid"]){
				$usercode = "B".$ordersinfo["adduserid"];
			}else{
				$customsid = $ordersinfo["customsid"];
				$customs = getModel("customs");
				$custinfo= $customs->getrow("customsid=$customsid");
				if($custinfo){
					$usercode = "B".$custinfo["userid"];
				}
			}
			$this->tpl->set("usercode",$usercode);
		}

		$expaddress = $express->expaddress();
		$this->tpl->set("expaddress",$expaddress);
		$this->tpl->set("back",$this->cookie->get("views"));

		//订购信息
		$orders_product = $orders->ordersinfo("ordersid=$ordersid&group=true");
		$this->tpl->set("orders_product",$orders_product);

		$cate = 0;
		$this->tpl->set("cate",$cate);

		if($show=="yto"){  			//圆通
			$this->tpl->display("express.print.yto.php");
		}elseif($show=="fedex"){	//联邦
			$this->tpl->display("express.print.fedex.php");
		}elseif($show=="ems"){		//ems
			$this->tpl->display("express.print.ems.php");
		}elseif($show=="post"){		//POST
			$this->tpl->display("express.print.post.php");
		}elseif($show=="qfkd"){		//全峰
			$this->tpl->display("express.print.qfkd.php");
		}elseif($show=="htky"){		//汇通
			$this->tpl->display("express.print.htky.php");
		}elseif($show=="ttkd"){		//天天
			$this->tpl->display("express.print.ttkd.php");
		}elseif($show=="zto"){		//中通
			$this->tpl->display("express.print.zto.php");
		}elseif($show=="sto"){		//中通
			$this->tpl->display("express.print.sto.php");
		}elseif($show=="sf"){		//中通
			$this->tpl->display("express.print.sf.php");
		}elseif($show=="yunda") {    //韵达
			$this->tpl->display("express.print.yunda.php");
		}elseif($show=="whehtky"){

			$mailno = $_GET["mailno"];
			if($mailno==""){
				$mdinfo = $express->huitong($ordersinfo);
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

		}elseif($show=="wheqf"){	//武汉全峰电子面单

			$mailno = $_GET["mailno"];
			if($mailno==""){
				$mailno = $express->quanfeng();
			}else{
				$mailno = $mailno;
			}
			if(!is_numeric($mailno)){
				msgbox("","没在找到单据号码 ");
			}

			$this->tpl->set("mailno",$mailno);
			$this->tpl->display("express.print.wheqf.php");

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

        }elseif($show=="esf"){		//E顺丰

            exit;
            $sf = $express->shunfeng($ordersinfo);
            $this->tpl->set("destcode",$sf["destcode"]);
            $this->tpl->set("origincode",$sf["origincode"]);
            $mailno = $_GET["mailno"];
            if($mailno==""){
                $mailno = $sf["mailno"];
            }else{
                $mailno = $mailno;
            }
            $this->tpl->set("mailno",$mailno);
            $this->tpl->set("sfordersid",$sf["sfordersid"]);
            $this->tpl->display("express.print.esf.php");

        }elseif($show=="whesf"){		//E顺丰

            //$this->tpl->set("destcode","0730");
            //$this->tpl->set("origincode","0156");
            //$mailno = "808888800011";
			$mailno = $_GET["mailno"];
            if($mailno==""){
				$sf = $express->shunfeng($ordersinfo);
				$this->tpl->set("destcode",$sf["destcode"]);
				$this->tpl->set("origincode",$sf["origincode"]);
				$mailno = $_GET["mailno"];
                $mailno = $sf["mailno"];
            }else{
                $mailno = $mailno;
            }
            $this->tpl->set("mailno",$mailno);
            $this->tpl->set("sfordersid",$sf["sfordersid"]);
            $this->tpl->display("express.print.whesf.php");

		}else{

		}
	}

	//支付记录
	Public function charge()
	{
		$this->users->dialoglogin();		//登录判断
		$islevel = $this->users->getlevel();	//权限判断
		$do = $_GET["do"];

		$orders = getModel("orders");
		//付款类型
		$chargetype = $orders->chargetype();
		$this->tpl->set("chargetype",$chargetype);

		$charge = getModel("charge");
		$cates = $charge->cates();
		$this->tpl->set("cates",$cates);

		if($do=="add"){

			if(isset($_POST)&&!empty($_POST)){
				$ordersid = (int)base64_decode($_POST["ordersid"]);
			}else{
				$ordersid = (int)base64_decode($_GET["id"]);
			}
			$info = $orders->getrow("id=$ordersid");
			//if($info["checked"]=="1"&&!$islevel){ dialog("订单已通过审核，您没有权限操作款项记录！"); }

			if(isset($_POST)&&!empty($_POST))
			{
				$ordersid = (int)base64_decode($_POST["ordersid"]);
				$orders->ordersid = $ordersid;
				$msg = $orders->charge_add();
				if($msg=="1"){
					echo "1";
				}else{
					echo $msg;
				}
			}else{

				$payptype = $charge->paytype("id=0");
				$this->tpl->set("payptype",$payptype);

				$this->tpl->set("type","chargeinfo");
				$this->tpl->display("orders.dialog.php");
			}
		}elseif($do=="edit"){

			if(isset($_POST)&&!empty($_POST))
			{
				$ordersid = (int)base64_decode($_POST["ordersid"]);
				$orders->ordersid = $ordersid;
				$id = (int)base64_decode($_POST["id"]);
				$orders->id = $id;
				$msg = $orders->charge_edit();
				if($msg=="1"){
					echo "1";
				}else{
					echo $msg;
				}

			}else{

				$id = (int)base64_decode($_GET["id"]);
				$info = $orders->charge_getrow("id=$id");
				$timeline = time()-86400;	//计算前一天
				$userid = (int)$this->cookie->get("userid");
				$isadmin = $this->users->isadmin();	//判断是否管理员
				$islevel = $this->users->getlevel();	//判断页面权限
				if($info["jobsid"]){ dialog("此为工单入款，需要从对应工单进行修改！"); }

				$ordersid = $info["ordersid"];
				$orderinfo = $orders->getrow("id=$ordersid");
				if($info["dateline"]<$orderinfo["checkdate"]){ dialog("订单审核前的支付记录无法修改"); }

				if($info["userid"]!=$userid&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限进行操作！"); }
				//if($info["dateline"]<$timeline&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限进行操作！"); }
				if($info["checked"]==1&&$isadmin!=1){ dialog("此记录已确认，无法进行操作！"); }
				$this->tpl->set("info",$info);

				$payptype = $charge->paytype("id=0");
				$this->tpl->set("payptype",$payptype);

				$paytypeid = (int)$info["paytype"];
				$paytype = $charge->paytype("id=$paytypeid");
				$this->tpl->set("paytype",$paytype);

				$this->tpl->set("type","chargeinfo");
				$this->tpl->display("orders.dialog.php");

			}
		}elseif($do=="del"){

			$id = (int)base64_decode($_GET["id"]);
			$info = $orders->charge_getrow("id=$id");
			$timeline = time()-86400;	//计算前一天
			$userid = (int)$this->cookie->get("userid");
			$isadmin = $this->users->isadmin();		//判断是否管理员
			$islevel = $this->users->getlevel();	//判断页面权限

			$ordersid = $info["ordersid"];
			$orderinfo = $orders->getrow("id=$ordersid");
			if($info["dateline"]<$orderinfo["checkdate"]){ dialog("订单审核前的支付记录无法删除"); }

			if($info["userid"]!=$userid&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限进行操作！"); }
			if($info["dateline"]<$timeline&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限进行操作！"); }
			if($info["checked"]==1&&$isadmin!=1){ dialog("此记录已审核，无法进行操作！"); }
			$orders->id = $id;
			$orders->ordersid = $info["ordersid"];
			$orders->charge_del();
			echo 1;

		}else{
			//处理订单ID
			$id = (int)base64_decode($_GET["id"]);
			$page = ($_GET["page"])?"1":"0";
			$list = $orders->charge("ordersid=$id&nums=5&page=1&show=2");
			$this->tpl->set("list",$list["record"]);
			$this->tpl->set("page",$list["pages"]);
			$this->tpl->set("type","charge");
			$this->tpl->set("editno",(int)$_GET["editno"]);
			$this->tpl->display("orders.dialog.php");
		}
	}

	//审核状态调整
	Public function checked()
	{
		$this->users->dialoglogin();		//登录判断
		$this->users->dialoglevel();		//权限判断
		$orders = getModel("orders");

		if(isset($_POST)&&!empty($_POST))
		{

			$id = (int)base64_decode($_POST["id"]);
			$checked = (int)$_POST["checked"];
			$orders->checked("id=$id&checked=$checked");
			echo 1;

		}else{

			//处理订单ID
			$id = (int)base64_decode($_GET["id"]);
			//订单信息
			$info = $orders->getrow("id=$id");
			//已支付金额
			// $paycharge = $orders->orders_charge("ordersid=$id");
			// if($paycharge>$info["price"]){
			// 	dialog("订单异常，当前入款金额大于订单金额，无法进行审核！");
			// }

			$this->tpl->set("info",$info);
			//判断管理员，管理员可操作～～～
			$isadmin = $this->users->isadmin();

			// if($info["checked"]==1&&$info["status"]!=0&&$isadmin!=1){
			// 	dialog("订单已经进入处理流程，不能回退操作！");
			// }
			// $dateline = time()-86400*5;
			// if($info["checked"]=="1"&&$info["checkdate"]<$dateline){
			// 	dialog("订单已审核，目前已超过修正时限，您没有权限进行修正！");
			// }
			if($info["status"]=="1"&&$isadmin!=1){
				// dialog("订单已完成，您没有权限进行修正！");
			}
			$userid = $this->cookie->get("userid");
			if($userid == $info["adduserid"]){
				//dialog("错误，你不能审核自己录入的订单！");
			}
			//付款状态
			$checktype = $orders->checktype();
			$this->tpl->set("checktype",$checktype);
			$this->tpl->set("type","checked");
			$this->tpl->display("orders.dialog.php");
		}
	}

	//订单客户类型调整
	Public function upctype()
	{
		$this->users->dialoglogin();		//登录判断
		$this->users->dialoglevel();		//权限判断
		$orders = getModel("orders");

		$id = (int)base64_decode($_GET["id"]);
		if(isset($_POST)&&!empty($_POST))
		{
			$orders->id = $id;
			$orders->upctype();
			echo 1;
		}else{
			//客户类型
			$customstype = $orders->customstype();
			$this->tpl->set("customstype",$customstype);
			$info = $orders->getrow("id=$id");
			$this->tpl->set("info",$info);
			$this->tpl->set("type","upctype");
			$this->tpl->display("orders.dialog.php");
		}
	}

	//订单进度调整
	Public function status()
	{
		exit;
		$this->users->dialoglogin();		//登录判断
		$this->users->dialoglevel();		//权限判断
		$orders = getModel("orders");

		if(isset($_POST)&&!empty($_POST))
		{
			$id = (int)base64_decode($_POST["id"]);
			$status = (int)$_POST["status"];
			$orders->status("id=$id&status=$status");
			echo 1;
		}else{
			//处理订单ID
			$id = (int)base64_decode($_GET["id"]);
			//订单信息
			$info = $orders->getrow("id=$id");
			$this->tpl->set("info",$info);
			//判断管理员，管理员可操作～～～
			//$isadmin = $this->users->isadmin();
			if($info["checked"]!="1"){ dialog("订单没有审核，无法进行操作！"); }
			//付款状态
			$statustype = $orders->statustype();
			$this->tpl->set("statustype",$statustype);
			$this->tpl->set("type","status");
			$this->tpl->display("orders.dialog.php");
		}
	}

	Public function products()
	{
		$this->users->dialoglogin();		//登录判断
		$orders = getModel("orders");
		$id = (int)base64_decode($_GET["id"]);
		$group = ($_GET["group"]=="0")?"false":"true";
		//订购信息
		$orders_product = $orders->ordersinfo("ordersid=$id&group=$group");
		$this->tpl->set("orders_product",$orders_product);
		$this->tpl->set("type","plist");
		$this->tpl->display("orders.dialog.php");
	}

	//订单取消
	Public function killed()
	{
		$this->users->dialoglogin();		//登录判断
		$this->users->dialoglevel();		//权限判断
		$orders = getModel("orders");
		if(isset($_POST)&&!empty($_POST))
		{
			$id = (int)base64_decode($_POST["id"]);
			$detail = $_POST["detail"];
			$orders->killed("id=$id&detail=$detail");
			echo 1;
		}else{
			//处理订单ID
			$id = (int)base64_decode($_GET["id"]);
			//订单信息
			$info = $orders->getrow("id=$id");
			$dateline = time()-86400*30;
			if($info["status"]=="1"&&$info["dateline"]<$dateline){
				dialog("订单已完成，且已超过作废时限，您没有权限进行操作！");
			}
			$this->tpl->set("info",$info);
			$this->tpl->set("type","killed");
			$this->tpl->display("orders.dialog.php");
		}
	}

	//订单完成
	Public function completed()
	{
		$this->users->dialoglogin();		//登录判断
		$this->users->dialoglevel();		//权限判断
		$orders = getModel("orders");
		$id = (int)base64_decode($_GET["id"]);
		$info = $orders->getrow("id=$id");
		$dateline = time()-86400*15;
		if($info["checked"]!="1"){ dialog("订单没有审核，不能点击完成！"); }
		if($info["status"]=="-1"&&$info["dateline"]<$dateline){
			dialog("订单已作废，且已超过取消时限，您没有权限进行操作！");
		}
		$orders->completed("id=$id");
		echo 1;
	}

	//付款状态调整
	Public function paystate()
	{
		$this->users->dialoglogin();		//登录判断
		$this->users->dialoglevel();		//权限判断
		$orders = getModel("orders");

		if(isset($_POST)&&!empty($_POST))
		{
			$id = (int)base64_decode($_POST["id"]);
			$paystate = (int)$_POST["paystate"];
			$orders->paystate("id=$id&paystate=$paystate");
			echo 1;
		}else{
			//处理订单ID
			$id = base64_decode($_GET["id"]);
			//订单信息
			$info = $orders->getrow("id=$id");
			$this->tpl->set("info",$info);
			//付款状态
			$paystatetype = $orders->paystatetype();
			$this->tpl->set("paystatetype",$paystatetype);
			$this->tpl->set("type","paystate");
			$this->tpl->display("orders.dialog.php");
		}
	}



	//发票记录
	Public function invoice()
	{
		$this->users->dialoglogin();		//登录判断
		$invoice = getModel("invoice");
		//处理订单ID
		$id = (int)base64_decode($_GET["id"]);
		$catetype = $invoice->catetype();
		$this->tpl->set("catetype",$catetype);
		$worktype = $invoice->worktype();
		$this->tpl->set("worktype",$worktype);
		$checktype = $invoice->checktype();
		$this->tpl->set("checktype",$checktype);
		$list = $invoice->getrows("ordersid=$id&nums=5&page=1&show=2");
		$this->tpl->set("list",$list["record"]);
		$this->tpl->set("page",$list["pages"]);
		$this->tpl->set("editno",(int)$_GET["editno"]);
		$this->tpl->set("type","invoice");
		$this->tpl->display("invoice.dialog.php");
	}

	//工单记录
	Public function jobs()
	{
		$this->users->dialoglogin();		//登录判断
		$jobs = getModel("jobs");
		//处理订单ID
		$id = (int)base64_decode($_GET["id"]);
		$jobstype = $jobs->jobstype();
		$this->tpl->set("jobstype",$jobstype);
		$worktype = $jobs->worktype();
		$this->tpl->set("worktype",$worktype);
		$list = $jobs->getrows("ordersid=$id&joblist=1&nums=5&page=1&show=2");
		$this->tpl->set("list",$list["record"]);
		$this->tpl->set("page",$list["pages"]);
		$this->tpl->set("type","jobs");
		$this->tpl->display("jobs.dialog.php");
	}

	//物流记录
	Public function express()
	{
		$this->users->dialoglogin();		//登录判断
		$express = getModel("express");
		//处理订单ID
		$id = (int)base64_decode($_GET["id"]);
		$cates = $express->cates();
		$this->tpl->set("cates",$cates);
		$expresstype = $express->expresstype();
		$this->tpl->set("expresstype",$expresstype);
		$expstate = $express->expstate();
		$this->tpl->set("expstate",$expstate);
		$list = $express->getrows("ordersid=$id&nums=5&page=1&show=2");
		$this->tpl->set("list",$list["record"]);
		$this->tpl->set("page",$list["pages"]);
		$this->tpl->set("type","lists");
		$this->tpl->display("express.dialog.php");
	}

	//操作记录
	Public function logs()
	{
		$this->users->dialoglogin();		//登录判断
		$do = $_GET["do"];
		$orders = getModel("orders");
		//付款类型
		$logstype = $orders->logstype();
		$this->tpl->set("logstype",$logstype);
		//处理ID
		$id = (int)base64_decode($_GET["id"]);
		if($do=="add"){
			$this->users->dialoglevel();	//权限判断
			if(isset($_POST)&&!empty($_POST))
			{
				$ordersid = (int)base64_decode($_POST["ordersid"]);
				$orders->ordersid = $ordersid;
				$orders->logs_add();
				echo "1";
			}else{
				$this->tpl->set("type","logsinfo");
				$this->tpl->display("orders.dialog.php");
			}
		}elseif($do=="edit"){
			if(isset($_POST)&&!empty($_POST))
			{
				$ordersid = (int)base64_decode($_POST["ordersid"]);
				$orders->ordersid = $ordersid;
				$id = (int)base64_decode($_POST["id"]);
				$orders->id = $id;
				$orders->logs_edit();
				echo "1";
			}else{
				$id = (int)base64_decode($_GET["id"]);
				$info = $orders->logs_getrow("id=$id");
				if($info["locked"]=="1"){ dialog("你无法修改系统处理类别的操作记录！"); }
				$timeline = time()-86400*3;	//计算前一天
				$userid = (int)$this->cookie->get("userid");
				$isadmin = $this->users->isadmin();	//判断是否管理员
				$islevel = $this->users->getlevel();	//判断页面权限
				if($info["userid"]!=$userid&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限进行操作他人记录！"); }
				if($info["dateline"]<$timeline&&$isadmin!=1&&!$islevel){ dialog("抱歉，修改超过有效时限无法操作！"); }
				$this->tpl->set("info",$info);
				$this->tpl->set("type","logsinfo");
				$this->tpl->display("orders.dialog.php");
			}
		}elseif($do=="del"){
			$id = (int)base64_decode($_GET["id"]);
			$info = $orders->logs_getrow("id=$id");
			$timeline = time()-3600;	//计算前一天
			$userid = (int)$this->cookie->get("userid");
			$isadmin = $this->users->isadmin();	//判断是否管理员
			$islevel = $this->users->getlevel();	//判断页面权限
			if($info["userid"]!=$userid&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限进行操作！"); }
			if($info["dateline"]<$timeline&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限删除他人记录！"); }
			if($info["locked"]==1&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限删除系统记录！"); }
			$orders->id = $id;
			$orders->ordersid = $info["ordersid"];
			$orders->logs_del();
			echo 1;
		}else{
			$userid = (int)$this->cookie->get("userid");
			$userinfo = $this->users->getrow("userid=$userid");
			// if($userinfo["usertype"]!="1"){ $adduserid = $userid; }
			// $list = $orders->logs("ordersid=$id&nums=10&page=1&show=2&userid=$adduserid");
			$list = $orders->logs("ordersid=$id&nums=10&page=1&show=2");
			$this->tpl->set("list",$list["record"]);
			$this->tpl->set("page",$list["pages"]);
			$this->tpl->set("type","logs");
			$this->tpl->display("orders.dialog.php");
		}
	}

	//查看地图
	Public function viewmaps()
	{
		$this->users->dialoglogin();	//登录判断
		$this->tpl->set("type","viewmaps");
		$this->tpl->display("orders.dialog.php");
	}

	//子订单记录
	Public function parents()
	{
		$this->users->onlogin();	//登录判断
		$orders = getModel("orders");
		$id = (int)base64_decode($_GET["id"]);
		//订单进度
		$statustype = $orders->statustype();
		$this->tpl->set("statustype",$statustype);
		$rows = $orders->orders_parent("page=1&info=1&ordersid=$id&show=2&nums=5");
		$this->tpl->set("list",$rows["record"]);
		$this->tpl->set("page",$rows["pages"]);
		$this->tpl->set("type","parents");
		$this->tpl->display("orders.dialog.php");

	}

	//图像查询
	Public function pic()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断

		extract($_GET);
		$show = $_GET["show"];

		if($godate&&$todate){
			$godate = $godate;
			$todate = $todate;
		}else{
			$godate = date("Y-m-d",time()-86400*30);
			$todate = date("Y-m-d");
		}

		$orders = getModel("orders");

		$filetype = $orders->fileltype();
		$this->tpl->set("filetype",$filetype);

		if($show=="lists"){

			$rows = $orders->files("page=1&nums=24&type=$type&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&ordersid=$ordersid");
			//print_r($rows);
			$this->tpl->set("list",$rows["record"]);
			$this->tpl->set("page",$rows["pages"]);

		}else{

			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);

		}
		$this->tpl->set("show",$show);
		$this->tpl->display("orders.pic.php");

	}

	//取得订单中的用户列表
	Public function users()
	{
		$this->users->onlogin();	//登录判断
		extract($_GET);

		if($type=="1"){
			$typename = "销售";
		}elseif($type=="2"){
			$typename = "售后";
		}elseif($type=="3"){
			$typename = "服务";
		}

		$str = "";
		$orders = getModel("orders");
		//订购信息
		$users = $orders->users("type=$type&godate=$godate&todate=$todate&idno=$userid&salesarea=$salesarea&salesid=$salesid&afterarea=$afterarea&afterid=$afterid");

		if($userid){
			$userinfo = $this->users->getrow("userid=$userid");
			$str.= "<option value=\"".$userinfo["userid"]."\">".$userinfo["worknum"]."_".$userinfo["name"]."</option>";
		}else{
			$str.= "<option value=\"\">选择".$typename."人员</option>";
		}

		if($users){
			foreach($users AS $rs){
				if($rs["userid"]){ $name = $rs["name"]; }else{ $name = "系统录入"; }
				$str.="<option value=\"".$rs["userid"]."\">".$rs["worknum"]."_".$name."</option>";
			}
		}
		echo $str;
		exit;
	}

	//附件列表
	Public function files()
	{
		$this->users->dialoglogin();		//登录判断
		$orders = getModel("orders");
		//处理订单ID
		$id = (int)base64_decode($_GET["id"]);
		$list = $orders->files("ordersid=$id&nums=5&page=1&show=2");
		$this->tpl->set("list",$list["record"]);
		$this->tpl->set("page",$list["pages"]);
		$filetype = $orders->fileltype();
		$this->tpl->set("filetype", $filetype);
		$this->tpl->set("type","files");
		$this->tpl->display("orders.dialog.php");
	}

	//订单附件上传
	Public function upload()
	{
		$this->users->dialoglogin();		//登录判断
		$do = $_GET["do"];
		$orders = getModel("orders");
		$userid = $this->cookie->get("userid");
		if($do=="detail"){
			//处理订单ID
			$id = (int)base64_decode($_GET["id"]);
			$islevel = $this->users->getlevel();		//登录判断
			$info = $orders->filesinfo("id=$id");
			if($info["userid"]!=$userid&&!$islevel){ dialog("抱歉，你没有权限更新批注！"); }
			$dateline = time()-86400*3;
			if($info["dateline"]<$dateline){ dialog("超过有效时间，无法进行更正！"); }
			if(isset($_POST)&&!empty($_POST))
			{
				$orders->id = $id;
				$orders->editfiles();
				echo 1;exit;
			}else{

				$filetype = $orders->fileltype();
				$this->tpl->set("filetype", $filetype);

				$jobs = getModel("jobs");
				$taskjobs = $jobs->taskjobs("type=3&ordersid=$ordersid");
				$this->tpl->set("taskjobs", $taskjobs);

				$this->tpl->set("info",$info);
				$this->tpl->set("type","filesinfo");
				$this->tpl->display("orders.dialog.php");
			}
		}elseif($do=="views"){
			//处理订单ID
			$id = (int)base64_decode($_GET["id"]);
			$info = $orders->filesinfo("id=$id");
			$this->tpl->set("info",$info);
			$this->tpl->set("type","filesviews");
			$this->tpl->display("orders.dialog.php");
		}elseif($do=="del"){
			//处理订单ID
			$id = (int)base64_decode($_GET["id"]);
			$islevel = $this->users->getlevel();		//登录判断
			$info = $orders->filesinfo("id=$id");
			if($info["userid"]!=$userid&&!$islevel){ dialog("抱歉，你没有权限删除附件！"); }
			$dateline = time()-43200;
			if($info["dateline"]<$dateline){ dialog("超过有效时间，无法进行删除！"); }
			$orders->id = $id;
			$orders->delfiles();
			echo 1;exit;
		}else{
			//处理订单ID
			$ordersid = (int)base64_decode($_GET["ordersid"]);
			//订单信息
			$info = $orders->getrow("id=$ordersid");
			$this->users->dialoglevel();		//登录判断
			if(isset($_POST)&&!empty($_POST)) {

				$orders->id = $ordersid;
				$return = $orders->orders_upload();
				if((int)$return=="1"){
					jsmsg("parent.fileslist(1);parent.closedialog();","上传图片成功！","2000");
				}else{
					dialog($return);
				}

			}else{
				$this->tpl->set("show", $_GET["show"]);
				$this->tpl->set("orderinfo", $info);

				$filetype = $orders->fileltype();
				$this->tpl->set("filetype", $filetype);

				$this->tpl->set("userid", (int)$this->cookie->get("userid"));
				$this->tpl->display("orders.upload.php");
			}
		}
	}

	//+--------------------------------------------------------------------------------------------
	//Desc:批量上传
	Public function upfiles()
	{
		$orders = getModel('orders');
		$msg = $orders->orders_upload("picturefile");
		if($msg){
			header("HTTP/1.1 500 File Upload Error");
			exit;
		}
	}

}
?>
