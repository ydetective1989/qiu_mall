<?php
class levelModules extends Modules
{

	//读取权限
	Public function getrow($str="")
	{

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if($id){ $where.= " AND id = $id "; }
		$query = "SELECT * FROM ".DB_ORDERS.".config_level WHERE 1=1 $where ";
		$rows = $this->db->getRow($query);
		return $rows;
	}

	//取得权限列表及菜单
	public function getrows($str="")
	{

		$str = plugin::extstr($str);//处理字符串
		extract($str);

		//父目录ID
		if($id){
			if(count(explode(",",$id))>1){
				$where.=" AND id IN($id)";
			}else{
				$id = (int)$id;
				$where.=" AND id = $id";
			}
		}

		//规避ID
		if($idno){
			if(count(explode(",",$idno))>1){
				$where.=" AND id NOT IN($idno)";
			}else{
				$idno = (int)$idno;
				$where.=" AND id != $idno";
			}
		}

		//父目录ID
		if($parentid!=""){
			if(count(explode(",",$parentid))>1){
				$where.=" AND parentid IN($parentid)";
			}else{
				$id = (int)$id;
				$where.=" AND parentid = $parentid";
			}
			//$group = " GROUP BY parentid ";
		}

		//排除的ID
		if($idno){
			if(count(explode(",",$idno))>1){
				$where.=" AND id NOT IN($idno)";
			}else{
				$artno = (int)$idno;
				$where.=" AND id != $idno";
			}
		}
		//正常状态
		if($checked!=""){
			$checked =" AND checked = $checked ";
		}
		//菜单状态
		if($naved!=""){
			$naved =" AND naved = $naved ";
		}

		//用户ID
		$userid = (int)$this->cookie->get("userid");
		$users = getModel("users");
		$userinfo = $users->getrow("userid=$userid");
		$groupid = (int)$userinfo["groupid"];//echo $groupid;exit;
		if($userinfo["isadmin"]!="1"&&$alled!="1"){

			$arrs = "";
			$query = "SELECT levelid FROM ".DB_ORDERS.".config_group_level WHERE groupid = $groupid ";
			$arra = $this->db->getRows($query);
			$arrs = $arra;
			$query = "SELECT levelid FROM ".DB_ORDERS.".config_users_level WHERE userid = $userid ";
			$arrb = $this->db->getRows($query);
			if(!$arra&&!$arrb){ return; }
			if($arrb){
				if($arrs){
					$arrs = array_merge($arrs,$arrb);
				}else{
					$arrs = $arrb;
				}
			}
			if($arrs){
				$idarr = array();
				foreach($arrs AS $rs){ $idarr[] = $rs["levelid"]; }
				$levelarr = implode(",",$idarr);
				if($parentid){
					$where.= " AND id IN($levelarr) " ;
				}else{
					$parentlevel.= " AND id IN($levelarr) " ;
				}
			}
		}
    $query = "SELECT * FROM ".DB_ORDERS.".config_level WHERE hide = 1 $where $checked $naved ORDER BY checked DESC,orderd DESC,id ASC ";
		$rows = $this->db->getRows($query);
		if($rows&&$tree){
			$arr = array();
			foreach($rows AS $rs){
				$parentid = (int)$rs["id"];
				if($parentid){
					$query = " SELECT * FROM ".DB_ORDERS.".config_level WHERE hide = 1 AND parentid = $parentid $parentlevel $checked $naved ORDER BY checked DESC,orderd DESC,id ASC ";
					$rs["tree"] = $this->db->getRows($query);
				}
				$arr[] = $rs;
			}
			$rows = $arr;
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
				$arr = array(
					'name'		=> trim($name[$item]),
					'reqmod'	=> trim($reqmod[$item]),
					'reqac'		=> trim($reqac[$item]),
					'reqdo'		=> trim($reqdo[$item]),
					'urlto'		=> trim($urlto[$item]),
					'orderd'	=> trim($orderd[$item])
				);
				$this->db->update(DB_ORDERS.".config_level",$arr,$where);
			}
		}
		if($new_ids){
			foreach($new_ids AS $n=>$item){
				$arr = array(
					'name'		=> trim($new_name[$item]),
					'parentid'	=> (int)$parentid,
					'reqmod'	=> trim($new_reqmod[$item]),
					'reqac'		=> trim($new_reqac[$item]),
					'reqdo'		=> trim($new_reqdo[$item]),
					'urlto'		=> trim($new_urlto[$item]),
					'orderd'	=> trim($new_orderd[$item]),
					'naved'		=> 0
				);
				$this->db->insert(DB_ORDERS.".config_level",$arr);
			}
		}
		return 1;
	}

	//添加权限
	Public function add()
	{
		extract($_POST);
		if($this->checked("reqmod=$reqmod&reqac=$reqac&reqdo=$reqdo")){ return "抱歉，此权限已经存在！<br>Error:$reqmod,$reqac,$reqdo"; }
		$arr = array(
			'name'		=> trim($name),
			'parentid'	=> (int)$parentid,
			'reqmod'	=> trim($reqmod),
			'reqac'		=> trim($reqac),
			'reqdo'		=> trim($reqdo),
			'urlto'		=> trim($urlto),
			'checked'	=> (int)$checked,
			'isadmin'	=> (int)$isadmin,
			'naved'		=> (int)$naved
		);
		$this->db->insert(DB_ORDERS.".config_level",$arr);
		return 1;
	}

	//修改权限
	Public function edit()
	{
		extract($_POST);
		$id = (int)$this->id;
		if($this->checked("id=$id&reqmod=$reqmod&reqac=$reqac&reqdo=$reqdo")){ return "抱歉，此权限已经存在！<br>Error:$reqmod,$reqac,$reqdo"; }
		$arr = array(
			'name'		=> trim($name),
			'parentid'	=> (int)$parentid,
			'reqmod'	=> trim($reqmod),
			'reqac'		=> trim($reqac),
			'reqdo'		=> trim($reqdo),
			'urlto'		=> trim($urlto),
			'checked'	=> (int)$checked,
			'isadmin'	=> (int)$isadmin,
			'naved'		=> (int)$naved
		);
		//print_r($arr);exit;
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".config_level",$arr,$where);
		return 1;
	}

	//删除权限
	Public function del()
	{
		$id = (int)$this->id;
		$arr = array(
			'hide'		=> 0
		);
		$where = array("id"=>$id);
		//print_r($where);
		$this->db->update(DB_ORDERS.".config_level",$arr,$where);
		return 1;
	}

	//判断权限是否存在
	Public function checked($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if($id)		{ $where.=" AND id<>$id "; }
		$where.=" AND reqmod = '$reqmod' ";
		$where.=" AND reqac  = '$reqac' ";
		$where.=" AND reqdo  = '$reqdo' ";
		if(!$reqmod&&!$reqac&&!$reqdo){ return false; }
		$query = "SELECT id FROM ".DB_ORDERS.".config_level WHERE hide = 1 $where ";
		return $rows = $this->db->getRow($query);
	}


	//权限状态调整
	Public function status($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$info = $this->getrow("id=$id");
		$where = array("id"=>$id);
		if($type=="checked"){
			if($info["checked"]){ $checked = 0; }else{ $checked = 1; }
			$arr = array("checked"=>$checked);
			$this->db->update(DB_ORDERS.".config_level",$arr,$where);
		}elseif($type=="naved"){
			if($info["naved"]){ $naved = 0; }else{ $naved = 1; }
			$arr = array("naved"=>$naved);
			$this->db->update(DB_ORDERS.".config_level",$arr,$where);
		}else{

		}
	}



}
?>
