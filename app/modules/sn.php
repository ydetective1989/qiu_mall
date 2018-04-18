<?php
class snModules extends Modules
{

	Public function add()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$userid = $this->cookie->get("userid");
		$arr = array(
			'ordersid'	=> (int)$ordersid,
			'sn'				=> $sn,
			'tags'			=> "YWS",
			'detail'		=> $detail,
			'userid'		=> $userid,
			'dateline'	=> time()
		);
		$logsarr.= plugin::arrtostr($arr);
		$this->db->insert(DB_ORDERS.".orders_sn",$arr);
		$id = $this->db->getLastInsId();

		$jobsid = (int)$jobsid;
		if($jobsid){
			$jobs = getModel("jobs");
			$jobs->tasked("type=2&jobsid=$jobsid"); //将最后一个工单的收款任务标为完成
		}

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=订单操作[序列号]&detail=添加订单[".$ordersid."]的序列号记录#".$id."&sqlstr=".$logsarr."");
		return 1;
	}

	Public function edit()
	{
		extract($_POST);
		$id = (int)$this->id;
		$ordersid = (int)$this->ordersid;
		$where = array("id"=>$id);
		$arr = array(
			'sn'		=> $sn,
			'detail'	=> $detail
		);
		$logsarr.= plugin::arrtostr($arr);
		$this->db->update(DB_ORDERS.".orders_sn",$arr,$where);

		$jobsid = (int)$jobsid;
		if($jobsid){
			$jobs = getModel("jobs");
			$jobs->tasked("type=2&jobsid=$jobsid"); //将最后一个工单的收款任务标为完成
		}

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=订单操作[序列号]&detail=修改订单[".$ordersid."]的序列号记录#".$id."&sqlstr=".$logsarr."");
		return 1;
	}

	Public function del()
	{
		$id = (int)$this->id;
		$ordersid = (int)$this->ordersid;
		$where = array("id"=>$id);
		$arr = array(
			'hide'		=> 0
		);
		$logsarr.= plugin::arrtostr($arr);
		$this->db->update(DB_ORDERS.".orders_sn",$arr,$where);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=订单操作[序列号]&detail=删除订单[".$ordersid."]的序列号记录#".$id."&sqlstr=".$logsarr."");

		return 1;
	}

	Public function getrow($str=""){

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		$query = " SELECT * FROM ".DB_ORDERS.".orders_sn WHERE hide = 1 AND id = $id ";
		$row = $this->db->getRow($query);
		return $row;

	}

	Public function getrows($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($ordersid!=""){
			$ordersid = (int)$ordersid;
			$where.=" AND s.ordersid = $ordersid ";
		}

		if($desc=="DESC"){ $desc="DESC"; }else{ $desc="ASC"; }
		switch($order){
			case "dateline" : $order = " s.dateline $desc,"; break;
			default : $order = "";
		}

		if($nums){
			$nums = (int)$nums;
		}else{
			$nums = "10";
		}

		$query = " SELECT s.*,au.name AS addname
		FROM ".DB_ORDERS.".orders_sn AS s
		INNER JOIN ".DB_ORDERS.".users AS au ON au.userid = s.userid
		WHERE s.hide = 1 $where
		ORDER BY $order s.id DESC ";

		if($page){
			$this->db->keyid = "s.id";
			$show = (int)$show;
			$rows = $this->db->getPageRows($query,$nums,$show);
		}else{
			if((int)$xls=="0"){
				$start = ($start)?(int)$start:"0";
				$limt = " LIMIT $start,$nums ";
				$rows = $this->db->getRows($query.$limt);
			}else{
				$xdb = xdb();
				$rows = $xdb->getRows($query);
			}
		}
		//print_r($rows);
		return $rows;


	}

}
?>
