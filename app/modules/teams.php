<?php
class teamsModules extends Modules
{

	//读取机构信息
	Public function getrow($str="")
	{

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		$query = "SELECT * FROM ".DB_ORDERS.".config_teams WHERE openid = ".OPEN_ID." AND id = $id $where ";
		$rows = $this->db->getRow($query);
		return $rows;
	}

	public function areas($str="")
	{
		//echo $str;
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if($fuwu=="1")
		{
			$parwhere = "AND c.parentid IN(12) ";
		}else{
			$parwhere = "AND c.parentid NOT IN (0,12)";
		}

		if((int)$provid||(int)$cityid||(int)$areaid)
		{
			$provid = (int)$provid;
			if($provid){ $areawhere = " OR c.provid = $provid"; }
			$cityid = (int)$cityid;
			if($cityid){ $areawhere = " OR c.cityid = $cityid"; }

            if($iscc=="1")
            {
                $parwhere = "AND c.parentid IN(411,12) ";
                $areawhere.=" OR c.id = 112 ";
            }
			$where = " $parwhere AND ( c.id = 1 $areawhere ) ";
		}elseif($allarea=="1"){
            $where = $parwhere." AND parentid NOT IN(132)";
        }else{
			$where = " AND c.parentid = 132 ";
		}

		//类型
		if($id!=""){
			$id = (int)$id;
			$where.=" AND c.id = $id ";
		}
		if($type!=""){
			$type = (int)$type;
			$where.=" AND c.type = $type ";
		}
		//正常状态
		if($checked!=""){
			$checked = (int)$checked;
			$where.=" AND c.checked = $checked ";
		}
		$query = "SELECT c.id,c.encoded,c.name
		FROM ".DB_ORDERS.".config_teams AS c
		WHERE c.openid = ".OPEN_ID." AND c.hide = 1
		$where
		ORDER BY c.checked DESC,c.encoded ASC,c.numbers ASC ";
       // echo $query."<br>";
		$rows = $this->db->getRows($query);
		return $rows;
	}

	//取得机构列表
	public function getrows($str="")
	{
		//echo $str;
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		//规避ID
		if($idno){
			if(count(explode(",",$idno))>1){
				$where.=" AND c.id NOT IN($idno)";
			}else{
				$idno = (int)$idno;
				$where.=" AND c.id != $idno";
			}
		}
		//类型
		if($type!=""){
			$type = (int)$type;
			$where.=" AND c.type = $type ";
			$owhere.=" AND t.type = $type ";
		}

        if($parentid==""){
            $parentid = 0;
            $where.=" AND c.parentid = $parentid";
        }else{
            if(count(@explode(",",$parentid))>1){
                $where.=" AND c.parentid IN($parentid)";
            }else{
                $idno = (int)$idno;
                $where.=" AND c.parentid = $parentid";
            }
        }


        if($parentid=="0"&&$areasid){
			$where.= " AND c.id IN($areasid) ";
		}

		//正常状态
		if($checked!=""){
			$checked = (int)$checked;
			$where.=" AND c.checked = $checked ";
		}

		//名称搜索
		if($name!=""){
			$where.=" AND c.name like '%".$name."%' ";
		}

		//编码搜索
		if($numbers!=""){
			$where.=" AND c.numbers = '$numbers' ";
		}

		//用户ID
		$userid = (int)$this->cookie->get("userid");
		$users = getModel("users");
		$userinfo = $users->getrow("userid=$userid");

		if($level){
			if($type=="1"){
					if((int)$userinfo["alled"]) { $level = 0; }else{ $level = 1; }
			}elseif($type=="3"){
					if((int)$userinfo["jobsed"]){ $level = 0; }else{ $level = 1; }
			}else{
					$level = 1;
			}
		}

		if($userinfo["isadmin"]=="0"&&$level){

			if($parentid){

          if($userinfo['alled']!="2")
          {
              $query = " SELECT t.id
              FROM ".DB_ORDERS.".config_teams AS t
              INNER JOIN ".DB_ORDERS.".config_teams_jobs AS ctj ON t.id = ctj.teamid
              WHERE t.openid = ".OPEN_ID." AND ctj.userid = $userid $owhere
              GROUP BY t.id
              ORDER BY t.id ASC ";
              $rows = $this->db->getRows($query);
              $idarr = array();
              if($rows){
                  foreach($rows AS $rs){
                      $arr[] = $rs["id"];
                  }
                  $idrows = implode(",",$arr);
                  $where.= " AND c.id IN($idrows) ";
              }else{
                  return;
              }
          }
			}else{
				$query = " SELECT t.parentid
				FROM ".DB_ORDERS.".config_teams AS t
				INNER JOIN ".DB_ORDERS.".config_teams_jobs AS ctj ON t.id = ctj.teamid
				WHERE t.openid = ".OPEN_ID." AND ctj.userid = $userid $owhere
				GROUP BY t.parentid
				ORDER BY t.id ASC ";
				$rows = $this->db->getRows($query);
				$idarr = array();
				if($rows){
					foreach($rows AS $rs){
						$arr[] = $rs["parentid"];
					}
					$idrows = implode(",",$arr);
					$where.= " AND c.id IN($idrows) ";
				}else{
					return;
				}
			}

		}

    $desc = ($desc=="DESC")?"DESC":"ASC";
    switch($order){
        case "id": $order = " c.id $desc,";break;
        default  : $order = "";
    }

		//分页数
		$page = (int)$page;
		$query = "SELECT c.*,
		pa.name AS provname,ca.name AS cityname,aa.name AS areaname
		FROM ".DB_ORDERS.".config_teams AS c
	    INNER JOIN ".DB_CONFIG.".areas AS pa ON c.provid = pa.areaid
	    INNER JOIN ".DB_CONFIG.".areas AS ca ON c.cityid = ca.areaid
	    INNER JOIN ".DB_CONFIG.".areas AS aa ON c.areaid = aa.areaid
		WHERE c.openid = ".OPEN_ID." AND c.hide = 1
		$where
		ORDER BY c.checked DESC,$order c.orderd DESC,c.numbers ASC ";
		//echo $query;
		if($page){
			$rows = $this->db->getPageRows($query,$page);
		}else{
			$rows = $this->db->getRows($query);
		}
		return $rows;
	}

	//批量修改
	Public function editlist()
	{
		extract($_POST);
		if($ids){
			foreach($ids AS $n=>$item){
				$where = array("id"=>$item);
				$info = $this->getrow("id=$item");
				$logsarr = plugin::arrtostr($info)."修正为：\n";
				$arr = array(
					'name'		=> trim($name[$item]),
					'subname'	=> trim($subname[$item]),
					'numbers'	=> trim($encoded[$item]),
					'encoded'	=> trim($encoded[$item]),
					'orderd'	=> trim($orderd[$item])
				);
				$logsarr.= plugin::arrtostr($arr);
				$this->db->update(DB_ORDERS.".config_teams",$arr,$where);
			}
			//操作日志记录
			$logs = getModel('logs');
			$logs->insert("type=update&ordersid=0&name=组织结构[批量]&detail=批量修正#".$id."的组织结构&sqlstr=$logsarr");
		}
		return 1;
	}

	//增加机构信息
	Public function add()
	{
		extract($_POST);
		$type = (int)$this->type;
		$arr = array(
			'openid'	=> OPEN_ID,
			'name'		=> trim($name),
			'subname'	=> trim($subname),
			'type'		=> (int)$type,
			'parentid'	=> (int)$parentid,
			'numbers'	=> trim($encoded),
			'encoded'	=> trim($encoded),
			'address'	=> trim($address),
			'phone'		=> trim($phone),
			'provid'	=> (int)$provid,
			'cityid'	=> (int)$cityid,
			'areaid'	=> (int)$areaid,
			'maxplan'	=> (int)$maxplan,
			'minplan'	=> (int)$minplan,
			'pointer'	=> $point
		);
		$this->db->insert(DB_ORDERS.".config_teams",$arr);
		$logsarr = plugin::arrtostr($arr);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=insert&ordersid=0&name=组织结构[新建]&detail=新建组织结构[".$name."]的#".$id."&sqlstr=$logsarr");

		return 1;
	}

	//编辑机构信息
	Public function edit()
	{
		extract($_POST);
		$id = (int)$this->id;
		$type = (int)$this->type;

		$info = $this->getrow("id=$id");
		$logsarr = plugin::arrtostr($info)."修正为：\n";

		$arr = array(
			'openid'  => OPEN_ID,
			'name'		=> trim($name),
			'subname'	=> trim($subname),
			'type'		=> (int)$type,
			'parentid'	=> (int)$parentid,
			'numbers'	=> trim($encoded),
			'encoded'	=> trim($encoded),
			'address'	=> trim($address),
			'phone'		=> trim($phone),
			'provid'	=> (int)$provid,
			'cityid'	=> (int)$cityid,
			'areaid'	=> (int)$areaid,
			'checked'	=> (int)$checked,
			'maxplan'	=> (int)$maxplan,
			'minplan'	=> (int)$minplan,
			'pointer'	=> $point
		);
		$where = array("id"=>$id);
		$logsarr.= plugin::arrtostr($arr);
		$this->db->update(DB_ORDERS.".config_teams",$arr,$where);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=0&name=组织结构[更新]&detail=修正#".$id."的组织结构[".$name."]&sqlstr=$logsarr");
		return 1;
	}

	//删除机构信息
	Public function del()
	{
		$id = (int)$this->id;
		$arr = array(
			'hide'		=> 0
		);
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".config_teams",$arr,$where);
		return 1;
	}

	//取得权限TREE
	Public function tree($str)
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$rows = $this->getrows("checked=1&type=$type&parentid=0");
		if($rows){
			$arr = array();
			foreach($rows AS $rs){
				$parentid = (int)$rs['id'];
				$tree = $this->getrows("checked=1&parentid=$parentid");
				$rs["tree"] = $tree;
				$arr[] = $rs;
			}
			$rows = $arr;
		}
		return $rows;
	}

	//机构状态调整
	Public function status($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$info = $this->getrow("id=$id");
		$where = array("id"=>$id);
		if($type=="checked"){
			if($info["checked"]){ $checked = 0; }else{ $checked = 1; }
			$arr = array("checked"=>$checked);
			$this->db->update(DB_ORDERS.".config_teams",$arr,$where);
		}else{

		}
	}

	//取得选择的权限
	Public function teamed($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if(!$userid){ return ""; }
		if($val=="orderteams"){
			$name = "orders";
		}elseif($val=="jobsteams"){
			$name = "jobs";
		}else{
			return "";
		}
		$query = "SELECT teamid FROM ".DB_ORDERS.".config_teams_".$name." WHERE userid = $userid ";
		$rows = $this->db->getRows($query);
		if($rows){
			$arr = array();
			foreach($rows AS $rs){
				$arr[$rs["teamid"]] = $rs["teamid"];
			}
			$rows = $arr;
		}
		return $rows;
	}
	//取得我的机构信息
	Public function userteams($str="")
	{

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$userid = (int)$userid;
		if($type){ $type = (int)$type; $where.=" AND ct.type = $type "; }
		$query = "SELECT ct.id,ct.name,ct.parentid,ct.numbers
		FROM ".DB_ORDERS.".config_teams AS ct
		INNER JOIN ".DB_ORDERS.".config_teams_jobs AS ctj ON ctj.teamid = ct.id
		WHERE ct.openid = ".OPEN_ID." AND ctj.userid = $userid $where
		ORDER BY ct.id ASC ";
		$rows = $this->db->getRow($query);
		return $rows;
	}

	//取得用户表
	Public function users($str="")
	{

		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$type = (int)$type;
		$idno = (int)$idno;

		$parentid = (int)$parentid;
		if($parentid){ $where.=" AND teams.parentid = $parentid "; }

		$teamid = (int)$teamid;
		if($teamid){ $where.=" AND teams.id = $teamid "; }

		if($checked!=""){
			$checked=(int)$checked; $where.=" AND u.checked = $checked ";
		}else{
			$where = " AND u.checked = 1 ";
		}

		if($idno){ $where.=" AND u.userid != $idno "; }

		$query = " SELECT u.userid,u.name,u.worknum,g.name AS groupname
		FROM ".DB_ORDERS.".users AS u
		INNER JOIN ".DB_ORDERS.".config_teams_jobs AS ctj ON u.userid = ctj.userid
		INNER JOIN ".DB_ORDERS.".config_teams AS teams ON ctj.teamid = teams.id
		INNER JOIN ".DB_ORDERS.".config_group AS g ON u.groupid = g.id
		WHERE teams.openid = ".OPEN_ID." AND teams.type = $type $where
		GROUP BY u.userid
		ORDER BY u.worknum ASC ";
		return $this->db->getRows($query);
	}

}
?>
