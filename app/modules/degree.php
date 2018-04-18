<?php
class degreeModules extends Modules
{

	Public function getrow($str)
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$jobsid   = (int)$jobsid;
		$ordersid = (int)$ordersid;

		$query	= " SELECT cd.*,cu.name AS callname,su.name AS salesuname,au.name AS afteruname,
		st.name AS salesname,at.name AS aftername
		FROM ".DB_ORDERS.".callback_degree AS cd
		LEFT JOIN ".DB_ORDERS.".config_teams AS st ON cd.salesid = st.id
		LEFT JOIN ".DB_ORDERS.".config_teams AS at ON cd.afterid = at.id
		LEFT JOIN ".DB_ORDERS.".users AS cu ON cd.calluserid = cu.userid
		LEFT JOIN ".DB_ORDERS.".users AS su ON cd.saleuserid = su.userid
		LEFT JOIN ".DB_ORDERS.".users AS au ON cd.afteruserid = au.userid
		WHERE cd.jobsid = $jobsid AND cd.ordersid = $ordersid ";
		$rows = $this->db->getRow($query);
		return $rows;
	}

	Public function getrows($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($ordersid){

			if($ordersid){
				$ordersid = (int)$ordersid;
				$where.=" AND o.id = $ordersid ";
			}

		}else{

			if($status == 0){
				if($godate&&$todate){ $where.= " AND jobs.datetime >= '".$godate."' AND jobs.datetime <= '".$todate."'"; }
			}else{
				//if($godate&&$todate){ $where.= " AND cd.datetime >= '".$godate."' AND cd.datetime <= '".$todate."'"; }
			}

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

			if($salesarea!=""){
				$salesarea = (int)$salesarea;
				$where.= " AND st.parentid = $salesarea ";
			}

			if($salesid!=""){
				$salesid = (int)$salesid;
				$where.= " AND o.salesid = $salesid ";
			}

			if($type!=""){
				$type = (int)$type;
				$where.=" AND jobs.type = $type ";
			}

		}


		if($status=="2"){
			$where.= " AND cd.checked = 0 ";
		}elseif($status=="3"){
			$where.= " AND cd.checked = 2 ";
		}elseif($status=="1"){
			$where.= " AND cd.checked = 1 ";
		}

		if($nums){
			$nums = (int)$nums;
		}else{
			$nums = "10";
		}

		//用户ID
		$userid = (int)$this->cookie->get("userid");
		$users = getModel("users");
		$userinfo = $users->getrow("userid=$userid");

		if($status=="0"){ $desc = "ASC"; }else{ $desc = "DESC"; }

		$show = (int)$show;

		if($status=="0"){
			$query = "SELECT cd.id AS id,o.id AS ordersid,jobs.id AS jobsid,jobs.datetime,jobs.type AS jobstype,
			pa.name AS provname,ca.name AS cityname,aa.name AS areaname
			FROM ".DB_ORDERS.".job_orders AS jobs
			INNER JOIN ".DB_ORDERS.".orders AS o ON jobs.ordersid = o.id
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON st.id = o.salesid
			LEFT JOIN ".DB_ORDERS.".callback_degree AS cd ON cd.ordersid = o.id
			INNER JOIN ".DB_CONFIG.".areas AS pa ON o.provid = pa.areaid
			INNER JOIN ".DB_CONFIG.".areas AS ca ON o.cityid = ca.areaid
			INNER JOIN ".DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid
			WHERE jobs.openid = ".OPEN_ID." AND cd.ordersid IS NULL AND jobs.worked = 1 AND jobs.type IN(2,5,6) $where AND o.status NOT IN(0,7,8,-1)
			GROUP BY o.id
			ORDER BY jobs.datetime $desc ";
			$this->db->keyid = 'jobs.id';
		}else{
			$query = "SELECT cd.id AS id,o.id AS ordersid,jobs.id AS jobsid,cd.datetime,jobs.type AS jobstype,
			pa.name AS provname,ca.name AS cityname,aa.name AS areaname
			FROM ".DB_ORDERS.".callback_degree AS cd
			INNER JOIN ".DB_ORDERS.".job_orders AS jobs ON cd.jobsid = jobs.id
			INNER JOIN ".DB_ORDERS.".orders AS o ON cd.ordersid = o.id
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON st.id = o.salesid
			INNER JOIN ".DB_CONFIG.".areas AS pa ON o.provid = pa.areaid
			INNER JOIN ".DB_CONFIG.".areas AS ca ON o.cityid = ca.areaid
			INNER JOIN ".DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid
			WHERE jobs.openid = ".OPEN_ID." $where
			GROUP BY cd.id
			ORDER BY cd.datetime $desc ";
			$this->db->keyid = 'cd.id';
		}

		if($page){
			$rows = $this->db->getPageRows($query,$nums,$show);
		}else{
			$start = ($start)?(int)$start:"0";
			$limt = " LIMIT $start,$nums ";
			$rows = $this->db->getRows($query.$limt);
		}
		return $rows;
	}

	//取得服务站信息
	Public function aftergroup()
	{
		//用户ID
		$userid = (int)$this->cookie->get("userid");
		$users = getModel("users");
		$userinfo = $users->getrow("userid=$userid");

		if($userinfo["isadmin"]!="1"){
			$owhere = "";
			$query = " SELECT t.id
			FROM ".DB_ORDERS.".config_teams AS t
			INNER JOIN ".DB_ORDERS.".config_teams_jobs AS ctj ON t.id = ctj.teamid OR t.parentid = ctj.teamid
			WHERE t.openid = ".OPEN_ID." AND ctj.userid = $userid
			GROUP BY t.id
			ORDER BY t.id ASC ";
			$rows = $this->db->getRows($query);
			$idarr = array();
			if($rows){
				foreach($rows AS $rs){
					$arr[] = $rs["id"];
				}
				$idrows = implode(",",$arr);
				$owhere = " OR job.afterid IN($idrows) ";
				$where.=" AND ( job.afteruserid = $userid $owhere ) ";
			}else{
				return false;
			}
		}

		$show = (int)$show;
		$query = " SELECT ct.id,ct.name
		FROM ".DB_ORDERS.".job_orders AS job
		INNER JOIN ".DB_ORDERS.".config_teams AS ct ON job.afterid = ct.id
		WHERE job.openid = ".OPEN_ID." AND job.hide = 1 $where
		GROUP BY job.afterid
		ORDER BY ct.orderd DESC ";
		return $this->db->getRows($query);
	}

	//满意度回访
	Public function degree()
	{
		extract($_POST);

		$id = (int)$this->id;
		$jobsid = (int)$this->jobsid;
		$ordersid = (int)$this->ordersid;
		$userid = (int)$this->cookie->get("userid");

		if(!$id){
			$info = $this->getrow("jobsid=$jobsid&ordersid=$ordersid");
			$id   = (int)$info["id"];
		}

		if(!(int)$sales){ $salesid = 0; $saleuserid = 0; $sales = 0; $salesinfo = ""; }

		$arr = array(
			'ordersid'		=>  (int)$ordersid,
			'jobsid'		=>	$jobsid,
			'datetime'		=>	$datetime,
			'calluserid'	=>  (int)$userid,
			'salesid'		=>	(int)$salesid,		//销售中心
			'saleuserid'	=>	(int)$saleuserid,	//销售人员
			'sales'			=>	(int)$sales,
			'salesinfo'		=>	$salesinfo,
			'afterid'		=>	(int)$afterid,		//服务中心
			'afteruserid'	=>	(int)$afteruserid,	//服务人员
			'after'			=>	(int)$after,
			'afterinfo'		=>	$afterinfo,
			'detail'		=>	$detail,
			'userid'		=>	(int)$userid,
			'dateline'		=>	time(),
			'checked'		=>	(int)$checked
		);
		$logsarr.= plugin::arrtostr($arr);

		if($checked=="1"){
			$loginfo = "满意度回访，服务评分：".$this->numstype($after);
		}elseif($checked=="2"){
			$loginfo = "无需回访,".$detail;
		}else{
			$loginfo = "无法回访,".$detail;
		}

		$logsinfo = array(
				'ordersid'	=>	$ordersid,
				'jobsid'	=>	$jobsid,
				'type'		=>	"12",
				'datetime'	=>	date("Y-m-d"),
				'detail'	=>	$loginfo,
				'userid'	=>	$userid,
				"locked"	=>  0,
				'dateline'	=>	time()
		);

		if($id){

			$where = array("id"=>$id);
			$this->db->update(DB_ORDERS.".callback_degree",$arr,$where);

			$where = array("id"=>$id);
			$this->db->update(DB_ORDERS.".orders_logs",$logsinfo,$where);

		}else{

			$this->db->insert(DB_ORDERS.".callback_degree",$arr);
			$id    = $this->db->getLastInsId();

			$this->db->insert(DB_ORDERS.".orders_logs",$logsinfo);

		}//type=12
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=满意度回访[回执]&detail=回执满意度，订单[".$ordersid."]，工单[".$jobsid."]#".$id."&sqlstr=$logsarr");
		return 1;

	}

	Public function numstype($nums=0){

		switch($nums){
			//case "4":$rows="非常满意";break;
			case "3":$rows="非常满意";break;
			case "2":$rows="满意";break;
			case "0":$rows="不满意";break;
			default: $rows="一般";
		}
		return $rows;

	}

}
?>
