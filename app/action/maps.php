<?php
class mapsAction extends Action
{

	Public function app()
	{

	}

	//地图
	Public function dialog()
	{
		$this->users->dialoglogin();		//登录判断
		$this->tpl->display("maps.dialog.php");
	}


	Public function orders()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$maps = getModel("maps");
		$show   = $_GET["show"];
		$provid = $_GET["provid"];
		$cityid = $_GET["cityid"];
		$areaid = $_GET["areaid"];
		if($show=="lists"){
			$pointarr = $_GET["pointarr"];
			$workrows = $maps->orders("provid=$provid&cityid=$cityid&areaid=$areaid&pointarr=$pointarr");
			if($workrows){
				$arra = array();
				foreach($workrows AS $rs){
					$rw = array();
					switch($rs["checked"]){
						case "1" : $type = 1; $bgcolor="#990000"; $color="#FFF"; break; //安装
						default  : $type = 0; $bgcolor="#cc00cc"; $color="#FFF";	     //其它
					}
					//if($rs["checked"]=="0"){ $checked = "<a class='pointer' onclick='vieworder('".base64_encode($rs["ordersid"])."');'>[查看订单]</a>"; }
					$revise = "<a class='pointer' onclick='vieworder('".base64_encode($rs["ordersid"])."');'>[查询工单]</a>";
					$rw["title"]   = $rs["name"];
					$rw["ordersid"]= $rs["ordersid"];
					$rw["id"]  		= base64_encode($rs["ordersid"]);
					$ordersid			= $rw["id"];
					$rw["type"]    = $type;
					$rw["bgcolor"] = $bgcolor;
					$rw["color"]   = $color;
					$mobile        = ($rs["mobile"])?"<br>手机：".$rs["mobile"]:"";
					$phone         = ($rs["phone"])?"<br>电话：".$rs["phone"]:"";
					$rw["content"] = $rs["address"].$mobile.$phone."<br>购买日期：".$rs["datetime"].$revise;
					$rw["point"]   = $rs["pointlng"]."|".$rs["pointlat"];
					$rw["isOpen"]  = "0";
					$rw["icon"]    = array("t"=>"0","w"=>"15","h"=>"23");
					$arra[] = $rw;
				}
				$arrs = $arra;
				echo json_encode($arrs);
			}else{
				echo "";
			}
		}elseif($show=="maps"){
				$row = $maps->orders("pointed=1&provid=$provid&cityid=$cityid&areaid=$areaid");
				//print_r($row);exit;
				$this->tpl->set("row",$row[0]);
				$this->tpl->set("show","maps");
				$this->tpl->display("maps.orders.php");
		}else{
				$this->tpl->display("maps.orders.php");
		}
	}

	Public function jobs()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$orders = getModel("orders");
		$jobs = getModel("jobs");
		$show = $_GET["show"];
		$afterid = $_GET["afterid"];
		$datetime = $_GET["datetime"];
		if($show=="lists"){
			$pointarr = $_GET["pointarr"];
			$workrows = $jobs->maprows("joblist=1&afterid=$afterid&datetime=$datetime&pointarr=$pointarr");
			if($workrows){
				$arra = array();
				foreach($workrows AS $rs){
					$rw = array();
					switch($rs["type"]){
						case "2" : $type = 1; $bgcolor="#990000"; $color="#FFF"; break; //安装
						case "5" : $type = 2; $bgcolor="#996600"; $color="#FFF"; break; //维修
						case "6" : $type = 3; $bgcolor="#006600"; $color="#FFF"; break; //耗材
						default  : $type = 0; $bgcolor="#cc00cc"; $color="#FFF";	     //其它
					}

					if($rs["checked"]=="0"){ $checked = "<a class='pointer' onclick='checkjobs('".base64_encode($rs["jobsid"])."');'>[确认工单]</a>"; }
					$revise = "<a class='pointer' onclick='revise('".base64_encode($rs["jobsid"])."');'>[调整工单]</a>";

					$rw["title"]   = $rs["datetime"]." ".$rs["ordersid"];
					$rw["ordersid"]= $rs["ordersid"];
					$rw["jobsid"]  = $rs["jobsid"];
					$rw["id"]  		= base64_encode($rs["jobsid"]);
					$rw["type"]    = $type;
					$rw["bgcolor"] = $bgcolor;
					$rw["color"]   = $color;
					$rw["content"] = $rs["detail"]."<br>".$revise;
					$rw["point"]   = $rs["pointlng"]."|".$rs["pointlat"];
					$rw["isOpen"]  = "0";
					$rw["icon"]    = array("t"=>"0","w"=>"15","h"=>"23");
					$arra[] = $rw;
				}
				$arrs = $arra;
				echo json_encode($arrs);
			}else{
				echo "";
			}

		}elseif($show=="maps"){
			$afterid = $_GET["afterid"];
			$datetime = $_GET["datetime"];
			$row = $jobs->maprows("pointed=1&joblist=1&afterid=$afterid&datetime=$datetime");
			//print_r($row);exit;
			$this->tpl->set("row",$row[0]);
			$this->tpl->set("show","maps");
			$this->tpl->display("maps.jobs.php");
		}else{
			$this->tpl->set("datetime",$datetime);
			$this->tpl->set("afterid",$afterid);
			$this->tpl->display("maps.jobs.php");
		}
	}

}
?>
