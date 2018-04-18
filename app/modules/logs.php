<?php
class logsModules extends Modules
{

	//记录登录信息
	Public function passinfo($str)
	{
		// $str = plugin::extstr($str);//处理字符串
		// extract($str);
		// $arr = array(
		// 		'userid' 	=> $userid,
		// 		'passinfo'	=> $passinfo,
		// 		'dateline'	=> time(),
		// 		'ip'		=> plugin::getIP()
		// );
		// //print_r($arr);exit;
		// $this->odb->insert(DB_LOGS.".yws_login",$arr);
	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:读取日志资料
	Public function getrow($str)
	{
			if(!$this->odb){ return; }	//判断没有用日志
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			//$id = (int)$id;
	    // $sql = "SELECT l.*,li.sqlstr
	    // FROM ".DB_LOGS.".yws_logs AS l
	    // INNER JOIN ".DB_LOGS.".yws_logsinfo AS li ON li.id = l.id
			// WHERE l.id = '".$id."' ";
			$query = array("_id"=>$id);
			$fields=array();
			$row = $this->odb->fetchRow("syslogs",$query,$fields);//print_r($row);exit;
			$userid = $row["userid"];
			$query = " SELECT userid,worknum,name FROM ".DB_ORDERS.".users WHERE userid = $userid ";
			$r = $this->db->getRow($query);
			$row["worknum"] = $r["worknum"];
			$row["username"]= $r["name"];
			return $row;
	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:记录日志
	Public function insert($str)
	{
			if(!$this->odb){ return; }	//判断没有用日志
			if($str){
					$str = plugin::extstr($str);//处理字符串
					extract($str);
					if(!$userid){ $userid = $this->cookie->get("userid"); }
					$arr = array(
							'ordersid'	=>	(int)$ordersid,
							'openid'		=>	OPEN_ID,
							'type'			=>	trim($type),
							'name'			=>	trim($name),
							'detail'		=>	trim($detail),
							'logsinfo'	=>	$sqlstr,
							'userid'		=>	(int)$userid,
							'dateline'	=>	time(),
							'ip'				=>	plugin::getIP()
					);
					$msg = $this->odb->insert("syslogs",$arr);
			}
			return 1;
	}

	Public function namelist()
	{
			if(!$this->odb){ return; }	//判断没有用日志
			extract($_GET);
			//$query = "SELECT name FROM ".DB_LOGS.".yws_logs WHERE openid = ".OPEN_ID." GROUP BY name ORDER BY name ASC";
			return $this->odb->fetchDistinct("syslogs","name",array("openid" => OPEN_ID));
	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:显示日志列表(分页)
	Public function getrows($str="")
	{
			if(!$this->odb){ return; }	//判断没有用日志
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$godate = strtotime($godate." 00:00:00");
			$todate = strtotime($todate." 23:59:59");

			$query = array();
			$query["openid"] = OPEN_ID;
			$query["dateline"] = array($this->odb->cmd('>=')=>$godate,$this->odb->cmd('<=')=>$todate);
			if($keyword!=""){
					switch($cateid){
						case "1":
								$query["ordersid"] = (int)$keyword;
								break;
						case "2":
								$keyword = new MongoRegex("/$keyword/");
								$query["detail"] = $keyword;
								break;
						case "3":
								$query["userid"] = (int)$keyword;

								break;
						default	:
						 		$query["ordersid"] = (int)$keyword;
					}
			}else{
					$query["dateline"] = array($this->odb->cmd('>=')=>$godate,$this->odb->cmd('<=')=>$todate);
			}
			if($name!=""){
					$query["name"] = $name;
			}

			$fields = array("_id","openid","ordersid","type","name","detail","userid","dateline","ip");
			$sort = array("dateline"=>-1);
			if($xls=="1"){
					$rows = $this->odb->select("syslogs",$fields,$query,$sort);//select($colName,$fields=array(),$query=array(),$sort=array(),$limit=0,$skip=0)
			}else{
					$rows   = $this->odb->fetchPage("syslogs",$fields,$query,$sort);//fetchPage($colName,$fields=array(),$query=array(),$sort=array(),$nums='20',$type='0')
			}
			return $rows;
	}


}
?>
