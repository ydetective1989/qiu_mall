<?php
class invoiceModules extends Modules
{

	//发票申请
	Public function add()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$userid = (int)$this->cookie->get("userid");
		$arr = array(
			'openid'		=> OPEN_ID,
			'cateid'		=> (int)$cateid,
			'ordersid'		=> (int)$ordersid,
			'title'			=> trim($title),
			'type'			=> (int)$type,
			'price'			=> @round($price,2),
			'detail'		=> trim($detail),
			'posted'		=> (int)$posted,
			'postname'		=> trim($postname),
			'cityname'		=> trim($cityname),
			'postaddress'	=> trim($postaddress),
			'postphone'		=> trim($postphone),
			'corpname'		=> trim($corpname),
			'corpaddress'	=> trim($corpaddress),
			'corptel'		=> $corptel,
			'corpnums'		=> $corpnums,
			'corpbank'		=> $corpbank,
			'dateline'		=> time(),
			'userid'		=> $userid
		);
		$logsarr.= plugin::arrtostr($arr);
		$this->db->insert(DB_ORDERS.".invoice",$arr);
		$id = (int)$this->db->getLastInsId();

		//默认加入关注
		$focus = getModel("focus");
		$focus->addfav("cates=fp&id=$id");

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=发票信息[增加]&detail=订单[".$ordersid."]申请发票#".$id."&sqlstr=$logsarr");
		return $id;
	}

	//发票修改
	Public function edit()
	{
		extract($_POST);
		$id = (int)$this->id;
		$ordersid = (int)$this->ordersid;
		$userid = (int)$this->cookie->get("userid");
		$arr = array(
			'cateid'		=> (int)$cateid,
			'ordersid'		=> (int)$ordersid,
			'title'			=> trim($title),
			'type'			=> (int)$type,
			'price'			=> @round($price,2),
			'detail'		=> trim($detail),
			'posted'		=> (int)$posted,
			'cityname'		=> trim($cityname),
			'postname'		=> trim($postname),
			'postaddress'	=> trim($postaddress),
			'postphone'		=> trim($postphone),
			'corpname'		=> trim($corpname),
			'corpaddress'	=> trim($corpaddress),
			'corptel'		=> $corptel,
			'corpnums'		=> $corpnums,
			'corpbank'		=> $corpbank,
			'checked'		=> 0,
			'checkdate'		=> NULL,
			'worked'		=> 0,
			'workinfo'		=> NULL
		);
		$logsarr.= plugin::arrtostr($arr);
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".invoice",$arr,$where);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=发票信息[修改]&detail=订单[".$ordersid."]发票信息#".$id."&sqlstr=$logsarr");
		return $id;
	}

	//发票信息
	Public function getrow($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		$query = " SELECT i.*,ci.name AS catename,au.name AS addname,cu.name AS checkname,wu.name AS workname
		FROM ".DB_ORDERS.".invoice AS i
		INNER JOIN ".DB_ORDERS.".config_invoice AS ci ON ci.id = i.cateid
		INNER JOIN ".DB_ORDERS.".users AS au ON i.userid = au.userid
		INNER JOIN ".DB_ORDERS.".users AS cu ON i.checkuserid = cu.userid
		INNER JOIN ".DB_ORDERS.".users AS wu ON i.workuserid = wu.userid
		WHERE i.openid = ".OPEN_ID." AND i.id = $id GROUP BY i.id ";
		$rows = $this->db->getRow($query);
		//print_r($rows);
		return $rows;
	}

	//发票列表
	public function getrows($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if($ordersid){
			$ordersid = (int)$ordersid;
			$where.=" AND i.ordersid = $ordersid ";
		}

		if(trim($sokey)<>""){
			switch($sotype){
				case "2": $where.=" AND i.worknums = '$sokey' "; break;
				case "3": $where.=" AND i.id = '$sokey' ";		 break;
				default	: $where.=" AND i.ordersid = '$sokey' ";
			}
		}

		if($type<>""){ $type = (int)$type; $where.=" AND i.type = '$type' "; }

		if($contract<>""){ $where.=" AND o.contract = '$contract' "; }
		//echo $ordersid;
		if(!$sokey&&!$ordersid&&!$contract){
			if($userid){
				$userid = (int)$userid; $where.=" AND i.userid = '$userid' ";
			}else{
				$gotime = time()-86400*33;
				$timewhere = " AND i.dateline > $gotime ";
			}
		}

		if($ochecked!=""){
			$where.="  AND o.checked = $ochecked ";
		}

		if($cateid<>""){ $where.=" AND i.cateid = '$cateid' "; }
		if($status<>""){
			$status = (int)$status;
			switch($status){
				case "2":
					$where.=" AND i.checked = 1 AND i.worked = 0  AND o.status NOT IN(-1,0,7) "; $orderd = "i.id ASC,";
				break;
				case "3":
					$where.=" $timewhere AND i.checked = 1 AND i.worked = 1  AND o.status NOT IN(-1,0,7) "; $orderd = "i.id DESC,";
				break;
				case "4":
					$where.=" $timewhere AND i.checked = 2 AND i.worked = 0  AND o.status NOT IN(-1,0,7) "; $orderd = "i.id DESC,";
				break;
				case "5":
					$where.=" $timewhere AND i.worked = 2  AND o.status NOT IN(-1,0,7) ";  $orderd = "i.id DESC,";
				break;
				case "6":
					$where.=" $timewhere AND i.worked = 3  AND o.status IN(-1,7) ";  $orderd = "i.id DESC,";
				break;
				case "7":
					$where.=" $timewhere AND o.status NOT IN(-1,0,7) ";  $orderd = "i.id DESC,";
				break;
				default:
					$where.=" AND i.checked = 0 AND i.worked = 0 AND o.status NOT IN(-1,0,7) "; $orderd = "i.id ASC,";
			}
		}
		if($nums){
			$nums = (int)$nums;
		}else{
			$nums = "10";
		}
		$show = (int)$show;
		$query = " SELECT i.*,ci.name AS catename,o.dateline AS odateline,
		au.name AS addname,cu.name AS checkname,wu.name AS workname
		FROM ".DB_ORDERS.".invoice AS i
		INNER JOIN ".DB_ORDERS.".config_invoice AS ci ON ci.id = i.cateid
		INNER JOIN ".DB_ORDERS.".orders AS o ON o.id = i.ordersid
		INNER JOIN ".DB_ORDERS.".users AS au ON i.userid = au.userid
		INNER JOIN ".DB_ORDERS.".users AS cu ON i.checkuserid = cu.userid
		INNER JOIN ".DB_ORDERS.".users AS wu ON i.workuserid = wu.userid
		WHERE i.openid = ".OPEN_ID." AND i.hide = 1 $where
		GROUP BY i.id
		ORDER BY $orderd i.dateline DESC ";
		if($page){
			$this->db->keyid = "i.id";
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
		return $rows;
	}

	//删除申请记录
	Public function del()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$id = (int)$this->id;
		$where = array("id"=>$id);
		$arr = array(
				'hide'	=>	0
		);
		$this->db->update(DB_ORDERS.".invoice",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=delete&ordersid=$ordersid&name=发票信息[删除]&detail=删除订单[".$ordersid."]的发票申请#".$id."&sqlstr=$logsarr");
		return 1;
	}

	Public function checked()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$id = (int)$this->id;
		$userid = (int)$this->cookie->get("userid");
		$where = array("id"=>$id);
		$arr = array(
			'checked'		=>	$checked,
			'checkuserid'	=>	(int)$this->cookie->get("userid"),
			'checkdate'		=>	time(),
			'workinfo'		=>	$workinfo
		);
		$this->db->update(DB_ORDERS.".invoice",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);

		// if($checked=="2"){
		// 	//系统通知
		// 	$notes = getModel("notes");
		// 	$userid = $info["userid"];
		// 	$notes->insert("type=4&ordersid=$ordersid&userid=$userid&content=收一条来自订单[".$ordersid."]发票申请的驳回通知：".$workinfo);
		// }
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=发票信息[审核]&detail=审核订单[".$ordersid."]的发票申请#".$id."&sqlstr=$logsarr");
		return 1;
	}

	Public function opened()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$id = (int)$this->id;
		$where = array("id"=>$id);
		$arr = array(
			'cateid'		=> (int)$cateid,
			'title'			=> trim($title),
			'type'			=> (int)$type,
			'price'			=> @round($price,2),
			'corpname'		=> trim($corpname),
			'corpaddress'	=> trim($corpaddress),
			'corptel'		=> $corptel,
			'corpnums'		=> $corpnums,
			'corpbank'		=> $corpbank,
			'worked'		=> 1,
			'worknums'		=> $worknums,
			'workinfo'		=> $workinfo,
			'workuserid'	=> (int)$this->cookie->get("userid"),
			'workdate'		=> time()
		);
		$this->db->update(DB_ORDERS.".invoice",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=发票信息[开票]&detail=订单[".$ordersid."]的发票开票操作#".$id."&sqlstr=$logsarr");
		return 1;
	}

	//发票作废
	Public function killed()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$id = (int)$this->id;
		$where = array("id"=>$id);
		$arr = array(
			'worked'		=> $worked,
			'workinfo'		=> $workinfo,
			'workuserid'	=> (int)$this->cookie->get("userid"),
			'workdate'		=> time()
		);
		$this->db->update(DB_ORDERS.".invoice",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);
		$worked = ($worked=="3")?"作废":"取消";
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=发票信息[".$worked."]&detail=".$worked."订单[".$ordersid."]的发票申请#".$id."&sqlstr=$logsarr");
		return 1;
	}

	//申请状态
	public function checkjoin($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$query = "SELECT id FROM ".DB_ORDERS.".invoice WHERE
		openid = ".OPEN_ID." AND  ordersid = $ordersid AND checked <> 1 AND hide = 1 ";
		$rows = $this->db->getRow($query);
		return (int)$rows["id"];
	}

	//已开金额
	public function opencount($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$query = "SELECT SUM(price) AS total FROM ".DB_ORDERS.".invoice WHERE
		openid = ".OPEN_ID." AND ordersid = $ordersid AND checked = 1 AND worked IN(0,1) AND hide = 1 ";
		$rows = $this->db->getRow($query);
		return $rows["total"];
	}

	//发票类目
	Public function catetype()
	{
		// $ds[6] = array('id' =>'6',	'name'	=> '亿家净水(武汉)科技有限公司',		'img'	=>	'');
		// $ds[1] = array('id' =>'1',	'name'	=> '亿家联合环保设备(北京)有限公司',	'img'	=>	'');
		// $ds[2] = array('id' =>'2',	'name'	=> '北京亿家互动科技有限公司',		'img'	=>	'');
		// $ds[3] = array('id' =>'3',	'name'	=> '上海韵纯环保设备有限公司',		'img'	=>	'');
		// $ds[4] = array('id' =>'4',	'name'	=> '凯优亿家（天津）环保科技有限公司','img'	=>	'');
		// $ds[5] = array('id' =>'5',	'name'	=> '沈阳三浦联合环保科技有限公司',	'img'	=>	'');
		// $ds[7] = array('id' =>'7',	'name'	=> '诗曼浦（天津）科技有限公司',			'img'	=>	'');
		// $ds[8] = array('id' =>'8',	'name'	=> '北京盛畅水科技有限公司',					'img'	=>	'');
		// $ds[9] = array('id'	=>'9',	'name'	=> '武汉纳霏膜科技有限公司',				'img'	=>	'');
		$query = " SELECT id,name FROM ".DB_ORDERS.".config_invoice WHERE openid = ".OPEN_ID." AND hide = 1 ";
		$ds = $this->db->getRows($query);
		return $ds;
	}

	//开票状态
	Public function worktype()
	{
		$ds		= array();
		$ds[1] = array('id' =>'1',	'name'	=> '已开票据',	'color'	=>	'green');
		$ds[2] = array('id' =>'2',	'name'	=> '申请取消',	'color'	=>	'');
		$ds[3] = array('id' =>'3',	'name'	=> '票据作废',	'color'	=>	'');
		$ds[0] = array('id' =>'0',	'name'	=> '待开票据',	'color'	=>	'red');
		return $ds;
	}

	//审核状态
	Public function checktype()
	{
		$ds		= array();
		$ds[1] = array('id' =>'1',	'name'	=> '审核通过',	'color'	=>	'green');
		$ds[2] = array('id' =>'2',	'name'	=> '审核驳回',	'color'	=>	'');
		$ds[0] = array('id' =>'0',	'name'	=> '等待审核',	'color'	=>	'red');
		return $ds;
	}


}
?>
