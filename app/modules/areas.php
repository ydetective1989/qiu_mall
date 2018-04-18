<?php
class areasModules extends Modules
{

	Public function get($areaid)
	{
			$sql  = "SELECT * FROM ".DB_CONFIG.".areas WHERE areaid=$areaid";
			$data = $this->db->getRow($sql);
			return $data;
	}

	//取得城市索引
	public function getrows($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$parentid = (int)$parentid;
			$sql  = "SELECT * FROM ".DB_CONFIG.".areas WHERE hide = 1 AND parentid = $parentid  ORDER BY areaid ASC ";
			$data = $this->db->getRows($sql);
			return $data;
	}


}
?>
