<?php
class serviceAction extends Action
{

	Public function app()
	{
		$this->tpl->display("page.main.php");
	}

	//回访提醒
	Public function clockd()
	{
		$do = $_GET["do"];
		//提醒记录

		//用户类型
		$usertype = $this->cookie->get("usertype");
		$this->tpl->set("usertype",$usertype);

		if($do=="info"){

			$this->users->onlogin();	//登录判断
			$clockd = getModel("clockd");
			$id	= ($_GET["id"])?(int)base64_decode($_GET["id"]):"0";
			$ordersid	= ($_GET["ordersid"])?(int)base64_decode($_GET["ordersid"]):"0";
			$info = $clockd->getrow("id=$id");
			if($info){
					$ordersid = $info["ordersid"];
			}
			$checkadd = $clockd->checkadd("ordersid=$ordersid");
			if($checkadd){ dialog("存在未提醒的记录，勿重复增加！"); }
			if(isset($_POST)&&!empty($_POST))
			{
				$clockd->id = $id;
				$clockd->ordersid = $ordersid;
				$clockd->clockdinfo();
				echo 1;exit;
			}else{
				if($info){
					$this->tpl->set("info",$info);
					$userid = (int)$this->cookie->get("userid");
					$isadmin = $this->users->isadmin();		//判断是否管理员
					$islevel = $this->users->getlevel();	//判断页面权限
					$timeline = time()-21600;	//计算前一天
					if($info["adduserid"]!=$userid&&!$islevel&&$isadmin!=1){
						dialog("抱歉，你没有权限进行操作！");
					}
					if($info["worked"]!=0){
						dialog("提醒已处理，无法进行变更！");
					}
					if($timeline>$info["workdate"]&&!$islevel&&$isadmin!=1){
						dialog("超过修改时间，无法进行变更！");
					}
				}else{
					$this->users->dialoglevel();	//权限判断
				}
				$orders = getModel("orders");
				$ordersinfo = $orders->getrow("id=$ordersid");
				if($ordersinfo["parentid"]!="0"){ dialog("订单不是主订单,无法添加"); }
				if($ordersinfo["status"]!="1"){ dialog("订单不是完成状态,无法添加"); }
				$this->tpl->set("ordersinfo",$ordersinfo);
				$this->tpl->set("type","info");
				$this->tpl->display("service.clockd.dialog.php");
			}

		//回访记录
		}elseif($do=="call"){

			$this->users->onlogin();	//登录判断
			$clockd = getModel("clockd");
			$id	= ($_GET["id"])?(int)base64_decode($_GET["id"]):"0";
			$ordersid	= ($_GET["ordersid"])?(int)base64_decode($_GET["ordersid"]):"0";
			if(isset($_POST)&&!empty($_POST))
			{
				$clockd->id = $id;
				$clockd->ordersid = $ordersid;
				$clockd->call();
				echo 1; exit;
			}else{
				$info = $clockd->getrow("id=$id");
				$this->tpl->set("info",$info);
				$userid = (int)$this->cookie->get("userid");
				$isadmin = $this->users->isadmin();		//判断是否管理员
				$islevel = $this->users->getlevel();	//判断页面权限
				$timeline = time()-21600;				//计算前一天
				if($info["worked"]){
					$datetime = $info["datetime"];
					if($info["workuserid"]!=$userid&&!$islevel&&$isadmin!=1){
						dialog("抱歉，你没有权限对别人的回执进行修改！");
					}
					if($timeline>$info["workdate"]&&!$islevel&&$isadmin!=1){
						dialog("超过修改时间，无法进行变更！");
					}
				}else{
					if(!$islevel&&$isadmin!=1){
						dialog("对不起，你没有权限进行操作！");
					}
					$datetime = date("Y-m-d",time()+$info["cycle"]*86400);
				}
				$this->tpl->set("datetime",$datetime);
				$orders = getModel("orders");
				$ordersid = $info["ordersid"];
				$ordersinfo = $orders->getrow("id=$ordersid");
				$this->tpl->set("ordersinfo",$ordersinfo);
				$this->tpl->set("type","callinfo");
				$this->tpl->display("service.clockd.dialog.php");
			}

		//关闭订单提醒
		}elseif($do=="close"){

			$this->users->dialoglogin();	//登录判断
			$this->users->dialoglevel();
			$orders = getModel("orders");
			$id	= ($_GET["id"])?(int)base64_decode($_GET["id"]):"0";
			$orderinfo = $orders->getrow("id=$id");
			if(!$orderinfo){ dialog("订单记录不存在"); };
			if($orderinfo["clocked"]=="4"){ dialog("订单提醒已关闭，无需重复操作"); }
			if(isset($_POST)&&!empty($_POST))
			{
					$clockd = getModel("clockd");
					$clockd->id = $id;
					$clockd->clocked_close();
					echo 1; exit;
			}else{
					$this->tpl->set("orderinfo",$orderinfo);
					$this->tpl->set("type","clockedclose");
					if(wapfun::checked())
					{
					   	$this->tpl->set("backurl",$this->cookie->get("views"));
	            $this->tpl->display("wap/service.clockd.dialog.php");
					}else{
							$this->tpl->display("service.clockd.dialog.php");
					}
			}

		//删除记录
		}elseif($do=="del"){

			$this->users->onlogin();	//登录判断
			$id	= ($_GET["id"])?(int)base64_decode($_GET["id"]):"0";
			$clockd = getModel("clockd");
			$info = $clockd->getrow("id=$id");
			$userid = (int)$this->cookie->get("userid");
			$isadmin = $this->users->isadmin();		//判断是否管理员
			$islevel = $this->users->getlevel();	//判断页面权限
			if($info["adduserid"]!=$userid&&!$islevel&&$isadmin!=1){
				dialog("抱歉，你没有权限进行操作！");
			}
			if($info["worked"]!=0){
				dialog("提醒已处理，无法进行删除！");
			}
			$clockd->id = $id;
			$clockd->del();
			echo 1;exit;

		//回访记录
		}elseif($do=="logs"){

			$this->users->onlogin();	//登录判断
			$worked = (int)$_GET["worked"];
			$ordersid = ($_GET["ordersid"])?(int)base64_decode($_GET["ordersid"]):"0";

			if($ordersid){
					$clockd = getModel("clockd");
					if($worked){ $worked = $worked; $checked = ""; }else{ $worked = 0; $checked = ""; }
					$list = $clockd->getrows("loglist=1&ordersid=$ordersid&worked=$worked&desc=DESC&&nums=5&page=1&show=2");
					$this->tpl->set("list",$list["record"]);
					$this->tpl->set("page",$list["pages"]);
			}
			if($worked=="1"){ $type = "logslist"; }else{ $type = "clocklist"; }
			$this->tpl->set("type",$type);
			$this->tpl->set("worked",$worked);
			$this->tpl->display("service.clockd.dialog.php");

		//查看回访
		}elseif($do=="views"){

			$this->users->onlogin();	//登录判断
			$clockd = getModel("clockd");
			$orders = getModel("orders");
			$id = ($_GET["id"])?(int)base64_decode($_GET["id"]):"0";
			//$ordersid = ($_GET["ordersid"])?(int)base64_decode($_GET["ordersid"]):"0";
			$isadmin = $this->users->isadmin();		//判断是否管理员
			$islevel = $this->users->getlevel();	//判断页面权限
			if($id){
					$info = $clockd->getrow("id=$id");
					$ordersid = (int)$info["ordersid"];
			}else{
					$ordersid = ($_GET["ordersid"])?(int)base64_decode($_GET["ordersid"]):"0";
			}
			$ordersinfo = $orders->getrow("id=$ordersid");
			$userid = $this->cookie->get("userid");
			$teamlevel = $this->users->teamed("teamid=".$ordersinfo["afterid"]."");	//判断区域权限
			if(!$islevel&&$isadmin!=1){
				if($ordersinfo["afteruserid"]!=$userid&&!$teamlevel){
					msgbox("","抱歉，你没有权限进行操作！");
				}
			}
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

			$this->tpl->set("orderinfo",$ordersinfo);
			$this->tpl->set("info",$info);
			//订购信息
			$orders_product = $orders->ordersinfo("ordersid=$ordersid&group=true");
			$this->tpl->set("orders_product",$orders_product);
			$this->tpl->display("service.clockd.views.php");

		//地图模式
		}elseif($do=="maps"){

			$this->users->onlogin();	//登录判断
			$this->users->pagelevel();	//权限判断

			extract($_GET);
			$clockd = getModel("clockd");
			$alled = (int)$alled;
			$this->tpl->set("ordersid",$info);
			$this->tpl->set("provid",$provid);
			$this->tpl->set("cityid",$cityid);
			$this->tpl->set("areaid",$areaid);
			$this->tpl->set("salesarea",$salesarea);
			$this->tpl->set("salesid",$salesid);

			$clockd = getModel("clockd");
			$godate = date("Y-m-d");
			$todate = date("Y-m-d",strtotime($godate)+86400*30);
			$rows = $clockd->getrows("maped=1&nums=1&alled=1&worked=0&checked=1&ordersid=$ordersid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&provid=$provid&cityid=$cityid&areaid=$areaid");
			$this->tpl->set("info",$rows[0]);
			$this->tpl->display("service.clockd.maps.list.php");

		}elseif($do=="mapsrows"){

			extract($_GET);
			$this->users->onlogin();	//登录判断
			$clockd = getModel("clockd");
			$godate = date("Y-m-d");
			$todate = date("Y-m-d",strtotime($godate)+86400*30);
			$rows = $clockd->getrows("nums=20&alled=1&worked=0&checked=1&ordersid=$ordersid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&provid=$provid&cityid=$cityid&areaid=$areaid&pointarr=$pointarr");

			$arrs = "";
			if($rows){
				$arra = array();
				foreach($rows AS $rs){
					$rw = array();
					$rw["title"]   = $rs["datetime"]." 订单ID：".(int)$rs["ordersid"];
					$rw["content"] = plugin::cutstr($rs["clockinfo"],"30")."<a href=\"javascript:void(0)\" class=\"ured\" onclick=\"parent.parent.addTab('回访".$rs["ordersid"]."','service/clockd?do=views&id=".base64_encode((int)$rs["id"])."&ordersid=".base64_encode((int)$rs["ordersid"])."','clockd')\">[处理提醒]</a>";
					//$rw["content"] = plugin::cutstr($rs["clockinfo"],"30")."<a href='javascript:void(0)' class='ured' onclick='parent.parent.addTab()'>[立即提醒3]</a>";
					$rw["point"]   = $rs["pointlng"]."|".$rs["pointlat"];
					$rw["isOpen"]  = "2";
					$rw["icon"]    = array("t"=>"2","w"=>"15","h"=>"23");
					$arra[] = $rw;
				}
				$arrs = $arra;
			}

			$godate = date("Y-m-d",strtotime($godate)-86400*90);
			$todate = date("Y-m-d");
			$rows = $clockd->getrows("nums=50&alled=1&worked=0&checked=1&ordersid=$ordersid&godate=$godate&todate=$todate&datetime=$datetime&salesarea=$salesarea&salesid=$salesid&provid=$provid&cityid=$cityid&areaid=$areaid&pointarr=$pointarr");
			//print_r($rows);exit;
			if($rows){
				$arrb = array();
				foreach($rows AS $rs){
					$rw = array();
					$rw["title"]   = $rs["datetime"]." 订单ID：".(int)$rs["ordersid"];
					$rw["content"] = plugin::cutstr($rs["clockinfo"],"30")."<a href=\"javascript:void(0)\" class=\"ured\" onclick=\"parent.parent.addTab('回访".$rs["ordersid"]."','service/clockd?do=views&id=".base64_encode((int)$rs["id"])."&ordersid=".base64_encode((int)$rs["ordersid"])."','clockd')\">[处理提醒]</a>";
					//$rw["content"] = plugin::cutstr($rs["clockinfo"],"30")."<a href='javascript:void(0)' class='ured' onclick='parent.parent.addTab('回访提醒222','service/clockd?do=views&id=".base64_encode((int)$rs["id"])."&ordersid=".base64_encode((int)$rs["ordersid"])."','22')'>[立即提醒3]</a>";
					$rw["point"]   = $rs["pointlng"]."|".$rs["pointlat"];
					$rw["isOpen"]  = "0";
					$rw["icon"]    = array("t"=>"0","w"=>"15","h"=>"23");
					$arrb[] = $rw;
				}
				if($arrb){
					if($arrs){
						$arrs = array_merge($arrs,$arrb);
					}else{
						$arrs = $arrb;
					}
				}
			}

			if($arrs){
				echo json_encode($arrs);
			}else{
				echo "";
			}

		//地图模式
		}elseif($do=="lists"){

			$this->users->onlogin();	//登录判断
			$this->users->pagelevel();	//权限判断
			extract($_GET);
			$clockd = getModel("clockd");
			if($godate&&$todate){
					$godate = $godate;
					$todate = $todate;
	        if ($godate > $todate) {
	            msgbox('', '抱歉，起始日期不能大于截止日期！');
	        }
	        $godateint = strtotime($godate);
	        $todateint = strtotime($todate);
	        $checkint = $todateint - $godateint;
	        if ($checkint > 86400 * 366) {
	            msgbox('', '抱歉，记录查询期限范围不能超过365天和1年！');
	        }
			}else{
					$todate = date("Y-m-d",time()-86400*90);
					$godate = date("Y-m-d",time()-86400*366);
			}

			$page = 1;
			$datetime = date("Y-m-d");
			if($status == 1){
					$godate  = $datetime;
					$todate  = "";			//60天内要回访的客户
					$checked = "1";
					$worked	 = "0";
					$clocked  = "1";
					$desc		 = "ASC";
			}elseif($status == 2){	//过期的用户
					$godate   = "";
					$todate   = $datetime;
					$checked  = "1";
					$worked	  = "0";
					$clocked  = "1";
					$desc		  = "DESC";
			}elseif($status == 3){	//不提醒的用户
					$godate   = "";
					$todate   = $datetime;
					$checked  = "0";
					$worked	  = "1";
					$clocked  = "1";
					$desc		  = "DESC";
			}elseif($status == 4){	//未激活的客户
					$godate   = $godate;
					$todate   = $todate;
					$checked  = "";
					$worked	  = "";
					$clocked  = "0";
					$desc		  = "ASC";
			}else{									//不提醒的订单
					$godate   = $godate;
					$todate   = $todate;
					$checked  = "";
					$worked	  = "";
					$clocked  = "4";
					$desc		  = "DESC";
			}
			$nums    = "20";
			$rows = $clockd->getrows("page=$page&nums=$nums&clocked=$clocked&desc=$desc&ctype=$ctype&mtype=$mtype&checked=$checked&stars=$stars&worked=$worked&customsid=$customsid&ordersid=$ordersid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&provid=$provid&cityid=$cityid&areaid=$areaid&address=$address&brandid=$brandid&encoded=$encoded");
			if($page=="1"){
				$this->tpl->set("list",$rows["record"]);
				$this->tpl->set("page",$rows["pages"]);
			}else{
				$this->tpl->set("list",$rows);
			}
			$this->tpl->display("service.clockd.lists.php");

		//回访
		}else{

			$this->users->onlogin();	//登录判断
			$this->users->pagelevel();	//权限判断

			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);

			$orders = getModel("orders");

			//客户类型
			$customstype = $orders->customstype();
			$this->tpl->set("customstype",$customstype);

			$product = getModel("product");
			$brands = $product->brand();
			$this->tpl->set("brands",$brands);

			$this->tpl->display("service.clockd.php");

		}
	}

	//满意度回访
	Public function degree()
	{

		$do = $_GET["do"];
		$degree 	= getModel("degree");
		//操作回访
		if($do=="edit"){

			$this->users->dialoglogin();		//登录判断
			$this->users->dialoglevel();		//权限判断
			$id			= ($_GET["id"])?(int)base64_decode($_GET["id"]):"0";
			$ordersid	= ($_GET["ordersid"])?(int)base64_decode($_GET["ordersid"]):"0";
			$jobsid		= ($_GET["jobsid"])?(int)base64_decode($_GET["jobsid"]):"0";
			$info = $degree->getrow("ordersid=$ordersid&jobsid=$jobsid");
			$this->tpl->set("info",$info);

			if(isset($_POST)&&!empty($_POST))
			{
				$degree->id = $id;
				$degree->ordersid = $ordersid;
				$degree->jobsid = $jobsid;
				$msg = $degree->degree();
				echo 1;exit;
			}else{
				//$orders = getModel("orders");
				$userid = (int)$this->cookie->get("userid");
				$isadmin = $this->users->isadmin();		//判断是否管理员
				$islevel = $this->users->getlevel();	//判断页面权限
				if(!$islevel&&!$isadmin){
					dialog("抱歉，你没有权限进行操作！");
				}
				if($info["checked"]){
					$datetime = time()-86400;
					if($datetime>=$info["dateline"]){
						dialog("抱歉，信息已经超过修改日期！");
					}
				}

				if($ordersid){
					$orders = getModel("orders");
					$ordersinfo = $orders->getrow("id=$ordersid");
					$this->tpl->set("ordersinfo",$ordersinfo);
				}
				if($jobsid){
					$jobs = getModel("jobs");
					$jobsinfo = $jobs->getrow("id=$jobsid");
					$this->tpl->set("jobsinfo",$jobsinfo);
				}

				$this->tpl->set("type","edit");
				$this->tpl->display("service.degree.info.php");
			}

		//查看回访
		}elseif($do=="views"){

			$this->users->onlogin();	//登录判断
			//$this->users->pagelevel();	//权限判断
			$ordersid	= ($_GET["ordersid"])?(int)base64_decode($_GET["ordersid"]):"0";
			$jobsid		= ($_GET["jobsid"])?(int)base64_decode($_GET["jobsid"]):"0";
			$this->tpl->set("ordersid",$ordersid);
			$this->tpl->set("jobsid",$jobsid);

			$info = $degree->getrow("ordersid=$ordersid&jobsid=$jobsid");

			if($ordersid){
				$orders = getModel("orders");
				//订单类型
				$ordertype = $orders->ordertype();
				$this->tpl->set("ordertype",$ordertype);
				//订单进度
				$statustype = $orders->statustype();
				$this->tpl->set("statustype",$statustype);
				//送货方式
				$delivertype = $orders->delivertype();
				$this->tpl->set("delivertype",$delivertype);
				//安装方式
				$setuptype = $orders->setuptype();
				$this->tpl->set("setuptype",$setuptype);
				$ordersinfo = $orders->getrow("id=$ordersid");
				$this->tpl->set("orderinfo",$ordersinfo);
			}
			if($jobsid){
				$jobs = getModel("jobs");
				$jobsinfo = $jobs->getrow("id=$jobsid");
				$this->tpl->set("jobsinfo",$jobsinfo);
			}

			$this->tpl->set("info",$info);
			$this->tpl->display("service.degree.views.php");

		//回访
		}elseif($do=="lists"){

			$this->users->onlogin();	//登录判断
			$this->users->pagelevel();	//权限判断
			extract($_GET);
			$degree = getModel("degree");
			if($godate&&$todate){
				$godate = $godate;
				$todate = $todate;
			}else{
				$date = plugin::getTheMonth(date("Y-m",time()));
				$godate = $date[0];
				$todate = $date[1];
			}

			//工单类型
			$jobs = getModel("jobs");
			$jobstype = $jobs->jobstype();
			$this->tpl->set("jobstype",$jobstype);

			$status = (int)$status;
			$rows = $degree->getrows("page=1&type=$type&status=$status&ordersid=$ordersid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid");
			//print_r($rows);exit;
			$this->tpl->set("list",$rows["record"]);
			$this->tpl->set("page",$rows["pages"]);
			$this->tpl->display("service.degree.lists.php");

		//提醒
		}else{

			$this->users->onlogin();	//登录判断
			$this->users->pagelevel();	//权限判断

			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);

			$jobs = getModel("jobs");
			$jobstype = $jobs->jobstype();
			$this->tpl->set("jobstype",$jobstype);

			$this->tpl->display("service.degree.php");

		}

	}

	Public function calls()
	{
		$this->users->onlogin();	//检查登录
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show=="1"){

			$ordersid	= $_GET["ordersid"];
			$contract	= $_GET["contract"];
			$mobile		= $_GET["mobile"];
			$address	= trim($_GET["address"]);
			$orders 	= getModel("orders");

			//订单类型
			$ordertype = $orders->ordertype();
			$this->tpl->set("ordertype",$ordertype);
			//订单进度
			$statustype = $orders->statustype();
			$this->tpl->set("statustype",$statustype);

			$rows = $orders->getrows("page=1&nums=25&alled=1&address=$address&cityinfo=1&ordersid=$ordersid&address=$address&contract=$contract&mobile=$mobile&wangwang=$wangwang");
			if(!$rows["record"]){ msgbox(S_ROOT."pages","没有查询到相关订单！"); }
			$this->tpl->set("list",$rows["record"]);
			$this->tpl->set("page",$rows["pages"]);
			$this->tpl->display("service.calls.lists.php");
		}else{

			$this->tpl->display("service.calls.php");
		}
	}

	Public function express(){

		$this->users->onlogin();	//检查登录
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		$orders = getModel("orders");
		$express = getModel("express");
		$expstats= $express->expstate();
		$this->tpl->set("expstats",$expstats);
		//订单进度
		$statustype = $orders->statustype();
		$this->tpl->set("statustype",$statustype);
		$setuptype = $orders->setuptype();
		$this->tpl->set("setuptype",$setuptype);
		if($show=="1"){

			$numbers	= $_GET["numbers"];
			$godate		= $_GET["godate"];
			$todate		= $_GET["todate"];
			$cateid		= $_GET["cateid"];
			$finished	= $_GET["finished"];
			$provid		= $_GET["provid"];
			$cityid		= $_GET["cityid"];
			$areaid		= $_GET["areaid"];
			$status		= $_GET["status"];
			$setuptype	= $_GET["setuptype"];
			$salesarea	= $_GET["salesarea"];
			$salesid	= $_GET["salesid"];

			if($godate==""&&$todate==""){
				$godate = date("Y-m-d",time()-86400*150);
				$todate = date("Y-m-d",time());
			}
			$rows = $express->getrows("page=1&nums=17&sqled=jobexp&expnumbers=$numbers&salesarea=$salesarea&salesid=$salesid&cateid=$cateid&godate=$godate&todate=$todate&status=$status&setuptype=$setuptype&finished=$finished&provid=$provid&cityid=$cityid&areaid=$areaid&order=finishtime&desc=DESC");
			$this->tpl->set("list",$rows["record"]);
			$this->tpl->set("page",$rows["pages"]);
			$this->tpl->display("service.express.lists.php");

		}else{
			$cates = $express->cates();
			$this->tpl->set("cates",$cates);

			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);

			$this->tpl->display("service.express.php");
		}
	}


}
?>
