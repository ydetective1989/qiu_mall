<?php
class ordersModules extends Modules
{
	//添加订单
	Public function add_orders()
	{

		extract($_POST);

		$parentid = (int)$this->id;
		$userid = (int)$this->cookie->get("userid");

		if($parentid){	//调用主订单相关信息

			$info = $this->getrow("id=$parentid");

		}else{

			//判断合同号是否存在
			if($contract){
					$query = "SELECT id FROM ".DB_ORDERS.".orders WHERE openid = ".OPEN_ID." AND contract = '$contract'  ";
					$row = $this->db->getRow($query);
					if($row){ msgbox("","合同号已存在，请不要重新录入订单！"); }
			}

		}

		if($point==""){
			//坐标获取
			$curl = getFunc("curl");
			$url = "http://api.map.baidu.com/geocoder/v2/?address=".urlencode($address)."&output=json&ak=E5103eeac5a35ba21edd3f04aef82ef7&callback=?";
			$data  = $curl->contents($url);
			$mapinfo  = json_decode($data,true);
			$point = $mapinfo["result"]["location"];
			if($point){
				$pointlng = $point["lng"];
				$pointlat = $point["lat"];
			}else{
				$pointlng = $info["pointlng"];
				$pointlat = $info["pointlat"];
			}
		}

		//生成订单流水号
		$randstr  = str_pad(substr($this->cookie->get("userid"),3),3,"0",STR_PAD_LEFT).rand(0,9);
		$ordernum = date("YmdHis",time()).$randstr;		//请与贵网站订单系统中的唯一订单号匹配

		//其它销售人员
		$othersalesuserid = (int)$othersalesuserid;
		if($othersalesuserid){ $saleuserid = (int)$othersalesuserid; }

		if($type==""){
			$type = $this->type;
			$type = ($type)?$type:"1";
		}

		if($source==""){
			$source = $this->source;
			$source = ($source)?$source:"PAAS";
		}

		$ctype = ((int)$ctype)?(int)$ctype:"1";

		//录入订单信息
		$arr = array(
			"openid"			=>	OPEN_ID,
			"datetime"		=>	trim($datetime),
			"ordernum"		=>	trim($ordernum),
			"parentid"		=>	(int)$parentid,
			"source"			=>	"PAAS",
			"type"				=>	(int)$type,
			"ctype"				=>	(int)$ctype,
			"customsid"		=>	(int)$customsid,
			"contract"		=>	trim($contract),
			"name"				=>	trim($name),
			"sex"					=>	(int)$sex,
			"provid"		=>	(int)$provid,
			"cityid"		=>	(int)$cityid,
			"areaid"		=>	(int)$areaid,
			"loops"			=>	(int)$loops,
			"address"		=>	trim($address),
			"postnum"		=>	trim($postnum),
			"phone"			=>	trim($phone),
			"mobile"		=>	trim($mobile),
			"email"			=>	trim($email),
			"qq"				=>	trim($qq),
			"wangwang"	=>	trim($wangwang),
			"im"				=>	trim($im),
			"price_setup"		=>	round($price_setup,2),
			"price_deliver"	=>	round($price_deliver,2),
			"price_minus"		=>	round($price_minus,2),
			"price_cash"		=>	round($price_cash,2),
			"price_other"		=>	round($price_other,2),
			"price_detail"	=>	trim($price_detail),
			"paytype"			=>	($paytype)?(int)$paytype:"0",
			"setuptype"		=>	($setuptype)?(int)$setuptype:"4",
			"delivertype"	=>	($delivertype)?(int)$delivertype:"5",
			"plansend"		=>	$datetime,
			"plansetup"		=>	$datetime,
			"detail"			=>	trim($detail),
			"salesid"			=>	(int)$salesid,
			"saleuserid"	=>	($saleuserid)?(int)$saleuserid:$userid,
			"dateline"		=>	time(),
			"adduserid"		=>	(int)$userid,
			"updateline"	=>	time(),
			"upuserid"		=>	(int)$userid,
			"pointlng"		=>	$pointlng,
			"pointlat"		=>	$pointlat

		);//280577
		$logsarr.= plugin::arrtostr($arr);
		$this->db->insert(DB_ORDERS.".orders",$arr);
		$ordersid = (int)$this->db->getLastInsId();

		//记录产品信息
		if($products){

			//计算总金额
			$allprice = "0";
			$price		= "0";
			$parr 		= array();
			$grouped	= 1;

			foreach($products as $item){	//计算总费用
					$pprice   = @round($prices[$item],2);
					$pnums		= (int)$nums[$item];
					$price 		= @round($pprice*$pnums,2);
					$allprice = $allprice + $price;
					$arr = array(
						'ordersid'	=>	$ordersid,
						'grouped'		=>	$grouped,
						'productid'	=>	(int)$productids[$item],
						'price'			=>	$pprice,
						'encoded'		=>	$encodeds[$item],
						'title'			=>	$titles[$item],
						'nums'			=>	$pnums,
						'detail'		=>	$details[$item]
					);
					$this->db->insert(DB_ORDERS.".ordersinfo",$arr);
					$logsarr.= plugin::arrtostr($arr);
					$grouped++;
			}
			//实际费用 商品总价+安装费+送货费+优惠+其它费用
			$endprice = $allprice+$price_setup+$price_deliver+$price_minus+$price_other;
			//更新总价
			$where = array('id'=>$ordersid);
			$arr = array(
					'price_all'	=>	@round($allprice,2),
					'price'			=>	@round($endprice,2)
			);
			$logsarr.= plugin::arrtostr($arr);
			$this->db->update(DB_ORDERS.".orders",$arr,$where);

			//从订单时，增加操作记录到主订单
			if((int)$parentid){
				$arr = array(
					'ordersid'	=> (int)$parentid,
					'type'			=> 0,
					'detail'		=> "增加子订单编号为：".$ordersid,
					'datetime'	=> date("Y-m-d"),
					'userid'		=> $userid,
					"locked"		=> 1,
					'dateline'	=> time()
				);
				$logsarr.= plugin::arrtostr($arr);
				$this->db->insert(DB_ORDERS.".orders_logs",$arr);
			}
		}else{
			return "没有添加产品信息";
		}

		//更新电话缓存
		if($mobile==$phone){
				$phone = "";
		}
		if($mobile){
			$arr = array("ordersid"=>$ordersid,"phone"=>$mobile);
			$this->db->insert(DB_ORDERS.".cache_phone",$arr);
		}
		if($phone){
			$arr = array("ordersid"=>$ordersid,"phone"=>$phone);
			$this->db->insert(DB_ORDERS.".cache_phone",$arr);
		}

		//默认加入关注
		$focus = getModel("focus");
		$focus->addfav("cates=dd&id=$ordersid");

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=订单信息[增加]&detail=录入新订单[".$ordersid."]&sqlstr=$logsarr");
		return $ordersid;
	}

	//修改订单
	Public function edit()
	{

		extract($_POST);

		$ordersid = (int)$this->id;
		$userid = (int)$this->cookie->get("userid");
		$info = $this->getrow("id=$ordersid");
		//订单锁定状态
		if((int)$info["checked"]!="1"){
			$closed = 0;
		}else{
			$closed = 1;
		}

		//判断合同号是否存在
		if($contract&&$contract<>$info["contract"]){
			$query = "SELECT id FROM ".DB_ORDERS.".orders WHERE contract = '$contract' AND id<>'$ordersid'  ";
			$row = $this->db->getRow($query);
			if($row){ msgbox("","合同号已存在，请不要重新录入订单！"); }
		}

		//其它销售人员
		$othersalesuserid = (int)$othersalesuserid;
		if($othersalesuserid){ $saleuserid = (int)$othersalesuserid; }


		//更新订单信息
		if((int)$closed){
			$arr = array(
				"name"			=>	trim($name),
				"sex"			=>	(int)$sex,
				"provid"		=>	(int)$provid,
				"cityid"		=>	(int)$cityid,
				"areaid"		=>	(int)$areaid,
				"address"		=>	trim($address),
				"postnum"		=>	trim($postnum),
				"phone"			=>	trim($phone),
				"mobile"		=>	trim($mobile),
				"email"			=>	trim($email),
				"qq"			=>	trim($qq),
				"wangwang"		=>	trim($wangwang),
				"im"			=>	trim($im),
				"updateline"	=>	time(),
				"upuserid"		=>	(int)$userid
			);
		}else{

			$ctype = ((int)$ctype)?(int)$ctype:"1";

			$arr = array(
				"datetime"	=>	trim($datetime),
				"type"			=>	(int)$type,
				"ctype"			=>	(int)$ctype,
				"contract"	=>	trim($contract),
				"name"			=>	trim($name),
				"sex"				=>	(int)$sex,
				"provid"		=>	(int)$provid,
				"cityid"		=>	(int)$cityid,
				"areaid"		=>	(int)$areaid,
				"address"		=>	trim($address),
				"postnum"		=>	trim($postnum),
				"phone"			=>	trim($phone),
				"mobile"		=>	trim($mobile),
				"email"			=>	trim($email),
				"qq"				=>	trim($qq),
				"wangwang"	=>	trim($wangwang),
				"im"				=>	trim($im),
				"price_setup"		=>	round($price_setup,2),
				"price_deliver"	=>	round($price_deliver,2),
				"price_cash"	=>	round($price_cash,2),
				"price_minus"	=>	round($price_minus,2),
				"price_other"	=>	round($price_other,2),
				"price_detail"	=>	trim($price_detail),
				"paytype"		=>	(int)$paytype,
				"setuptype"		=>	(int)$setuptype,
				"delivertype"	=>	(int)$delivertype,
				"plansend"		=>	trim($plansend),
				"plansetup"		=>	trim($plansetup),
				"detail"		=>	trim($detail),
				"salesid"		=>	(int)$salesid,
				"saleuserid"	=>	(int)$saleuserid,
				"checked"		=>	0,
				"status"		=>	0,
				"updateline"	=>	time(),
				"upuserid"		=>	(int)$userid
			);
		}

		//坐标获取
		if($info["pointed"]=="0"){
			$curl = getFunc("curl");
			$url = "http://api.map.baidu.com/geocoder/v2/?address=".urlencode($address)."&output=json&ak=EC1bb4d2591cdc482c712b0626f63066&callback=?";
			$data  = $curl->contents($url);
			$info  = json_decode($data,true);
			$point = $info["result"]["location"];
			if($point){
				$pointlng = $point["lng"];
				$pointlat = $point["lat"];
				$arr_point = array(
					"pointlng"	=>	trim($pointlng),
					"pointlat"	=>	trim($pointlat)
				);
			}
		}

		if($arr_point){
			$arr = array_merge($arr,$arr_point);
		}
		$logsarr.= plugin::arrtostr($arr);
		$where = array("id"=>$ordersid);
		$this->db->update(DB_ORDERS.".orders",$arr,$where);

		//更新产品信息
		if(!(int)$closed&&$products){
			//删除旧记录
			$where = array("ordersid"=>$ordersid);
			$this->db->delete(DB_ORDERS.".ordersinfo",$where);

			//计算总金额
			$allprice = "0";
			$price		= "0";
			$parr = array();
			$grouped = 1;

			foreach($products as $item){	//计算总费用
					$pprice   = @round($prices[$item],2);
					$pnums		= (int)$nums[$item];
					$price 		= @round($pprice*$pnums,2);
					$allprice = $allprice + $price;
					$arr = array(
						'ordersid'	=>	$ordersid,
						'grouped'		=>	$grouped,
						'productid'	=>	(int)$productids[$item],
						'price'			=>	$pprice,
						'encoded'		=>	$encodeds[$item],
						'title'			=>	$titles[$item],
						'nums'			=>	$pnums,
						'detail'		=>	$details[$item]
					);
					$this->db->insert(DB_ORDERS.".ordersinfo",$arr);
					$logsarr.= plugin::arrtostr($arr);
					$grouped++;
			}
			//实际费用 商品总价+安装费+送货费+优惠+其它费用
			$endprice = $allprice+$price_setup+$price_deliver+$price_minus+$price_other+$price_cash;
			//更新总价
			$where = array('id'=>$ordersid);
			$arr = array(
					'price_all'	=>	@round($allprice,2),
					'price'			=>	@round($endprice,2)
			);
			$logsarr.= plugin::arrtostr($arr);
			$this->db->update(DB_ORDERS.".orders",$arr,$where);

		}

		//更新电话缓存
		$where = array("ordersid"=>$ordersid);
		$this->db->delete(DB_ORDERS.".cache_phone",$where);
		if($mobile==$phone){
				$phone = "";
		}
		if($mobile){
			$arr = array("ordersid"=>$ordersid,"phone"=>$mobile);
			$this->db->insert(DB_ORDERS.".cache_phone",$arr);
		}
		if($phone){
			$arr = array("ordersid"=>$ordersid,"phone"=>$phone);
			$this->db->insert(DB_ORDERS.".cache_phone",$arr);
		}
		//默认加入关注
		$focus = getModel("focus");
		$focus->addfav("cates=dd&id=$ordersid");

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=订单信息[更新]&detail=更新订单[".$ordersid."]&sqlstr=$logsarr");
		return $ordersid;
	}

	public function superinfo()
	{
		extract($_POST);
		$ordersid = (int)$this->id;
		$info	= $this->getrow("id=$ordersid");
		$userid = (int)$this->cookie->get("userid");

		$parentid = (int)$parentid;

		$price_all	=	$info["price_all"];
		$price_setup=	round($price_setup,2);
		$price_deliver=	round($price_deliver,2);
		$price_minus=	round($price_minus,2);
		$price_other=	round($price_other,2);
		$price_cash =	round($price_cash,2);
		$price		=	$price_all+$price_setup+$price_deliver+$price_minus+$price_other+$price_cash;


		$ctype = ((int)$ctype)?(int)$ctype:"1";
		$arr = array(
			"type"		=>	(int)$type,
			"ctype"		=>	(int)$ctype,
			"parentid"	=>	(int)$parentid,
			"checked"	=>	(int)$checked,
			"status"	=>	(int)$status,
			"paytype"	=>	(int)$paytype,
			"paystate"	=>	(int)$paystate,
			"price_all" =>	$price_all,
			"price_setup"	=>	$price_setup,
			"price_deliver"	=>	$price_deliver,
			"price_minus"=>	$price_minus,
			"price_other"=>	$price_other,
			"price_cash" =>	$price_cash,
			"price"		=>	$price
		);
		$logsarr.= plugin::arrtostr($arr);
		$where = array("id"=>$ordersid);
		$this->db->update(DB_ORDERS.".orders",$arr,$where);


		$query = " SELECT id,price,nums FROM ".DB_ORDERS.".ordersinfo WHERE ordersid = $ordersid ORDER BY grouped DESC ";
		$row = $this->db->getRows($query);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=订单信息[高级]&detail=更正订单[".$ordersid."]的属性信息&sqlstr=$logsarr");

		return 1;
	}

	Public function upctype()
	{
			extract($_POST);
			$ordersid = (int)$this->id;
			$userid = (int)$this->cookie->get("userid");

			$ctype  = (int)$ctype;
			$where = array('id'=>$ordersid);
			$arr = array(
				'ctype'			=>	$ctype
			);
			$logsarr.= plugin::arrtostr($arr);
			$this->db->update(DB_ORDERS.".orders",$arr,$where);
			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=update&ordersid=$ordersid&name=订单操作[客户类型]&detail=更新订单[".$ordersid."]的客户类别为：".$ctypename."&sqlstr=$logsarr");
			return 1;
	}

	//订单信息
	Public function getrow($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		if($id)	{ $where = " AND o.id = $id "; }
		if($customsid)	{ $where = " AND o.customsid = $customsid "; }
		if(!$id&&!$customsid){ return; }
		$query = "SELECT o.*,st.name AS salesname,au.name AS addname,
		st.encoded AS salesencoded,
		pa.name AS provname,ca.name AS cityname,aa.name AS areaname,
		slu.name AS salesuname,slu.worknum AS salesworknum,cu.name AS checkname,
		st.parentid AS salesarea
		FROM ".DB_ORDERS.".orders AS o
		INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id      销售单位id和订单id对应
		INNER JOIN ".DB_ORDERS.".users AS slu ON o.saleuserid = slu.userid    销售人员id和订单id对应
		INNER JOIN ".DB_ORDERS.".users AS au ON o.adduserid = au.userid       销售人员id和制单id对应
		INNER JOIN ".DB_ORDERS.".users AS cu ON o.checkuserid = cu.userid     销售人员id和审单id对应
		INNER JOIN ".DB_CONFIG.".areas AS pa ON o.provid = pa.areaid
		INNER JOIN ".DB_CONFIG.".areas AS ca ON o.cityid = ca.areaid
		INNER JOIN ".DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid
		WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
		GROUP BY o.id
		ORDER BY o.id DESC ";
		$row = $this->db->getRow($query);
		return $row;
	}

	Public function checkrow($str=""){
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$id = (int)$id;
			$query = " SELECT id FROM ".DB_ORDERS.".orders WHERE hide = 0 AND parentid = $id AND status NOT IN(1,6,7,-1) ";
			$row = $this->db->getRow($query);
			return $row;
	}

	//取得订购信息
	Public function ordersinfo($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$ordersid = (int)$ordersid;
			if($group){ $grouped = " GROUP BY grouped "; }
			$query = "SELECT * FROM ".DB_ORDERS.".ordersinfo WHERE ordersid = $ordersid $grouped ORDER BY grouped ASC ";
			$rows = $this->db->getRows($query);
			// if($rows){
			// 	$arr = array();
			// 	foreach($rows AS $rs){
			// 		$productid = (int)$rs["productid"];
			// 		if($productid){
			// 			$query = " SELECT erpname FROM ".DB_PRODUCT.".product WHERE productid = $productid ";
			// 			$row = $this->db->getRow($query);
			// 			if($row["erpname"]){
			// 				$rs["erpname"] = $row["erpname"];
			// 			}
			// 		}
			// 		$arr[]	=	$rs;
			// 	}
			// 	$rows = $arr;
			// }
			return $rows;
	}

	//取得订单列表
	public function getrows($str="")
	{

		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$join = "";
		$orwhere = "";

		//订单编号
		$ordersid	= (int)$ordersid;
		$showpid	= (int)$showpid;
		if($ordersid) {
			if($showpid){
				$where.= " AND (o.id = $ordersid OR o.parentid = $ordersid) ";
			}else{
				$where.= " AND o.id = $ordersid ";
			}
		}
		if($parentid){
			$where.= " AND o.parentid = $parentid ";
		}

		//订单类型
		if($type!=""){ $where.= " AND o.type = '".(int)$type."' "; }
		//客户类型
		if($ctype!=""){ $where.= " AND o.ctype = '".(int)$ctype."' "; }
		//合同号码contract
		if($contract!=""){ $where.= " AND o.contract = '".trim($contract)."' "; }
		//客户姓名
		if($name!=""){ $where.= " AND o.name like '".trim($name)."%' "; }
		//订购时间
		if($datetime!=""){
			$where.= " AND o.datetime like '".trim($datetime)."%' ";
		}else{
			if($godate!=""){
				$where.= " AND o.datetime >= '".trim($godate)."' ";
			}
			if($todate!=""){
				$where.= " AND o.datetime <= '".trim($todate)."' ";
			}
		}
		//淘宝旺旺
		if($wangwang!=""){ $where.= " AND o.wangwang like '".trim($wangwang)."%' "; }
		//客户电话
		if($mobile!=""){
				$join.= "INNER JOIN ".DB_ORDERS.".cache_phone AS cp ON cp.ordersid = o.id ";
				$where.=" AND cp.phone = '".trim($mobile)."' ";
	 	}
		//if($phone!=""){ $where.= " AND o.phone = '".trim($phone)."'  "; }
		//客户地址
		if($address!=""){ $where.= " AND o.address like '%".trim($address)."%' "; }
		//if($address!=""){ $where.= " AND MATCH(o.address) AGAINST('$address' WITH QUERY EXPANSION ) "; }
		//match(atitle,acontent) against('$keyword')
		//订单状态
		if($checked!=""){ $checked = (int)$checked; $where.= " AND o.checked = $checked "; }
		//客户来源
		// if($source!=""){ $where.= " AND o.source = '".trim($source)."' "; }
		//省份
		$provid = (int)$provid;
		if($provid){  $where.= " AND o.provid = $provid "; }
		//城市
		$cityid = (int)$cityid;
		if($cityid){  $where.= " AND o.cityid = $cityid "; }
		//区域
		$areaid = (int)$areaid;
		if($areaid){  $where.= " AND o.areaid = $areaid "; }
		//环路
		$loops = (int)$loops;
		if($loops){  $where.= " AND o.loops = $loops "; }
		//销售区域
		$salesarea = (int)$salesarea;
		if($salesarea){  $where.= " AND st.parentid = $salesarea "; }
		//销售中心
		$salesid = (int)$salesid;
		if($salesid){  $where.= " AND st.id = $salesid "; }
		//销售人员
		$saleuserid = (int)$saleuserid;
		if($saleuserid){ $where.= " AND o.saleuserid = $saleuserid "; }

		//每页数量
		$nums = ($nums)?(int)$nums:"20";

		//用户ID
		$userid = (int)$this->cookie->get("userid");
		$users = getModel("users");
		$userinfo = $users->getrow("userid=$userid");
		//$userinfo["isadmin"]=="0"&&$userinfo["alled"]=="0"&&||$userinfo["usertype"]!="1"
		$alled	= (int)$alled;
		if($userinfo["isadmin"]=="0"&&$userinfo["alled"]=="0"&&$alled=="0"){	 //不是管理员，并且没有全部权限
			if($ordersid==""&&$ordernum==""&&$wangwang==""&&$name==""&&$address==""&&$customsid==""&&$mobile==""&&$phone==""&&$contract==""){
				$owhere = "";
				$query = " SELECT t.id
				FROM ".DB_ORDERS.".config_teams AS t
				INNER JOIN ".DB_ORDERS.".config_teams_orders AS cto ON t.id = cto.teamid
				WHERE cto.userid = $userid
				ORDER BY t.id ASC ";
				$rows = $this->db->getRows($query);
				$idarr = array();
				if($rows){
					foreach($rows AS $rs){ $arr[] = $rs["id"]; }
					$idrows = implode(",",$arr);
					$owhere = " OR o.salesid IN($idrows) ";
				}
				$where.=" AND ( o.adduserid = $userid OR o.saleuserid = $userid $owhere $bwhere ) ";
			}
		}

		$desc = ($desc=="ASC")?"ASC":"DESC";
		switch($order){
				case "id" :			$orderd = " o.id $desc "; break;
				case "checked" :	$orderd = " o.checked $desc "; break;
				default : $orderd = " o.id DESC ";
		}

		if((int)$cityinfo){
				$cityval = ",pa.name AS provname,ca.name AS cityname,aa.name AS areaname ";
				$join.= "INNER JOIN ".DB_CONFIG.".areas AS pa ON o.provid = pa.areaid
				INNER JOIN ".DB_CONFIG.".areas AS ca ON o.cityid = ca.areaid
				INNER JOIN ".DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid";
		}

		if($tagid){
			$tagid = (int)$tagid;
			$join.= " INNER JOIN ".DB_ORDERS.".orders_tags AS tag ON tag.customsid = c.id ";
			$where.=" AND tag.tagid = $tagid AND o.parentid = 0 ";
		}

		//订单进度
		if($status!="") {
			$status = (int)$status;
			if($status){
				$where.= " AND o.status = $status ";
			}else{
				$where.= " AND o.checked = 0 AND o.status = 0 ";
			}
		}

		if($where=="")
		{
				$mindate = date("Y-m-d",time()-86400*180);	//只显示近3年的客户
				$where.=" AND o.datetime >= '$mindate' ";
		}else{
				if($status=="7"||$status=="-1"||$status=="1"){
						$mindate = date("Y-m-d",time()-86400*365);	//只显示近3年的客户
						$where.=" AND o.datetime >= '$mindate' ";
				}
		}

		// if($pjoin){
		// 	$join.="INNER JOIN ".DB_ORDERS.".ordersinfo AS oi ON o.id = oi.ordersid
		// 	INNER JOIN ".DB_PRODUCT.".product AS p ON oi.productid = p.productid";
		// 	$groupby = " GROUP BY o.id";
		// }

		$query = "SELECT o.id,o.ordernum,o.type,o.ctype,o.contract,o.name,o.address,
		o.datetime,o.phone,o.mobile,o.price,o.source,o.checked,
		o.status,o.paystate,st.name AS salename,su.name AS saleusername $cityval
		FROM  ".DB_ORDERS.".orders AS o
		INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
		INNER JOIN ".DB_ORDERS.".users AS su ON o.saleuserid = su.userid
		$join
		WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
		ORDER BY $orderd ";

		//echo $query;exit;
		if($page){
			$this->db->keyid = "o.id";
			$rows = $this->db->getPageRows($query,$nums);
		}else{
			$start = ($start)?(int)$start:"0";
			$limt = " LIMIT $start,$nums ";
			$rows = $this->db->getRows($query.$limt);
		}
		return $rows;
	}

	//取得子订单信息
	Public function orders_parent($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($ordersid){
			$orderesid = (int)$orderesid;
			$where.=" AND o.parentid = $ordersid ";
		}


		if($desc=="DESC"){ $desc="DESC"; }else{ $desc="ASC"; }
		switch($order){
			case "dateline" : $order = " o.dateline $desc,"; break;
			default : $order = "";
		}

		if($nums){
			$nums = (int)$nums;
		}else{
			$nums = "10";
		}

		$query = " SELECT o.id,o.checked,o.status,o.datetime,su.name AS saleuname
		FROM ".DB_ORDERS.".orders AS o
		INNER JOIN ".DB_ORDERS.".users AS su ON su.userid = o.saleuserid
		WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND o.parentid<>0 $where
		ORDER BY $order o.id DESC";
		//echo $query;exit;
		if($page){
			$this->db->keyid = "o.id";
			$show = (int)$show;
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
		//print_r($rows);exit;
		if($rows&&$info){
			$arr = array();
			$list = $rows["record"];
			foreach($list AS $rs){
				$id = (int)$rs["id"];
				$orders_product = $this->ordersinfo("ordersid=$id&group=true");
				$rs["parents"] = $orders_product;
				//		print_r($orders_product);exit;

				$arr[] = $rs;
			}
			$s = array();
			$s["record"] = $arr;
			$s["pages"]  = $rows["pages"];
			$rows = $s;
		}

		return $rows;

	}

	//统计已支付的金额
	Public function orders_charge($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$ordersid = (int)$ordersid;
		$query = " SELECT SUM(price) AS price FROM ".DB_ORDERS.".orders_charge WHERE hide = 1 AND ordersid = $ordersid ";
		$row = $this->db->getRow($query);
		return round($row["price"],2);
	}


	//所有订单的销售人员和服务人员名录
	Public function users($str="")
	{

		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$type = (int)$type;

		$idno = (int)$idno;

		$salesarea = (int)$salesarea;
		if($salesarea){ $where.=" AND teams.parentid = $salesarea "; }

		$salesid = (int)$salesid;
		if($salesid){ $where.=" AND o.salesid = $salesid "; }

		$afterarea = (int)$afterarea;
		if($afterarea){ $where.=" AND teams.parentid = $afterarea "; }

		$afterid = (int)$afterid;
		if($afterid){ $where.=" AND o.afterid = $afterid "; }

		if($godate){ $where.=" AND o.datetime >= '$godate' "; }

		if($todate){ $where.=" AND o.datetime <= '$todate' "; }

		if($type=="2"){
			if($idno){ $where.=" AND o.afteruserid != $idno "; }
			$join = " INNER JOIN ".DB_ORDERS.".users AS u ON o.afteruserid = u.userid
			INNER JOIN ".DB_ORDERS.".config_teams AS teams ON o.afterid = teams.id ";
		}else{
			if($idno){ $where.=" AND o.saleuserid != $idno "; }
			$join = " INNER JOIN ".DB_ORDERS.".users AS u ON o.saleuserid = u.userid
			INNER JOIN ".DB_ORDERS.".config_teams AS teams ON o.salesid = teams.id ";
		}

		$query = " SELECT u.userid,u.name,u.worknum
		FROM ".DB_ORDERS.".orders AS o
		$join
		WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
		GROUP BY u.userid
		ORDER BY u.worknum ASC ";
		return $this->db->getRows($query);
	}

	//支付记录
	Public function charge($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if($ordersid){ $where.=" AND oc.ordersid = $ordersid "; }
		if($nums){ $nums = (int)$nums; }else{ $nums = "10"; }
		if($godate&&!$ordersid){ $where.=" AND oc.datetime >= '$godate' "; }
		if($todate&&!$ordersid){ $where.=" AND oc.datetime <= '$todate' "; }
		if($gotime&&!$ordersid){ $where.=" AND oc.dateline >= '$gotime' "; }
		if($totime&&!$ordersid){ $where.=" AND oc.dateline <= '$totime' "; }
		if($type!=""){ $where.=" AND oc.type = '".(int)$type."' "; }
		if($checked!=""){ $where.=" AND oc.checked = '".(int)$checked."' "; }

		$salesarea = (int)$salesarea;
		if($salesarea){ $where.=" AND st.parentid = $salesarea "; }
		$salesid = (int)$salesid;
		if($salesid){ $where.=" AND o.salesid = $salesid "; }

		$ptype = (int)$ptype;
		if($ptype){ $where.=" AND cct.parentid = $ptype "; }

		$payid = (int)$payid;
		if($payid){ $where.=" AND cct.id = $payid "; }

		if($checked!=""){
			$checked = (int)$checked;
			$where.=" AND oc.checked = $checked ";
		}

		if($userid!=""){
			$userid = (int)$userid;
			$where.=" AND oc.userid = $userid ";
		}

		if($checkuserid!=""){
			$checkuserid = (int)$checkuserid;
			$where.=" AND oc.checkuserid = $checkuserid ";
		}

		if($salesarea!=""){
			$salesarea = (int)$salesarea;
			$where.=" AND st.parentid = $salesarea ";
		}

		if($salesid!=""){
			$salesid = (int)$salesid;
			$where.=" AND o.salesid = $salesid ";
		}

		if($saleuserid!=""){
			$saleuserid = (int)$saleuserid;
			$where.=" AND o.saleuserid = $saleuserid ";
		}

		$show = (int)$show;
		if($order){
			$desc  = ($desc=="DESC")?"DESC":"ASC";
			$orderby = " oc.$order $desc, ";
		}

		// if((int)$xls){
		// 	$sqlst = ",o.price AS ordersprice,o.status,o.contract,o.datetime AS odatetime,exp.detail AS expinfo ";
		// 	$join = " LEFT JOIN ".DB_ORDERS.".express AS exp ON exp.ordersid = oc.ordersid";
		// 	$where.=" AND exp.type = 1 ";
		// 	$group =" GROUP BY oc.id ";
		// }

		$query = " SELECT oc.*,au.name AS addname,cct.name AS payname,cu.name AS checkuname,
		o.customsid,st.name AS salesname $sqlst
		FROM ".DB_ORDERS.".orders_charge AS oc
		INNER JOIN ".DB_ORDERS.".orders AS o ON o.id = oc.ordersid
		INNER JOIN ".DB_ORDERS.".config_teams AS st ON st.id = o.salesid
		INNER JOIN ".DB_ORDERS.".config_charge_type AS cct ON oc.payid = cct.id
		$join
		INNER JOIN ".DB_ORDERS.".users AS au ON oc.userid = au.userid
		INNER JOIN ".DB_ORDERS.".users AS cu ON oc.checkuserid = cu.userid
		WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND oc.hide = 1 $where
		$group
		ORDER BY $orderby oc.id DESC ";
		if($page){
			$this->db->keyid = "oc.id";
			$rows = $this->db->getPageRows($query,$nums,$show);
		}else{
			if(!(int)$xls){
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

	Public function charge_getrow($str)
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		$query = " SELECT oc.*,au.name AS addname,cct.parentid AS paytype
		FROM ".DB_ORDERS.".orders_charge AS oc
		INNER JOIN ".DB_ORDERS.".users AS au ON oc.userid = au.userid
		INNER JOIN ".DB_ORDERS.".config_charge_type AS cct ON oc.payid = cct.id
		WHERE oc.id = $id ";
		$rows = $this->db->getRow($query);
		return $rows;
	}

	Public function charge_add()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$userid = (int)$this->cookie->get("userid");

		if($type=="1"&&$price<="0"){
			return "入款金额不能为 0";
		}
		if($type=="2"&&$price>="0"){
			return "退款金额不能大于及等于 0";
		}

		$arr = array(
			'ordersid'	=>	$ordersid,
			'type'		=>	((int)$type)?(int)$type:"1",
			'datetime'	=>	$datetime,
			'cates'		=>	(int)$cates,
			'payid'		=>	(int)$payid,
			'price'		=>	$price,
			'detail'	=>	$detail,
			'userid'	=>	$userid,
			'dateline'	=>	time()
		);
		$this->db->insert(DB_ORDERS.".orders_charge",$arr);
		$id = (int)$this->db->getLastInsId();
		$logsarr.= plugin::arrtostr($arr);

		//调整支付状态 订单金额
		$ordersinfo = $this->getrow("id=$ordersid");
		$orders_price = $ordersinfo["price"];
		//已付金额
		if($ordersinfo['paystate']<>1){
				$orders_charge = $this->orders_charge("ordersid=$ordersid");
				if($orders_charge >= $orders_price){
					$arr = array("paystate"=>"1");
				}else{
					$arr = array("paystate"=>"0");
				}
				$where = array("id"=>$ordersid);
				$this->db->update(DB_ORDERS.".orders",$arr,$where);
				$logsarr.= plugin::arrtostr($arr);
		}
		//
		// if($jobsid){
		// 	$jobsid = (int)$jobsid;
		// 	$jobs = getModel("jobs");
		// 	$jobs->tasked("type=1&jobsid=$jobsid"); //将最后一个工单的收款任务标为完成
		// }
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=订单操作[支付记录]&detail=添加订单[".$ordersid."]的支付记录#".$id."&sqlstr=".$logsarr."");
		return 1;
	}

	Public function charge_edit()
	{
		extract($_POST);

		if($type=="1"&&$price<="0"){
			return "入款金额不能为 0";
		}
		if($type=="2"&&$price>="0"){
			return "退款金额不能大于及等于 0";
		}

		$id = (int)$this->id;
		$ordersid = (int)$this->ordersid;
		$userid = (int)$this->cookie->get("userid");
		$where = array("id"=>$id);
		$arr = array(
			'type'		=>	$type,
			'datetime'	=>	$datetime,
			'cates'		=>	(int)$cates,
			'payid'		=>	(int)$payid,
			'price'		=>	$price,
			'detail'	=>	$detail
		);
		$this->db->update(DB_ORDERS.".orders_charge",$arr,$where);
		$logsarr = plugin::arrtostr($arr);

		//调整支付状态 订单金额
		$ordersinfo = $this->getrow("id=$ordersid");
		$orders_price = $ordersinfo["price"];
		if($ordersinfo['paystate']<>1){
				//已付金额
				$orders_charge = $this->orders_charge("ordersid=$ordersid");
				if($orders_charge >= $orders_price){
					$arr = array("paystate"=>"1");
				}else{
					$arr = array("paystate"=>"0");
				}
				$where = array("id"=>$ordersid);
				$this->db->update(DB_ORDERS.".orders",$arr,$where);
				$logsarr.= plugin::arrtostr($arr);
		}

		// if($jobsid){
		// 	$jobsid = (int)$jobsid;
		// 	$jobs = getModel("jobs");
		// 	$jobs->tasked("type=1&jobsid=$jobsid"); //将最后一个工单的收款任务标为完成
		// }

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=订单操作[支付记录]&detail=修改订单[".$ordersid."]的支付记录#".$id."&sqlstr=".$logsarr."");
		return 1;
	}

	Public function charge_del()
	{
		extract($_POST);
		$id = (int)$this->id;
		$ordersid = (int)$this->ordersid;
		$where = array("id"=>$id);
		$arr = array(
			'hide' =>	0
		);
		$this->db->update(DB_ORDERS.".orders_charge",$arr,$where);
		$logsarr = plugin::arrtostr($arr);

		//调整支付状态 订单金额
		$ordersinfo = $this->getrow("id=$ordersid");
		$orders_price = $ordersinfo["price"];
		//已付金额
		$orders_charge = $this->orders_charge("ordersid=$ordersid");
		if($orders_charge >= $orders_price){
			$arr = array("paystate"=>"1");
		}else{
			$arr = array("paystate"=>"0");
		}
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=delete&ordersid=$ordersid&name=订单操作[支付记录]&detail=删除订单[".$ordersid."]的支付记录#".$id."&sqlstr=$logsarr");
		return 1;
	}


	//操作记录
	Public function logs($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$ordersid = (int)$ordersid;
		$where.=" AND (o.id = $ordersid OR o.parentid = $ordersid) ";

		if($nums){
			$nums = (int)$nums;
		}else{
			$nums = "10";
		}
		if($userid){
			$where.=" AND ol.userid = $userid ";
		}
		$show = (int)$show;
		$query = " SELECT type FROM ".DB_ORDERS.".orders WHERE id = $ordersid ";
		$row = $this->db->getRow($query);
		if($row["type"]=="1"){
				$parents = ",o.parentid";
		}
		$query = " SELECT ol.*,au.name AS addname $parents
		FROM ".DB_ORDERS.".orders_logs AS ol
		INNER JOIN  ".DB_ORDERS.".orders AS o ON o.id = ol.ordersid
		INNER JOIN ".DB_ORDERS.".users AS au ON ol.userid = au.userid
		WHERE o.openid = ".OPEN_ID." AND ol.hide = 1 $where
		GROUP BY ol.id
		ORDER BY ol.dateline DESC ";
		if($page){
			$this->db->keyid = "ol.id";
			$rows = $this->db->getPageRows($query,$nums,$show);
		}else{
			$start = ($start)?(int)$start:"0";
			$limt = " LIMIT $start,$nums ";
			$rows = $this->db->getRows($query.$limt);
		}
		return $rows;
	}

	Public function logs_getrow($str)
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		$query = " SELECT ol.*,au.name AS addname
		FROM ".DB_ORDERS.".orders_logs AS ol
		INNER JOIN ".DB_ORDERS.".users AS au ON ol.userid = au.userid
		WHERE ol.id = $id ";
		$rows = $this->db->getRow($query);
		return $rows;
	}

	Public function logs_add()
	{
		extract($_POST);
		$ordersid = (int)$this->ordersid;
		$userid = (int)$this->cookie->get("userid");
		$arr = array(
			'ordersid'	=>	$ordersid,
			'type'		=>	$type,
			'datetime'	=>	$datetime,
			'detail'	=>	$detail,
			'userid'	=>	$userid,
			"locked"	=>  0,
			'dateline'	=>	time()
		);
		$this->db->insert(DB_ORDERS.".orders_logs",$arr);
		$id = (int)$this->db->getLastInsId();
		$logsarr = plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=订单操作[操作记录]&detail=添加订单[".$ordersid."]的操作记录#".$id."&sqlstr=$logsarr");
		return 1;
	}

	Public function logs_edit()
	{
		extract($_POST);
		$id = (int)$this->id;
		$ordersid = (int)$this->ordersid;
		$userid = (int)$this->cookie->get("userid");
		$where = array("id"=>$id);
		$arr = array(
			'type'		=>	$type,
			'datetime'	=>	$datetime,
			'detail'	=>	$detail
		);
		$this->db->update(DB_ORDERS.".orders_logs",$arr,$where);
		$logsarr = plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=订单操作[操作记录]&detail=修改订单[".$ordersid."]的操作记录#".$id."&sqlstr=$logsarr");
		return 1;
	}

	Public function logs_del()
	{
		extract($_POST);
		$id = (int)$this->id;
		$ordersid = (int)$this->ordersid;
		$where = array("id"=>$id);
		$arr = array(
			'hide' =>	0
		);
		$this->db->update(DB_ORDERS.".orders_logs",$arr,$where);
		$logsarr = plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=delete&ordersid=$ordersid&name=订单操作[操作记录]&detail=删除订单[".$ordersid."]的操作记录#".$id."&sqlstr=$logsarr");
		return 1;
	}

	//	订单
	Public function completed($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$arr = array("checked"=>"1","status"=>"1");	//完成订单
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".orders",$arr,$where);
		$logsarr = plugin::arrtostr($arr);

		$query = " SELECT type,ctype,dateline FROM ".DB_ORDERS.".orders WHERE id = $id ";
		$orderinfo = $this->db->getRow($query);

		if($orderinfo["type"]=="1"){
				//针对需要回访的添加回访记录
				$query = "SELECT id FROM ".DB_ORDERS.".callback_clockd
				WHERE hide = 1 AND worked = 0 AND ordersid = $id
				ORDER BY datetime DESC";
				$info = $this->db->getRow($query);
				$strtotime = $orderinfo["dateline"];
				if(!$info){
					//生成订单服务计划
					$dateline = $strtotime+86400*90;	//安装时间第100天
					$datetime = date("Y-m-d",$dateline);
					$arr = array(
						'openid'		=> OPEN_ID,
						'ordersid'	=> $id,
						'datetime'	=> trim($datetime),
						'cycle'			=> "90",
						'clockinfo'	=> "首次提醒",
						'stars'			=> '1',
						'detail'		=> "订单完成自动生成提醒记录",
						'adduserid'	=> "1",
						'dateline'	=> time(),
						'checked'		=> "1"
					);
					$logsarr.= plugin::arrtostr($arr);
					$this->db->insert(DB_ORDERS.".callback_clockd",$arr);
				}
		}
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$id&name=订单操作[订单完成]&detail=订单完成操作，订单号[".$id."]&sqlstr=$logsarr");
		return 1;
	}

	//取消订单
	Public function closed($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$arr = array("checked"=>"0","status"=>"7");	//取消进入等待取消
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".orders",$arr,$where);
		$logsarr = plugin::arrtostr($arr);
		$arr = array(
				'ordersid'	=>	$id,
				'type'			=>	0,
				'datetime'	=>	date("Y-m-d",time()),
				'detail'		=>	"[取消订单]".$detail,
				'userid'		=>	$this->cookie->get("userid"),
				"locked"		=> 1,
				'dateline'	=>	time()
		);
		$this->db->insert(DB_ORDERS.".orders_logs",$arr);
		$logsarr.= plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$id&name=订单操作[取消订单]&detail=取消订单编号[".$id."]&sqlstr=$logsarr");
		return 1;
	}

	//取消订单
	Public function killed($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$arr = array("checked"=>"1","status"=>"-1");	//订单作废
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".orders",$arr,$where);
		$logsarr = plugin::arrtostr($arr);

		$arr = array(
			'ordersid'	=>	$id,
			'type'			=>	0,
			'datetime'	=>	date("Y-m-d",time()),
			'detail'		=>	"[作废订单]".$detail,
			'userid'		=>	$this->cookie->get("userid"),
			"locked"		=> 1,
			'dateline'	=>	time()
		);
		$this->db->insert(DB_ORDERS.".orders_logs",$arr);
		$logsarr.= plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$id&name=订单操作[作废订单]&detail=作废订单编号[".$id."]&sqlstr=$logsarr");
		return 1;
	}

	//审核状态
	Public function checked($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$info = $this->getrow("id=$id");

		$arr = array();
		$arr["checked"] = $checked;
		$arr["checkuserid"] = $this->cookie->get("userid");
		if($info["checkdate"]==""){
			$arr["checkdate"] = time();
		}
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".orders",$arr,$where);
		$logsarr = plugin::arrtostr($arr);
		if($checked=="1"){
				if($info["status"]=="0"||$info["status"]=="7"||$info["status"]=="-1"){
					$arr = array("status"=>2);	//审核通过，进入等待处理
					$this->db->update(DB_ORDERS.".orders",$arr,$where);
				}
		}
		$logsarr.= plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$id&name=订单操作[审核状态]&detail=调整订单[".$id."]审核状态&sqlstr=$logsarr");
		return 1;
	}

	//进度状态
	Public function status($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$arr = array("status"=>$status);
			$where = array("id"=>$id);
			$this->db->update(DB_ORDERS.".orders",$arr,$where);
			$logsarr = plugin::arrtostr($arr);
			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=update&ordersid=$id&name=订单操作[进度状态]&detail=调整订单[".$id."]受理状态&sqlstr=$logsarr");
			return 1;
	}

	//支付状态
	Public function paystate($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$arr = array("paystate"=>$paystate);
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".orders",$arr,$where);
		$logsarr = plugin::arrtostr($arr);
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$id&name=订单操作[支付状态]&detail=调整订单[".$id."]支付状态&sqlstr=$logsarr");
		return 1;
	}

	//订单附件
	Public function files($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($type!=""){
			$type = (int)$type;
			$where.= " AND f.type = $type ";
		}

		if($godate!=""){
			$gotime = strtotime($godate." 00:00:00");
			$where.= " AND f.dateline >= $gotime ";
		}

		if($todate!=""){
			$totime = strtotime($todate." 23:59:59");
			$where.= " AND f.dateline <= $totime ";
		}

		$salesarea = (int)$salesarea;
		if($salesarea){
			$where.= " AND st.parentid = $salesarea ";
		}

		$salesid = (int)$salesid;
		if($salesid){
			$where.= " AND o.salesid = $salesid ";
		}

		$ordersid = (int)$ordersid;
		if($ordersid){
			$where.= " AND f.ordersid = $ordersid ";
		}

		if($where==""){
			$godate = date("Y-m-d",time()-86400*30);
			$todate = date("Y-m-d");
			$gotime = strtotime($godate." 00:00:00");
			$totime = strtotime($todate." 23:59:59");
			$where.= " AND f.dateline >= $gotime AND f.dateline <= $totime ";
		}

		if($nums){
			$nums = (int)$nums;
		}else{
			$nums = "10";
		}
		$show = (int)$show;
		$query = "SELECT f.*,u.name AS addname
		FROM ".DB_ORDERS.".orders_files AS f
		INNER JOIN ".DB_ORDERS.".orders AS o ON o.id = f.ordersid
		INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
		INNER JOIN ".DB_ORDERS.".users AS u ON u.userid = f.userid
		WHERE o.openid = ".OPEN_ID." AND f.hide = 1 $where
		ORDER BY f.dateline DESC ";
		if($page){
			//echo $query;
			$this->db->keyid = "f.id";
			$rows = $this->db->getPageRows($query,$nums,$show);
		}else{
			$start = ($start)?(int)$start:"0";
			$limt = " LIMIT $start,$nums ";
			$rows = $this->db->getRows($query.$limt);
		}
		return $rows;
	}

	//+--------------------------------------------------------------------------------------------
	//Desc:上传产品图片
	Public function orders_upload()
	{
		extract($_POST);
		$ordersid = (int)$this->id;
		$userid = $this->cookie->get("userid");
		$files = $this->upload("files_upload");
		if($files){
				if(is_file(".".$pic)){
					$size = @round(filesize(".".$pic)/1024,0);
					//获得文件扩展名
					$temp_arr = explode(".", $pic);
					$file_ext = array_pop($temp_arr);
					$file_ext = trim($file_ext);
					$file_ext = strtolower($file_ext);
				}
				//print_r($files);exit;
				include_once(LIB.'alioss/upload.php');
				$alioss = new Alioss();
				$filedir  = UPFILE."orders/";
				$ossfile = "orders/".date("Y")."/".date("m")."-".date("d")."/".$files;//print_r($object);//要上传图片位置
				$filePath  = ".".$filedir.$files;
				$alioss->uploadFile($filePath,$ossfile);//print_r($files);exit;
				//$filePath = ".".$files;//print_r($filePath);exit;//本地上传图片位置
				@unlink($filePath);
				$files = $ossfile;//print_r($files);exit;//oss上传图片位置

				$arr = array(
					'ordersid'	=>	$ordersid,
					'type'		=>	(int)$type,
					'files'		=>	$files,
					'detail'	=>	$detail,
					'hash'		=>	md5($files),
					'userid'	=>	$userid,
					'ziped'		=>	1,
					'dateline'	=>	time()
				);
				$this->db->insert(DB_ORDERS.".orders_files",$arr);

				$id = (int)$this->db->getLastInsId();
				$logsarr = plugin::arrtostr($arr);
		}

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=$ordersid&name=订单操作[增加附件]&detail=增加订单[".$ordersid."]的附件文件#".$id."&sqlstr=$logsarr");

		return 1;
	}

	Public function editfiles()
	{
		extract($_POST);
		$where = array("id"=>(int)$this->id);
		$arr = array("type"=>(int)$type,"detail"=>$detail);
		$this->db->update(DB_ORDERS.".orders_files",$arr,$where);

		$id = (int)$this->id;
		$logsarr = plugin::arrtostr($arr);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=订单操作[增加附件]&detail=修改订单[".$ordersid."]的附件批注#".$id."&sqlstr=$logsarr");
	}

	Public function delfiles()
	{
			extract($_POST);
			$where = array("id"=>(int)$this->id);
			$arr = array("hide"=>0);
			$this->db->update(DB_ORDERS.".orders_files",$arr,$where);
			$logsarr = plugin::arrtostr($arr);
			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=delete&ordersid=$ordersid&name=订单操作[删除附件]&detail=删除订单[".$ordersid."]的批注#".$id."&sqlstr=$logsarr");
	}

	//1普通 2发货 3反馈 4序列号 0其它
	Public function filesinfo($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$id = (int)$id;
			$query = " SELECT * FROM ".DB_ORDERS.".orders_files WHERE id = $id ";
			$row = $this->db->getRow($query);
			return $row;
	}

	//+--------------------------------------------------------------------------------------------
	//Desc:上传图片
	Public function upload($upfile)
	{
		if(isset($_FILES[$upfile]) && is_uploaded_file($_FILES[$upfile]["tmp_name"]) && $_FILES[$upfile]["error"] == '0')
		{
			$uploader = getFunc("upload");
			$filedir  = UPFILE."orders/";
			$uploader->path = ".".$filedir;	//上传路径
			$uploader->maxSize = "8192000";						//文件大小
			$uploader->upType = "jpg|gif|png";					//文件类型
			$fileName = $uploader->upload($_FILES[$upfile],true);
			if(!$fileName){//返回错误信息
				msgbox(S_ROOT,$uploader->msg);
			}
			$files = $uploader->upFile;
			$allfiles = ".".UPFILE.$files;
			$rarimg = getFunc("rarimg");
			$rarimg->makethumb($allfiles,$allfiles);
			return $files;
		}
		return false;
	}

	/**************  类别配置   *************/
	//订单类型
	Public function ordertype()
	{
			$ds = array();
			$ds[1] = array('id' =>'1',	'name'	=> '普通订单',	'type'	=>	'1');
			$ds[2] = array('id' =>'2',	'name'	=> '维修订单',	'type'	=>	'0');
			$ds[3] = array('id' =>'3',	'name'	=> '耗材订单',	'type'	=>	'0');
			$ds[4] = array('id' =>'4',	'name'	=> '配件订单',	'type'	=>	'0');
			$ds[6] = array('id' =>'6',	'name'	=> '服务订单',	'type'	=>	'0');
			$ds[5] = array('id' =>'5',	'name'	=> '其他订单',	'type'	=>	'0');
			return $ds;
	}

	//销售类型
	Public function customstype()
	{
		//零售客户、商用客户、大客户&经销商）云净家用、云净商用
		$ds = array();
		$ds[1] = array('id' =>'1',	'name'	=> '零售客户',	'type'	=>	'1');
		$ds[2] = array('id' =>'2',	'name'	=> '商用客户',	'type'	=>	'1');
		$ds[3] = array('id' =>'3',	'name'	=> 'VIP大客户',	'type'	=>	'0');
		$ds[4] = array('id' =>'4',	'name'	=> '经销商客户',	'type'	=>	'0');
		$ds[0] = array('id' =>'0',	'name'	=> '其它客户',	'type'	=>	'0');
		return $ds;
	}

	//付款状态
	Public function paystatetype()
	{
		$ds = array();
		$ds[0] = array('id' =>'0',	'name'	=> '未付款',  'color'=>'red');
		$ds[1] = array('id' =>'1',	'name'	=> '已付款',	 'color'=>'green');
		$ds[2] = array('id' =>'2',	'name'	=> '无需付款','color'=>'green');
		$ds[3] = array('id' =>'3',	'name'	=> '已退款',	 'color'=>'gray');
		return $ds;
	}
	//审核状态
	Public function checktype()
	{
		$ds = array();
		$ds[1] = array('id' =>'1',	'name'	=> '确认通过',	'color'	=>	'green');
		$ds[0] = array('id' =>'0',	'name'	=> '等待审核',	'color'	=>	'red');
		return $ds;
	}
	//订单状态
	Public function statustype()
	{
		$ds = array();
		$ds[0]	= array('id' =>'0',	'name'	=> '等待审核',	'color'	=>	'blue',		'next'	=>	'0,2,5');
		$ds[2]	= array('id' =>'2',	'name'	=> '等待处理',	'color'	=>	'orange',	'next'	=>	'2,3,4,5,7');
		//$ds[3]	= array('id' =>'3',	'name'	=> '完成确认',	'color'	=>	'orange',	'next'	=>	'5,6,7');
		$ds[1]	= array('id' =>'1',	'name'	=> '订单完成',	'color'	=>	'green',	'next'	=>	'');
		//$ds[4]	= array('id' =>'4',	'name'	=> '完成确认',	'color'	=>	'orange',	'next'	=>	'6,1');
		//$ds[7]	= array('id' =>'7',	'name'	=> '订单取消',	'color'	=>	'orange',	'next'	=>	'7,8,-1');
		$ds[-1]	= array('id' =>'-1','name'	=> '订单作废',	'color'	=>	'green',	'next'	=>	'');
		//$ds[3]	= array('id' =>'3',	'name'	=> '等待收货',	'color'	=>	'orange',	'next'	=>	'3,4,5,6,7');
		//$ds[4]	= array('id' =>'4',	'name'	=> '等待送货',	'color'	=>	'orange',	'next'	=>	'4,5,6,7');
		//$ds[8]	= array('id' =>'8',	'name'	=> '等待退款',	'color'	=>	'orange',	'next'	=>	'8,-1');
		return $ds;
	}

	//配送方式
	Public function delivertype()
	{
		$ds = array();
		$ds[1] = array('id' =>'1',	'name'	=> '送货上门',	'img'	=>	'');
		$ds[2] = array('id' =>'2',	'name'	=> '委托发货',	'img'	=>	'');
		$ds[3] = array('id' =>'3',	'name'	=> '自行取货',	'img'	=>	'');
		$ds[4] = array('id' =>'4',	'name'	=> '第三方配送',	'img'	=>	'');
		$ds[5] = array('id' =>'5',	'name'	=> '其它',		'img'	=>	'');
		return $ds;
	}

	//款项类型
	Public function chargetype()
	{
		$ds = array();
		$ds[1] = array('id' =>'1',	'name'	=> '入款',		'img'	=>	'');
		$ds[2] = array('id' =>'2',	'name'	=> '退款',		'img'	=>	'');
		$ds[0] = array('id' =>'0',	'name'	=> '其它',		'img'	=>	'');
		return $ds;
	}
	//订单操作记录类型
	Public function logstype()
	{
		$ds		= array();
		$ds[1]	= array('id' =>'1',	'name'	=> '安装',	'img'	=>	'');
		$ds[2]	= array('id' =>'2',	'name'	=> '调试',		'img'	=>	'');
		$ds[3]	= array('id' =>'3',	'name'	=> '维修',		'img'	=>	'');
		$ds[4]	= array('id' =>'4',	'name'	=> '耗材',	'img'	=>	'');
		$ds[5]	= array('id' =>'5',	'name'	=> '送货',		'img'	=>	'');
		$ds[6]	= array('id' =>'6',	'name'	=> '发货',	'img'	=>	'');
		$ds[7]	= array('id' =>'7',	'name'	=> '指导',	'img'	=>	'');
		$ds[8]	= array('id' =>'8',	'name'	=> '收款',	'img'	=>	'');
		$ds[9]	= array('id' =>'9',	'name'	=> '合同签订',	'img'	=>	'');
		$ds[10] = array('id' =>'10','name'	=> '投诉',	'img'	=>	'');
		$ds[11]	= array('id' =>'11','name'	=> '提醒',		'img'	=>	'');
		$ds[12]	= array('id' =>'12','name'	=> '反馈',		'img'	=>	'');
		$ds[13]	= array('id' =>'13','name'	=> '预约',    	'img'	=>	'');
		$ds[14]	= array('id' =>'14','name'	=> '报修',	    'img'	=>	'');
		$ds[15]	= array('id' =>'15','name'	=> '费用',	    'img'	=>	'');
		$ds[0]	= array('id' =>'0',	'name'	=> '系统',		'img'	=>	'');
		$ds[16]	= array('id' =>'16','name'	=> '其它',	    'img'	=>	'');
		return $ds;
	}

	//支付方式
	Public function paytype()
	{
		$ds[1] = array('id' =>'1',	'name'	=> '货到付款' ,	'img'	=>	'');
		$ds[2] = array('id' =>'2',	'name'	=> '网上支付',	'img'	=>	'');
		$ds[3] = array('id' =>'3',	'name'	=> '现金支付',	'img'	=>	'');
		$ds[4] = array('id' =>'4',	'name'	=> '银行转帐',	'img'	=>	'');
		$ds[5] = array('id' =>'5',	'name'	=> '邮政汇款',	'img'	=>	'');
		$ds[6] = array('id' =>'6',	'name'	=> 'POS刷卡支付',	'img'	=>	'');
		$ds[7] = array('id' =>'7',	'name'	=> '支票付款',	'img'	=>	'');
		$ds[0] = array('id' =>'0',	'name'	=> '其它',		'img'	=>	'');
		return $ds;
	}

	//文件类型
	Public function fileltype()
	{
		$ds[1] = array('id' =>'1',	'name'	=> '故障反馈' ,	'img'	=>	'');
		$ds[2] = array('id' =>'2',	'name'	=> '发货检验',	'img'	=>	'');
		$ds[3] = array('id' =>'3',	'name'	=> '安装效果',	'img'	=>	'');
		$ds[4] = array('id' =>'4',	'name'	=> '序列号/条码',	'img'	=>	'');
		$ds[0] = array('id' =>'0',	'name'	=> '其它' ,		'img'	=>	'');
		return $ds;
	}

	//地址环路
	Public function origintype()
	{
		$ds		= array();
		$ds[1] = array('id' =>'1',	'name'	=> '门店购买',	'img'	=>	'');
		$ds[2] = array('id' =>'2',	'name'	=> '电话订购',	'img'	=>	'');
		$ds[3] = array('id' =>'3',	'name'	=> '网络订单',	'img'	=>	'');
		$ds[4] = array('id' =>'4',	'name'	=> '第三方订单',	'img'	=>	'');
		$ds[5] = array('id' =>'5',	'name'	=> '团购订单',	'img'	=>	'');
		$ds[6] = array('id' =>'6',	'name'	=> '用户提交',	'img'	=>	'');
		$ds[0] = array('id' =>'0',	'name'	=> '其它',		'img'	=>	'');
		return $ds;
	}

	//安装
	Public function setuptype()
	{
		$ds		= array();
		$ds[1] = array('id' =>'1',	'name'	=> '上门安装',	'img'	=>	'');
		$ds[2] = array('id' =>'2',	'name'	=> '自行安装',	'img'	=>	'');
		$ds[3] = array('id' =>'3',	'name'	=> '无需安装',	'img'	=>	'');
		$ds[4] = array('id' =>'4',	'name'	=> '其它',		'img'	=>	'');
		return $ds;
	}


}
?>
