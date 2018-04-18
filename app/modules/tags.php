<?php
class tagsModules extends Modules
{

	//增加标签
	Public function tag_add()
	{
		$ordersid	  = $_POST["ordersid"];
		$tagid		  = $_POST["tagid"];
		$userid = (int)$this->cookie->get("userid");
		$arr = array("ordersid"=>$ordersid,"tagid"=>$tagid,"userid"=>$userid,"dateline"=>time());
		$this->db->insert(DB_ORDERS.".orders_tags",$arr);
		$logsarr = plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=客户标签[增加]&detail=增加订单[".$ordersid."]标签".$tagid."&sqlstr=$logsarr");

	}

	//删除标签
	Public function tag_del()
	{
		$ordersid	= $_POST["ordersid"];
		$tagid		= $_POST["tagid"];
		$arr = array("hide"=>"0");
		$where = array("ordersid"=>$ordersid,"tagid"=>$tagid);
		$this->db->update(DB_ORDERS.".orders_tags",$arr,$where);
		$logsarr = plugin::arrtostr($where);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=客户标签[删除]&detail=删除订单[".$ordersid."]标签".$tagid."&sqlstr=$logsarr");
	}


	Public function taglist($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($alled=="1"){
			$where = " AND parentid > 0 ";
		}else{
			$parentid = (int)$parentid;
			$where = " AND parentid = $parentid ";
		}
		$query = "SELECT t.id,t.name,t.admed
		FROM ".DB_ORDERS.".config_orders_tag AS t
		WHERE t.hide = 1 $where
		ORDER BY admed DESC,t.id ASC ";
		return $this->db->getRows($query);

	}

	Public function tags($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$parentid = (int)$parentid;
		if($ordersid){
			$ordersid = (int)$ordersid;
			$where.=" AND ct.ordersid = $ordersid ";
		}
		$query = "SELECT t.id,t.name,t.admed
		FROM ".DB_ORDERS.".config_orders_tag AS t
		WHERE t.hide = 1 AND t.parentid = $parentid $where
		ORDER BY t.id ASC ";
		return $this->db->getRows($query);
	}

	Public function taginfo($str=""){

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		$query = "SELECT * FROM ".DB_ORDERS.".config_orders_tag WHERE id = $id ";
		return $this->db->getRow($query);

	}

	Public function mytags($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$ordersid = (int)$ordersid;
		$timeout   = time();
		$query = "SELECT t.id,t.name,t.admed
		FROM ".DB_ORDERS.".orders_tags AS cc
		INNER JOIN ".DB_ORDERS.".config_orders_tag AS t ON t.id = cc.tagid
		WHERE cc.hide AND t.hide = 1  AND (cc.timeout > $timeout OR cc.timeout = 0 ) AND cc.ordersid = $ordersid
		ORDER BY t.id ASC ";
		return $this->db->getRows($query);
	}

	Public function tagsed($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$info = $this->taginfo("id=$tagid");
		$logs = getModel('logs');
		if($do=="add"){
			$where = array("ordersid"=>$ordersid,"tagid"=>$tagid);
			$this->db->delete(DB_ORDERS.".orders_tags",$where);
			if($info["volid"]){ $timeout = time()+$info["volid"]*86400; }
			$arr = array(
				"ordersid"	=>	$ordersid,
				"tagid"		=>	$tagid,
				"userid"	=>	(int)$this->cookie->get("userid"),
				"dateline"	=>	time(),
				"timeout"	=>	(int)$timeout
			);
			//print_r($arr);exit;
			$this->db->insert(DB_ORDERS.".orders_tags",$arr);
			$logsarr = plugin::arrtostr($arr);
			$logs->insert("type=insert&ordersid=$ordersid&name=客户标签[增加]&detail=增加订单[".$ordersid."]标签".$tagid."&sqlstr=$logsarr");
		}elseif($do=="del"){
			$arr = array("hide"=>"0");
			$where = array("ordersid"=>$ordersid,"tagid"=>$tagid);
			$this->db->update(DB_ORDERS.".orders_tags",$arr,$where);
			$logsarr = plugin::arrtostr($arr);
			$logs->insert("type=insert&ordersid=$ordersid&name=客户标签[删除]&detail=删除订单[".$ordersid."]标签".$tagid."&sqlstr=$logsarr");
		}

	}

}
?>
