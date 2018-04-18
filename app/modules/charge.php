<?php
class chargeModules extends Modules
{

	Public function paytype($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		$query = " SELECT id,name
		FROM ".DB_ORDERS.".config_charge_type
		WHERE openid = ".OPEN_ID." AND hide = 1 AND parentid = $id
		ORDER BY orderd DESC,id ASC ";
		$rows = $this->db->getRows($query);
		return $rows;
	}

	Public function checked()
	{
		//分裂数组(简化变量的访问)
		extract($_POST);
		//print_r($id);exit;
		if($id){
			$userid = $this->cookie->get("userid");
			$idarr = explode(",",$id);
			foreach($idarr AS $rs){
				$chargeid = $rs;
				$where = array("id"=>$chargeid);
				$arr = array("checked"=>1,"checkuserid"=>$userid,"checkdate"=>time());
				$this->db->update(DB_ORDERS.".orders_charge",$arr,$where);
			}
			return 1;
		}else{
			return "错误：未选择内容！";
		}

	}

	Public function cates()
	{
		//订单贷款，预付款，押金，安装费，材料费，远程费，工单收款，其它
		$ds		= array();
		$ds[1]	= array('id' =>'1',	'name'	=> '订单货款',	'color'	=>	'green');
		$ds[2]	= array('id' =>'2',	'name'	=> '预付款',		'color'	=>	'orange');
		$ds[3]	= array('id' =>'3',	'name'	=> '押金',		'color'	=>	'green');
		$ds[4]	= array('id' =>'4',	'name'	=> '安装费',		'color'	=>	'green');
		$ds[5]	= array('id' =>'5',	'name'	=> '材料费',		'color'	=>	'green');
		$ds[6]	= array('id' =>'6',	'name'	=> '远程费',		'color'	=>	'green');
		$ds[7]	= array('id' =>'7',	'name'	=> '退差返现',	'color'	=>	'green');
		$ds[0]	= array('id' =>'0',	'name'	=> '其它',		'color'	=>	'red');
		return $ds;

	}



}
?>
