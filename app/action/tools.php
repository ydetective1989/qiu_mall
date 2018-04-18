<?php
class toolsAction extends Action
{

	//日志记录
	Public function logs()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断
		$logs = getModel("logs");
		$show = $_GET["show"];
		if($show=="1"){
			extract($_GET);
			if(!$godate&&!$todate){
				$date = plugin::getTheMonth(date("Y-m",time()));
				$godate = $date[0];
				$todate = $date[1];
			}
			$list = $logs->getrows("godate=$godate&todate=$todate&name=$name&cateid=$cateid&keyword=$keyword");
			//print_r($list);
			$this->tpl->set("list",$list["record"]);
			$this->tpl->set("page",$list["pages"]);
			$this->tpl->set("type","list");
			$this->tpl->display("tools.logs.php");
		}elseif($show=="2"){
			$id = base64_decode($_GET["id"]);
			$info = $logs->getrow("id=$id");
			$this->tpl->set("info",$info);
			$this->tpl->set("type","show");
			$this->tpl->display("tools.logs.php");
		}elseif($show=="3"){

			extract($_GET);

			ini_set("memory_limit","2000M");

			if(!$godate&&!$todate){
				$date = plugin::getTheMonth(date("Y-m",time()));
				$godate = $date[0];
				$todate = $date[1];
			}
			$list = $logs->getrows("xls=1&godate=$godate&todate=$todate&name=$name&cateid=$cateid&keyword=$keyword&desc=ASC&order=dateline");

			if($list){
				$xls = getFunc("excel");
				$data = array();
				$data[] = array('操作人','操作类别','关联订单号','操作内容','操作时间','IP');
				foreach($list AS $rs){
					$data[]=array($rs["userid"],$rs["name"],$rs["ordersid"],$rs["detail"],date("Y-m-d H:i:s",$rs["dateline"]),$rs["ip"]);
				}
				$xls->addArray($data);
				$xls->generateXML("logs.xls");
			}

		}else{
			$date = plugin::getTheMonth(date("Y-m",time()));
			$godate = $date[0];
			$todate = $date[1];
			$this->tpl->set("godate",$godate);
			$this->tpl->set("todate",$todate);
			$namelist = $logs->namelist();
			$this->tpl->set("namelist",$namelist);
			$this->tpl->set("type","iframe");
			$this->tpl->display("tools.logs.php");
		}
	}

}
?>
