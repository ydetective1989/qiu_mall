<?php
class storeModules extends Modules
{

	//增加出库记录
	Public function add()
	{

		extract($_POST);
		$ordersid = $this->id;

		$userid = (int)$this->cookie->get("userid");

		$checkerp = $this->checkerp("erpnum=".$erpnum);
		if($checkerp){
			return "当前ERP单据号已存在，出库OMS订单号为".$checkerp["ordersid"];
		}

		if($infoarr){
			$ifnums = 0;
			foreach($infoarr AS $rs){
				if((int)$rs["nums"]){

					$ifnums = 1;

					if($type=="1"){
						if($nums>$rs["maxnums"]){
							return "[".$rs["encoded"]."]出库数量不能大于已销售数量！";
						}
					}else{
						$checknums = $rs["storenums"]+$nums;
						if($checknums<0){
							return "[".$rs["encoded"]."]退库数量不能大于已出库数量！";
						}
					}

				}
			}
			if($ifnums=="0"){
				return "SORRY，商品出库数量不能为空";
			}

		}else{
			return "非法的商品信息";
		}

		$arr = array(
			"openid"	=>	OPEN_ID,
			"ordersid"	=>	$ordersid,
			"erpnum"	=>	$erpnum,
			"type"		=>	$type,
			"storeid"	=>	(int)$infoarr[0]["storeid"],
			"userid"	=>	$userid,
			"dateline"	=>	time(),
			"upuserid"	=>	$userid,
			"updateline"=>	time()
		);
		$this->db->insert(DB_ORDERS.".store",$arr);
		$sid = $this->db->getLastInsId();
		$logsarr.= plugin::arrtostr($arr);

		foreach($infoarr AS $rs){

			if((int)$rs["nums"]){
				$arr = array(
					"sid"		=>	(int)$sid,
					"storeid"	=>	(int)$rs["storeid"],
					"oid"		=>	(int)$rs["id"],
					"productid"	=>	(int)$rs["productid"],
					"encoded"	=>	$rs["encoded"],
					"title"		=>	$rs["erpname"],
					"nums"		=>	(int)$rs["nums"]
				);
				$this->db->insert(DB_ORDERS.".storeinfo",$arr);
				$logsarr.= plugin::arrtostr($arr);
			}

		}

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=出库信息[增加]&detail=增加订单[".$ordersid."]的出库信息#".$sid."&sqlstr=$logsarr");

		return "1";

	}

	//修改出库记录
	Public function edit()
	{

		extract($_POST);
		$id = $this->id;

		$userid = (int)$this->cookie->get("userid");

		$checkerp = $this->checkerp("erpnum=".$erpnum."&id=".$id);
		if($checkerp){
			return "当前ERP单据号已存在，出库OMS订单号为".$checkerp["ordersid"];
		}

		$where = array("id"=>$id);

		$arr = array(
			"erpnum"	=>	$erpnum,
			"storeid"	=>	0,
			"type"		=>	$type,
			"upuserid"	=>	$userid,
			"updateline"=>	time()
		);
		$this->db->update(DB_ORDERS.".store",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);

		if($infoarr){
			$ifnums = 0;
			foreach($infoarr AS $rs){
				if((int)$rs["nums"]){

					$ifnums = 1;

					if($type=="1"){
						if($nums>$rs["maxnums"]){
							return "[".$rs["encoded"]."]出库数量不能大于已销售数量！";
						}
					}else{
						$checknums = $rs["storenums"]+$nums;
						if($checknums<0){
							return "[".$rs["encoded"]."]退库数量不能大于已出库数量！";
						}
					}

				}
			}
			if($ifnums=="0"){
				return "SORRY，商品出库数量不能为空";
			}

		}else{
			return "非法的商品信息";
		}

		$where = array("sid"=>$id);
		$this->db->delete(DB_ORDERS.".storeinfo",$where);
		foreach($infoarr AS $rs){
			if((int)$rs["nums"]){
				$arr = array(
						"sid"		=>	(int)$id,
						"storeid"	=>	(int)$rs["storeid"],
						"oid"		=>	(int)$rs["id"],
						"productid"	=>	(int)$rs["productid"],
						"encoded"	=>	$rs["encoded"],
						"title"		=>	$rs["erpname"],
						"nums"		=>	(int)$rs["nums"]
				);
				$this->db->insert(DB_ORDERS.".storeinfo",$arr);
				$logsarr.= plugin::arrtostr($arr);
			}
		}

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=出库信息[更新]&detail=更新订单[".$ordersid."]的出库信息#".$sid."&sqlstr=$logsarr");


		return "1";
	}

	//删除工单记录
	Public function del()
	{
		extract($_POST);
		$ordersid	= (int)$this->ordersid;
		$id			= (int)$this->id;
		$userid = (int)$this->cookie->get("userid");
		$where = array("id"=>$id);
		$arr = array(
			'checked'	=>	4,
			'checkuserid'=>$userid,
			'checkdate'	=>	time(),
			'deliver'	=>	4
		);
		$this->db->update(DB_ORDERS.".store",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=delete&ordersid=$ordersid&name=出库信息[取消]&detail=取消订单[".$ordersid."]的出库信息#".$id."&sqlstr=$logsarr");
		return 1;
	}

	Public function checked()
	{

		extract($_POST);
		$ordersid	= (int)$this->ordersid;
		$id			= (int)$this->id;
		$info		= $this->info;

		$userid = (int)$this->cookie->get("userid");

		$where = array("id"=>$id);

		$checkerp = $this->checkerp("erpnum=".$erpnum."&id=".$id);
		if($checkerp){
			return "当前ERP单据号已存在，出库OMS订单号为".$checkerp["ordersid"];
		}

		$query  = " SELECT storeid FROM ".DB_ORDERS.".storeinfo WHERE sid = $id GROUP BY storeid ";
		$stores = $this->db->getRows($query);

		$arr = array(
				'erpnum'	=>	$erpnum,
				'storeid'	=>	$stores[0]["storeid"],
				'checked'	=>	1,
				'checkuserid'	=>	$userid,
				'checkdate'	=>	time()
		);
		$this->db->update(DB_ORDERS.".store",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);

		foreach($stores AS $rs){
			$storeid = $rs["storeid"];
			$query = "SELECT id FROM ".DB_ORDERS.".store WHERE id = $id AND storeid = $storeid ";
			$row = $this->db->getRow($query);
			if(!$row){
				$arr = array(
					'openid'	=>	OPEN_ID,
					"ordersid"	=>	$ordersid,
					"erpnum"	=>	$erpnum,
					"type"		=>	$info["type"],
					"storeid"	=>	$storeid,
					"userid"	=>	$info["userid"],
					"dateline"	=>	$info["dateline"],
					"upuserid"	=>	$info["upuserid"],
					"updateline"=>	$info["updateline"],
					'checked'	=>	1,
					'checkuserid'	=>	$userid,
					'checkdate'	=>	time()
				);
				$this->db->insert(DB_ORDERS.".store",$arr);
				$sid = $this->db->getLastInsId();
				$logsarr.= plugin::arrtostr($arr);
				$where	= array("sid"=>$id,"storeid"=>$storeid);
				$arr	= array("sid"=>$sid);
				$logsarr.= plugin::arrtostr($where);
				$this->db->update(DB_ORDERS.".storeinfo",$arr,$where);
			}
		}

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=出库信息[确认]&detail=确认订单[".$ordersid."]的出库信息#".$id."&sqlstr=$logsarr");
		return 1;
	}

	Public function getrow($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;

		$query = " SELECT s.*,au.name AS addname,cu.name AS checkname,ru.name AS delivername
		FROM ".DB_ORDERS.".store AS s
		INNER JOIN ".DB_ORDERS.".config_store AS cs ON s.storeid = cs.id
		INNER JOIN ".DB_ORDERS.".users AS au ON s.userid = au.userid
		INNER JOIN ".DB_ORDERS.".users AS cu ON s.checkuserid = cu.userid
		INNER JOIN ".DB_ORDERS.".users AS ru ON s.deliveruserid = ru.userid
		WHERE s.openid = ".OPEN_ID." AND s.hide = 1 AND s.id = $id ";

		$rows = $this->db->getRow($query);
		return $rows;
	}


	Public function getrows($str=""){

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$userid = (int)$this->cookie->get("userid");

		if($checked!=""){
			$checked = (int)$checked;
			$where.= " AND s.checked = $checked ";
		}

		if($deliver!=""){
			$deliver = (int)$deliver;
			$where.= " AND s.deliver = $deliver ";
		}

		if($storeid!=""){
			$storeid = (int)$storeid;
			$where.= " AND si.storeid = $storeid ";
		}

		if($godate!=""){
			$gotime = strtotime($godate." 00:00:00");
			$where.= "AND s.dateline >= '$gotime' ";
		}

		if($todate!=""){
			$totime = strtotime($todate." 23:59:59");
			$where.= "AND s.dateline <= '$totime' ";
		}

		if($ordersid){
			$ordersid = (int)$ordersid;
			$where =" AND s.ordersid = $ordersid ";
		}

		if($erpnum){
			$ordersid = (int)$ordersid;
			$where =" AND s.erpnum = '$erpnum' ";
		}

		//限制库房权限
		$users = getModel("users");
		$userinfo = $users->getrow("userid=$userid");
		$stored = (int)$userinfo["stored"];
		if($storelevel=="1"&&$stored=="0"){
			$query = " SELECT storeid FROM ".DB_ORDERS.".config_users_store WHERE userid = $userid ";
			$rows = $this->db->getRows($query);
			if($rows){
				$arr = array();
				foreach($rows AS $rs){
					$arr[]	=	$rs["storeid"];
				}
				$storearr = implode(",",$arr);
				$where.=" AND s.storeid IN($storearr) ";
			}else{
				$where.=" AND s.userid = $userid ";
			}
		}

		//每页数量
		$nums = ($nums)?(int)$nums:"20";
		$desc = ($desc=="ASC")?"ASC":"DESC";
		switch($order){
			case "checkdate" :	$orderd = " s.checkdate $desc "; break;
			case "deliverdate" :	$orderd = " s.deliverdate $desc "; break;
			default : $orderd = " s.dateline DESC ";
		}

		$query = " SELECT s.*,au.name AS addname,cu.name AS checkname,ru.name AS delivername
		FROM ".DB_ORDERS.".store AS s
		INNER JOIN ".DB_ORDERS.".storeinfo AS si ON si.sid = s.id
		INNER JOIN ".DB_ORDERS.".orders AS o ON s.ordersid = o.id
		INNER JOIN ".DB_ORDERS.".users AS au ON s.userid = au.userid
		INNER JOIN ".DB_ORDERS.".users AS cu ON s.checkuserid = cu.userid
		INNER JOIN ".DB_ORDERS.".users AS ru ON s.deliveruserid = ru.userid
		WHERE s.openid = ".OPEN_ID." AND s.hide = 1 $where
		ORDER BY $orderd
		";
		//echo $query;
		if($page){
			$show = (int)$show;
			$this->db->keyid = "s.id";
			$rows = $this->db->getPageRows($query,$nums,$show);
		}else{
			if((int)$xls=="0"){
				$start = ($start)?(int)$start:"0";
				$limt = " LIMIT $start,$nums ";
				$rows = $this->db->getRows($query.$limt);
			}else{
				$xdb = xdb();
				$rows = $xdb->getRows($query.$limt);
			}
		}
		return $rows;

	}


	Public function product($str=""){

		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$ordersid = (int)$ordersid;
		$sid = (int)$sid;

		$query = " SELECT oi.*,p.erpname
		FROM ".DB_ORDERS.".ordersinfo AS oi
		INNER JOIN ".DB_PRODUCT.".product AS p ON oi.productid = p.productid
		WHERE oi.ordersid = $ordersid AND oi.encoded <> '000000'
		GROUP BY oi.grouped
		ORDER BY oi.grouped ASC ";
		$rows = $this->db->getRows($query);
		if($rows){
			$arr = array();
			foreach($rows AS $rs){

				$oid = (int)$rs["id"];
				$rs["storenums"]	=	$this->storenums("id=$sid&oid=$oid");
				if($sid){
					$query = " SELECT nums AS editnums FROM ".DB_ORDERS.".storeinfo WHERE sid = $sid AND oid = $oid ";
					$row = $this->db->getRow($query);
					$rs["editnums"] = (int)$row["editnums"];
				}
				$arr[]	=	$rs;

			}
			$rows = $arr;
		}
		//print_r($rows);
		return $rows;
	}

	//复核确认信息
	Public function deliver(){
		//print_r($_POST);
		extract($_POST);
		$ordersid	= (int)$this->ordersid;
		$id			= (int)$this->id;
		$userid		= (int)$this->cookie->get("userid");

		$idarr		= $idarr;
		if($idarr){
			foreach($idarr AS $rs){
				$pid		= $rs;
				$where		= array("id"=>$pid);
				$this->db->delete(DB_ORDERS.".storeinfo_code",$where);

				$pserial 	= $serial[$pid];
				$pnums		= $nums[$pid];
				$pbarcode	= $barcode[$pid];
				//print_r($pbarcode);
				$arr		= array("serial"=>$pserial);
				$this->db->update(DB_ORDERS.".storeinfo",$arr,$where);
				$logsarr.= plugin::arrtostr($arr);
				for($i=0;$i<$pnums;$i++){
					if($pbarcode[$i]){
						$arr = array("id"=>$pid,"barcode"=>$pbarcode[$i]);
						$this->db->insert(DB_ORDERS.".storeinfo_code",$arr);
						$logsarr.= plugin::arrtostr($arr);
					}
				}
			}
			$arr = array("deliver"=>1,"deliveruserid"=>$userid,"deliverdate"=>time());
			$where = array("id"=>$id);
			$this->db->update(DB_ORDERS.".store",$arr,$where);
			$logsarr.= plugin::arrtostr($arr);
		}
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=出库信息[复核]&detail=复核订单[".$ordersid."]的出库信息#".$id."&sqlstr=$logsarr");
		return 1;
	}

	Public function deliverinfo($str=""){

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$userid		= (int)$this->cookie->get("userid");

		if($checked!=""){
			$checked = (int)$checked;
			$where.= " AND s.checked = $checked ";
		}

		if($deliver!=""){
			$deliver = (int)$deliver;
			$where.= " AND s.deliver = $deliver ";
		}

		if($storeid!=""){
			$storeid = (int)$storeid;
			$where.= " AND s.storeid = $storeid ";
		}

		if($datatype=="checkdate"){
			if($godate!=""){
				$gotime = strtotime($godate." 00:00:00");
				$where.= "AND s.checkdate >= '$gotime' ";
			}
			if($todate!=""){
				$totime = strtotime($todate." 23:59:59");
				$where.= "AND s.checkdate <= '$totime' ";
			}
			$order = "checkdate";	$desc  = "ASC";
		}else{
			if($godate!=""){
				$gotime = strtotime($godate." 00:00:00");
				$where.= "AND s.dateline >= '$gotime' ";
			}
			if($todate!=""){
				$totime = strtotime($todate." 23:59:59");
				$where.= "AND s.dateline <= '$totime' ";
			}
		}

		if($id){
			$id		= (int)$id;
			$where	= " AND si.sid = $id ";
		}

		if($ordersid){
			$id		= (int)$ordersid;
			$where	= " AND s.ordersid = $id ";
		}

		//限制库房权限
		$users = getModel("users");
		$userinfo = $users->getrow("userid=$userid");
		$stored = (int)$userinfo["stored"];
		if($storelevel=="1"&&$stored=="0"){
			$query = " SELECT storeid FROM ".DB_ORDERS.".config_users_store WHERE userid = $userid ";
			$rows = $this->db->getRows($query);
			if($rows){
				$arr = array();
				foreach($rows AS $rs){
					$arr[]	=	$rs["storeid"];
				}
				$storearr = implode(",",$arr);
				$where.=" AND s.storeid IN($storearr) ";
			}else{
				$where.=" AND s.userid = $userid ";
			}
		}

		//每页数量
		$nums = ($nums)?(int)$nums:"20";
		$desc = ($desc=="ASC")?"ASC":"DESC";
		switch($order){
			case "deliverdate" :	$orderd = " s.deliverdate $desc "; break;
			case "checkdate" :		$orderd = " s.checkdate $desc "; break;
			default : $orderd = " si.id ASC ";
		}

		$query = " SELECT si.*,cs.name AS storename,cs.encoded AS storecode,p.barcode AS enbarcode,p.models,b.name AS brandname,
		au.name AS addname,cu.name AS checkname,ru.name AS delivername,oi.price AS price,
		o.address,o.phone,o.mobile,o.name,o.detail AS odetail,o.checked AS ochecked,o.status AS ostatus,o.contract,
		s.type,s.userid,s.deliveruserid,s.checkuserid,s.dateline,s.checkdate,s.deliverdate,
		s.ordersid,s.erpnum,s.deliver,s.checked,st.name AS salesname,su.name AS salesuname
		FROM ".DB_ORDERS.".storeinfo AS si
		INNER JOIN ".DB_ORDERS.".store AS s ON si.sid = s.id
		INNER JOIN ".DB_ORDERS.".ordersinfo AS oi ON si.oid = oi.id
		INNER JOIN ".DB_ORDERS.".orders AS o ON s.ordersid = o.id
		INNER JOIN ".DB_PRODUCT.".product AS p ON oi.productid = p.productid
		INNER JOIN ".DB_PRODUCT.".brand AS b ON b.brandid = p.brandid
		INNER JOIN ".DB_ORDERS.".config_store AS cs ON si.storeid = cs.id
		INNER JOIN ".DB_ORDERS.".users AS au ON s.userid = au.userid
		INNER JOIN ".DB_ORDERS.".users AS cu ON s.checkuserid = cu.userid
		INNER JOIN ".DB_ORDERS.".users AS ru ON s.deliveruserid = ru.userid
		INNER JOIN ".DB_ORDERS.".config_teams AS st ON st.id = o.salesid
		INNER JOIN ".DB_ORDERS.".users AS su ON su.userid = o.saleuserid
		WHERE s.openid = ".OPEN_ID." AND s.hide = 1 $where
		ORDER BY $orderd ";

		if($page){

			$show = (int)$show;
			$this->db->keyid = "si.id";
			$rows = $this->db->getPageRows($query,$nums,$show);
			//print_r($rows);

		}else{
			if((int)$xls=="0"){
				$start = ($start)?(int)$start:"0";
				$limt = " LIMIT $start,$nums ";
				$rows = $this->db->getRows($query.$limt);
			}else{
				$xdb = xdb();
				$rows = $xdb->getRows($query);
			}
			if($rows&&(int)$xls=="0"){
				$arr	=	array();
				foreach($rows AS $rs){
					$pid	=	$rs["id"];
					$query = " SELECT barcode FROM ".DB_ORDERS.".storeinfo_code WHERE id = $pid ";
					$barcode = $this->db->getRows($query);
					$rs["barcode"]	=	$barcode;
					$arr[]	=	$rs;
				}
				$rows = $arr;
			}
		}
		//print_r($rows);
		return $rows;
	}

	//检查ERP是否存在
	Public function checkerp($str=""){

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if($erpnum=="0"){
			return false;
		}
		if($id){
			$id = (int)$id;
			$where = " AND id NOT IN($id) ";
		}
		$query = " SELECT id,ordersid FROM ".DB_ORDERS.".store WHERE
		openid = ".OPEN_ID." AND hide = 1 AND checked NOT IN(4) AND erpnum = '$erpnum' $where ";
		$row = $this->db->getRow($query);
		return $row;
	}

	//统计已出入库数量
	Public function storenums($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($id){
			$id = (int)$id;
			$where.=" AND si.sid NOT IN($id) ";
		}
		if($oid){
			$where.=" AND si.oid = $oid ";
		}else{
			return 0;
		}

		$query = " SELECT SUM(si.nums) AS total
		FROM ".DB_ORDERS.".storeinfo AS si
		INNER JOIN ".DB_ORDERS.".store AS s ON si.sid = s.id
		WHERE s.openid = ".OPEN_ID." AND s.hide = 1 AND s.checked NOT IN(4) $where ";
		//echo $query;exit;
		$row = $this->db->getRow($query);
		return (int)$row["total"];

	}

	Public function level($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$userid		= (int)$this->cookie->get("userid");
		$users		= getModel("users");
		$userinfo	= $users->getrow("userid=$userid");
		$isadmin	= (int)$userinfo["isadmin"];
		if($isadmin){ return 1; }

		$storeid = (int)$storeid;
		$query = " SELECT userid FROM ".DB_ORDERS.".config_users_store WHERE storeid = $storeid ";
		$row = $this->db->getRow($query);
		if($row){
			return 1;
		}
		return 0;

	}


	Public function store($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		//限制库房权限
		$userid		= (int)$this->cookie->get("userid");
		$users		= getModel("users");
		$userinfo	= $users->getrow("userid=$userid");
		$isadmin	= (int)$userinfo["isadmin"];
		$stored		= (int)$userinfo["stored"];
		if($storelevel=="1"&&$stored=="0"&&$isadmin=="0"){
			$query = " SELECT storeid FROM ".DB_ORDERS.".config_users_store WHERE userid = $userid ";
			$rows = $this->db->getRows($query);
			if($rows){
				$arr = array();
				foreach($rows AS $rs){
					$arr[]	=	$rs["storeid"];
				}
				$storearr = implode(",",$arr);
				$where = " AND id IN($storearr) ";
			}else{
				return false;
			}
		}
		$query = " SELECT * FROM ".DB_ORDERS.".config_store WHERE hide = 1 $where ORDER BY orderd DESC ";
		$rows = $this->db->getRows($query);
		return $rows;
	}

	public function verifed($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$userid = (int)$this->cookie->get("userid");

		$id = (int)$id;
		$query = " SELECT verifed FROM ".DB_ORDERS.".storeinfo WHERE id = $id ";
		$row = $this->db->getRow($query);
		//return $query;
		if($row["verifed"]=="1"){
			$verifed = 0;
		}else{
			$verifed = 1;
		}

		$arr = array(
			"verifed"		=>	$verifed,
			"verifuserid"	=>	$userid,
			"verifdate"		=>	time()
		);
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".storeinfo",$arr,$where);
		return 1;
	}


	//取得出库产品列表
	Public function storeinfo($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($ordersid){
			$ordersid = (int)$ordersid;
			$where.=" AND s.ordersid = $ordersid ";
		}

		if($checked!=""){
			$checked = (int)$checked;
			$where.=" AND s.checked = $checked ";
		}

		if($storeid!=""){
			$storeid = (int)$storeid;
			$where.=" AND s.storeid = $storeid ";
		}

		$query = " SELECT si.title,si.encoded,si.nums
		FROM ".DB_ORDERS.".storeinfo AS si
		INNER JOIN ".DB_ORDERS.".store AS s ON si.sid = s.id
		WHERE s.openid = ".OPEN_ID." AND s.hide = 1 $where
		ORDER BY si.id ASC ";

		$rows = $this->db->getRows($query);
		return $rows;

	}

	public function checkinfo($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$query = " SELECT id FROM ".DB_ORDERS.".store WHERE
		openid = ".OPEN_ID." AND hide = 1 AND checked NOT IN(4) AND ordersid = '$ordersid' ";
		$row = $this->db->getRow($query);
		if($row){
			return 1;
		}

	}

}
?>
