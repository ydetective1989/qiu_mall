<?php
class storeAction extends Action
{

	Public function add()
	{

			$this->users->dialoglogin();			//登录判断
			$this->users->dialoglevel();			//登录判断
			$store 	= getModel("store");
			$orders = getModel("orders");
			$ordersid = (int)base64_decode($_GET["id"]);
			if(isset($_POST)&&!empty($_POST)){
				$store->id = $ordersid;
				$msg = $store->add();
				echo $msg;
			}else{
				$orderinfo = $orders->getrow("id=$ordersid");
				$this->tpl->set("orderinfo",$orderinfo);
				if($orderinfo["checked"]!="1"){ dialog("订单没有审核，无法增加出库记录"); }
				$product = $store->product("ordersid=$ordersid");
				$this->tpl->set("product",$product);
				$this->tpl->set("stores",$store->store());
				$this->tpl->set("show","info");
				$this->tpl->display("store.dialog.php");
			}
	}

	Public function edit()
	{
		$this->users->dialoglogin();			//登录判断
		$isadmin = $this->users->isadmin();		//判断是否管理员
		$islevel = $this->users->getlevel();	//判断页面权限
		$id		=	(int)base64_decode($_GET["id"]);

		$store 	= getModel("store");
		$orders = getModel("orders");
		$info = $store->getrow("id=$id");
		if(!$info){ dialog("信息不存在"); }
		$ordersid = $info["ordersid"];

		if(!$islevel){
			if($info["userid"]!=$userid){//
				dialog("抱歉，非录入人员，你没有权限修改出库信息！");
			}
		}
		if($info["checked"]=="1"){
			dialog("ERP出库已复核，无法进行修改！");
		}
		if($info["checked"]=="4"){
			dialog("ERP出库已取消，无法进行修改！");
		}

		if(isset($_POST)&&!empty($_POST)){

			$store->id = $id;
			$msg = $store->edit();
			echo $msg;

		}else{

			$orderinfo = $orders->getrow("id=$ordersid");
			$this->tpl->set("orderinfo",$orderinfo);

			$product = $store->product("sid=$id&ordersid=$ordersid");
			$this->tpl->set("product",$product);
			$this->tpl->set("stores",$store->store());

			$this->tpl->set("info",$info);
			$this->tpl->set("show","info");
			$this->tpl->display("store.dialog.php");
		}
	}

	Public function del()
	{
		$this->users->dialoglogin();			//登录判断
		$store = getModel("store");
		$id		= (int)base64_decode($_GET["id"]);
		$info = $store->getrow("id=$id");
		if(!$info){ dialog("信息不存在"); }
		$userid = (int)$this->cookie->get("userid");
		$isadmin = $this->users->isadmin();		//判断是否管理员
		$islevel = $this->users->getlevel();	//判断页面权限
		if(!$islevel){
			if($info["userid"]!=$userid){//
				dialog("抱歉，非录入人员，你没有权限删除出库信息！");
			}
		}
		if($info["deliver"]=="1"){
			dialog("ERP出库已复核，无法进行修改！");
		}
		if($info["checked"]=="4"){
			dialog("ERP出库已取消，请勿重复进行！");
		}
		$store->ordersid = (int)$info["ordersid"];
		$store->id = $id;
		$store->del();
		echo 1;
	}

	Public function deliver()
	{

		$this->users->onlogin();			//登录判断
		$islevel = $this->users->islevel();
		$id		=	(int)base64_decode($_GET["id"]);
		$userid	=	(int)$this->cookie->get("userid");

		$urlto	= S_ROOT."store/views?id=".$_GET["id"];

		$store 	= getModel("store");
		$orders = getModel("orders");

		$info = $store->getrow("id=$id");
		if(!$info){ dialog("信息不存在"); }
		$ordersid = $info["ordersid"];

		if(!$islevel){
			$storeid = (int)$info["storeid"];
			$storelevel = $store->level("storeid=$storeid");
			if(!$storelevel){
				msgbox($urlto,"抱歉，你没有此库房复核权限！");
			}
		}
		$checkuserid = $info["checkuserid"];
		if($checkuserid==$userid){
			msgbox($urlto,"抱歉，信息确认人无法复核进行操作！");
		}

		$timeline = time()-86400*3;	//计算前一天
		if($info["deliver"]<>"0"&&$info["deliverdate"]<$timeline){
			msgbox($urlto,"出库复核超过3天，复核信息无法进行编辑！");
		}
		if($info["checked"]=="0"){
			msgbox($urlto,"ERP出库没有确认，无法进行复核！");
		}
		if($info["checked"]=="4"){
			msgbox($urlto,"ERP出库已取消，无法进行确认！");
		}
		if(isset($_POST)&&!empty($_POST)){

			$store->id = $id;
			$store->ordersid = $ordersid;
			$msg = $store->deliver();
			if($msg=="1"){
				msgbox($urlto,"OK，操作完成！",2000);
			}else{
				msgbox($urlto,$msg);
			}
		}else{
			$orderinfo = $orders->getrow("id=$ordersid");
			$this->tpl->set("orderinfo",$orderinfo);
			$deliverinfo = $store->deliverinfo("id=$id");
			//print_r($deliverinfo);
			if(!$deliverinfo){ msgbox("","出库产品与订单产品不一致，异常无法操作！请取消重新出库~~~"); }
			$this->tpl->set("deliverinfo",$deliverinfo);
			$this->tpl->set("info",$info);
			$this->tpl->set("show","deliver");
			$this->tpl->display("store.page.php");

		}
	}

	Public function search()
	{
		$this->users->onlogin();			//登录判断
		$this->users->pagelevel();
		$show = $_GET['show'];
		if($show=="lists"){

			$store 	= getModel("store");
			$ordersid	= (int)$_GET["ordersid"];
			$erpnum		= trim($_GET["erpnum"]);
			$rows = $store->getrows("page=1&nums=20&ordersid=$ordersid&erpnum=$erpnum");

			if(!$rows["record"]){ msgbox("","没有查询到此出库记录"); }
			$this->tpl->set("list",$rows["record"]);
			$this->tpl->set("page",$rows["pages"]);

			$this->tpl->set("show","lists");
		}else{
			$this->tpl->set("show","");
		}
		$this->tpl->display("store.page.php");
	}

	Public function views()
	{
		$this->users->dialoglogin();			//登录判断
		$this->users->pagelevel();
		$id		=	(int)base64_decode($_GET["id"]);

		$store 	= getModel("store");
		$orders 	= getModel("orders");

		$info = $store->getrow("id=$id");
		if(!$info){ dialog("信息不存在"); }
		$ordersid = $info["ordersid"];

		$orderinfo = $orders->getrow("id=$ordersid");
		$this->tpl->set("orderinfo",$orderinfo);

		$orders_product = $orders->ordersinfo("ordersid=$ordersid&group=true");
		$this->tpl->set("orders_product",$orders_product);

		$deliverinfo = $store->deliverinfo("id=$id");
		$this->tpl->set("deliverinfo",$deliverinfo);

		$deliverlist = $store->deliverinfo("ordersid=$ordersid");
		$this->tpl->set("deliverlist",$deliverlist);

		$productc	= $store->product("ordersid=$ordersid");
		$this->tpl->set("productc",$productc);

		//已开金额
		$invoice = getModel("invoice");
		$countnums = $invoice->opencount("ordersid=$ordersid");
		$this->tpl->set("invoiced",$countnums);

		$this->tpl->set("info",$info);

		$this->tpl->set("show","views");
		$this->tpl->display("store.page.php");
	}


	Public function checked()
	{

		$this->users->dialoglogin();			//登录判断
		$islevel = $this->users->pagelevel();	//判断页面权限

		$id		=	(int)base64_decode($_GET["id"]);

		$store 	= getModel("store");
		$orders = getModel("orders");

		$info = $store->getrow("id=$id");
		if(!$info){ dialog("信息不存在"); }
		$ordersid = $info["ordersid"];

		if($info["deliver"]=="1"){
			dialog("ERP出库已复核，无法重复操作！");
		}
		if($info["checked"]=="1"){
			dialog("ERP出库已确认，无法重复确认！");
		}
		if($info["checked"]=="4"){
			dialog("ERP出库已取消，无法重新确认！");
		}

		if(isset($_POST)&&!empty($_POST)){

			$store->id = $id;
			$store->ordersid = $ordersid;
			$store->info = $info;
			$msg = $store->checked();
			echo $msg;

		}else{

			$deliverinfo = $store->deliverinfo("id=$id");
			$this->tpl->set("deliverinfo",$deliverinfo);

			if(!$deliverinfo){ dialog("出库产品与订单产品不一致，异常无法操作！<br>请取消重新出库~~~"); }

			$this->tpl->set("info",$info);
			$this->tpl->set("show","checked");
			$this->tpl->display("store.dialog.php");
		}

	}


	Public function charge()
	{
		extract($_GET);
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();
		$isadmin = $this->users->isadmin();		//判断是否管理员

		$store 	= getModel("store");

		if($godate&&$todate){
			$godate = $godate;
			$todate = $todate;
		}else{
			$godate = date("Y-m-d",time()-86400*30);
			$todate = date("Y-m-d");
		}


		if($do=="deliver"){

			if(!$isadmin){
				$storelevel = 1;	//限制库房权限
			}
			$checked = 1;	$deliver = 0;

		}elseif($do=="checked"){

			$checked = 0;	$deliver = 0;

		}elseif($do=="stores"){

			if(!$isadmin){
				$storelevel = 1;	//限制库房权限
			}
			$datatype = "checkdate";

		}else{
			exit;
		}

		if($show=="lists"){

			$ordersid	= (int)$_GET["ordersid"];
			$erpnum		= trim($_GET["erpnum"]);
			$storeid	= $_GET["storeid"];
			if($do=="stores"){
					$rows = $store->deliverinfo("datatype=$datatype&page=1&nums=20&godate=$godate&todate=$todate&ordersid=$ordersid&erpnum=$erpnum&checked=$checked&deliver=$deliver&storelevel=$storelevel&storeid=$storeid");
			}else{
					$rows = $store->getrows("page=1&nums=20&datatype=$datatype&godate=$godate&todate=$todate&ordersid=$ordersid&erpnum=$erpnum&checked=$checked&deliver=$deliver&storelevel=$storelevel&storeid=$storeid");
			}
			$this->tpl->set("doshow",$do);
			$this->tpl->set("list",$rows["record"]);
			$this->tpl->set("page",$rows["pages"]);

		}elseif($show=="xls"){


			$gotime = strtotime($godate." 00:00:00");
			$totime = strtotime($todate." 23:59:59");
			$chtime = 86400*31;
			if($chtime<$gotime-$totime){
				msgbox("","导出内容的时间范围不能超过一个月",10000);
			}
			$ordersid	= (int)$_GET["ordersid"];
			$erpnum		= trim($_GET["erpnum"]);
			$storeid	= $_GET["storeid"];
			$rows = $store->deliverinfo("xls=1&datatype=$datatype&godate=$godate&todate=$todate&ordersid=$ordersid&erpnum=$erpnum&checked=$checked&deliver=$deliver&storelevel=$storelevel&storeid=$storeid");
			if($rows){

				ini_set("memory_limit","3000M");
				$xls = getFunc("excel");

				$orders = getModel('orders');
				//订单类型
				$checktype = $orders->checktype();//审核状态
				$statustype = $orders->statustype();
				//$statustype[$rs['status']]['name'];//订单状态

				$data = array();
				$data[] = array('库房编码','库房名称','订单编号','合同编号','审核状态','订单进度','销售部门','销售人员','类型','ERP单据号','商品编码',
				'客户地址','客户姓名','手机号码','其它电话','订单备注',
				'品牌','商品名称','商品型号','商品单价','商品数量',
				'录入时间','确认状态','确认人','确认时间','复核状态','复核人','复核时间');
				foreach($rows AS $rs){
					$typename	= ($rs["type"]=="1")?"出库":"退库";
					switch($rs["checked"]){
						case "1" :
							$checked	=	"完成确认";
							$checkname	=	$rs["checkname"];
							$checkdate	=	date("Y-m-d H:i",$rs["checkdate"]);
							break;
						case "4" :
							$checked	= 	"取消出库";
							$checkname	=	$rs["checkname"];
							$checkdate	=	date("Y-m-d H:i",$rs["checkdate"]);
							break;
						default  : $checked = "等待确认";$checkname="";$chekdate="";
					}
					switch($rs["deliver"]){
						case "1" :
							$deliver		=	"完成复核";
							$delivername	=	$rs["delivername"];
							$deliverdate	=	date("Y-m-d H:i",$rs["deliverdate"]);
							break;
						case "4" :
							$deliver		=	"无需复核";
							$delivername	=	"";
							$deliverdate	=	"";
							break;
						default  :
							$deliver		= 	"等待复核";
							$delivername	=	"";
							$deliverdate	=	"";
					}
					$data[] = array($rs["storecode"],$rs["storename"],$rs["ordersid"],$rs["contract"],$checktype[$rs['ochecked']]['name'],$statustype[$rs['ostatus']]['name'],$rs["salesname"],$rs["salesuname"],$typename,$rs["erpnum"],
					$rs["encoded"],$rs["address"],$rs["name"],$rs["mobile"],$rs["phone"],$rs["odetail"],
					$rs["brandname"],$rs["title"],$rs["models"],$rs["price"],$rs["nums"],date("Y-m-d H:i",$rs["dateline"]),
					$checked,$checkname,$checkdate,$deliver,$delivername,$deliverdate);

				}
				//print_r($data);exit;
				$xls->addArray($data);
				$xls->generateXML("storelogs");

			}else{
				msgbox("","没有找到相关数据！");
			}
			exit;

		}else{

			$stores = $store->store("storelevel=1");
			$this->tpl->set("stores",$stores);

			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$do = $_GET["do"];
			$this->tpl->set("status",$do);

		}
		if($do=="stores"&&$show=="lists"){ $show = $do; }
		$this->tpl->set("show",$show);
		$this->tpl->display("store.charge.php");
	}

	Public function verifed()
	{
		$this->users->dialoglogin();	//登录判断
		$this->users->dialoglevel();
		$id		=	(int)base64_decode($_GET["id"]);
		$store 	= getModel("store");
		$rows = $store->verifed("id=$id");
		echo "1";
	}


	Public function lists()
	{
		$this->users->onlogin();	//登录判断
		$id		=	(int)base64_decode($_GET["id"]);
		$store 	= getModel("store");
		$rows = $store->getrows("page=1&show=2&nums=5&ordersid=$id");
		//print_r($rows);
		$this->tpl->set("list",$rows["record"]);
		$this->tpl->set("page",$rows["pages"]);
		//print_r($rows);
		$this->tpl->set("show","lists");
		$this->tpl->display("store.dialog.php");
	}


}
?>
