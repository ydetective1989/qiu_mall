<?php
class focusModules extends Modules
{

	//检查关注
	Public function status($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$userid = (int)$this->cookie->get("userid");
		$cates	= $this->cates($cates);
		$id = (int)$id;
		$sql  = "SELECT id,userid,dateline
		FROM ".DB_ORDERS.".focus_".$cates."
		WHERE hide = 1 AND id = $id AND userid = $userid ";
		$data = $this->db->getRow($sql);
		return $data;
	}

    //删除全部关注
    Public function cleard($str="")
    {
        $str = plugin::extstr($str);//处理字符串
        extract($str);
        $userid = (int)$this->cookie->get("userid");
        $cates	= $this->cates($cates);
        $where  = array("userid"=>$userid);
        $this->db->delete(DB_ORDERS.".focus_".$cates,$where);
        return 1;
    }

	//增加关注
	Public function addfav($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($userid==""){
			$userid = (int)$this->cookie->get("userid");
		}else{
			$userid = (int)$userid;
		}

		$cates	= $this->cates($cates);
		$where	= array("userid"=>$userid,"id"=>$id);
		$this->db->delete(DB_ORDERS.".focus_".$cates,$where);

		$arr	= array("userid"=>$userid,"id"=>$id,"dateline"=>time());
		$this->db->insert(DB_ORDERS.".focus_".$cates,$arr);
		return 1;
	}

	//取消关注
	Public function channel($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$userid = (int)$this->cookie->get("userid");
		$where	= array("userid"=>$userid,"id"=>$id);
		$cates	= $this->cates($cates);
		$this->db->delete(DB_ORDERS.".focus_".$cates,$where);
		return 1;
	}



	public function invoice($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$userid = (int)$this->cookie->get("userid");

		$show = ($show)?$show:"2";
		$nums = ($nums)?$nums:"5";

		$query = " SELECT i.id,i.ordersid AS ordersid,i.price,i.checked,i.worked,
		o.price AS oprice,o.status
		FROM ".DB_ORDERS.".focus_invoice AS fi
		INNER JOIN ".DB_ORDERS.".invoice AS i ON fi.id = i.id
		INNER JOIN ".DB_ORDERS.".orders AS o ON i.ordersid = o.id
		WHERE fi.userid = $userid AND i.hide = 1
		GROUP BY fi.id	ORDER BY fi.dateline DESC ";
		$rows = $this->db->getPageRows($query,$nums,$show);
		if($rows){
			//print_r($rows);
			$data	=	$arr	=	array();
			$record = $rows["record"];
			$pages	= $rows["pages"];

			foreach($record AS $rs){

				$ordersid	=	(int)$rs["ordersid"];

				//物流信息
				$query = " SELECT e.id,e.cateid,ce.name AS expname,e.numbers
				FROM ".DB_ORDERS.".orders_express AS e
				INNER JOIN ".DB_ORDERS.".config_express AS ce ON e.cateid = ce.id
				WHERE e.hide = 1 AND e.type = 2 AND e.ordersid = $ordersid ORDER BY e.id DESC ";
				$row = $this->db->getRow($query);
				$rs["express"]	= $row;

				$arr[]	=	$rs;

			}
			//print_r($arr);
			$data["record"] = $arr;
			$data["pages"]	= $pages;
			$rows = $data;
		}
		return $rows;
	}

	Public function orders($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$userid = (int)$this->cookie->get("userid");

		$show = ($show)?$show:"2";
		$nums = ($nums)?$nums:"5";

		$query = " SELECT o.id AS ordersid,o.ordernum,o.datetime,o.status,o.paystate,o.price,o.type AS otype
		FROM ".DB_ORDERS.".focus_orders AS fo
		INNER JOIN ".DB_ORDERS.".orders AS o ON fo.id = o.id
		WHERE fo.userid = $userid AND o.hide = 1
		GROUP BY fo.id	ORDER BY fo.dateline DESC ";
		$rows = $this->db->getPageRows($query,$nums,$show);
		//print_r($rows);exit;

		if($rows){

			$data	=	$arr	=	array();
			$record = $rows["record"];
			$pages	= $rows["pages"];

			foreach($record AS $rs){
				$ordersid	=	(int)$rs["ordersid"];

				$rs["charge"]	= $rs["price"];

				//是否派工
				$query = " SELECT id FROM ".DB_ORDERS.".job_orders WHERE hide = 1 AND type = 2 ";
				$row = $this->db->getRow($query);
				$rs["jobsed"]	= (int)$row["id"];
				$arr[]	=	$rs;
			}
			//print_r($arr);
			$data["record"] = $arr;
			$data["pages"]	= $pages;
			$rows = $data;
		}
		return $rows;
	}

	Public function jobs($str="")
	{
		//工单号 日期 订单号 订单状态 服务中心  工单状态  服务人员  派工人  取消

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$userid = (int)$this->cookie->get("userid");

		$show = ($show)?$show:"2";
		$nums = ($nums)?$nums:"5";

		$query = " SELECT jobs.id AS jobsid,jobs.jobnum,jobs.type,jobs.datetime,jobs.ordersid,jobs.checked,jobs.worked,
		o.status,at.name AS aftername,au.name AS addname,su.name AS afteruname
		FROM ".DB_ORDERS.".focus_jobs AS fj
		INNER JOIN ".DB_ORDERS.".job_orders AS jobs ON fj.id = jobs.id
		INNER JOIN ".DB_ORDERS.".orders AS o ON jobs.ordersid = o.id
		INNER JOIN ".DB_ORDERS.".config_teams AS at ON jobs.afterid = at.id
		INNER JOIN ".DB_ORDERS.".users AS au ON jobs.adduserid = au.userid
		INNER JOIN ".DB_ORDERS.".users AS su ON jobs.afteruserid = su.userid
		WHERE fj.userid = $userid AND jobs.hide = 1
		GROUP BY fj.id	ORDER BY fj.dateline DESC ";
		$rows = $this->db->getPageRows($query,$nums,$show);
		return $rows;
	}

	//关注源检测
	Public function cates($cates)
	{

		switch($cates){
			case "ts":	$cates = "complaint";	break;
			case "gd":	$cates = "jobs";		break;
			case "fp":	$cates = "invoice";		break;
			case "wl":	$cates = "express";		break;
			default:	$cates = "orders";
		}
		return $cates;
	}

}
?>
