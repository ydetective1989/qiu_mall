<?php
class notesModules extends Modules
{

	Public function getrow($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$query = " SELECT n.*,ni.content,u.name AS addname
		FROM ".DB_ORDERS.".note AS n
		INNER JOIN ".DB_ORDERS.".noteinfo AS ni ON n.id = ni.id
		INNER JOIN ".DB_ORDERS.".users AS u ON u.userid = n.adduserid
		WHERE n.id = $id
		ORDER BY $order n.dateline DESC ";
		$rows = $this->db->getRow($query);
		return $rows;
	}

	Public function insert($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$adduserid = $this->cookie->get("userid");
		$arr = array(
			"type"		=> $type,
			"ordersid"	=> $ordersid,
			"userid"	=> (int)$userid,
			"adduserid"	=> (int)$adduserid,
			"dateline"	=> time()
		);
		$this->db->insert(DB_ORDERS.".note",$arr);
		$id = $this->db->getLastInsId();

		$arr = array(
			"id"		=>	$id,
			"content"	=>	$content
		);
		$this->db->insert(DB_ORDERS.".noteinfo",$arr);

		//推送RTX信息
		$curl = getFunc("curl");
		$message = urlencode($content);
		$urlto = "http://yos.shui.cn/oas/api/rtx?userid=$userid&message=$message&url=".urlencode("http://yws.shui.cn");
		$curl->contents($urlto);
	}

	Public function getrows($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$userid = (int)$this->cookie->get("userid");

		if($checked!=""){
			$checked = (int)$checked;
			$where.=" n.checked = $checked ";
		}

		$totime = time();
		$gotime = time()-86400*30;

		$show = (int)$show;
		$query = " SELECT n.*,ni.content,u.name AS addname
		FROM ".DB_ORDERS.".note AS n
		INNER JOIN ".DB_ORDERS.".noteinfo AS ni ON n.id = ni.id
		INNER JOIN ".DB_ORDERS.".users AS u ON u.userid = n.adduserid
		WHERE n.hide = 1 AND n.userid = $userid AND n.dateline >='$gotime' AND n.dateline <='$totime'  $where
		ORDER BY $order n.dateline DESC ";

		if($nums){ $nums = (int)$nums; }else{ $nums = "10"; }
		if($page){
			$this->db->keyid = "n.id";
			$rows = $this->db->getPageRows($query,$nums,$show);
		}else{
			if((int)$xls=="0"){
				$start = ($start)?(int)$start:"0";
				$limt = " LIMIT $start,$nums ";
			}
			$rows = $this->db->getRows($query.$limt);
		}
		return $rows;
	}

	Public function total($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		$userid = (int)$this->cookie->get("userid");

		if($checked!=""){
			$checked = (int)$checked;
			$where.=" AND checked = $checked ";
		}
		$totime = time();
		$gotime = time()-86400*15;

		$query = " SELECT COUNT(id) AS total
		FROM ".DB_ORDERS.".note
		WHERE hide = 1 AND userid = $userid AND dateline >='$gotime' AND dateline <='$totime' $where ";

		$rows = $this->db->getRow($query);
		return $rows["total"];

	}

	//确认
	Public function checknote($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$where = array("id"=>(int)$id);
		$info = $this->getrow("id=$id");
		$checked = $info["checked"];
		if($checked){ $checked = 0; }else{ $checked = 1; }
		$arr = array("checked"=>$checked);
		$this->db->update(DB_ORDERS.".note",$arr,$where);
	}

	public function selnote()
	{
		extract($_POST);
		$userid = $this->cookie->get("userid");
		if($id){
			$idarr = explode(",",$id);
			foreach($idarr AS $rs){
				$noteid = $rs;
				$where = array("id"=>$noteid,"userid"=>(int)$userid);
				$arr = array("checked"=>1);
				$this->db->update(DB_ORDERS.".note",$arr,$where);
			}
		}
	}

	public function allnote()
	{
		$userid = $this->cookie->get("userid");
		$where = array("userid"=>(int)$userid);
		$arr = array("checked"=>1);
		$this->db->update(DB_ORDERS.".note",$arr,$where);
	}

	//类别
	Public function type()
	{
		$ds		= array();
		$ds[1] = array('id' =>'1',	'name'	=> '工单',	'img'	=>	'');
		$ds[2] = array('id' =>'2',	'name'	=> '投诉',	'img'	=>	'');
		$ds[3] = array('id' =>'3',	'name'	=> '审核',	'img'	=>	'');
		$ds[4] = array('id' =>'4',	'name'	=> '发票',	'img'	=>	'');
		$ds[5] = array('id' =>'5',	'name'	=> '业务',	'img'	=>	'');
		$ds[0] = array('id' =>'0',	'name'	=> '其它',	'img'	=>	'');
		return $ds;
	}

}
?>
