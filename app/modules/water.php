<?php
class waterModules extends Modules
{
	
	Public function add()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$userid = $this->cookie->get("userid");
		$arr = array(
			'ordersid'	=> (int)$ordersid,
			'wp'		=> round($wp,2),
			'otds'		=> round($otds,0),
			'tds'		=> round($tds,0),
			'ohard'		=> round($ohard,2),
			'hard'		=> round($hard,2),
			'orc'		=> round($orc,2),
			'rc'		=> round($rc,2),
			'other'		=> $other,
			'userid'	=> $userid,
			'dateline'	=> time()
		);
		$logsarr.= plugin::arrtostr($arr);
		$this->db->insert(DB_ORDERS.".orders_water",$arr);
		return 1;
	}
	
	Public function edit()
	{
		extract($_POST);
		$id = (int)$this->id;
		$ordersid = (int)$this->ordersid;
		$where = array("id"=>$id);
		$userid = $this->cookie->get("userid");
		$arr = array(
			'wp'		=> $wp,
			'otds'		=> $otds,
			'tds'		=> $tds,
			'ohard'		=> $ohard,
			'hard'		=> $hard,
			'orc'		=> $orc,
			'rc'		=> $rc,
			'other'		=> $other,
			'userid'	=> $userid,
			'dateline'	=> time()
		);
		$logsarr.= plugin::arrtostr($arr);
		$this->db->update(DB_ORDERS.".orders_water",$arr,$where);
		return 1;
	}
	
	Public function del()
	{
		$id = (int)$this->id;
		$where = array("id"=>$id);
		$arr = array(
			'hide'		=> 0
		);
		$logsarr.= plugin::arrtostr($arr);
		$this->db->update(DB_ORDERS.".orders_water",$arr,$where);
		return 1;
	}
	
	Public function getrow($str=""){

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		$query = " SELECT * FROM ".DB_ORDERS.".orders_water WHERE hide = 1 AND id = $id ";
		$row = $this->db->getRow($query);
		return $row;
		
	}
	
	Public function getrows($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		
		if($ordersid!=""){
			$ordersid = (int)$ordersid;
			$where.=" AND w.ordersid = $ordersid ";
		}

		if($desc=="DESC"){ $desc="DESC"; }else{ $desc="ASC"; }
		switch($order){
			case "dateline" : $order = " w.dateline $desc,"; break;
			default : $order = "";
		}
		
		if($nums){
			$nums = (int)$nums;
		}else{
			$nums = "10";
		}
		
		$query = " SELECT w.*,au.name AS addname
		FROM ".DB_ORDERS.".orders_water AS w
		INNER JOIN ".DB_ORDERS.".users AS au ON au.userid = w.userid
		WHERE w.hide = 1 $where 
		ORDER BY $order w.id DESC ";
		
		if($page){
			$this->db->keyid = "w.id";
			$show = (int)$show;
			$rows = $this->db->getPageRows($query,$nums,$show);
		}else{
			if((int)$xls=="0"){
				$start = ($start)?(int)$start:"0";
				$limt = " LIMIT $start,$nums ";
			}
			$rows = $this->db->getRows($query.$limt);
		}
		//print_r($rows);
		return $rows;
		
		
	}

}
?>