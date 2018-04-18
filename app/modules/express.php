<?php
class expressModules extends Modules
{

	Public function getrow($str)
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$id = (int)$id;
		if($id){ $where = " AND e.id = $id "; }
		$jobsid = (int)$jobsid;
		if($jobsid){ $where = " AND e.jobsid = $jobsid "; }

		$query = " SELECT e.*,u.name AS addname,ce.name AS expname,ce.authnum AS expauthnum,ce.apia AS expapia
		FROM ".DB_ORDERS.".orders_express AS e
		INNER JOIN ".DB_ORDERS.".config_express AS ce ON ce.id = e.cateid
		INNER JOIN ".DB_ORDERS.".users AS u ON e.userid = u.userid
		WHERE e.hide = 1 $where ORDER BY e.id DESC ";
		$rows = $this->db->getRow($query);
		return $rows;

	}

	Public function getrows($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);


		if($cateid!=""){
			$cateid = (int)$cateid;
			$where.= " AND e.cateid = $cateid ";
		}

		if($userid!=""){
			$userid = (int)$userid;
			$where.= " AND e.userid = $userid ";
		}

		if($checked!=""&&$godate==""&&$todate==""){
			$checked = (int)$checked;
			$where.= " AND e.checked = $checked ";
			if($checked){
				$godate = date("Y-m-d",time()-86400*60);
			}
		}

		if($status!=""){
			$status = (int)$status;
			$where.= " AND o.status = $status ";
		}

		if($setuptype!=""){
			$setuptype = (int)$setuptype;
			$where.= " AND o.setuptype = $setuptype ";
		}

		//销售区域
		$salesarea = (int)$salesarea;
		if($salesarea){ $where.= " AND st.parentid = $salesarea "; }
		//销售中心
		$salesid = (int)$salesid;
		if($salesid){  	$where.= " AND st.id = $salesid "; }

		if($provid!=""){
			$provid = (int)$provid;
			$where.= " AND o.provid = $provid ";
		}

		if($cityid!=""){
			$cityid = (int)$cityid;
			$where.= " AND o.cityid = $cityid ";
		}

		if($areaid!=""){
			$areaid = (int)$areaid;
			$where.= " AND o.areaid = $areaid ";
		}

		if($finished!=""){
			$finished = (int)$finished;
			$where.= " AND e.finished = $finished ";
		}


		if($godate!=""){
			$where.= " AND e.datetime >= '".$godate."' ";
		}

		if($todate!=""){
			$where.= " AND e.datetime <= '".$todate."'";
		}


		if($cgodate!=""){
			$cgodate = strtotime($cgodate." 00:00:00");
			$where.= " AND e.checkdate >= '".$cgodate."' ";
		}

		if($ctodate!=""){
			$ctodate = strtotime($ctodate." 23:59:59");
			$where.= " AND e.checkdate <= '".$ctodate."'";
		}

		if($ordersid!=""){
			$ordersid = (int)$ordersid;
			$where.= " AND e.ordersid = $ordersid ";
		}

		if($expnumbers!=""){
			$expnumbers = trim($expnumbers);
			$where = " AND e.numbers = $expnumbers ";
		}

		if($nums){
			$nums = (int)$nums;
		}else{
			$nums = "10";
		}

		if($order){
			$desc = ($desc=="ASC")?$desc:"DESC";
			switch($order){
				case "datetime" : $orderd = "e.datetime ".$desc.","; break;
				case "dateline" : $orderd = "e.dateline ".$desc.","; break;
				case "finishtime" : $orderd = "e.finishtime ".$desc.","; break;
				default : $orderd = "" ;
			}
		}

		$show = (int)$show;

		$query = " SELECT e.id,e.ordersid,e.jobsid,e.type,e.cateid,e.numbers,e.weight,e.price,
		e.dateline,e.checked,e.checkdate,e.detail,e.finished,e.finishtime,
		u.name AS addname,ce.name AS expname,ce.authnum AS expauthnum,ce.apia AS expapia,
		o.datetime AS buydatetime,pa.name AS provname,ca.name AS cityname,aa.name AS areaname,
		st.name AS salesname,o.parentid,o.status,o.setuptype,o.contract,o.type AS ordertype,o.ctype AS orderctype
		FROM ".DB_ORDERS.".orders_express AS e
		INNER JOIN ".DB_ORDERS.".config_express AS ce ON ce.id = e.cateid
		INNER JOIN ".DB_ORDERS.".users AS u ON e.userid = u.userid
		INNER JOIN ".DB_ORDERS.".orders AS o ON e.ordersid = o.id
		INNER JOIN ".DB_CONFIG.".areas AS pa ON o.provid = pa.areaid
		INNER JOIN ".DB_CONFIG.".areas AS ca ON o.cityid = ca.areaid
		INNER JOIN ".DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid
		INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
		WHERE e.hide = 1 $where
		ORDER BY $orderd e.dateline DESC ";
		//echo $query;exit;
		//GROUP BY e.id
		//INNER JOIN ".DB_ORDERS.".job_orders AS jobs ON e.jobsid = jobs.id
		if($page){
			$this->db->keyid = 'e.id';
			$rows = $this->db->getPageRows($query,$nums,$show);
			if($sqled="jobexp"&&$rows["record"]){
				$rowarr = array();
				$list = $rows["record"];
				$page = $rows["pages"];
				foreach($list AS $rs){
					//echo print_r($rows);exit;
					$ordersid = (int)$rs["ordersid"];
					$query = "SELECT id,type,worked,datetime FROM ".DB_ORDERS.".job_orders
					WHERE type = 2 AND hide = 1 AND ordersid = $ordersid ORDER BY datetime DESC ";
					$row = $this->db->getRow($query);
					$rs["jobsid"]		= $row["id"];
					$rs["jobstatus"] 	= $row["worked"];
					$rs["jobsdate"] 	= $row["datetime"];
					$rowarr[] = $rs;
				}
				$rows = array();
				$rows["record"]  = $rowarr;
				$rows["pages"]   = $page;
			}
		}else{
			if((int)$xls=="0"){
				$start = ($start)?(int)$start:"0";
				$limt = " LIMIT $start,$nums ";
			}else{
				$xdb = xdb();
				$rows = $this->db->getRows($query);
			}
		}
		return $rows;
	}

	//添加记录
	Public function add()
	{

		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$userid = (int)$this->cookie->get("userid");
		$expresstype = $this->expresstype();
		$checked = (int)$expresstype[$type]["checked"];
		if($checked){ $sync = 1; }

		$cateid = (int)$cateid;
		$query = "SELECT id,ordersid FROM ".DB_ORDERS.".orders_express
		WHERE cateid = $cateid AND numbers = '".trim($numbers)."' ";
		$row = $this->db->getRow($query);//hide = 1 AND
		if($row){ return "此物流单号已被".$row["ordersid"]."使用，请勿重复启用！"; }

		$arr = array(
			'ordersid'		=>	$ordersid,
			'datetime'		=>	trim($datetime),
			'cateid'			=>	(int)$cateid,
			'type'				=>	(int)$type,
			'numbers'			=>	trim($numbers),
			'detail'			=>	trim($detail),
			'userid'			=>	$userid,
			'checked'			=>	$checked,
			'checkdate'		=>	time(),
			'checkuserid'	=>	'0',
			'synced'			=>	(int)$sync,
			'finished'		=>	$finished,
			'dateline'		=>	time()
		);

		//print_r($arr);exit;
		$this->db->insert(DB_ORDERS.".orders_express",$arr);
		$id = (int)$this->db->getLastInsId();
		$logsarr.= plugin::arrtostr($arr);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=物流信息[录入]&detail=录入订单[".$ordersid."]的物流信息#".$id."&sqlstr=$logsarr");
		return 1;
	}

	//修改工单记录
	Public function edit()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$id = (int)$this->id;
		$userid = (int)$this->cookie->get("userid");
		$expresstype = $this->expresstype();
		$checked = (int)$expresstype[$type]["checked"];
		if($checked){ $sync = 1; }
		$where = array("id"=>$id);

		$cateid = (int)$cateid;
		$query = "SELECT id,ordersid FROM ".DB_ORDERS.".orders_express
		WHERE hide = 1 AND cateid = $cateid AND numbers = '".trim($numbers)."' AND id <> $id ";
		$row = $this->db->getRow($query);
		if($row){ return "此物流单号已被".$row["ordersid"]."使用，请勿重复启用！"; }

		$arr = array(
			'cateid'			=>	(int)$cateid,
			'datetime'		=>	trim($datetime),
			'type'				=>	(int)$type,
			'numbers'			=>	trim($numbers),
			'detail'			=>	trim($detail),
			'checked'			=>	$checked,
			'checkuserid'	=>	'0',
			'checkdate'		=>	time(),
			'finished'		=>	$finished
		);
		$this->db->update(DB_ORDERS.".orders_express",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=物流信息[更新]&detail=更新订单[".$ordersid."]的物流信息#".$id."&sqlstr=$logsarr");
		return 1;
	}

	//确认物流记录
	Public function checked()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$id = (int)$this->id;
		$userid = (int)$this->cookie->get("userid");
		$where = array("id"=>$id);
		$arr = array(
			'cateid'		=>	(int)$cateid,
			'datetime'		=>	trim($datetime),
			'numbers'		=>	trim($numbers),
			'weight'		=>	round($weight,2),
			'price'			=>	round($price,2),
			'detail'		=>	trim($detail),
			'checked'		=>	'1',
			'checkuserid'	=>	$userid,
			'checkdate'		=>	time()
		);
		$this->db->update(DB_ORDERS.".orders_express",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=物流信息[确认]&detail=确认订单[".$ordersid."]的物流信息#".$id."&sqlstr=$logsarr");
		return 1;
	}

	//删除工单记录
	Public function del()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$id = (int)$this->id;
		$where = array("id"=>$id);
		$arr = array(
			'hide'	=>	0
		);
		$this->db->update(DB_ORDERS.".orders_express",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=delete&ordersid=$ordersid&name=物流信息[删除]&detail=删除订单[".$ordersid."]的物流信息#".$id."&sqlstr=$logsarr");
		return 1;
	}

	//订单发货状态
	Public function statuslist($str=""){

		$str = plugin::extstr($str);//处理字符串
		extract($str);

		//订单编号
		$ordersid = (int)$ordersid;
		if($ordersid) { $where.= " AND o.id = $ordersid "; }

		//合同号码contract
		if($contract){ $where.= " AND o.contract = '".trim($contract)."' "; }

		if(!$ordersid&&!$contract){

			if($godate){
				$where.= " AND o.datetime >= '".$godate."' ";
			}
			if($todate){
				$where.= " AND o.datetime <= '".$todate."' ";
			}
			//销售区域
			$salesarea = (int)$salesarea;
			if($salesarea){  $where.= " AND st.parentid = $salesarea "; }
			//销售中心
			$salesid = (int)$salesid;
			if($salesid){  $where.= " AND st.id = $salesid "; }

		}

		if($issend=="1"){
			$join = " INNER JOIN ".DB_ORDERS.".orders_express AS e ON e.ordersid = o.id ";
		}else{
			if($issend=="0"){
				$where.=" AND e.ordersid IS NULL ";
			}
			$join = " LEFT JOIN ".DB_ORDERS.".orders_express AS e ON e.ordersid = o.id ";
		}

		$query = " SELECT o.id AS ordersid,o.datetime,o.delivertype,
		pa.name AS provname,ca.name AS cityname,aa.name AS areaname,o.address,
		st.name AS salesname,o.checked,o.status,e.hide AS exphide
		FROM ".DB_ORDERS.".orders AS o
		$join
		INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
		INNER JOIN ".DB_CONFIG.".areas AS pa ON o.provid = pa.areaid
		INNER JOIN ".DB_CONFIG.".areas AS ca ON o.cityid = ca.areaid
		INNER JOIN ".DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid
		WHERE o.hide = 1 $where
		GROUP BY o.id
		ORDER BY o.id ASC ";
        if($xls=="1"){
			$xdb = xdb();
            $rows = $xdb->getRows($query);
        }else{
            $rows = $this->db->getPageRows($query,20);
        }
		return $rows;

	}

	//API
	Public function apiexp($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$key = "e0eac430db9d40e7";
		$com = $com;			//快递公司编码
		$nums= $nums;			//物流编号
		$valicode = $valicode;	//验证码
		$url = "http://api.kuaidi100.com/api?id=$key&com=$com&nu=$nums&valicode=$valicode&show=2&muti=1&order=asc";
		$curl = getFunc("curl");
		return $curl->contents($url);
	}

	Public function cates()
	{
		$query = " SELECT * FROM ".DB_ORDERS.".config_express WHERE hide = 1 ORDER BY orderd DESC,id ASC ";
		$rows = $this->db->getRows($query);
		return $rows;
	}

	Public function cateinfo($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$query = " SELECT * FROM ".DB_ORDERS.".config_express WHERE id = $id ";
		$rows = $this->db->getRow($query);
		return $rows;
	}

	//物品
	Public function expresstype()
	{
		$ds = array();
		$ds[1] = array('id' =>'1',	'name'	=> '货物',	'checked'	=>	'0');
		$ds[2] = array('id' =>'2',	'name'	=> '发票',	'checked'	=>	'1');
		$ds[3] = array('id' =>'3',	'name'	=> '配件',	'checked'	=>	'1');
		$ds[4] = array('id' =>'4',	'name'	=> '退货',	'checked'	=>	'1');
		$ds[5] = array('id' =>'5',	'name'	=> '调拨',	'checked'	=>	'0');
		$ds[0] = array('id' =>'0',	'name'	=> '其它',	'checked'	=>	'1');
		return $ds;
	}

	public function expstate()
	{

		$ds = array();
		$ds[0] = array('id' =>'0',	'name'	=> '在途中',	'color'	=>	'');
		$ds[1] = array('id' =>'1',	'name'	=> '已收件',	'color'	=>	'blue');
		$ds[2] = array('id' =>'2',	'name'	=> '疑难件',	'color'	=>	'orange');
		$ds[3] = array('id' =>'3',	'name'	=> '已签收',	'color'	=>	'green');
		$ds[4] = array('id' =>'4',	'name'	=> '已退回',	'color'	=>	'red');
		$ds[5] = array('id' =>'5',	'name'	=> '正派件', 'color'	=>	'green');
		$ds[6] = array('id' =>'6',	'name'	=> '退回中', 'color'	=>	'blue');
		$ds[7] = array('id' =>'7',	'name'	=> '已转投', 'color'	=>	'blue');
		$ds[44]= array('id' =>'44',	'name'	=> '已发出', 'color'	=>	'');	//亿家自定义状态
		$ds[99]= array('id' =>'99',	'name'	=> '待发件', 'color'	=>	'');
		return $ds;

	}

}
?>
