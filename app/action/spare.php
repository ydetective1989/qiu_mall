<?php
class spareAction extends Action
{

	Public function add()
	{

		$this->users->dialoglogin();		//登录判断
		$this->users->dialoglevel();		//权限判断

		$spare = getModel("spare");
		//处理ID
		$id = (int)base64_decode($_GET["id"]);
		
		if(isset($_POST)&&!empty($_POST))
		{
			$spare->ordersid = $id;
			$spare->add();
			echo "1";
		}else{
			$this->tpl->set("ordersid",$id);
			$product = getModel("product");
			$brand = $product->brand();
			$this->tpl->set("brand",$brand);
			$cates = $spare->spacetype();
			$this->tpl->set("cates",$cates);
			$this->tpl->set("type","addspare");
			$this->tpl->display("spare.dialog.php");
		}
	}
	
	Public function info()
	{

		$this->users->dialoglogin();		//登录判断
		$this->users->dialoglevel();		//权限判断

		//处理ID
		$id = (int)base64_decode($_GET["id"]);
		$spare = getModel("spare");

		if(isset($_POST)&&!empty($_POST))
		{
			$ordersid = (int)base64_decode($_POST["ordersid"]);
			$spare->ordersid = $ordersid;
			$spare->id = $id;
			$spare->info();
			echo "1";
		}else{
			$info = $spare->getrow("id=$id");
			$timeline = time()-21600;	//计算前一天
			$userid = (int)$this->cookie->get("userid");
			$isadmin = $this->users->isadmin();	//判断是否管理员
			$islevel = $this->users->getlevel();	//判断页面权限
			if($info["userid"]!=$userid&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限操作（非您录入）"); }
			if($info["checked"]!="0"&&$isadmin!=1&&!$islevel){ dialog("抱歉，记录已审核无法进行操作！"); }
			$this->tpl->set("info",$info);
			$cates = $spare->spacetype();
			$this->tpl->set("cates",$cates);
			$this->tpl->set("type","info");
			$this->tpl->display("spare.dialog.php");
		}
		
	}
	
	Public function del()
	{

		$this->users->dialoglogin();		//登录判断
		$this->users->dialoglevel();		//权限判断

		//处理ID
		$id = (int)base64_decode($_GET["id"]);
		$spare = getModel("spare");

		$info = $spare->getrow("id=$id");
		$timeline = time()-21600;	//计算前一天
		$userid = (int)$this->cookie->get("userid");
		$isadmin = $this->users->isadmin();	//判断是否管理员
		$islevel = $this->users->getlevel();	//判断页面权限
		if($info["userid"]!=$userid&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限进行操作！"); }
		if($info["dateline"]<$timeline&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限进行操作！"); }
		$spare->id = $id;
		$spare->ordersid = $info["ordersid"];
		$spare->del();
		echo 1;
	}
	
	
	//记录
	Public function lists()
	{
		$this->users->onlogin();		//登录判断
		$spare = getModel("spare");
		$orders = getModel("orders");
		//处理ID
		$id = (int)base64_decode($_GET["id"]);
		$checktype = $spare->checktype();
		$this->tpl->set("checktype",$checktype);
		$info = $orders->getrow("id=$id");
		if($info["parentid"]=="0"){ $parented = "1"; }
		$list = $spare->getrows("parented=$parented&ordersid=$id&nums=5&page=1&show=2");
		$cates = $spare->spacetype();
		$this->tpl->set("cates",$cates);
		$this->tpl->set("list",$list["record"]);
		$this->tpl->set("page",$list["pages"]);
		$this->tpl->set("type","lists");
		$this->tpl->display("spare.dialog.php");
		
	}
	
	
	//审核
	Public function checked()
	{
		
		$show = $_GET["show"];
		$spare = getModel("spare");
		if($show=="checked"){
			
			$this->users->dialoglogin();		//登录判断
			$this->users->dialoglevel();		//权限判断
			

			$timeline = time()-21600;	//计算前一天
			$userid = (int)$this->cookie->get("userid");
			$isadmin = $this->users->isadmin();	//判断是否管理员
			if($info["checkuserid"]!=$userid&&$isadmin!=1&&!$islevel){ dialog("抱歉，你没有权限进行操作！"); }
			if($info["dateline"]<$timeline&&$isadmin!=1&&!$islevel){ dialog("抱歉，超过有效时限无法进行修改！"); }

			//处理ID
			$id = (int)base64_decode($_GET["id"]);			
			if(isset($_POST)&&!empty($_POST))
			{
				$spare->id = $id;
				$spare->checked();
				echo "1";
				
			}else{
				
				$info = $spare->getrow("id=$id");
				$this->tpl->set("info",$info);

				$cates = $spare->spacetype();
				$this->tpl->set("cates",$cates);
				
				$this->tpl->set("show","checked");
				$this->tpl->display("spare.dialog.php");
			}
			
		}elseif($show=="xls"){

			$this->users->onlogin();			//登录判断
			$this->users->pagelevel();			//权限判断
			extract($_GET);
			$rows = $spare->charge("xls=1&checked=$checked&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid");
			
			if($rows){

				//print_r($rows);exit; 
				$check = $spare->checktype();
				$cates = $spare->spacetype();

				$xls = getFunc("excel");
				$data = array();
				$data[] = array('订单编号','使用性质','备件编号','备件名称','使用数量','批注','归属服务中心','操作时间','操作人','审核状态');
				foreach($rows AS $rs){
					$catesed = $cates[$rs["cateid"]]["name"];
					$checked = $check[$rs["checked"]]["name"];
					$data[]=array($rs["ordersid"],$catesed,$rs["encode"],$rs["title"],$rs["nums"],$rs["detail"],$rs["aftername"],date("Y-m-d H:i",$rs["dateline"]),$rs["addname"],$checked);
				}
				$xls->addArray($data);
				$xls->generateXML("spare");
				
			}

			
		}elseif($show=="lists"){
			
			$this->users->onlogin();			//登录判断
			$this->users->pagelevel();			//权限判断
			extract($_GET);
			$rows = $spare->charge("page=1&checked=$checked&godate=$godate&todate=$todate&afterarea=$afterarea&afterid=$afterid");
			$this->tpl->set("list",$rows["record"]);
			$this->tpl->set("page",$rows["pages"]);
			$cates = $spare->spacetype();
			$this->tpl->set("cates",$cates);
			$this->tpl->set("show","lists");
			$this->tpl->display("spare.lists.php");
			
		}else{
			
			$this->users->onlogin();			//登录判断
			$this->users->pagelevel();			//权限判断

			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);

			$this->tpl->set("show","iframe");
			$this->tpl->display("spare.lists.php");
			
		}
	}
	
	
	
	
	
	
	
}
?>