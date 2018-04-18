<?php
class countsAction extends Action
{

	Public function app()
	{
		$this->users->onlogin();	//登录判断
		msgbox("","此栏目还没上线，请稍等一段时间！");
	}

	Public function pages()
	{
		$this->users->onlogin();	//登录判断
		$this->tpl->display("counts.pages.php");
	}

	Public function menu()
	{
		$this->users->onlogin();	//登录判断
		$level = getModel("level");
		$menus = $level->getrows("id=1091,1092,1171&tree=1&naved=1&checked=1");
		$this->tpl->set("menus",$menus);
		$this->tpl->display("frm.menu.php");
	}

	//客户
	Public function areas()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		$xls = $_GET["xls"];

		if($xls){

			extract($_GET);
			$counts = getModel("counts");
			$xls = getFunc("excel");
			$rows = $counts->areas("ctype=areas&godate=$godate&todate=$todate&provid=0");
			if($rows){

				//操作日志记录
				$logs = getModel('logs');
				$logs->insert("type=query&ordersid=0&name=统计系统[区域用户]&detail=导出了[区域用户]统计&sqlstr=$logsarr");

				$data = array();
				$data[] = array('城市','客户总数','主订单数','激活客户数','激活服务数');
				foreach($rows AS $rs){
					$data[] = array($rs["name"]);
					$eprovid = (int)$rs["areaid"];
					$rows = $counts->areas("ctype=areas&godate=$godate&todate=$todate&provid=$eprovid");
					if($rows){
						foreach($rows AS $cr){
							$ecityid = (int)$cr["areaid"];
							//总订单数
							$ordersnums = $counts->areas("ctype=orders&godate=$godate&todate=$todate&provid=$eprovid&cityid=$ecityid");
							//总客户数
							$customsnums = $counts->areas("ctype=customs&ordertype=1&godate=$godate&todate=$todate&provid=$eprovid&cityid=$ecityid");
							//服务订单数
							$pordersnums = $counts->areas("ctype=porders&godate=$godate&todate=$todate&provid=$eprovid&cityid=$ecityid");
							//服务客户数
							$pcustomsnums = $counts->areas("ctype=customs&ordertype=0&godate=$godate&todate=$todate&provid=$eprovid&cityid=$ecityid");
							$data[] = array($cr["name"],$ordersnums,$customsnums,$pordersnums,$pcustomsnums);
						}
					}
				}
				$xls->addArray($data);
				$xls->generateXML("xxxx");
				exit;
			}
		}

		if($show){

			extract($_GET);
			$counts = getModel("counts");


			//总订单数
			$rows = $counts->areas("ctype=orders&godate=$godate&todate=$todate&provid=$provid&cityid=$cityid");
			$this->tpl->set("ordersnums",$rows);
			//总客户数
			$rows = $counts->areas("ctype=customs&ordertype=1&godate=$godate&todate=$todate&provid=$provid&cityid=$cityid");
			$this->tpl->set("customsnums",$rows);

			//服务订单数
			$rows = $counts->areas("ctype=porders&godate=$godate&todate=$todate&provid=$provid&cityid=$cityid");
			$this->tpl->set("pordersnums",$rows);
			//服务客户数
			$rows = $counts->areas("ctype=customs&ordertype=0&godate=$godate&todate=$todate&provid=$provid&cityid=$cityid");
			$this->tpl->set("pcustomsnums",$rows);


			$arealists = $counts->areas("ctype=areas&godate=$godate&todate=$todate&provid=$provid&cityid=$cityid");
			$rows = array();
			if($arealists){

				foreach($arealists AS $rs){

					if((int)$provid){
						if($cityid){
							$eprovid = (int)$provid;
							$ecityid = (int)$cityid;
							$eareaid = (int)$rs["areaid"];
						}else{
							$eprovid = (int)$provid;
							$ecityid = (int)$rs["areaid"];
							$eareaid = 0;
						}
					}else{
						$eprovid = (int)$rs["areaid"];
						$ecityid = 0;
						$eareaid = 0;
					}
					//总订单数
					$rs["ordersnums"] = $counts->areas("ctype=orders&godate=$godate&todate=$todate&provid=$eprovid&cityid=$ecityid&areaid=$eareaid");
					//总客户数
					$rs["customsnums"] = $counts->areas("ctype=customs&ordertype=1&godate=$godate&todate=$todate&provid=$eprovid&cityid=$ecityid&areaid=$eareaid");
					//服务订单数
					$rs["pordersnums"] = $counts->areas("ctype=porders&godate=$godate&todate=$todate&provid=$eprovid&cityid=$ecityid&areaid=$eareaid");
					//服务客户数
					$rs["pcustomsnums"] = $counts->areas("ctype=customs&ordertype=0&godate=$godate&todate=$todate&provid=$eprovid&cityid=$ecityid&areaid=$eareaid");
					$rows[] = $rs;
				}//print_r($rows);exit;
				$rows = plugin::sortArr($rows,"ordersnums","DESC");
			}
			$this->tpl->set("arealists",$rows);

			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[区域用户]&detail=查询了[区域用户]统计&sqlstr=$logsarr");

			$this->tpl->set("type","show");
			$this->tpl->display("counts.areas.php");
		}else{
			$this->tpl->set("type","iframe");
			$this->tpl->display("counts.areas.php");
		}


	}

	//订单统计
	Public function orders()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show=="1"){


			extract($_GET);
			$orders = getModel("orders");
			$counts = getModel("counts");


			//销售订单数
			$rows = $counts->orderc("ctype=orders&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$this->tpl->set("ordernums",$rows);
			//订单金额
			$rows = $counts->orderc("ctype=price&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$this->tpl->set("orderprice",$rows);
			//客户数量
			$rows = $counts->orderc("ctype=customs&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$this->tpl->set("customsnums",$rows);
			//产品数目
			$rows = $counts->orderc("ctype=products&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$this->tpl->set("products",$rows);
			//产品总数
			$rows = $counts->orderc("ctype=productnums&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$this->tpl->set("productnums",$rows);

			//支付状态统计
			$paystatetype = $orders->paystatetype();
			$arr = array();
			foreach($paystatetype AS $rs){
				$rows = $counts->orderc("ctype=orders&paystate=".$rs["id"]."&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
				$rs["ordernums"] = $rows;
				$rows = $counts->orderc("ctype=price&paystate=".$rs["id"]."&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
				$rs["orderprice"] = $rows;
				$arr[] = $rs;
			}
			$this->tpl->set("paycount",$arr);

			//订单类型统计
			$ordertype = $orders->ordertype();
			$arr = array();
			foreach($ordertype AS $rs){
				$rows = $counts->orderc("ctype=orders&type=".$rs["id"]."&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
				$rs["ordernums"] = $rows;
				$rows = $counts->orderc("ctype=price&type=".$rs["id"]."&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
				$rs["orderprice"] = $rows;
				$arr[] = $rs;
			}
			$rs = array();
			$rs["name"] = "信用订单";
			$rows = $counts->orderc("ctype=orders&octype=6&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$rs["ordernums"] = $rows;
			$rows = $counts->orderc("ctype=price&octype=6&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$rs["orderprice"] = $rows;
			$arr[] = $rs;
			$this->tpl->set("typecount",$arr);

			//客户类别统计
			$customstype = $orders->customstype();
			$arr = array();
			foreach($customstype AS $rs){
				$rows = $counts->orderc("ctype=orders&customstype=".$rs["id"]."&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
				$rs["ordernums"] = $rows;
				$rows = $counts->orderc("ctype=price&customstype=".$rs["id"]."&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
				$rs["orderprice"] = $rows;
				$arr[] = $rs;
			}
			$this->tpl->set("customscount",$arr);


			$rows = $counts->orderc("ctype=salesgroup&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$arr = array();
			if($rows){
				foreach($rows AS $rs){
          if($rs["id"]=="0"){ continue; }
					$rows = $counts->orderc("ctype=orders&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesid=".$rs["id"]."&saleuserid=$saleuserid");
					$rs["ordernums"] = $rows;
					$rows = $counts->orderc("ctype=price&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesid=".$rs["id"]."&saleuserid=$saleuserid");
					$rs["orderprice"] = $rows;
					$arr[] = $rs;
				}
				//print_r($arr);exit;
				$arr = plugin::sortArr($arr,"orderprice","DESC");
				$this->tpl->set("teamcount",$arr);
			}

			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[订单统计]&detail=查看了[订单统计]&sqlstr=$logsarr");

			$this->tpl->set("type","show");
			$this->tpl->display("counts.orders.php");


		}elseif($show=="2"){

			//saleusers
			extract($_GET);
			$counts = getModel("counts");

			$str = "<option value=''>请选择销售人员</option>";
			//销售订单数
			$rows = $counts->orderc("ctype=saleusers&checkno=2,3&statusno=7,8,-1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid");
			if($rows){
				//print_r($rows);
				foreach($rows AS $rs){
					$username = ($rs["userid"]=="1"||$rs["userid"]=="0")?"系统默认":$rs["name"];
					$str.="<option value='".$rs["userid"]."'>".$rs["worknum"]."_".$username."</option>";
				}
			}
			echo $str;
			exit;

		}else{

			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);

			$orders = getModel("orders");
			$users = $orders->users("type=1&godate=$godate&todate=$todate&salesarea=0&salesid=0");
			$this->tpl->set("users",$users);
			$this->tpl->set("type","iframe");
			$this->tpl->display("counts.orders.php");

		}

	}



	//订单统计
	Public function orderadd()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show=="show"){

			extract($_GET);
			$teams = getModel("teams");
			$counts = getModel("counts");


			$users = $teams->users("type=1&checked=1&parentid=$salesarea&teamid=$salesid");
			if($users){
				$arr = array();
				foreach($users AS $rs){

					$userid = $rs["userid"];
					$rs["nums"] = $counts->addorder("ctype=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&userid=$userid");
					$rs["price"]=$counts->addorder("ctype=price&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&userid=$userid");
					$arr[] = $rs;
				}
				$users = $arr;
			}


			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[录单统计]&detail=查看了[录单统计]&sqlstr=$logsarr");

			$this->tpl->set("users",$users);
			$this->tpl->set("show","show");
		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("show","iframe");
		}
		$this->tpl->display("counts.orderadd.php");
	}

	//产品统计
	Public function product()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show){
			extract($_GET);
			$counts = getModel("counts");



			//分类销量
			$rows = $counts->productc("ctype=categorylist&checkno=2,3&statusno=7,8,-1&provid=$provid&cityid=$cityid&areaid=$areaid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$arr = array();
			if($rows){
				foreach($rows AS $rs){
					$rows = $counts->productc("ctype=nums&categoryid=".$rs["categoryid"]."&checkno=2,3&statusno=7,8,-1&provid=$provid&cityid=$cityid&areaid=$areaid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
					$rs["productnums"] = $rows;
					$rows = $counts->productc("ctype=price&categoryid=".$rs["categoryid"]."&checkno=2,3&statusno=7,8,-1&provid=$provid&cityid=$cityid&areaid=$areaid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
					$rs["productprice"] = $rows;
					$arr[] = $rs;
				}
				$arr = plugin::sortArr($arr,"productnums","DESC");
				$this->tpl->set("categoryarr",$arr);
			}

			//品牌销量
			$rows = $counts->productc("ctype=brandlist&checkno=2,3&statusno=7,8,-1&provid=$provid&cityid=$cityid&areaid=$areaid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$arr = array();
			if($rows){
				foreach($rows AS $rs){
					$rows = $counts->productc("ctype=nums&brandid=".$rs["brandid"]."&checkno=2,3&statusno=7,8,-1&provid=$provid&cityid=$cityid&areaid=$areaid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
					$rs["productnums"] = $rows;
					$rows = $counts->productc("ctype=price&brandid=".$rs["brandid"]."&checkno=2,3&statusno=7,8,-1&provid=$provid&cityid=$cityid&areaid=$areaid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
					$rs["productprice"] = $rows;
					$arr[] = $rs;
				}
				$arr = plugin::sortArr($arr,"productnums","DESC");
				$this->tpl->set("brandarr",$arr);
			}

			//产品销量
			$rows = $counts->productc("ctype=productlist&checkno=2,3&statusno=7,8,-1&provid=$provid&cityid=$cityid&areaid=$areaid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$arr = array();
			if($rows){
				foreach($rows AS $rs){
					$rows = $counts->productc("ctype=nums&productid=".$rs["productid"]."&checkno=2,3&statusno=7,8,-1&provid=$provid&cityid=$cityid&areaid=$areaid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
					$rs["productnums"] = $rows;
					$rows = $counts->productc("ctype=price&productid=".$rs["productid"]."&checkno=2,3&statusno=7,8,-1&provid=$provid&cityid=$cityid&areaid=$areaid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
					$rs["productprice"] = $rows;
					$arr[] = $rs;
				}
				$arr = plugin::sortArr($arr,"productnums","DESC");
				$this->tpl->set("productarr",$arr);
			}



			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[商品统计]&detail=查看了[商品统计]&sqlstr=$logsarr");

			$this->tpl->set("type","show");
			$this->tpl->display("counts.product.php");

		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$orders = getModel("orders");
			$users = $orders->users("type=1&godate=$godate&todate=$todate&salesarea=0&salesid=0");
			$this->tpl->set("users",$users);
			$this->tpl->set("type","iframe");
			$this->tpl->display("counts.product.php");
		}
	}

	//订单状态
	Public function ostatus()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show){
			extract($_GET);
			$orders = getModel("orders");
			$counts = getModel("counts");


			//总订单数
			$rows = $counts->orderc("ctype=orders&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$this->tpl->set("ordernums",$rows);
			//客户数量
			$rows = $counts->orderc("ctype=customs&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
			$this->tpl->set("customsnums",$rows);
			//审核状态统计
			$checktype = $orders->checktype();
			$arr = array();
			foreach($checktype AS $rs){
				$rows = $counts->orderc("ctype=orders&checked=".$rs["id"]."&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
				$rs["ordernums"] = $rows;
				$rows = $counts->orderc("ctype=customs&checked=".$rs["id"]."&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
				$rs["ordercustoms"] = $rows;
				$arr[] = $rs;
			}
			$this->tpl->set("checkcount",$arr);
			//进度状态统计
			$statustype = $orders->statustype();
			$arr = array();
			foreach($statustype AS $rs){
				$rows = $counts->orderc("ctype=orders&status=".$rs["id"]."&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
				$rs["ordernums"] = $rows;
				$rows = $counts->orderc("ctype=customs&status=".$rs["id"]."&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
				$rs["ordercustoms"] = $rows;
				$arr[] = $rs;
			}
			$this->tpl->set("statuscount",$arr);



			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[订单状态]&detail=查看了[订单状态]&sqlstr=$logsarr");

			$this->tpl->set("type","show");
			$this->tpl->display("counts.status.php");
		}else{

			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$orders = getModel("orders");
			$users = $orders->users("type=1&godate=$godate&todate=$todate&salesarea=0&salesid=0");
			$this->tpl->set("users",$users);
			$this->tpl->set("type","iframe");
			$this->tpl->display("counts.status.php");

		}

	}

	//市场统计
	Public function market()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show=="1"){
			extract($_GET);
			$counts = getModel("counts");


			$this->tpl->set("clientcount",$counts->market("ctype=counts&val=clientcount&type=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("clientnums",$counts->market("ctype=counts&val=clientnums&type=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("clientphone",$counts->market("ctype=counts&val=clientphone&type=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("clientsales",$counts->market("ctype=counts&val=clientsales&type=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("ordernums",$counts->market("ctype=counts&val=ordernums&type=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("orderprice",$counts->market("ctype=counts&val=orderprice&type=price&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("productnums",$counts->market("ctype=counts&val=productnums&type=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("homenums",$counts->market("ctype=counts&val=homenums&type=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("homeprice",$counts->market("ctype=counts&val=homeprice&type=price&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("ternums",$counts->market("ctype=counts&val=ternums&type=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("terprice",$counts->market("ctype=counts&val=terprice&type=price&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("epsonnums",$counts->market("ctype=counts&val=epsonnums&type=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("epsonprice",$counts->market("ctype=counts&val=epsonprice&type=price&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("retnums",$counts->market("ctype=counts&val=retnums&type=nums&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("retprice",$counts->market("ctype=counts&val=retprice&type=price&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("cash",$counts->market("ctype=counts&val=cash&type=price&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));
			$this->tpl->set("pos",$counts->market("ctype=counts&val=pos&type=price&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid"));

			$list = $counts->market("ctype=getrows&page=1&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid");
			$this->tpl->set("list",$list["record"]);
			$this->tpl->set("page",$list["pages"]);
			$this->tpl->set("type","show");

		}elseif($show=="2"){
			$market = getModel("market");
			$id = (int)base64_decode($_GET["id"]);
			$info = $market->reports_getrow("id=$id");
			$this->tpl->set("info",$info);
			$this->tpl->set("type","info");

			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[市场统计]&detail=查看了[市场统计]&sqlstr=$logsarr");

		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("type","iframe");
		}
		$this->tpl->display("counts.market.php");
	}


	Public function works()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show){
			extract($_GET);
			$counts = getModel("counts");


			$jobs = getModel("jobs");
			$jobstype = $jobs->jobstype();
			$this->tpl->set("jobstype",$jobstype);

			$worktype = $jobs->worktype();
			$this->tpl->set("worktype",$worktype);

			//总计
			$all = array();
			$all["all"] = $counts->works("ctype=counts&vtype=nums&val=id&godate=$godate&todate=$todate");
			foreach($worktype AS $r){
				$all[$r["id"]] = $counts->works("ctype=counts&vtype=nums&val=id&worked=".$r["id"]."&godate=$godate&todate=$todate");
			}
			$all["price"] = $counts->works("ctype=counts&vtype=price&val=price&godate=$godate&todate=$todate");
			$this->tpl->set("workall",$all);

			//完成状态
			$afters = $counts->works("ctype=afterlist&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid");
			if($afters){
				$arr = array();
				foreach($afters AS $rs){
					$rs["all"] = $counts->works("ctype=counts&vtype=nums&val=id&godate=$godate&todate=$todate&afterid=".$rs["id"]."");
					foreach($worktype AS $r){
						$rs[$r["id"]] = $counts->works("ctype=counts&vtype=nums&val=id&worked=".$r["id"]."&godate=$godate&todate=$todate&afterid=".$rs["id"]."");
					}
					$rs["price"] = $counts->works("ctype=counts&vtype=price&val=price&godate=$godate&todate=$todate&afterid=".$rs["id"]."");
					$arr[] = $rs;
				}
				$arr = plugin::sortArr($arr,"all","DESC");
				$this->tpl->set("worklist",$arr);
			}

			//类型统计
			//总计
			$all = array();
			$all["all"] = $counts->works("ctype=counts&vtype=nums&val=id&godate=$godate&todate=$todate");
			foreach($jobstype AS $r){
				$all[$r["id"]] = $counts->works("ctype=counts&vtype=nums&val=id&type=".$r["id"]."&godate=$godate&todate=$todate");
			}
			$this->tpl->set("typeall",$all);

			if($afters){
				$arr = array();
				foreach($afters AS $rs){
					$rs["all"] = $counts->works("ctype=counts&vtype=nums&val=id&godate=$godate&todate=$todate&afterid=".$rs["id"]."");
					foreach($jobstype AS $r){
						$rs[$r["id"]] = $counts->works("ctype=counts&vtype=nums&val=id&type=".$r["id"]."&godate=$godate&todate=$todate&afterid=".$rs["id"]."");
					}
					$arr[] = $rs;
				}
				$arr = plugin::sortArr($arr,"all","DESC");
				$this->tpl->set("typelist",$arr);
			}



			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[工单统计]&detail=查看了[工单统计]&sqlstr=$logsarr");

			$this->tpl->set("type","show");
		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("type","iframe");
		}
		$this->tpl->display("counts.works.php");

	}


	//服务单
	Public function after()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		$afterarea = $_GET["afterarea"];
		$afterid = $_GET["afterid"];
		$counts = getModel("counts");


		if($show){
			$list = $counts->teams("ctype=teamslist&afterarea=$afterarea&afterid=$afterid");
			if($list){
				$arr = array();
				foreach($list AS $rs){
					$date1 = date("Y-m-d",time());
					$date2 = date("Y-m-d",time()+86400);
					$date3 = date("Y-m-d",time()+86400*2);
					$this->tpl->set("date3",$date3);
					$date4 = date("Y-m-d",time()+86400*3);
					$this->tpl->set("date4",$date4);
					$date5 = date("Y-m-d",time()+86400*4);
					$this->tpl->set("date5",$date5);
					$rs["date1"] = $counts->teams("ctype=count&checked=1&godate=$date1&todate=$date1&afterid=".(int)$rs["id"]."");
					$rs["date2"] = $counts->teams("ctype=count&godate=$date2&todate=$date2&afterid=".(int)$rs["id"]."");
					$rs["date3"] = $counts->teams("ctype=count&godate=$date3&todate=$date3&afterid=".(int)$rs["id"]."");
					$rs["date4"] = $counts->teams("ctype=count&godate=$date4&todate=$date4&afterid=".(int)$rs["id"]."");
					$rs["date5"] = $counts->teams("ctype=count&godate=$date5&todate=$date5&afterid=".(int)$rs["id"]."");
					$arr[] = $rs;
				}
				$list = $arr;
			}
			//$list = plugin::sortArr($list,"date1","DESC");
			$this->tpl->set("list",$list);


			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[实时派单量]&detail=查看了[实时派单量]&sqlstr=$logsarr");

			$this->tpl->set("type","show");
		}else{
			$this->tpl->set("type","iframe");
		}
		$this->tpl->display("counts.after.php");
	}



	Public function jobs()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show){
			extract($_GET);
			$counts = getModel("counts");


			$jobs = getModel("jobs");
			$jobstype = $jobs->jobstype();
			$this->tpl->set("jobstype",$jobstype);

			$worktype = $jobs->worktype();
			$this->tpl->set("worktype",$worktype);

			//服务总计
			$all = array();
			$all["all"] = $counts->works("ctype=counts&vtype=nums&val=id&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid");
			foreach($worktype AS $r){
				$all[$r["id"]] = $counts->works("ctype=counts&vtype=nums&val=id&worked=".$r["id"]."&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid");
			}
			$all["price"] = $counts->works("ctype=counts&vtype=price&val=price&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid");
			$this->tpl->set("workall",$all);

			//服务人员
			$afterusers = $counts->works("ctype=afterusers&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid");
			//print_r($afterusers);exit;
			if($afterusers){
				$arr = array();
				foreach($afterusers AS $rs){
					$rs["all"] = $counts->works("ctype=counts&vtype=nums&val=id&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid&afteruserid=".$rs["userid"]."");
					foreach($worktype AS $r){
						$rs[$r["id"]] = $counts->works("ctype=counts&vtype=nums&val=id&worked=".$r["id"]."&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid&afteruserid=".$rs["userid"]."");
					}
					$rs["price"] = $counts->works("ctype=counts&vtype=price&val=price&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid&afteruserid=".$rs["userid"]."");
					$arr[] = $rs;
				}
				$arr = plugin::sortArr($arr,"all","DESC");
				$this->tpl->set("worklist",$arr);
			}

			//总计
			$all = array();
			$all["all"] = $counts->works("ctype=counts&vtype=nums&val=id&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid");
			foreach($jobstype AS $r){
				$all[$r["id"]] = $counts->works("ctype=counts&vtype=nums&val=id&type=".$r["id"]."&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid");
			}
			$this->tpl->set("typeall",$all);

			//类型统计
			if($afterusers){
				$arr = array();
				foreach($afterusers AS $rs){
					$rs["all"] = $counts->works("ctype=counts&vtype=nums&val=id&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid&afteruserid=".$rs["userid"]."");
					foreach($jobstype AS $r){
						$rs[$r["id"]] = $counts->works("ctype=counts&vtype=nums&val=id&type=".$r["id"]."&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid&afteruserid=".$rs["userid"]."");
					}
					$arr[] = $rs;
				}
				$arr = plugin::sortArr($arr,"all","DESC");
				$this->tpl->set("typelist",$arr);
			}



			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[服务统计]&detail=查看了[服务统计]&sqlstr=$logsarr");

			$this->tpl->set("type","show");
		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("type","iframe");
		}
		$this->tpl->display("counts.jobs.php");

	}

	//满意统计(服务人员)
	Public function degreelogs()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show==1){

			extract($_GET);
			$counts = getModel("counts");
			$rows = $counts->degreelogs("godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&afterarea=$afterarea&afterid=$afterid");

			$this->tpl->set("rows",$rows);

			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[服务满意度统计]&detail=查看了[服务满意度统计]&sqlstr=$logsarr");

			$this->tpl->set("type","show");

		}else{

			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];

			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("type","iframe");
		}
		$this->tpl->display("counts.degreelogs.php");
	}

	//满意度回访统计
	Public function degree()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show==1){

			extract($_GET);
			$counts = getModel("counts");


			$degree = getModel("degree");
			$rows = $counts->degree("ctype=counts&val=id&vtype=nums&godate=$godate&todate=$todate&userid=$userid");
			$this->tpl->set("allnums",$rows);

			$rows = $counts->degree("ctype=counts&val=id&vtype=nums&calltype=sales&godate=$godate&todate=$todate&userid=$userid");
			$this->tpl->set("salenums",$rows);
			$degrees = $counts->degree("ctype=counts&val=sales&vtype=sums&calltype=sales&godate=$godate&todate=$todate&userid=$userid");
			$rows = $degree->numstype(round($degrees/$rows,0));
			$this->tpl->set("saledegree",$rows);

			$rows = $counts->degree("ctype=counts&val=id&vtype=nums&calltype=after&godate=$godate&todate=$todate&userid=$userid");
			$this->tpl->set("afternums",$rows);
			$degrees = $counts->degree("ctype=counts&val=after&vtype=sums&calltype=after&godate=$godate&todate=$todate&userid=$userid");
			$rows = $degree->numstype(round($degrees/$rows,0));
			$this->tpl->set("afterdegree",$rows);

			$rows = $counts->degree("ctype=saleusers&godate=$godate&todate=$todate&userid=$userid");
			if($rows){
				$arr = array();
				foreach($rows AS $rs){
					$rs["nums"] = $counts->degree("ctype=counts&val=id&vtype=nums&calltype=after&godate=$godate&todate=$todate&saleuserid=".$rs["userid"]."&userid=$userid");
					if($rs["nums"]){
						$degrees = $counts->degree("ctype=counts&val=after&vtype=sums&calltype=after&godate=$godate&todate=$todate&saleuserid=".$rs["userid"]."&userid=$userid");
						$rs["degree"] = $degree->numstype(round($degrees/$rs["nums"],0));
					}
					$arr[] = $rs;
				}
				$arr = plugin::sortArr($arr,"degree","DESC");
				$this->tpl->set("salescount",$arr);
			}

			$rows = $counts->degree("ctype=afterusers&godate=$godate&todate=$todate&userid=$userid");
			if($rows){
				$arr = array();
				foreach($rows AS $rs){
					$rs["nums"] = $counts->degree("ctype=counts&val=id&vtype=nums&calltype=after&godate=$godate&todate=$todate&afteruserid=".$rs["userid"]."&userid=$userid");
					if($rs["nums"]){
						$degrees = $counts->degree("ctype=counts&val=after&vtype=sums&calltype=after&godate=$godate&todate=$todate&afteruserid=".$rs["userid"]."&userid=$userid");
						$rs["degree"] = $degree->numstype(round($degrees/$rs["nums"],0));
					}
					$arr[] = $rs;
				}
				$arr = plugin::sortArr($arr,"degree","DESC");
				$this->tpl->set("aftercount",$arr);
			}



			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[满意度统计]&detail=查看了[满意度统计]&sqlstr=$logsarr");

			$this->tpl->set("type","show");

		}elseif($show==2){	//用户
			extract($_GET);
			$counts = getModel("counts");
			$users = $counts->degree("ctype=users&godate=$godate&todate=$todate");
			$str = "<option value=''>选择回访人员</option>";
			if($users){
				foreach($users AS $rs){
					$str.= "<option value='".$rs["userid"]."'>".$rs["worknum"]."_".$rs["name"]."</option>";
				}
			}
			echo $str;
		}else{
			$counts = getModel("counts");
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$users = $counts->degree("ctype=users&godate=$godate&todate=$todate");
			$this->tpl->set("users",$users);
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("type","iframe");
		}
		$this->tpl->display("counts.degree.php");
	}

	Public function clockd()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show==1){

			extract($_GET);
			$counts = getModel("counts");



			$rows = $counts->clockd("ctype=orders&godate=$godate&todate=$todate&userid=$userid");
			$this->tpl->set("ordernums",$rows);			//服务订单数
			$rows = $counts->clockd("ctype=customs&godate=$godate&todate=$todate&userid=$userid");
			$this->tpl->set("servicecustoms",$rows);	//服务客户数
			$rows = $counts->clockd("ctype=customs&ordertype=1&userid=$userid");
			$this->tpl->set("allcustoms",$rows);		//客户总数
			$rows = $counts->clockd("ctype=clockd&godate=$godate&todate=$todate&userid=$userid");
			$this->tpl->set("clockdnums",$rows);		//提醒操作量
			$rows = $counts->clockd("ctype=price&godate=$godate&todate=$todate&userid=$userid");
			$this->tpl->set("oprice",$rows);			//销售金额

			$rows = $counts->clockd("ctype=users&godate=$godate&todate=$todate&userid=$userid");
			if($rows){
				$arr = array();
				foreach($rows AS $rs){
					$afteruserid = (int)$rs["userid"];
					$rows = $counts->clockd("ctype=orders&godate=$godate&todate=$todate&userid=$afteruserid");
					$rs["ordernums"] = $rows;			//服务订单数
					$rows = $counts->clockd("ctype=customs&godate=$godate&todate=$todate&userid=$afteruserid");
					$rs["servicecustoms"] = $rows;		//服务客户数
					//$rows = $counts->clockd("ctype=customs&ordertype=1&userid=$afteruserid");
					//$rs["allcustoms"] = $rows;			//客户总数
					$rows = $counts->clockd("ctype=clockd&godate=$godate&todate=$todate&userid=$afteruserid");
					$rs["clockdnums"] = $rows;			//提醒操作量
					$rows = $counts->clockd("ctype=price&godate=$godate&todate=$todate&userid=$afteruserid");
					$rs["oprice"] = $rows;				//销售金额
					$arr[] = $rs;
				}

				$arr = plugin::sortArr($arr,"oprice","DESC");
				$this->tpl->set("userscount",$arr);
			}

			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[销售回访]&detail=查看了[销售回访统计]&sqlstr=$logsarr");

			$this->tpl->set("type","show");

		}elseif($show==2){	//用户
			extract($_GET);
			$counts = getModel("counts");
			$users = $counts->clockd("ctype=users&godate=$godate&todate=$todate");
			$str = "<option value=''>选择回访人员</option>";
			if($users){
				foreach($users AS $rs){
					$str.= "<option value='".$rs["userid"]."'>".$rs["worknum"]."_".$rs["name"]."</option>";
				}
			}
			echo $str;
		}else{
			$counts = getModel("counts");
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$users = $counts->clockd("ctype=users&godate=$godate&todate=$todate");
			$this->tpl->set("users",$users);
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("type","iframe");
		}
		$this->tpl->display("counts.clockd.php");
	}


	Public function invoice()	//发票统计
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		$this->tpl->set("show",$show);
		$invoice = getModel("invoice");
		$counts = getModel("counts");


		if($show=="info"){
			extract($_GET);
			if($godate&&$todate){
				$gotime = strtotime($godate." 00:00:00");
				$totime = strtotime($todate." 23:59:59");
			}else{
				$date = plugin::getTheMonth(date("Y-m",time()));
				$gotime = strtotime($date[0]." 00:00:00");
				$totime = strtotime($date[1]." 23:59:59");
			}
			//本月申请数量
			$regarr["nums"] = $counts->invoice("ctype=dateline&cateid=$cateid&gotime=$gotime&totime=$totime");
			//本月已审数量
			$regarr["checked"] = $counts->invoice("ctype=dateline&cateid=$cateid&gotime=$gotime&totime=$totime&checked=1");
			//本月驳回数量
			$regarr["checkerror"] = $counts->invoice("ctype=dateline&cateid=$cateid&gotime=$gotime&totime=$totime&checked=2");
			//本月未审数量
			$regarr["checkno"] = $counts->invoice("ctype=dateline&cateid=$cateid&gotime=$gotime&totime=$totime&checked=0");

			//本月申请待开数量
			$regarr["noopen"] = $counts->invoice("ctype=dateline&cateid=$cateid&gotime=$gotime&totime=$totime&checked=1&worked=0");
			//本月申请已开数量
			$regarr["opennums"] = $counts->invoice("ctype=dateline&cateid=$cateid&gotime=$gotime&totime=$totime&checked=1&worked=1");
			//本月申请取消数量
			$regarr["killnums"] = $counts->invoice("ctype=dateline&cateid=$cateid&gotime=$gotime&totime=$totime&worked=2");
			//本月申请作废数量
			$regarr["closenums"] = $counts->invoice("ctype=dateline&cateid=$cateid&gotime=$gotime&totime=$totime&worked=3");

			//待开金额
			$regarr["noprice"] = $counts->invoice("ctype=price&cateid=$cateid&gotime=$gotime&totime=$totime&checked=1&worked=0");
			//已开金额
			$regarr["openprice"] = $counts->invoice("ctype=price&cateid=$cateid&gotime=$gotime&totime=$totime&checked=1&worked=1");
			//取消金额
			$regarr["killprice"] = $counts->invoice("ctype=price&cateid=$cateid&gotime=$gotime&totime=$totime&worked=2");
			//作废金额
			$regarr["closeprice"] = $counts->invoice("ctype=price&cateid=$cateid&gotime=$gotime&totime=$totime&worked=3");

			$this->tpl->set("reg",$regarr);

			//本月审核数量
			$checkarr["nums"] = $counts->invoice("ctype=checked&cateid=$cateid&gotime=$gotime&totime=$totime&checked=1");
			//本月审核未开数量
			$checkarr["nonums"] = $counts->invoice("ctype=checked&cateid=$cateid&gotime=$gotime&totime=$totime&checked=1&worked=0");
			//本月审核开票数量
			$checkarr["opennums"] = $counts->invoice("ctype=checked&cateid=$cateid&gotime=$gotime&totime=$totime&checked=1&worked=1");
			$checkarr["killnums"] = $counts->invoice("ctype=checked&cateid=$cateid&gotime=$gotime&totime=$totime&checked=1&worked=2");
			$checkarr["closenums"] = $counts->invoice("ctype=checked&cateid=$cateid&gotime=$gotime&totime=$totime&checked=1&worked=3");

			$this->tpl->set("checked",$checkarr);


			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[发票统计]&detail=查看了[发票统计]&sqlstr=$logsarr");

		}elseif($show=="xls"){

		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			//发票类型
			$cateslist = $invoice->catetype();
			$this->tpl->set("cateslist",$cateslist);

		}
		$this->tpl->display("counts.invoice.php");
	}


	Public function postjob()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		$counts = getModel("counts");


		$jobs	= getModel("jobs");
		if($show=="info"){
			$jobstype = $jobs->jobstype();
			extract($_GET);
			//	echo $saleuserid;exit;
			$teams = $counts->postjob("ctype=teams&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid");
			if($teams){
				$arr = array();
				foreach($teams AS $rs){
					foreach($jobstype AS $r){
  					 	if($r["id"]=="8"){ continue; }
						$rs["count"][$r["id"]] = $counts->postjob("ctype=count&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&type=".$r["id"]."&afterid=".$rs["id"]."&adduserid=$saleuserid");
					}
					$rs["allcount"] = $counts->postjob("ctype=count&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&afterid=".$rs["id"]."&adduserid=$saleuserid");
					$arr[]=$rs;
				}
				$teams = $arr;
				//print_r($teams);
			}
			$this->tpl->set("list",$teams);
			$this->tpl->set("jobstype",$jobstype);



			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[派单统计]&detail=查看了[派单统计]&sqlstr=$logsarr");

			$this->tpl->set("type","show");
		}elseif($show=="users"){
			extract($_GET);
			$select = "<option value=''>请选择人员</option>";
			$users = $counts->postjob("ctype=users&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid");
			if($users){
				foreach($users AS $rs){
					$select.="<option value=".$rs["userid"].">".$rs["worknum"]."_".$rs["name"]."</option>";
				}
			}
			echo $select;
			exit;
		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("type","iframe");

		}
		$this->tpl->display("counts.postjob.php");

	}



	Public function tags()
	{

		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$counts = getModel("counts");


		extract($_GET);
		$show = $_GET["show"];
		if($show=="views"){


		}elseif($show=="info"){
			//print_r($_GET);
			$taglist = $counts->tags("ctype=taglist&godate=$godate&todate=$todate&userid=$userid");
			if($taglist){


				$arr = array();
				foreach($taglist AS $rs){
					$tagid = (int)$rs["id"];
					$rs["customsnums"] = $counts->tags("ctype=customs&godate=$godate&todate=$todate&userid=$userid&tagid=$tagid");
					$arr[] = $rs;
				}

				$this->tpl->set("taglist",$arr);

				//总标签操作数
				$tagnums = $counts->tags("ctype=tags&godate=$godate&todate=$todate&userid=$userid");
				$this->tpl->set("tagnums",$tagnums);

				//总标签客户数
				$customsnums = $counts->tags("ctype=customs&godate=$godate&todate=$todate&userid=$userid");
				$this->tpl->set("customsnums",$customsnums);

			}


			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[标签统计]&detail=查看了[标签统计]&sqlstr=$logsarr");


			$this->tpl->set("type","info");

		}elseif($show=="users"){

			$opt = "<option value=\"\">选择人员</option>";
			$users = $counts->tags("ctype=users&godate=$godate&todate=$todate");
			if($users){
				foreach($users AS $rs){
					if($rs["userid"]){
						$opt.= "<option value=\"".$rs["userid"]."\">".$rs["worknum"]."_".$rs["name"]."</option>";
					}
				}
			}
			echo $opt;
			exit;

		}else{

			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$users = $counts->tags("ctype=users&godate=$godate&todate=$todate");
			$this->tpl->set("users",$users);
			$this->tpl->set("type","iframe");

		}

		$this->tpl->display("counts.tags.php");


	}


	Public function spare()
	{


		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$counts = getModel("counts");


		$spare = getModel("spare");
		extract($_GET);
		$show = $_GET["show"];
		if($show=="info"){

			$cates = $spare->spacetype();
			$this->tpl->set("cates",$cates);
			$checktype = $spare->checktype();
			$this->tpl->set("checktype",$checktype);

			$afters = $counts->spare("ctype=after&godate=$godate&todate=todate&afterarea=$afterarea&afterid=$afterid");
			if($afters){
				$arr = array();
				foreach($afters AS $ars){

					$aid = (int)$ars["afterid"];
					foreach($checktype AS $crs){
						$checked = (int)$crs["id"];
						$ars[$crs["id"]]["nums"] = $counts->spare("ctype=nums&godate=$godate&todate=todate&afterid=$aid&checked=$checked");
					}

					$ars["pricenum"] = $counts->spare("ctype=price&godate=$godate&todate=todate&afterid=$aid");
					$ars["ordernum"] = $counts->spare("ctype=order&godate=$godate&todate=todate&afterid=$aid");

					$arr[] = $ars;
				}
				$afters = $arr;
			}
			$this->tpl->set("afters",$afters);


			$product = $counts->spare("ctype=product&godate=$godate&todate=todate&afterarea=$afterarea&afterid=$afterid");
			if($product){
				$arr = array();
				foreach($product AS $ars){

					$productid = (int)$ars["productid"];
					foreach($cates AS $crs){
						$cateid = (int)$crs["id"];
						$ars[$crs["id"]]["nums"] = $counts->spare("ctype=nums&godate=$godate&todate=todate&afterarea=$afterarea&afterid=$afterid&productid=$productid&cateid=$cateid");
					}

					//$ars["pricenum"] = $counts->spare("ctype=price&godate=$godate&todate=todate&afterarea=$afterarea&afterid=$afterid&productid=$productid");
					$ars["ordernum"] = $counts->spare("ctype=order&godate=$godate&todate=todate&afterarea=$afterarea&afterid=$afterid&productid=$productid");

					$arr[] = $ars;
				}
				$product = $arr;
			}
			$this->tpl->set("product",$product);



			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[备件记录统计]&detail=查看了[备件统计]&sqlstr=$logsarr");

			$this->tpl->set("show","info");

		}else{

			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("show","iframe");

		}

		$this->tpl->display("counts.spare.php");

	}


	Public function enjobs()
	{

		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		if($show){

			extract($_GET);
			$counts = getModel("counts");


			$jobs	= getModel("jobs");

			$users	= $counts->enjobs("ctype=users&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid");
			//print_r($users);exit;
			if($users){

				$all = array();
				foreach($users AS $rs){


					$arr = array();
					$arr["name"]	=	$rs["name"];
					$arr["worknum"]	=	$rs["worknum"];
					$afteruserid	=	(int)$rs["userid"];
					//累积工单
					$arr["alljobs"] = $counts->enjobs("ctype=counts&godate=$godate&todate=$todate&afteruserid=$afteruserid");
					//取消工单
					$arr["closejobs"] = $counts->enjobs("ctype=counts&worked=4&godate=$godate&todate=$todate&afteruserid=$afteruserid");
					//安装工单
					$arr["anjobs"] = $counts->enjobs("ctype=counts&type=2&godate=$godate&todate=$todate&afteruserid=$afteruserid");
					//耗材工单
					$arr["tcjobs"] = $counts->enjobs("ctype=counts&type=6&godate=$godate&todate=$todate&afteruserid=$afteruserid");
					//维修工单
					$arr["wxjobs"] = $counts->enjobs("ctype=counts&type=5&godate=$godate&todate=$todate&afteruserid=$afteruserid");
					//其它工单
					$arr["qtjobs"] = $counts->enjobs("ctype=counts&type=0&godate=$godate&todate=$todate&afteruserid=$afteruserid");
					//申请金额
					$arr["charge"] = $counts->enjobs("ctype=price&val=charge&godate=$godate&todate=$todate&afteruserid=$afteruserid");
					//结算金额
					$encharge = $counts->enjobs("ctype=price&val=encharge&godate=$godate&todate=$todate&afteruserid=$afteruserid");
					//$ensetup = $counts->enjobs("ctype=price&val=ensetup&godate=$godate&todate=$todate&afteruserid=$afteruserid");
					//$enlong = $counts->enjobs("ctype=price&val=enlong&godate=$godate&todate=$todate&afteruserid=$afteruserid");
					$arr["encharge"] = round($encharge,2);

					$all[]	=	$arr;
				}
				$this->tpl->set("data",$all);
			}

			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=query&ordersid=0&name=统计系统[结算统计]&detail=查看了[结算统计]&sqlstr=$logsarr");

			$this->tpl->set("type","show");
		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("type","iframe");
		}
		$this->tpl->display("counts.enjobs.php");

	}


	//服务平台供应商统计
	Public function seller()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		$counts = getModel("counts");

		extract($_GET);

		if($show=="info"){
			$rows = $counts->seller("godate=$godate&todate=$todate&sellercode=$sellercode");

			$this->tpl->set("data",$rows);
			$this->tpl->set("type","info");
		}else{

			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$this->tpl->set("type","iframe");
		}
		$this->tpl->display("counts.seller.php");
    }



	//云净均摊表
	public function yuncharge()
	{
			$this->users->onlogin();    //登录判断
			$this->users->pagelevel();    //权限判断

			$show = $_GET['show'];

			if ($show == 'info') {
					$counts = getModel("counts");
					ini_set('memory_limit', '3000M');
					extract($_GET);
					$arr = array();
					$arr["allnums"] = $counts->yuncharge("ctype=nums&monthdate=$monthdate");	//总客户数
					$arr["nums"]		= $counts->yuncharge("ctype=nums&monthdate=$monthdate&status=1");	//有效客户数
					$arr["homenums"]= $counts->yuncharge("ctype=nums&monthdate=$monthdate&customstype=1&status=1"); //家用有效
					$arr["biznums"] = $counts->yuncharge("ctype=nums&monthdate=$monthdate&customstype=2&status=1");	//商用有效
					$arr["allnums"] = $counts->yuncharge("ctype=price&monthdate=$monthdate");	//总客户数
					$arr["price"]		= $counts->yuncharge("ctype=price&monthdate=$monthdate&status=1");	//有效客户数
					$arr["homeprice"]= $counts->yuncharge("ctype=price&monthdate=$monthdate&customstype=1&status=1"); //家用有效
					$arr["bizprice"] = $counts->yuncharge("ctype=price&monthdate=$monthdate&customstype=2&status=1");	//商用有效
					$sales = $counts->yuncharge("ctype=sales&monthdate=$monthdate&status=1");
					if($sales){
							$s = array();
							//print_r($sales);exit;
							foreach($sales AS $rs){
									$salesid = (int)$rs["id"];
									$rs["nums"]		 = $counts->yuncharge("ctype=nums&salesid=$salesid&monthdate=$monthdate&status=1");	//有效客户数
									$rs["homenums"]= $counts->yuncharge("ctype=nums&salesid=$salesid&monthdate=$monthdate&customstype=1&status=1"); //家用有效
									$rs["biznums"] = $counts->yuncharge("ctype=nums&salesid=$salesid&monthdate=$monthdate&customstype=2&status=1");	//商用有效
									$rs["price"]	 = $counts->yuncharge("ctype=price&salesid=$salesid&monthdate=$monthdate&status=1");	//有效客户数
									$rs["homeprice"]= $counts->yuncharge("ctype=price&salesid=$salesid&monthdate=$monthdate&customstype=1&status=1"); //家用有效
									$rs["bizprice"] = $counts->yuncharge("ctype=price&salesid=$salesid&monthdate=$monthdate&customstype=2&status=1");	//商用有效
									$s[] = $rs;
							}
							$arr["sales"] = $s;
					}
					$this->tpl->set("counts",$arr);
			}else{

			}
			$this->tpl->set("show",$show);
			$this->tpl->display("counts.yuncharge.php");
	}

	//工单监控统计
	Public function jobsmonitor()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$show = $_GET["show"];
		$counts = getModel("counts");
		$jobs = getModel("jobs");

		$worktype = $jobs->worktype();
		$this->tpl->set("worked",$worktype);

		$jobstype = $jobs->jobstype();
		$this->tpl->set("jobstype",$jobstype);

		if($show=="lists")
		{
			extract($_GET);
			$rows = $counts->jobsmonitor("provid=$provid&cityid=$cityid&areaid=$areaid&worked=$worked&ordersid=$ordersid&jobsid=$jobsid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&afterarea=$afterarea&afterid=$afterid");
			$this->tpl->set("rows",$rows["record"]);
			$this->tpl->set("page",$rows["pages"]);

		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);

		}
		$this->tpl->set("show",$show);
		$this->tpl->display("counts.jobs.monitor.php");
	}


}
?>
