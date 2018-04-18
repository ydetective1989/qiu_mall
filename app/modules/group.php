<?php
class groupModules extends Modules
{

	//读取岗位信息
	Public function getrow($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			if($id){ $where.= " AND id = $id "; }
			$query = "SELECT * FROM ".DB_ORDERS.".config_group WHERE 1=1 $where ";
			$rows = $this->db->getRow($query);
			return $rows;
	}

	//取得岗位列表
	public function getrows($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			//规避ID
			if($idno){
				if(count(explode(",",$idno))>1){
					$where.=" AND id NOT IN($idno)";
				}else{
					$idno = (int)$idno;
					$where.=" AND id != $idno";
				}
			}
			//正常状态
			if($checked!=""){
				$where.=" AND checked = $checked ";
			}
			$query = "SELECT * FROM ".DB_ORDERS.".config_group WHERE openid = ".OPEN_ID." AND hide = 1 $where ORDER BY checked DESC,orderd DESC,id ASC ";
			$rows = $this->db->getRows($query);
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
					'orderd'	=> trim($orderd[$item])
				);
				$this->db->update(DB_ORDERS.".config_group",$arr,$where);
			}
		}
		return 1;
	}

	//增加岗位信息
	Public function add()
	{
		extract($_POST);
		$arr = array(
			'openid'	=>	OPEN_ID,
			'name'		=> trim($name),
			'checked'	=> (int)$checked
		);
		$this->db->insert(DB_ORDERS.".config_group",$arr);
		$id = $this->db->getLastInsId();
		if($grouplevel){
			foreach($grouplevel AS $item){
				$arr = array("levelid"=>$item,"groupid"=>$id);
				$this->db->insert(DB_ORDERS.".config_group_level",$arr);
			}
		}
		return 1;
	}

	//编辑岗位信息
	Public function edit()
	{
		extract($_POST);
		$id = (int)$this->id;
		$arr = array(
			'name'		=> trim($name),
			'checked'	=> (int)$checked
		);
		//print_r($arr);exit;
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".config_group",$arr,$where);
		//删除旧记录
		$where = array("groupid"=>$id);
		$this->db->delete(DB_ORDERS.".config_group_level",$where);
		if($grouplevel){
			foreach($grouplevel AS $item){
				$arr = array("levelid"=>$item,"groupid"=>$id);
				$this->db->insert(DB_ORDERS.".config_group_level",$arr);
			}
		}
		return 1;
	}

	//删除岗位信息
	Public function del()
	{
		$id = (int)$this->id;
		$arr = array(
			'hide'		=> 0
		);
		$where = array("id"=>$id);
		$this->db->update(DB_ORDERS.".config_group",$arr,$where);
		return 1;
	}

	//岗位状态调整
	Public function status($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$info = $this->getrow("id=$id");
		$where = array("id"=>$id);
		if($type=="checked"){
			if($info["checked"]){ $checked = 0; }else{ $checked = 1; }
			$arr = array("checked"=>$checked);
			$this->db->update(DB_ORDERS.".config_group",$arr,$where);
		}else{

		}
	}

	//取得岗位权限
	Public function level($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if(!$id){ return; }
		$query = "SELECT levelid FROM ".DB_ORDERS.".config_group_level WHERE groupid = $id ";
		$rows = $this->db->getRows($query);
		if($rows){
			$arr = array();
			foreach($rows AS $rs){
				$arr[$rs["levelid"]] = $rs["levelid"];
			}
			$rows = $arr;
		}
		return $arr;
	}

}
?>
