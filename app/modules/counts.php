<?php
class countsModules extends Modules
{
	Public function checktime()
	{
		$starid = date("w");
		$htime = date("H");
		$userid = $this->cookie->get("userid");
		if($userid!="9"){
			if($starid>=1&&$starid<=5&&$htime>="9"&&$htime<="17"){
				dialog("周一~周五每天9点至18点,无法使用统计功能!");exit;
			}
		}
	}

	//订单数统计
	Public function orderc($str)
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);				//订单编号

		$userid = (int)$this->cookie->get("userid");
		//时间范围
		if($godate!=""){
			// $gotime = strtotime($godate." 00:00:00");
			$where .= " AND o.datetime >= '$godate' ";
		}
		if($todate!=""){
			// $totime = strtotime($todate." 23:59:59");
			$where .= " AND o.datetime <= '$todate' ";
		}
		//echo $where;exit;
		//订单类型
		if($type!=""){
			$where.= " AND o.type = '$type' ";
		}
		//客户类别
		if($customstype!=""){
			$where.= " AND o.ctype = '$customstype' ";
		}
		//订单状态
		if($checked!=""){
			$where.= " AND o.checked IN ($checked) ";
		}
		if($checkno!=""){
			$where.= " AND o.checked NOT IN ($checkno) ";
		}
		//订单进度
		if($status!="") {
			$where.= " AND o.status IN ($status) ";
		}
		if($statusno!="") {
			$where.= " AND o.status NOT IN ($statusno) ";
		}
		//客户来源
		if($source!=""){
			$where.= " AND o.source = '".trim($source)."' ";
		}
		//支付状态
		if($paystate!=""){
			$where.= " AND o.paystate = $paystate ";
		}
		//省份
		$provid = (int)$provid;
		if($provid){
			$where.= " AND o.provid = $provid ";
		}
		//城市
		$cityid = (int)$cityid;
		if($cityid){
			$where.= " AND o.cityid = $cityid ";
		}
		//区域
		$areaid = (int)$areaid;
		if($areaid){
			$where.= " AND o.areaid = $areaid ";
		}

		//if($userid==$saleuserid){

		//	$where = " AND o.saleuserid = $saleuserid ";

		//}else{

			//销售区域
			$salesarea = (int)$salesarea;
			if($salesarea){
				$where.= " AND st.parentid = $salesarea ";
			}
			//销售中心
			$salesid = (int)$salesid;
			if($salesid){
				$where.= " AND st.id = $salesid ";
			}

			//销售人员
			$saleuserid = (int)$saleuserid;
			if($saleuserid){
				$where.= " AND o.saleuserid = $saleuserid ";
			}

		//}

		//echo $where;exit;

		//录入人员
		$adduserid = (int)$adduserid;
		if($adduserid){
			$where.= " AND au.adduserid = $adduserid ";
		}

		/*
		//服务区域
		$afterarea = (int)$afterarea;
		if($afterarea){
			$where.= " AND at.parentid = $afterarea ";
		}
		//服务中心
		$afterid = (int)$afterid;
		if($afterid){
			$where.= " AND at.id = $afterid ";
		}
		//服务人员
		$afteruserid = (int)$afteruserid;
		if($afteruserid){
			$where.= " AND o.afteruserid = $afteruserid ";
		}
		*/
		$xdb = xdb();

		if(!$salesid){

			$users = getModel("users");
			$userinfo = $users->getrow("userid=$userid");
			if($userinfo["isadmin"]=="0"&&$userinfo["alled"]!="1"){	//不是管理员，并且没有全部权限
				$owhere = "";
          if($userinfo["alled"]=="2")
          {
              $query = " SELECT t.parentid
              FROM ".DB_ORDERS.".config_teams AS t
              INNER JOIN ".DB_ORDERS.".config_teams_jobs AS cto ON t.id = cto.teamid
              WHERE t.openid = ".OPEN_ID." AND t.type = 1 AND cto.userid = $userid AND t.parentid !='0'
              GROUP BY t.parentid
              ORDER BY t.parentid ASC ";
              $rows = $xdb->getRows($query);
              if($rows){
                  foreach($rows AS $rs){ $arr[] = $rs["parentid"]; }
                  $idrows = implode(",",$arr);
                  $owhere = " AND st.parentid IN($idrows) ";
                  $where.= $owhere;
              }else{
                  $where.= " AND o.saleuserid = $userid ";
              }
              //echo $where;
          }else{
              $query = " SELECT t.id
              FROM ".DB_ORDERS.".config_teams AS t
              INNER JOIN ".DB_ORDERS.".config_teams_jobs AS cto ON t.id = cto.teamid
              WHERE t.openid = ".OPEN_ID." AND t.type = 1 AND cto.userid = $userid
              GROUP BY t.id
              ORDER BY t.id ASC ";
              $rows = $xdb->getRows($query);
              $idarr = array();
              if($rows){
                  foreach($rows AS $rs){ $arr[] = $rs["id"]; }
                  $idrows = implode(",",$arr);
                  $owhere = " AND o.salesid IN($idrows) ";
                  $where.= $owhere;
              }else{
                  $where.= " AND o.saleuserid = $userid ";
              }
          }
			}

		}

		if($octype==""){
			$where.=" AND o.ctype <> 6 ";
		}else{
			$octype = (int)$octype;
			$where.=" AND o.ctype = $octype ";
		}

		if($ctype=="customs"){		//客户总数
			$query = "SELECT o.id
			FROM  ".DB_ORDERS.".orders AS o
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
			GROUP BY o.customsid ";
			$rows = $xdb->getRows($query);
			$rows = count($rows);
		}elseif($ctype=="price"){	//总金额
			$query = "SELECT SUM(o.price) AS price
			FROM  ".DB_ORDERS.".orders AS o
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where";
			$rows = $xdb->getRow($query);
			$rows = $rows["price"];
		}elseif($ctype=="products"){	//产品数目
			$query = "SELECT oi.productid
			FROM  ".DB_ORDERS.".ordersinfo AS oi
			INNER JOIN ".DB_ORDERS.".orders AS o ON oi.ordersid = o.id
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
			GROUP BY oi.productid ";
			$rows = $xdb->getRows($query);
			$rows = count($rows);
		}elseif($ctype=="productnums"){	//产品总数
			$query = "SELECT COUNT(oi.ordersid) AS total
			FROM  ".DB_ORDERS.".ordersinfo AS oi
			INNER JOIN ".DB_ORDERS.".orders AS o ON oi.ordersid = o.id
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where";
			$rows = $xdb->getRow($query);
			$rows = $rows["total"];
		}elseif($ctype=="salesgroup"){	//销售中心
			$query = "SELECT ct.id,ct.name
			FROM  ".DB_ORDERS.".config_teams AS ct
			INNER JOIN ".DB_ORDERS.".orders AS o ON ct.id = o.salesid
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
			GROUP BY o.salesid
			ORDER BY ct.orderd DESC ";
			return $rows = $xdb->getRows($query);
		}elseif($ctype=="saleusers"){	//销售人员
			$query = "SELECT u.userid,u.name,u.worknum
			FROM  ".DB_ORDERS.".config_teams AS ct
			INNER JOIN ".DB_ORDERS.".orders AS o ON ct.id = o.salesid
			INNER JOIN ".DB_ORDERS.".users AS u ON o.saleuserid = u.userid
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
			GROUP BY o.saleuserid
			ORDER BY u.worknum DESC ";
			return $rows = $xdb->getRows($query);
		}elseif($ctype=="orders"){
			$query = "SELECT o.id
			FROM  ".DB_ORDERS.".orders AS o
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
			GROUP BY o.id ";//echo $query;exit;
			$rows = $xdb->getRows($query);
			$rows = count($rows);
		}else{

		}
		return $rows;
	}


	//录单操作统计
	Public function addorder($str="")
	{

		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);				//订单编号
		//时间范围
		if($godate!=""){
			$gotime = strtotime($godate." 00:00:00");
			$where.=" AND o.dateline >= '$gotime' ";
		}
		if($todate!=""){
			$totime = strtotime($todate." 23:59:59");
			$where.=" AND o.dateline <= '$totime' ";
		}
		if($userid!=""){
			$where.=" AND o.adduserid = $userid ";
		}
		if($ctype=="nums"){
			$query = "SELECT COUNT(o.id) AS total
			FROM  ".DB_ORDERS.".orders AS o
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where  ";
			$rows = $xdb->getRow($query);
			$rows = (int)$rows["total"];
		}elseif($ctype=="price"){
			$query = "SELECT SUM(o.price) AS price
			FROM  ".DB_ORDERS.".orders AS o
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where  ";
			$rows = $xdb->getRow($query);
			$rows = $rows["price"];
		}else{

		}
		return $rows;
	}

	//产品统计
	Public function productc($str="")
	{

		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);				//订单编号
		//时间范围
		if($godate!=""){
			$where.=" AND o.datetime >= '$godate' ";
		}
		if($todate!=""){
			$where.=" AND o.datetime <= '$todate' ";
		}
		//订单类型
		if($type!=""){
			$where.= " AND o.type = '$type' ";
		}
		//订单状态
		if($checked!=""){
			$where.= " AND o.checked IN ($checked) ";
		}
		if($checkno!=""){
			$where.= " AND o.checked NOT IN ($checkno) ";
		}
		//订单进度
		if($status!="") {
			$where.= " AND o.status IN ($status) ";
		}
		if($statusno!="") {
			$where.= " AND o.status NOT IN ($statusno) ";
		}
		//客户来源
		if($source!=""){
			$where.= " AND o.source = '".trim($source)."' ";
		}
		//支付状态
		if($paystate!=""){
			$where.= " AND o.paystate = $paystate ";
		}
		//省份
		$provid = (int)$provid;
		if($provid){
			$where.= " AND o.provid = $provid ";
		}
		//城市
		$cityid = (int)$cityid;
		if($cityid){
			$where.= " AND o.cityid = $cityid ";
		}
		//区域
		$areaid = (int)$areaid;
		if($areaid){
			$where.= " AND o.areaid = $areaid ";
		}
		//销售区域
		$salesarea = (int)$salesarea;
		if($salesarea){
			$where.= " AND st.parentid = $salesarea ";
		}
		//销售中心
		$salesid = (int)$salesid;
		if($salesid){
			$where.= " AND st.id = $salesid ";
		}
		//销售人员
		$saleuserid = (int)$saleuserid;
		if($saleuserid){
			$where.= " AND o.saleuserid = $saleuserid ";
		}
		//服务区域
		$afterarea = (int)$afterarea;
		if($afterarea){
			$where.= " AND at.parentid = $afterarea ";
		}
		//服务中心
		$afterid = (int)$afterid;
		if($afterid){
			$where.= " AND at.id = $afterid ";
		}
		//服务人员
		$afteruserid = (int)$afteruserid;
		if($afteruserid){
			$where.= " AND o.afteruserid = $afteruserid ";
		}
		//产品编号
		if($productid!=""){
			$productid = (int)$productid;
			$where.= " AND oi.productid = $productid ";
		}
		//产品类别
		if($categoryid!=""){
			$categoryid = (int)$categoryid;
			$where.= " AND p.categoryid = $categoryid ";
		}
		//产品品牌
		if($brandid!=""){
			$brandid = (int)$brandid;
			$where.= " AND p.brandid = $brandid ";
		}

		$where.=" AND o.status NOT IN(7,-1) ";
		$where.=" AND o.ctype <> 6 ";

		if($ctype=="categorylist"){
			$query = "SELECT c.categoryid,c.name
			FROM ".DB_ORDERS.".ordersinfo AS oi
			INNER JOIN ".DB_ORDERS.".orders AS o ON oi.ordersid = o.id
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			INNER JOIN  ".DB_PRODUCT.".product AS p ON p.productid = oi.productid
			INNER JOIN ".DB_PRODUCT.".category AS c ON c.categoryid = p.categoryid
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
			GROUP BY p.categoryid
			ORDER BY p.categoryid ASC ";
			return $rows = $xdb->getRows($query);
		}elseif($ctype=="brandlist"){
			$query = "SELECT b.brandid,b.name
			FROM ".DB_ORDERS.".ordersinfo AS oi
			INNER JOIN ".DB_ORDERS.".orders AS o ON oi.ordersid = o.id
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			INNER JOIN  ".DB_PRODUCT.".product AS p ON p.productid = oi.productid
			INNER JOIN ".DB_PRODUCT.".brand AS b ON b.brandid = p.brandid
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
			GROUP BY p.brandid
			ORDER BY p.brandid ASC ";
			return $rows = $xdb->getRows($query);
		}elseif($ctype=="productlist"){
			$query = "SELECT p.productid,p.title
			FROM ".DB_ORDERS.".ordersinfo AS oi
			INNER JOIN ".DB_ORDERS.".orders AS o ON oi.ordersid = o.id
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			INNER JOIN  ".DB_PRODUCT.".product AS p ON p.productid = oi.productid
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
			GROUP BY oi.productid
			ORDER BY oi.productid ASC ";
			return $rows = $xdb->getRows($query);
		}elseif($ctype=="nums"){
			$query = "SELECT COUNT(oi.productid) AS total
			FROM ".DB_ORDERS.".ordersinfo AS oi
			INNER JOIN ".DB_ORDERS.".orders AS o ON oi.ordersid = o.id
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			INNER JOIN  ".DB_PRODUCT.".product AS p ON p.productid = oi.productid
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where ";
			$rows = $xdb->getRow($query);
			return (int)$rows["total"];
		}elseif($ctype=="price"){
			$query = "SELECT SUM(oi.price) AS price
			FROM ".DB_ORDERS.".ordersinfo AS oi
			INNER JOIN ".DB_ORDERS.".orders AS o ON oi.ordersid = o.id
			INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			INNER JOIN  ".DB_PRODUCT.".product AS p ON p.productid = oi.productid
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where ";
			$rows = $xdb->getRow($query);
			return round($rows["price"],2);
		}else{

		}
	}


	Public function works($str="")
	{

		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);				//订单编号

		//时间范围
		if($godate!=""){
			$where.=" AND jobs.datetime >= '$godate' ";
		}
		if($todate!=""){
			$where.=" AND jobs.datetime <= '$todate' ";
		}
		//服务区域
		$afterarea = (int)$afterarea;
		if($afterarea){
			$where.= " AND ct.parentid = $afterarea ";
		}
		//服务中心
		$afterid = (int)$afterid;
		if($afterid){
			$where.= " AND ct.id = $afterid ";
		}
		//工单类型
		if($type!=""){
			$type = (int)$type;
			$where.= " AND jobs.type = $type ";
		}
		//完成状况
		if($worked!=""){
			$worked = (int)$worked;
			$where.= " AND jobs.worked = $worked ";
		}
		//派工人员
		$adduserid = (int)$adduserid;
		if($adduserid!=""){
			$where.= " AND jobs.adduserid = $adduserid ";
		}
		//服务人员
		if($afteruserid!=""){
			$afteruserid = (int)$afteruserid;
			$where.= " AND jobs.afteruserid = $afteruserid ";
		}

		if($ctype=="counts"){
			if($vtype=="price"){
				$countval = " SUM(jobs.".$val.") AS price ";
			}else{
				$countval = " COUNT(jobs.".$val.") AS total ";
			}
			$query = "SELECT $countval
			FROM ".DB_ORDERS.".job_orders AS jobs
			INNER JOIN ".DB_ORDERS.".orders AS o ON o.id = jobs.ordersid
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON jobs.afterid = ct.id
			WHERE jobs.openid = ".OPEN_ID." AND jobs.hide = 1 AND o.status NOT IN(-1,7) $where ";
			//if($afteruserid == "0"){ echo $query; exit; }
			$row = $xdb->getRow($query);
			if($vtype=="price"){
				$rows = round($row["price"],2);
			}else{
				$rows = (int)$row["total"];
			}
			return $rows;
		}elseif($ctype=="afterlist"){
			$query = "SELECT ct.id,ct.name
			FROM ".DB_ORDERS.".config_teams AS ct
			INNER JOIN ".DB_ORDERS.".job_orders AS jobs ON jobs.afterid = ct.id
			WHERE jobs.openid = ".OPEN_ID." AND jobs.hide = 1 $where
			GROUP BY jobs.afterid
			ORDER BY ct.orderd DESC ";
			$rows = $xdb->getRows($query);
		}elseif($ctype=="afterusers"){
			$query = "SELECT u.userid,u.name,ct.name AS aftername
			FROM ".DB_ORDERS.".users AS u
			INNER JOIN ".DB_ORDERS.".job_orders AS jobs ON jobs.afteruserid = u.userid
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON jobs.afterid = ct.id
			WHERE jobs.openid = ".OPEN_ID." AND jobs.hide = 1 $where
			GROUP BY u.userid
			ORDER BY u.worknum ASC ";
			$rows = $xdb->getRows($query);
		}
		return $rows;
	}

	public function degreelogs($str="")
	{
		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);				//订单编号

		$datawhere = $saleswhere = $afterwhere = "";
		//时间范围
		if($godate!=""){
			$datawhere.=" job.datetime >= '$godate' AND ";
		}
		if($todate!=""){
			$datawhere.=" job.datetime <= '$todate' AND ";
		}
		if($salesarea){
			$salesarea = (int)$salesarea;
			$saleswhere.=" sts.parentid = $salesarea AND ";
		}
		if($salesid){
			$salesid = (int)$salesid;
			$saleswhere.=" sts.id = $salesid AND ";
		}
		if($afterarea){
			$afterarea = (int)$afterarea;
			$afterwhere.=" ats.parentid = $afterarea AND ";
		}
		if($afterid){
			$afterid = (int)$afterid;
			$afterwhere.=" ats.id = $afterid AND ";
		}


		$query = " SELECT job.afterid,job.afteruserid AS userid,au.worknum AS worknum,
 		au.name AS aftername,ats.name AS teamname
 		FROM ".DB_ORDERS.".job_orders AS job
 		INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
 		INNER JOIN ".DB_ORDERS.".config_teams AS sts ON o.salesid = sts.id
 		INNER JOIN ".DB_ORDERS.".config_teams AS ats ON job.afterid = ats.id
 		INNER JOIN ".DB_ORDERS.".users AS au ON job.afteruserid = au.userid
		WHERE job.openid = ".OPEN_ID." AND $datawhere $saleswhere $afterwhere job.afteruserid NOT IN(3,9) AND job.worked IN(1,4) AND job.hide = 1
		GROUP BY job.afteruserid ";
		$rows = $xdb->getRows($query);

		if($rows){
			$arr = array();
			$all_jobnums = 0;
			$all_worknum = 0;
			$all_callall = 0;
			$all_callnum = 0;
			$all_good	 = 0;
			$all_cool	 = 0;
			$all_hehe	 = 0;
			$all_nono	 = 0;
			foreach($rows AS $rs){

				$afteruserid = (int)$rs["userid"];
				if($afteruserid=="0"||$afteruserid=="1"){
					$rs["teamname"]	=	"异常服务结构";
				}
				//当期工单
				$query = " SELECT COUNT(job.id) AS total
				FROM ".DB_ORDERS.".job_orders AS job
				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
				INNER JOIN ".DB_ORDERS.".config_teams AS sts ON o.salesid = sts.id
				WHERE job.openid = ".OPEN_ID." AND $datawhere $saleswhere job.afteruserid = $afteruserid AND job.hide = 1 ";
				$row = $xdb->getRow($query);
				$rs["jobnums"]	= (int)$row["total"];
				$all_jobnums    = $all_jobnums+$rs["jobnums"];
				//当期完成
				$query = " SELECT COUNT(job.id) AS total
				FROM ".DB_ORDERS.".job_orders AS job
				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
				INNER JOIN ".DB_ORDERS.".config_teams AS sts ON o.salesid = sts.id
				WHERE job.openid = ".OPEN_ID." AND $datawhere $saleswhere job.worked = 1 AND job.afteruserid = $afteruserid AND job.hide = 1 ";
				$row = $xdb->getRow($query);
				$rs["worknum"]	= (int)$row["total"];
				$all_worknum	= $all_worknum+$rs["worknum"];
				//累计被回访
				$query = " SELECT COUNT(cd.id) AS total
				FROM ".DB_ORDERS.".callback_degree AS cd
				INNER JOIN ".DB_ORDERS.".job_orders AS job ON cd.jobsid = job.id
				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
				INNER JOIN ".DB_ORDERS.".config_teams AS sts ON o.salesid = sts.id
				WHERE job.openid = ".OPEN_ID." AND $saleswhere job.worked = 1 AND job.afteruserid = $afteruserid AND job.hide = 1 ";
				$row = $xdb->getRow($query);
				$rs["callall"]	= (int)$row["total"];
				$all_callall	= $all_callall+$rs["callall"];
				//当期回访
				$query = " SELECT COUNT(cd.id) AS total
				FROM ".DB_ORDERS.".callback_degree AS cd
				INNER JOIN ".DB_ORDERS.".job_orders AS job ON cd.jobsid = job.id
				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
				INNER JOIN ".DB_ORDERS.".config_teams AS sts ON o.salesid = sts.id
				WHERE job.openid = ".OPEN_ID." AND $datawhere $saleswhere job.worked = 1 AND job.afteruserid = $afteruserid AND job.hide = 1 ";
				$row = $xdb->getRow($query);
//				if($afteruserid=="0"){
//					$query = " SELECT COUNT(cd.id) AS total
//					FROM ".DB_ORDERS.".callback_degree AS cd
//					INNER JOIN ".DB_ORDERS.".job_orders AS job ON cd.jobsid = job.id
//					WHERE $datawhere job.worked = 1 AND job.afteruserid = $afteruserid AND job.hide = 1 ";
//					echo $query;exit;
//				}
				$rs["callnum"]	= (int)$row["total"];
				$all_callnum    = $all_callnum+$rs["callnum"];
				//非常满意
				$query = " SELECT COUNT(cd.id) AS total
				FROM ".DB_ORDERS.".callback_degree AS cd
				INNER JOIN ".DB_ORDERS.".job_orders AS job ON cd.jobsid = job.id
				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
				INNER JOIN ".DB_ORDERS.".config_teams AS sts ON o.salesid = sts.id
				WHERE job.openid = ".OPEN_ID." AND $datawhere $saleswhere cd.after = 3 AND job.worked = 1 AND job.afteruserid = $afteruserid AND job.hide = 1 ";
				$row = $xdb->getRow($query);
				$rs["good"]	= (int)$row["total"];
				$all_good	= $all_good+$rs["good"];
				//满意
				$query = " SELECT COUNT(cd.id) AS total
				FROM ".DB_ORDERS.".callback_degree AS cd
				INNER JOIN ".DB_ORDERS.".job_orders AS job ON cd.jobsid = job.id
				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
				INNER JOIN ".DB_ORDERS.".config_teams AS sts ON o.salesid = sts.id
				WHERE job.openid = ".OPEN_ID." AND $datawhere $saleswhere cd.after = 2 AND job.worked = 1 AND job.afteruserid = $afteruserid AND job.hide = 1 ";
				$row = $xdb->getRow($query);
				$rs["cool"]	= (int)$row["total"];
				$all_cool	=	$all_cool+$rs["cool"];
				//一般
				$query = " SELECT COUNT(cd.id) AS total
				FROM ".DB_ORDERS.".callback_degree AS cd
				INNER JOIN ".DB_ORDERS.".job_orders AS job ON cd.jobsid = job.id
				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
				INNER JOIN ".DB_ORDERS.".config_teams AS sts ON o.salesid = sts.id
				WHERE job.openid = ".OPEN_ID." AND $datawhere $saleswhere cd.after = 1 AND job.worked = 1 AND job.afteruserid = $afteruserid AND job.hide = 1 ";
				$row = $xdb->getRow($query);
				$rs["hehe"]	= (int)$row["total"];
				$all_hehe	= $all_hehe+$rs["hehe"];
				//NONO
				$query = " SELECT COUNT(cd.id) AS total
				FROM ".DB_ORDERS.".callback_degree AS cd
				INNER JOIN ".DB_ORDERS.".job_orders AS job ON cd.jobsid = job.id
				WHERE job.openid = ".OPEN_ID." AND $datawhere cd.after = 0 AND job.worked = 1 AND job.afteruserid = $afteruserid AND job.hide = 1 ";
				$row = $xdb->getRow($query);
				$rs["nono"]	= (int)$row["total"];
				$all_nono	=	$all_nono+$rs["nono"];
				$arr[]	=	$rs;
			}
			$all	=	array();
			$all[]  = array(
			"teamname"=>"汇总","jobnums"=>$all_jobnums,"worknum"=>$all_worknum,"callall"=>$all_callall,
			"callnum"=>$all_callnum,"good"=>$all_good,"cool"=>$all_cool,"hehe"=>$all_hehe,"nono"=>$all_nono);
			$rows = array_merge_recursive($all,$arr);
		}

		return $rows;
	}


	Public function degree($str="")
	{

		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);				//订单编号

		//时间范围
		if($godate!=""){
			$where.=" AND degree.datetime >= '$godate' ";
		}
		if($todate!=""){
			$where.=" AND degree.datetime <= '$todate' ";
		}
		//回访人员
		$saleuserid  = (int)$saleuserid;
		if($saleuserid){
			$where.= " AND degree.saleuserid = $saleuserid ";
		}
		//回访人员
		$afteruserid  = (int)$afteruserid;
		if($afteruserid){
			$where.= " AND degree.afteruserid = $afteruserid ";
		}
		//回访人员
		$userid  = (int)$userid;
		if($userid){
			$where.= " AND degree.userid = $userid ";
		}

		if($calltype=="sales"){
			$where.= " AND saleuserid > 0 ";
		}elseif($calltype=="sales"){
			$where.= " AND afteruserid > 0 ";
		}

		if($ctype=="counts"){
			if($vtype=="sums"){
				$countval = " SUM(degree.".$val.") AS total ";
			}else{
				$countval = " COUNT(degree.".$val.") AS total ";
			}
			$query = "SELECT $countval
			FROM ".DB_ORDERS.".callback_degree AS degree
			INNER JOIN ".DB_ORDERS.".users AS u ON degree.userid = u.userid
			WHERE u.openid = ".OPEN_ID."  $where ";
			$row = $xdb->getRow($query);
			if($vtype=="sums"){
				$rows = round($row["total"],2);
			}else{
				$rows = (int)$row["total"];
			}
		}elseif($ctype=="users"){
			$query = "SELECT u.userid,u.name,u.worknum
			FROM ".DB_ORDERS.".callback_degree AS degree
			INNER JOIN ".DB_ORDERS.".users AS u ON degree.userid = u.userid
			WHERE u.openid = ".OPEN_ID."  $where
			GROUP BY degree.userid
			ORDER BY u.worknum ASC ";
			$rows = $xdb->getRows($query);
		}elseif($ctype=="saleusers"){
			$query = "SELECT u.userid,u.name,u.worknum
			FROM ".DB_ORDERS.".callback_degree AS degree
			INNER JOIN ".DB_ORDERS.".users AS u ON degree.saleuserid = u.userid
			WHERE u.openid = ".OPEN_ID."  $where
			GROUP BY degree.saleuserid
			ORDER BY u.worknum ASC ";
			$rows = $xdb->getRows($query);
		}elseif($ctype=="afterusers"){
			$query = "SELECT u.userid,u.name,u.worknum
			FROM ".DB_ORDERS.".callback_degree AS degree
			INNER JOIN ".DB_ORDERS.".users AS u ON degree.afteruserid = u.userid
			WHERE u.openid = ".OPEN_ID."  $where
			GROUP BY degree.afteruserid
			ORDER BY u.worknum ASC ";
			$rows = $xdb->getRows($query);
		}
		return $rows;
	}

	Public function clockd($str="")
	{

		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($ctype=="clockd"){	//回访操作数

			//时间范围
			if($godate!=""){
				$godates = strtotime($godate." 00:00:00");
				$where.=" AND clockd.workdate >= '$godates' ";
			}
			if($todate!=""){
				$todates = strtotime($todate." 23:59:59");
				$where.=" AND clockd.workdate <= '$todates' ";
			}
			if($userid!=""){
				$userid = (int)$userid;
				$where.= " AND clockd.workuserid = $userid ";
			}
			$query = "SELECT COUNT(clockd.id) AS total
			FROM ".DB_ORDERS.".callback_clockd AS clockd
			WHERE clockd.openid = ".OPEN_ID." AND clockd.hide = 1 AND clockd.worked = 1 $where ";
			$row = $xdb->getRow($query);
			//print_r($row);exit;
			return $rows = (int)$row["total"];
			//echo $query."<br>";

		}elseif($ctype=="orders"){	//服务订单数

			//时间范围
			if($godate!=""){
				$where.=" AND o.datetime >= '$godate' ";
			}
			if($todate!=""){
				$where.=" AND o.datetime <= '$todate' ";
			}
			if($userid!=""){
				$userid = (int)$userid;
				$where.= " AND o.saleuserid = $userid ";
			}
			$query = "SELECT COUNT(o.id) AS total
			FROM ".DB_ORDERS.".orders AS o
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND o.type <> 1 AND o.status NOT IN(-1,7) $where ";
			$row = $xdb->getRow($query);
			$rows = (int)$row["total"];

		}elseif($ctype=="price"){	//服务销售金额

			//时间范围
			if($godate!=""){
				$where.=" AND o.datetime >= '$godate' ";
			}
			if($todate!=""){
				$where.=" AND o.datetime <= '$todate' ";
			}
			if($userid!=""){
				$userid = (int)$userid;
				$where.= " AND o.saleuserid = $userid ";
			}
			$query = "SELECT SUM(o.price) AS price
			FROM ".DB_ORDERS.".orders AS o
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND o.type <> 1 AND o.status NOT IN(-1,7) $where ";
			$row = $xdb->getRow($query);
			$rows = round($row["price"],2);

		}elseif($ctype=="customs"){	//服务客户数

			//时间范围
			if($godate!=""){
				$where.=" AND o.datetime >= '$godate' ";
			}
			if($todate!=""){
				$where.=" AND o.datetime <= '$todate' ";
			}
			if($userid!=""){
				$userid = (int)$userid;
				$where.= " AND o.afteruserid = $userid ";
			}
			if($ordertype=="1"){
				$where.=" AND o.type = 1 ";
			}else{
				$where.=" AND o.type <> 1 ";
			}
			$query = "SELECT COUNT(o.customsid) AS total
			FROM ".DB_ORDERS.".orders AS o
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND o.status NOT IN(-1,7) $where ";
			$row = $xdb->getRow($query);
			$rows = (int)$row["total"];

		}elseif($ctype=="users"){

			//时间范围
			if($godate!=""){
				$godates = strtotime($godate." 00:00:00");
				$where.=" AND clockd.workdate >= '$godates' ";
			}
			if($todate!=""){
				$todates = strtotime($todate." 23:59:59");
				$where.=" AND clockd.workdate <= '$todates' ";
			}
			if($userid!=""){
				$userid = (int)$userid;
				$where.= " AND clockd.workuserid = $userid ";
			}
			$query = "SELECT u.userid,u.name,u.worknum
			FROM ".DB_ORDERS.".callback_clockd AS clockd
			INNER JOIN ".DB_ORDERS.".users AS u ON clockd.workuserid = u.userid
			WHERE clockd.openid = ".OPEN_ID." AND clockd.hide = 1 AND workuserid > 0 $where
			GROUP BY clockd.workuserid
			ORDER BY u.worknum ASC ";
			$rows = $xdb->getRows($query);

		}
		return $rows;

	}

	Public function areas($str="")
	{

		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($ctype=="customs"){

			//时间范围
			if($godate!=""){
				$where.=" AND o.datetime >= '$godate' ";
			}
			if($todate!=""){
				$where.=" AND o.datetime <= '$todate' ";
			}
			if($provid){
				$provid = (int)$provid;
				$where.= " AND o.provid = $provid ";
			}
			if($cityid){
				$cityid = (int)$cityid;
				$where.= " AND o.cityid = $cityid ";
			}
			if($areaid){
				$areaid = (int)$areaid;
				$where.= " AND o.areaid = $areaid ";
			}
			if($ordertype=="1"){
				$where.=" AND o.type = 1 ";
			}else{
				$where.=" AND o.type = 3 ";
			}
			$query = "SELECT o.customsid
			FROM ".DB_ORDERS.".orders AS o
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND o.status NOT IN(-1,7) $where
			GROUP BY o.customsid ";
			$row = $xdb->getRows($query);
			$rows = (int)COUNT($row);

		}elseif($ctype=="orders"){

			//时间范围
			if($godate!=""){
				$where.=" AND o.datetime >= '$godate' ";
			}
			if($todate!=""){
				$where.=" AND o.datetime <= '$todate' ";
			}
			if($provid){
				$provid = (int)$provid;
				$where.= " AND o.provid = $provid ";
			}
			if($cityid){
				$cityid = (int)$cityid;
				$where.= " AND o.cityid = $cityid ";
			}
			if($areaid){
				$areaid = (int)$areaid;
				$where.= " AND o.areaid = $areaid ";
			}
			$query = "SELECT o.id
			FROM ".DB_ORDERS.".orders AS o
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND o.status NOT IN(-1,7) AND o.type = 1 $where
			GROUP BY o.id ";//echo $query;
			$row = $xdb->getRows($query);
			$rows = (int)COUNT($row);

		}elseif($ctype=="porders"){

			//时间范围
			if($godate!=""){
				$where.=" AND o.datetime >= '$godate' ";
			}
			if($todate!=""){
				$where.=" AND o.datetime <= '$todate' ";
			}
			if($provid){
				$provid = (int)$provid;
				$where.= " AND o.provid = $provid ";
			}
			if($cityid){
				$cityid = (int)$cityid;
				$where.= " AND o.cityid = $cityid ";
			}
			if($areaid){
				$areaid = (int)$areaid;
				$where.= " AND o.areaid = $areaid ";
			}

			$query = "SELECT o.parentid
			FROM ".DB_ORDERS.".orders AS o
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND o.status NOT IN(-1,7) AND o.type = 3 $where
			GROUP BY o.parentid ";
			$row = $xdb->getRows($query);
			$rows = (int)COUNT($row);

		}elseif($ctype=="areas"){

			$provid = (int)$provid;
			$cityid = (int)$cityid;
			if($provid){
				if($cityid){
					$parentid = $cityid;
				}else{
					$parentid = $provid;
				}
			}else{
				$parentid = 0;
			}
			$query = " SELECT * FROM ".DB_CONFIG.".areas WHERE areaid > 0 AND parentid = $parentid ";
			$rows = $xdb->getRows($query);

		}else{

		}
		//if($sh){ echo $query; }
		return $rows;
	}



	Public function invoice($str="")
	{

		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);				//订单编号


		if($datetype=="checked"){
			//时间范围
			if($gotime!=""){
				$where.=" AND checkdate >= '$gotime' ";
			}
			if($totime!=""){
				$where.=" AND checkdate <= '$totime' ";
			}
		}elseif($datetype=="worked"){
			//时间范围
			if($gotime!=""){
				$where.=" AND workdate >= '$gotime' ";
			}
			if($totime!=""){
				$where.=" AND workdate <= '$totime' ";
			}
		}else{
			//时间范围
			if($gotime!=""){
				$where.=" AND dateline >= '$gotime' ";
			}
			if($totime!=""){
				$where.=" AND dateline <= '$totime' ";
			}
		}

		if($checked!=""){
			$checked = (int)$checked;
			$where.=" AND checked = $checked ";
		}

		if($worked!=""){
			$worked = (int)$worked;
			$where.=" AND worked = $worked ";
		}

		if($cateid){
			$cateid = (int)$cateid;
			$where.=" AND cateid = $cateid ";
		}

		if($ctype=="price"){

			$query = "SELECT SUM(price) AS price
			FROM ".DB_ORDERS.".invoice
			WHERE openid = ".OPEN_ID." AND hide = 1 $where ";
			$row = $xdb->getRow($query);
			$total = round($row["price"],2);
			return $total;

		}else{

			$query = "SELECT COUNT(id) AS total
			FROM ".DB_ORDERS.".invoice
			WHERE openid = ".OPEN_ID." AND hide = 1 $where ";
			$row = $xdb->getRow($query);
			$total = (int)$row["total"];
			return $total;

		}

	}

	Public function teams($str=""){


		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if($ctype=="teamslist"){

			if($afterarea){
				$where.=" AND parentid = $afterarea ";
			}else{
				$where.=" AND parentid <> 0 ";
			}
			if($afterid){
				$where.=" AND afterid = $afterid ";
			}

			$query = " SELECT * FROM ".DB_ORDERS.".config_teams
			WHERE openid = ".OPEN_ID." AND type = 3 AND hide = 1 $where
			ORDER BY minplan DESC,id ASC ";
			return $xdb->getRows($query);

		}else{

			if($afterid!=""){ $afterid = (int)$afterid; $where.=" AND jobs.afterid = $afterid ";  }
			if($checked!=""){ $where.=" AND jobs.checked = 1 ";  }
			if($godate!="")	{ $where.=" AND jobs.datetime >= '$godate' ";  }
			if($todate!="")	{ $where.=" AND jobs.datetime <= '$todate' ";  }
			$sql = " SELECT COUNT(jobs.id) AS nums
			FROM ".DB_ORDERS.".job_orders AS jobs
			INNER JOIN ".DB_ORDERS.".orders AS o ON o.id = jobs.ordersid
			WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND jobs.hide = 1 $where ";
			$rows = $xdb->getRow($sql);
			return (int)$rows["nums"];

		}
	}

	Public function postjob($str=""){

		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if($ctype=="users"){

			if($salesarea!=""){ $salesarea = (int)$salesarea; $where.=" AND ct.parentid = $salesarea "; }
			if($salesid!=""){ $salesid = (int)$salesid; $where.=" AND ct.id = $salesid "; }
			$query = " SELECT u.userid,u.name,u.worknum
			FROM ".DB_ORDERS.".config_teams_jobs AS cj
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON ct.id = cj.teamid
			INNER JOIN ".DB_ORDERS.".users AS u ON u.userid = cj.userid
			WHERE ct.openid = ".OPEN_ID." AND u.checked = 1 AND ct.type = 1 AND u.usertype = 1 $where
			GROUP BY u.userid
			ORDER BY u.worknum ASC ";
			return $xdb->getRows($query);

		}elseif($ctype=="teams"){



			if($salesarea||$salesid){

				if($salesarea!=""){ $salesarea = (int)$salesarea; $uwhere.=" AND ct.parentid = $salesarea "; }
				if($salesid!=""){ $salesid = (int)$salesid; $uwhere.=" AND ct.id = $salesid "; }
				$query = " SELECT u.userid
				FROM ".DB_ORDERS.".config_teams_jobs AS cj
				INNER JOIN ".DB_ORDERS.".config_teams AS ct ON ct.id = cj.teamid
				INNER JOIN ".DB_ORDERS.".users AS u ON u.userid = cj.userid
				WHERE u.openid = ".OPEN_ID." AND u.checked = 1 AND ct.type = 1 AND u.usertype = 1 $uwhere
				GROUP BY u.userid
				ORDER BY u.worknum ASC ";
				$rows = $xdb->getRows($query);
				if($rows){
					$arr = array();
					foreach($rows AS $rs){
						$arr[] = $rs["userid"];
					}
					$join = implode(",",$arr);
					$where.= " AND job.adduserid IN($join)";
				}
			}

			//时间范围
			if($godate!=""){
				$gotime = strtotime($godate." 00:00:00");
				$where.=" AND job.dateline >= '$gotime' ";
			}
			if($todate!=""){
				$totime = strtotime($todate." 23:59:59");
				$where.=" AND job.dateline <= '$totime' ";
			}
			$query = " SELECT ct.id,ct.name,ct.numbers
			FROM ".DB_ORDERS.".job_orders AS job
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON ct.id = afterid
			WHERE job.openid = ".OPEN_ID." AND job.type = 3 AND parentid <> 0 AND job.hide = 1 AND ct.parentid NOT IN(132) $where
			GROUP BY ct.id
			ORDER BY ct.orderd DESC ";
			return $xdb->getRows($query);

		}elseif($ctype=="count"){

			//时间范围
			if($godate!=""){
				$gotime = strtotime($godate." 00:00:00");
				$where.=" AND dateline >= '$gotime' ";
			}
			if($todate!=""){
				$totime = strtotime($todate." 23:59:59");
				$where.=" AND dateline <= '$totime' ";
			}
			if($afterid!=""){
				$afterid = (int)$afterid; $where.=" AND afterid = $afterid ";
			}else{
				return 0;
			}
			if($type!=""){
				$type = (int)$type; $where.=" AND type = $type ";
			}
			if($adduserid!=""){
				$adduserid = (int)$adduserid; $where.=" AND adduserid = $adduserid ";
			}

			if($salesarea||$salesid){
				if($salesarea!=""){ $salesarea = (int)$salesarea; $uwhere.=" AND ct.parentid = $salesarea "; }
				if($salesid!=""){ $salesid = (int)$salesid; $uwhere.=" AND ct.id = $salesid "; }
				$query = " SELECT u.userid
				FROM ".DB_ORDERS.".config_teams_jobs AS cj
				INNER JOIN ".DB_ORDERS.".config_teams AS ct ON ct.id = cj.teamid
				INNER JOIN ".DB_ORDERS.".users AS u ON u.userid = cj.userid
				WHERE ct.openid = ".OPEN_ID." AND u.checked = 1 AND ct.type = 1 AND u.usertype = 1 $uwhere
				GROUP BY u.userid
				ORDER BY u.worknum ASC ";
				$rows = $xdb->getRows($query);
				if($rows){
					$arr = array();
					foreach($rows AS $rs){
						$arr[] = $rs["userid"];
					}
					$join = implode(",",$arr);
					$where.= " AND adduserid IN($join)";
				}
			}

			$query = " SELECT COUNT(id) AS total
			FROM ".DB_ORDERS.".job_orders
			WHERE hide = 1 $where ";
			//echo $query;exit;
			$row = $xdb->getRow($query);
			return (int)$row["total"];
		}else{

		}

	}






	/* 2014 */

	Public function tags($str=""){

		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$gotime = strtotime($godate." 00:00:00");
		$totime = strtotime($todate." 23:59:59");


		if($ctype=="users"){

			$query = " SELECT u.userid,u.name,u.worknum
			FROM ".DB_ORDERS.".orders_tags AS ct
			INNER JOIN ".DB_ORDERS.".users AS u ON u.userid = ct.userid
			WHERE u.openid = ".OPEN_ID." AND ct.dateline >='$gotime' AND ct.dateline <='$totime'
			GROUP BY ct.userid
			ORDER BY ct.userid ASC ";
			$rows = $xdb->getRows($query);
			return $rows;

		}elseif($ctype=="customs"){

			$userid = (int)$userid;
			if($userid){
				$where = " AND ct.userid = $userid ";
			}
			$tagid = (int)$tagid;
			if($tagid){
				$where.= " AND ct.tagid = $tagid ";
			}
			$query = " SELECT ct.customsid
			FROM ".DB_ORDERS.".orders_tags AS ct
			INNER JOIN ".DB_ORDERS.".orders AS o ON o.id = ct.ordersid
			WHERE o.openid = ".OPEN_ID." AND ct.dateline >='$gotime' AND ct.dateline <='$totime' $where
			GROUP BY ct.customsid ";
			$rows = $xdb->getRows($query);
			return (int)COUNT($rows);

		}elseif($ctype=="tags"){

			$userid = (int)$userid;
			if($userid){
				$where.= " AND ct.userid = $userid ";
			}
			$query = " SELECT ct.tagid
			FROM ".DB_ORDERS.".orders_tags AS ct
			INNER JOIN ".DB_ORDERS.".orders AS o ON o.id = ct.ordersid
			WHERE o.openid = ".OPEN_ID." AND ct.dateline >='$gotime' AND ct.dateline <='$totime' $where  ";
			$rows = $xdb->getRows($query);
			return (int)COUNT($rows);

		}elseif($ctype=="taglist"){

			if($userid){
				$userid = (int)$userid;
				$where = " AND ct.userid = $userid ";
			}
			$query = " SELECT t.id,t.name
			FROM ".DB_ORDERS.".orders_tags AS ct
			INNER JOIN ".DB_ORDERS.".config_customs_tag AS t ON t.id = ct.tagid
			INNER JOIN ".DB_ORDERS.".orders AS o ON o.id = ct.ordersid
			WHERE o.openid = ".OPEN_ID." AND ct.dateline >='$gotime' AND ct.dateline <='$totime' $where
			GROUP BY ct.tagid ";
			$rows = $xdb->getRows($query);
			return $rows;

		}

	}

	Public function spare($str=""){

		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$gotime = strtotime($godate." 00:00:00");
		$totime = strtotime($todate." 23:59:59");
		$where  = " ";

		$afterarea = (int)$afterarea;
		if($afterarea){
			$where.=" AND ct.parentid = $afterarea ";
		}

		$afterid = (int)$afterid;
		if($afterid){
			$where.=" AND os.afterid = $afterid ";
		}

		if($cateid!=""){
			$cateid = (int)$cateid;
			$where.=" AND os.cateid = $cateid ";
		}

		if($productid!=""){
			$productid = (int)$productid;
			$where.=" AND os.productid = $productid ";
		}

		if($checked!=""){
			$checked = (int)$checked;
			$where.=" AND os.checked = $checked ";
		}

		if($ctype=="order"){

			$query = " SELECT os.ordersid
			FROM ".DB_ORDERS.".orders_spare AS os
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON os.afterid = ct.id
			WHERE os.hide = 1 $where
			GROUP BY os.ordersid ";
			$rows = $xdb->getRows($query);
			return COUNT($rows);

		}elseif($ctype=="after"){

			$query = " SELECT os.afterid,ct.name AS aftername
			FROM ".DB_ORDERS.".orders_spare AS os
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON os.afterid = ct.id
			WHERE os.hide = 1 $where
			GROUP BY os.afterid ";
			$rows = $xdb->getRows($query);
			return $rows;

		}elseif($ctype=="product"){

			$query = " SELECT os.productid,p.title,p.encoded
			FROM ".DB_ORDERS.".orders_spare AS os
			INNER JOIN ".DB_PRODUCT.".product AS p ON p.productid = os.productid
			WHERE os.hide = 1 $where
			GROUP BY os.productid ";
			$rows = $xdb->getRows($query);
			return $rows;

		}elseif($ctype=="price"){

			$query = " SELECT SUM(os.price) AS price
			FROM ".DB_ORDERS.".orders_spare AS os
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON os.afterid = ct.id
			WHERE os.hide = 1 $where ";
			$row = $xdb->getRow($query);
			return $row["price"];

		}elseif($ctype=="sparenum"){

			$query = " SELECT COUNT(os.id) AS total
			FROM ".DB_ORDERS.".orders_spare AS os
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON os.afterid = ct.id
			WHERE os.hide = 1 $where ";
			$rows = $xdb->getRow($query);
			return $rows["total"];

		}elseif($ctype=="nums"){

			$query = " SELECT SUM(os.nums) AS total
			FROM ".DB_ORDERS.".orders_spare AS os
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON os.afterid = ct.id
			WHERE os.hide = 1 $where ";
			$rows = $xdb->getRow($query);
			return $rows["total"];

		}

	}


	Public function enjobs($str="")
	{
		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);				//订单编号

		//时间范围
		if($godate!=""){
			$where.=" AND jobs.datetime >= '$godate' ";
		}
		if($todate!=""){
			$where.=" AND jobs.datetime <= '$todate' ";
		}
		//服务区域
		$afterarea = (int)$afterarea;
		if($afterarea){
			$where.= " AND ct.parentid = $afterarea ";
		}
		//服务中心
		$afterid = (int)$afterid;
		if($afterid){
			$where.= " AND ct.id = $afterid ";
		}
		//工单类型
		if($type!=""){
			$type = (int)$type;
			$where.= " AND jobs.type = $type ";
		}
		//完成状况
		if($worked!=""){
			$worked = (int)$worked;
			$where.= " AND jobs.worked = $worked ";
		}
		//服务人员
		if($afteruserid!=""){
			$afteruserid = (int)$afteruserid;
			$where.= " AND jobs.afteruserid = $afteruserid ";
		}

		if($ctype=="counts"){

			$query = "SELECT COUNT(jobs.id) AS total
			FROM ".DB_ORDERS.".job_orders AS jobs
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON jobs.afterid = ct.id
			WHERE jobs.openid = ".OPEN_ID." AND jobs.hide = 1 $where ";
			//echo $query;exit;
			$row = $xdb->getRow($query);
			$rows = (int)$row["total"];
			return $rows;

		}elseif($ctype=="price"){

			$query = "SELECT SUM(jc.".$val.") AS price
			FROM ".DB_ORDERS.".job_charge AS jc
			INNER JOIN ".DB_ORDERS.".job_orders AS jobs ON jobs.id = jc.jobsid
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON jobs.afterid = ct.id
			WHERE jobs.openid = ".OPEN_ID." AND jobs.hide = 1 $where ";
			if($val="encharge"){
				//echo $query;exit;
			}
			$row = $xdb->getRow($query);
			$rows = round($row["price"],2);
			return $rows;

		}elseif($ctype=="charge"){

			$query = "SELECT COUNT(jobs.id) AS total
			FROM ".DB_ORDERS.".job_orders AS jobs
			INNER JOIN ".DB_ORDERS.".job_charge AS jc ON jobs.id = jc.jobsid
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON jobs.afterid = ct.id
			WHERE jobs.openid = ".OPEN_ID." AND jobs.hide = 1 $where ";
			//echo $query;exit;
			$row = $xdb->getRow($query);
			$rows = (int)$row["total"];
			return $rows;

		}elseif($ctype=="users"){
			$query = "SELECT u.userid,u.name,u.worknum
			FROM ".DB_ORDERS.".users AS u
			INNER JOIN ".DB_ORDERS.".job_orders AS jobs ON jobs.afteruserid = u.userid
			INNER JOIN ".DB_ORDERS.".config_teams AS ct ON jobs.afterid = ct.id
			WHERE jobs.openid = ".OPEN_ID." AND jobs.hide = 1 $where
			GROUP BY u.userid
			ORDER BY u.worknum ASC ";
			$rows = $xdb->getRows($query);
		}
		return $rows;
	}


	Public function seller($str="")
	{
		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		//时间范围
		if($godate!=""){
			$godate = trim($godate);
			$gotime = strtotime($godate." 00:00:00");
		}
		if($todate!=""){
			$todate = trim($todate);
			$totime = strtotime($todate." 23:59:59");
		}
		if($sellercode!=""){
			$uwhere.=" st.encoded = '$sellercode' ";
		}

		$dateline = time();

		$query = " SELECT u.userid,u.price,ui.name AS name,ui.teamid,st.encoded AS sellercode
		FROM ".DB_FUWU.".users AS u
		INNER JOIN ".DB_FUWU.".users_info AS ui ON ui.userid = u.userid
		INNER JOIN ".DB_ORDERS.".config_teams AS st ON ui.teamid = st.id
		WHERE st.openid = ".OPEN_ID." AND ui.checked = 1 AND u.type = 1 $uwhere
		ORDER BY price ASC
		LIMIT 0,50 ";
		$data = $xdb->getRows($query);

		if($data){
			$arr = array();
			foreach($data AS $rs) {

				$teamid = (int)$rs["teamid"];
				$price  = @round($rs["price"],2);
				$userid = (int)$rs["userid"];

				$query = " SELECT COUNT(job.id) AS total
				FROM ".DB_ORDERS.".job_orders AS job
				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
				WHERE job.openid = ".OPEN_ID." AND job.hide = 1 AND job.worked = 0 AND o.salesid = $teamid ";
				$row = $xdb->getRow($query);
				$worknums = (int)$row["total"];	    //处理中的工单数量

				$dateline = time()-86400*50;
				$query = " SELECT COUNT(job.id) AS total
				FROM ".DB_ORDERS.".job_orders AS job
				INNER JOIN ".DB_ORDERS.".job_charge AS jc ON jc.jobsid = job.id
				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
				WHERE job.openid = ".OPEN_ID." AND jc.fuwued = 0 AND job.hide = 1 AND job.workdateline > '$dateline'
 				AND job.worked = 1 AND o.salesid = $teamid ";
				$row = $xdb->getRow($query);
				$checknums = (int)$row["total"];

				$worknums           =   $worknums+$checknums;
				$rs["worknums"]     =   $worknums;
				$rs["workprice"]	=	@round($worknums*100,2);
				$postprice          =   $worknums*100;
				if($price>=$postprice){
					$postnums = ceil(($price-$postprice)/100);
				}else{
					$postnums = 0;
				}
				$rs["postnums"]    =   $postnums;

				$query = " SELECT COUNT(job.id) AS total
 				FROM ".DB_ORDERS.".job_orders AS job
 				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
 				WHERE job.openid = ".OPEN_ID." AND o.hide = 1 AND o.salesid = $teamid AND job.dateline >= '$gotime' AND job.dateline <= '$totime' ";
				$row = $xdb->getRow($query);
				$rs["addnums"]	   =   (int)$row["total"];

				$query = " SELECT COUNT(job.id) AS total
 				FROM ".DB_ORDERS.".job_orders AS job
 				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
 				INNER JOIN ".DB_ORDERS.".job_charge AS jc ON jc.jobsid = job.id
 				WHERE job.openid = ".OPEN_ID." AND o.salesid = $teamid AND o.status NOT IN(7,-1) AND jc.fuwued = 1 AND jc.fuwutime >= '$gotime' AND jc.fuwutime <= '$totime' ";
				$row = $xdb->getRow($query);
				$rs["chargenums"]  =   (int)$row["total"];

				$query = " SELECT SUM(jc.fuwu) AS total
 				FROM ".DB_ORDERS.".job_orders AS job
 				INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
 				INNER JOIN ".DB_ORDERS.".job_charge AS jc ON jc.jobsid = job.id
 				WHERE job.openid = ".OPEN_ID." AND o.salesid = $teamid AND o.status NOT IN(7,-1) AND jc.fuwued = 1 AND jc.fuwutime >= '$gotime' AND jc.fuwutime <= '$totime' ";
				$row = $xdb->getRow($query);
				$rs["chargeprice"]  =   @round($row["total"],2);

				$query = " SELECT SUM(price) AS total
				FROM ".DB_FUWU.".users_charge
				WHERE userid = $userid AND type = 2 AND dateline >= '$gotime' AND dateline <= '$totime' AND hide = 1 ";
				$row = $xdb->getRow($query);
				$rs["czprice"]  =   @round($row["total"],2);


				$arr[]	=	$rs;
			}
			$data = $arr;
		}
		//print_r($arr);
		return $data;


	}

	Public function jobsmonitor($str="")
	{
		$xdb = xdb();
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$worked = (int)$worked;

		if($jobsid){
			$jobsid = (int)$jobsid;
			$where.=" job.id = $jobsid AND ";
		}
		if($ordersid){
			$ordersid = (int)$ordersid;
			$where.=" o.id = $ordersid AND ";
		}

		if(!$jobsid&&!$ordersid){

			if($salesarea){
				$salesarea = (int)$salesarea;
				$where.=" sts.parentid = $salesarea AND ";
			}
			if($salesid){
				$salesid = (int)$salesid;
				$where.=" sts.id = $salesid AND ";
			}
			if($afterarea){
				$afterarea = (int)$afterarea;
				$where.=" ats.parentid = $afterarea AND ";
			}
			if($afterid){
				$afterid = (int)$afterid;
				$where.=" ats.id = $afterid AND ";
			}

			if($godate!=""){
				//时间范围
				if($godate!=""){
					$godate = trim($godate);
					$where.=" job.datetime >= '$godate' AND ";
				}
				if($todate!=""){
					$todate = trim($todate);
					$where.=" job.datetime <= '$todate' AND ";
				}
			}else{
				if($todate!=""){
					$todate = trim($todate);
					$where.=" job.datetime <= '$todate' AND ";
				}
				$jobdateline = time()-86400*300;
				$where.=" job.dateline => $jobdateline AND ";
			}

			//省份
			$provid = (int)$provid;
			if($provid){  $where.= " o.provid = $provid AND "; }
			//城市
			$cityid = (int)$cityid;
			if($cityid){  $where.= " o.cityid = $cityid AND "; }
			//区域
			$areaid = (int)$areaid;
			if($areaid){  $where.= " o.areaid = $areaid AND "; }

		}

		$query = " SELECT job.id AS jobsid,job.ordersid,job.type,job.dateline,job.datetime,job.afteruserid,
 		sts.name AS salesname,ats.name AS aftername,au.name AS afteruname,job.workdateline,job.worked
		FROM ".DB_ORDERS.".job_orders AS job
		INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
		INNER JOIN ".DB_ORDERS.".config_teams AS sts ON o.salesid = sts.id
		INNER JOIN ".DB_ORDERS.".config_teams AS ats ON job.afterid = ats.id
		INNER JOIN ".DB_ORDERS.".users AS au ON job.afteruserid = au.userid
		WHERE job.openid = ".OPEN_ID." AND $where job.worked = $worked AND o.status NOT IN(7,-1) AND job.hide = 1
		ORDER BY job.datetime ASC,job.dateline ASC
		";
		$rows = $xdb->getPageRows($query,25);
		//print_r($rows);
		if($rows["record"]){
			$arr = $data = array();
			$arr["pages"] = $rows["pages"];
			foreach($rows["record"] AS $rs)
			{
				$ordersid	= (int)$rs["ordersid"];
				$jobsid		= (int)$rs["jobsid"];

				//统计订单投诉数
				$startime = strtotime($rs["datetime"]);
				$query = " SELECT COUNT(id) AS total FROM ".DB_ORDERS.".complaint WHERE ordersid = $ordersid
				AND type = 4 AND hide = 1 AND dateline > $startime ";
				$row   = $xdb->getRow($query);
				$rs["complaint"]=	(int)$row["total"];

				//统计工单催单数
				$query = " SELECT COUNT(id) AS total FROM ".DB_ORDERS.".job_tourge WHERE jobsid = $jobsid AND hide = 1 ";
				$row   = $xdb->getRow($query);
				$rs["tourge"]	=	(int)$row["total"];

				//满意度回访
				$query = " SELECT COUNT(id) AS total FROM ".DB_ORDERS.".callback_degree WHERE jobsid = $jobsid AND checked = 1";
				$row  = $xdb->getRow($query);
				$rs["degree"]	=	(int)$row["total"];

				//最后操作时间
				$query = " SELECT id,dateline FROM ".DB_ORDERS.".orders_logs WHERE ordersid = $ordersid AND hide = 1 ORDER BY dateline DESC ";
				$row = $xdb->getRow($query);
				$rs["logstime"] = $row["dateline"];

				$data[]	= $rs;
			}
			$arr["record"]	=	$data;
			$rows = $arr;
		}
		return $rows;
	}

}

?>
