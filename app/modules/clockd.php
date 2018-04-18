<?php
class clockdModules extends Modules
{

	Public function getrow($str)
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		$query = " SELECT c.*,au.name AS afteruname,wu.name AS workuname
		FROM ".DB_ORDERS.".callback_clockd AS c
		INNER JOIN ".DB_ORDERS.".users AS au ON c.adduserid = au.userid
		INNER JOIN ".DB_ORDERS.".users AS wu ON c.workuserid = wu.userid
		WHERE c.openid = ".OPEN_ID." AND c.id = $id  ";
		$rows = $this->db->getRow($query);
		return $rows;
	}

  Public function checkadd($str)
  {
      $str = plugin::extstr($str);//处理字符串
      extract($str);
      $ordersid = (int)$ordersid;
      $query = " SELECT id
			FROM ".DB_ORDERS.".callback_clockd
			WHERE hide = 1 AND ordersid = $ordersid AND worked = 0 ";
      $row = $this->db->getRow($query);
      if($row){
          return 1;
      }else{
          return 0;
      }
  }

	Public function getrows($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		//用户ID
		$userid = (int)$this->cookie->get("userid");
		$users = getModel("users");
		$userinfo = $users->getrow("userid=$userid");

		if($ordersid) {

			$ordersid = (int)$ordersid;
			$where .= " o.id = $ordersid AND ";

		}elseif($customsid){

			$customsid = (int)$customsid;
			$where .= " o.customsid = $customsid AND ";

		}else{


			if($clocked=="1"&&$checked=="1"){
					if($godate){
						$where.= " c.datetime >= '".$godate."' AND ";
					}
					if($todate){
						$where.= " c.datetime <= '".$todate."' AND ";
					}
			}else{
					if($godate){
						$where.= " o.datetime >= '".$godate."' AND ";
					}
					if($todate){
						$where.= " o.datetime <= '".$todate."' AND ";
					}
			}

			//服务区域
			$salesarea = (int)$salesarea;
			if($salesarea!=""){
				$where.= " st.parentid = $salesarea AND ";
			}
			//服务中心
			$salesid = (int)$salesid;
			if($salesid!=""){
				$where.= " o.salesid = $salesid AND ";
			}

      if($stars){
          $stars = (int)$stars;
          $where.= " c.stars = $stars AND ";
      }

      //省份
      $provid = (int)$provid;
      if($provid){
          $where.= " o.provid = $provid AND ";
      }
      //城市
      $cityid = (int)$cityid;
      if($cityid){
          $where.= " o.cityid = $cityid AND ";
      }
      //区域
      $areaid = (int)$areaid;
      if($areaid){
          $where.= " o.areaid = $areaid AND ";
      }

		}

		if($address!=""){
			$where.= " o.address like '%".trim($address)."%' AND ";
		}

		if($pointarr){
			$parr = @explode("||",$pointarr);
			$where.= " o.pointlng >= '".$parr[0]."' AND o.pointlng <= '".$parr[1]."' AND o.pointlat >= '".$parr[2]."' AND o.pointlat <= '".$parr[3]."' AND ";
		}

		//处理状态
		if($worked!=""){

			//$datetime = date("Y-m-d",time()-86400*730);	//完成的订单，2年前的
			if($worked){
				$where.= " c.worked IN($worked) AND ";
			}else{
				$where.= " c.worked = 0 AND ";	//所有的
			}

		}

		//是否取消
		if($checked!=""){
			if($checked == 1){
				$where.= " c.checked = 1 AND ";
			}else{
				$where.= " c.checked = 0 AND ";
			}
		}

		if($nums){
			$nums = (int)$nums;
		}else{
			$nums = "10";
		}

		if($desc=="DESC"){ $desc = "DESC"; }else{ $desc = "ASC"; }
		//echo $desc;
		if($maped){ $where.=" o.pointlng!='0' AND o.pointlat!='0' AND "; }

		//产品搜索
		if($brandid){
			$where.= " p.brandid = $brandid AND ";
			$pjoin = 1;
		}

		if($encoded!=''){
			$where.=" p.encoded = '$encoded' AND ";
			$pjoin = 1;
		}

		if($clocked!=""){
				$clocked = (int)$clocked;
				$where.= " o.clocked = $clocked AND ";
		}

		//用户类别
		switch($mtype){
			case "weibo":
				$join.="INNER JOIN ".DB_ORDERS.".customs_users AS cu ON cu.customsid = o.customsid
						INNER JOIN ".DB_MEMBERS.".bind_weibo AS bu ON bu.userid = cu.userid";
				break;
			case "weixin":
				$join.="INNER JOIN ".DB_ORDERS.".customs_users AS cu ON cu.customsid = o.customsid
						INNER JOIN ".DB_MEMBERS.".mp_weixin AS bu ON bu.userid = cu.userid";
				break;
			case "taobao":
				$join.="INNER JOIN ".DB_ORDERS.".customs_users AS cu ON cu.customsid = o.customsid
						INNER JOIN ".DB_MEMBERS.".bind_taobao AS bu ON bu.userid = cu.userid";
				break;
			case "yun":
				$where.=" AND o.type = 8 ";
				break;
			default:"";
		}


		//客户类型 1 = 普通（家用和商用）
		if($ctype=="1"){    //家用普通
        $where.= " o.ctype = 1 AND ";
    }elseif($ctype=="2"){  //商用普通
        $where.= " o.ctype = 2 AND ";
    }elseif($ctype=="3"){   //家用云净
        $where.= " o.ctype = 3 AND ";
    }elseif($ctype=="4"){   //商用云净
        $where.= " o.ctype = 4 AND ";
    }elseif($ctype=="5"){   //家用包年
        $where.= " o.ctype = 3 AND ";
    }

		if($pjoin=="1"){
			$join.="INNER JOIN ".DB_ORDERS.".ordersinfo AS oi ON o.id = oi.ordersid
			INNER JOIN ".DB_PRODUCT.".product AS p ON oi.productid = p.productid";
		}

		//用户ID
		$userid = (int)$this->cookie->get("userid");
		$users = getModel("users");
		$userinfo = $users->getrow("userid=$userid");
		//$userinfo["isadmin"]=="0"&&$userinfo["alled"]=="0"&&||$userinfo["usertype"]!="1"
		$alled	= (int)$alled;
		if($userinfo["isadmin"]=="0"&&$userinfo["alled"]=="0"&&$alled=="0"){	 //不是管理员，并且没有全部权限
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
					$where.=" ( o.adduserid = $userid OR o.saleuserid = $userid $owhere $bwhere ) AND ";
		}
		//$groupby = " GROUP BY c.id";

		$show = (int)$show;
		if($clocked=="1"||$loglist=="1"){
				$this->db->keyid 	= "c.id";
				$query = " SELECT c.id,c.ordersid,c.datetime,c.stars,o.name AS name,o.address AS address,
				c.clockinfo,c.worked,c.workdate,wu.name AS workuname,c.workdetail,
				o.pointlng,o.pointlat,o.ctype AS ctype
				FROM ".DB_ORDERS.".callback_clockd AS c
				INNER JOIN ".DB_ORDERS.".orders AS o ON c.ordersid = o.id
				INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
			  INNER JOIN ".DB_ORDERS.".users AS wu ON c.workuserid = wu.userid
				$join
				WHERE o.openid = ".OPEN_ID." AND $where c.hide = 1 AND o.hide = 1 AND o.status NOT IN(0,7,-1) AND o.parentid = 0
				GROUP BY c.id
				ORDER BY c.datetime $desc ";
		}else{
				$this->db->keyid 	= "o.id";
				$query = " SELECT o.id AS ordersid,o.name AS name,o.address AS address,o.datetime AS datetime,
				o.pointlng,o.pointlat,o.ctype AS ctype
				FROM ".DB_ORDERS.".orders AS o
				INNER JOIN ".DB_ORDERS.".config_teams AS st ON o.salesid = st.id
				$join
				WHERE o.openid = ".OPEN_ID." AND $where o.checked = 1 AND o.parentid = 0 AND o.status NOT IN(0,7,-1)
				GROUP BY o.id
				ORDER BY o.datetime $desc ";
		}

		if($userid=="9"){
			//echo $query;
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

	Public function clockdinfo()
	{
		extract($_POST);
		$id = (int)$this->id;
		$ordersid = (int)$this->ordersid;
		$userid = (int)$this->cookie->get("userid");
    $arr = array(
				"openid"		=>  OPEN_ID,
        "ordersid"	=>	$ordersid,
        "cycle"			=>	$cycle,
        "clockinfo"	=>	$clockinfo,
        "stars"			=>	$stars,
        "detail"		=>	$detail,
        "adduserid"	=>	$userid,
        "dateline"	=>	time(),
        "autoed"		=>	(int)$autoed,
        "worked"		=>	0
    );
    if($cycle>"0")
    {
        $strtotime = time()+86400*$cycle;
        $datetime  = date("Y-m-d",$strtotime);
        $arr["datetime"]  =	$datetime;
    }
		$logsarr.= plugin::arrtostr($arr);		//操作日志记录
		$logs = getModel('logs');
		if($id){
				$where = array("id"=>$id);
				$this->db->update(DB_ORDERS.".callback_clockd",$arr,$where);
				$arr = array("checked"=>1);
				$logsarr.= plugin::arrtostr($arr);		//操作日志记录
				$where = array("ordersid"=>$ordersid);
				$this->db->update(DB_ORDERS.".callback_clockd",$arr,$where);
				$logs->insert("type=update&ordersid=$ordersid&name=提醒回访[修改]&detail=修改回访提醒记录，订单[".$ordersid."]#".$id."&sqlstr=$logsarr");
		}else{
				$this->db->insert(DB_ORDERS.".callback_clockd",$arr);
				$arr = array("checked"=>1);
				$logsarr.= plugin::arrtostr($arr);		//操作日志记录
				$where = array("ordersid"=>$ordersid);
				$this->db->update(DB_ORDERS.".callback_clockd",$arr,$where);
				//增加提醒记录后，将订单滤芯计划增加为1
				$arr = array("clocked"=>1);
				$where = array("id"=>$ordersid);
				$this->db->update(DB_ORDERS.".orders",$arr,$where);
				$logsarr.= plugin::arrtostr($arr);		//操作日志记录
				$logs->insert("type=insert&ordersid=$ordersid&name=提醒回访[新增]&detail=增加回访提醒记录，订单[".$ordersid."]&sqlstr=$logsarr");
		}
	}

	//回执处理提醒
	Public function call()
	{
		extract($_POST);

		$id = (int)$this->id;
		$ordersid = (int)$this->ordersid;
		$userid = (int)$this->cookie->get("userid");
		if($datetime==""&&$cycle){
			$strtotime = time()+86400*$cycle;
			$datetime  = date("Y-m-d",$strtotime);
		}

		//是否关闭提醒
		if((int)$closeed){ $checked = 0; }else{ $checked = 1; }

		$where = array("id"=>$id);
		if($worked){	//已操作的只能更改信息
			$arr = array(
				"worked"		=>	1,
				"workdate"		=>	time(),
				"workuserid"	=>	(int)$userid,
				"workdetail"	=>	$workdetail
			);
		}else{
			$arr = array(
				"worked"		=>	1,
				"workdate"		=>	time(),
				"workuserid"	=>	(int)$userid,
				"workdetail"	=>	$workdetail,
				"checked"		=>	(int)$checked
			);
		}
		$this->db->update(DB_ORDERS.".callback_clockd",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);		//操作日志记录

		if(!$worked&&$checked){
			if($datetime==""&&$cycle){
				$strtotime = time()+86400*$cycle;
				$datetime  = date("Y-m-d",$strtotime);
			}
			$arr = array(
					"openid"		=>	OPEN_ID,
					"ordersid"	=>	$ordersid,
					"datetime"	=>	$datetime,
					"cycle"		=>	$cycle,
					"clockinfo"	=>	($clockinfo)?$clockinfo:"无备注",
					"stars"		=>	$stars,
					"detail"	=>	$clockinfo,
					"adduserid"	=>	$userid,
					"dateline"	=>	time(),
					"autoed"	=>	(int)$autoed,
					"worked"	=>	0
			);
			$logsarr.= plugin::arrtostr($arr);		//操作日志记录
			$this->db->insert(DB_ORDERS.".callback_clockd",$arr);
		}

		if($checked=="0"){
				$arr = array("checked"=>0);
				$logsarr.= plugin::arrtostr($arr);		//操作日志记录
				$where = array("ordersid"=>$ordersid);
				$this->db->update(DB_ORDERS.".callback_clockd",$arr,$where);
		}else{
				$arr = array("clocked"=>1);
				$logsarr.= plugin::arrtostr($arr);		//操作日志记录
				$where = array("id"=>$ordersid);
				$this->db->update(DB_ORDERS.".orders",$arr,$where);
		}



		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=$ordersid&name=提醒回访[操作]&detail=处理回访提醒，订单[".$ordersid."]#".$id."&sqlstr=$logsarr");
		return 1;

	}


	public function clocked_close()
	{
			extract($_POST);
			$id = (int)$this->id;
			$arr = array("clocked"=>4);
			$where = array("id"=>$id);
			$logsarr.= plugin::arrtostr($arr);
			$this->db->update(DB_ORDERS.".orders",$arr,$where);
			$userid = (int)$this->cookie->get("userid");
      $arr = array(
          'ordersid' => (int) $id,
          'type'		 => 11,
          'detail' 	 => '关闭订单#'.$id.'的提醒，备注：'.$detail,
          'datetime' => date('Y-m-d'),
          'userid'   => $userid,
          'dateline' => time(),
      );
      $logsarr .= plugin::arrtostr($arr);
      $this->db->insert(DB_ORDERS.'.orders_logs', $arr);
			$logs = getModel('logs');
			$logs->insert("type=update&ordersid=$id&name=提醒回访[操作]&detail=关闭订单[".$id."]提醒操作&sqlstr=$logsarr");
			return 1;
	}

	//删除提醒记录
	Public function del()
	{
		extract($_POST);
		$id = (int)$this->id;
		$info = $this->getrow("id=$id");
		$ordersid = (int)$info["ordersid"];
		$where = array("id"=>$id);
		$arr = array(
			'hide'	=>	0
		);
		$this->db->update(DB_ORDERS.".callback_clockd",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);
		$query = " SELECT id FROM ".DB_ORDERS.".callback_clockd WHERE ordersid = $ordersid AND hide = 1  ";
		$row = $this->db->getRow($query);
		if(!$row){
				$arr = array("clocked"=>0);
				$where = array("id"=>$ordersid);
				$logsarr.= plugin::arrtostr($arr);
				$this->db->update(DB_ORDERS.".orders",$arr,$where);
		}
		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=delete&ordersid=$ordersid&name=提醒信息[删除]&detail=删除订单[".$ordersid."]的提醒记录#".$id."&sqlstr=$logsarr");
		return 1;
	}

}
?>
