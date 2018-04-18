<?php
class usersModules extends Modules
{

	public function add()
	{

		extract($_POST);
		$checkusers = $this->checkusers("type=username&username=$username");
		if($checkusers!="1"){ return $checkusers; }
		if($password==""){
			$password = rand(11110000,99999999);
		}
		$password = md5($password);

		$arr = array(
				"openid"		=> OPEN_ID,
				"username"	=>	strtolower(trim($username)),
				"password"	=>	$password,
				'name'		=>	trim($name),
				'worknum'	=>	strtoupper(trim($worknum)),
				'mobile'	=>	trim($mobile),
				'email'		=>	trim($email),
				'groupid'	=>	(int)$groupid,
				'checked'	=>	(int)$checked,
				'alled'	=>	(int)$alled,
				'jobsed'	=>	(int)$jobsed,
				'stored'  =>	(int)$userstored,
				'lastdate'	=>	time(),
				'lastip'	=>	plugin::getIP()
		);
		$this->db->insert(DB_ORDERS.".users",$arr);
		$userid = (int)$this->db->getLastInsId();

		//权限处理
		if($grouplevel){
			foreach($grouplevel AS $item){
				$arr = array("levelid"=>$item,"userid"=>$userid);
				$this->db->insert(DB_ORDERS.".config_users_level",$arr);
			}
		}

		//订单权限
		if($orderteamsed){
			foreach($orderteamsed AS $item){
				$arr = array("teamid"=>$item,"userid"=>$userid);
				$this->db->insert(DB_ORDERS.".config_teams_orders",$arr);
			}
		}

		//操作权限
		if($jobsteamsed){
			foreach($jobsteamsed AS $item){
				$arr = array("teamid"=>$item,"userid"=>$userid);
				$this->db->insert(DB_ORDERS.".config_teams_jobs",$arr);
			}
		}

		//操作权限
		if($stored){
			foreach($stored AS $item){
				$arr = array("storeid"=>$item,"userid"=>$userid);
				$this->db->insert(DB_ORDERS.".config_users_store",$arr);
			}
		}

		return 1;

	}

	//Desc:编辑用户
	Public function edit()
	{
		//分裂数组(简化变量的访问)
		extract($_POST);
		$userid = (int)$this->id;
		$where = array('userid'=>$userid);

		if($username){
				$checkusers = $this->checkusers("type=username&username=$username");
				if($checkusers!="1"){ return $checkusers; }
				$arr = array("username"=>$username);
				$this->db->update(DB_ORDERS.".users",$arr,$where);
		}

		if($password){
				$password = md5($password);
				$arr = array("password"=>$password);
				$this->db->update(DB_ORDERS.".users",$arr,$where);
		}

		$arr = array(
			'name'		=>	trim($name),
			'worknum'	=>	$worknum,
			'mobile'	=>	trim($mobile),
			'email'		=>	trim($email),
			'groupid'	=>	(int)$groupid,
			'checked'	=>	(int)$checked,
			'alled'	=>	(int)$alled,
			'jobsed'	=>	(int)$jobsed,
			'stored'  =>	(int)$userstored
		);
		$this->db->update(DB_ORDERS.".users",$arr,$where);

		//删除权限处理
		$where = array('userid'=>$userid);
		$this->db->delete(DB_ORDERS.".config_users_level",$where);
		if((int)$checked==1&&$grouplevel){
			foreach($grouplevel AS $item){
				$arr = array("levelid"=>$item,"userid"=>$userid);
				$this->db->insert(DB_ORDERS.".config_users_level",$arr);
			}
		}

		$where = array('userid'=>$userid);
		$this->db->delete(DB_ORDERS.".config_teams_orders",$where);
		//订单权限
		if((int)$checked==1&&$orderteamsed){
			foreach($orderteamsed AS $item){
				$arr = array("teamid"=>$item,"userid"=>$userid);
				$this->db->insert(DB_ORDERS.".config_teams_orders",$arr);
			}
		}

		$where = array('userid'=>$userid);
		$this->db->delete(DB_ORDERS.".config_teams_jobs",$where);
		//操作权限
		if((int)$checked==1&&$jobsteamsed){
			foreach($jobsteamsed AS $item){
				$arr = array("teamid"=>$item,"userid"=>$userid);
				$this->db->insert(DB_ORDERS.".config_teams_jobs",$arr);
			}
		}

		$where = array('userid'=>$userid);
		$this->db->delete(DB_ORDERS.".config_users_store",$where);
		//操作权限
		if((int)$checked==1&&$stored){
			foreach($stored AS $item){
				$arr = array("storeid"=>$item,"userid"=>$userid);
				$this->db->insert(DB_ORDERS.".config_users_store",$arr);
			}
		}
		return 1;
	}


	public function editinfo()
	{
		//分裂数组(简化变量的访问)
		extract($_POST);
		$userid = (int)$this->userid;
		$where = array('userid'=>$userid);
		//更新密码
		if($password){
				$password = md5($password);
				$arr = array("password"=>$password);
				$this->db->update(DB_ORDERS.".users",$arr,$where);
				$logsarr.= plugin::arrtostr($arr);
		}
		//更新个人信息
		$arr = array(
			'mobile'	=>	trim($mobile),
			'email'		=>	trim($email)
		);
		$this->db->update(DB_ORDERS.".users",$arr,$where);
		$logsarr.= plugin::arrtostr($arr);

		//操作日志记录
		$logs = getModel('logs');
		$logs->insert("type=update&ordersid=0&name=用户帐号[修改]&detail=用户#".userid."修改了自己的信息及密码&sqlstr=$logsarr");

		return;

	}


	Public function level($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if(!$id){
				return;
		}
		$query = "SELECT levelid FROM ".DB_ORDERS.".config_users_level WHERE userid = $id ";
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

	Public function teamed($str)
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);

		if((int)$userid=="0"){
			$userid = (int)$this->cookie->get("userid");
		}

		$userinfo = $this->getrow("userid=$userid");
		if($userinfo["isadmin"])		{ return $userid; }
		if($userinfo["jobsed"]=="1"){ return $userid; }

		$query = " SELECT t.id
		FROM ".DB_ORDERS.".config_teams AS t
		INNER JOIN ".DB_ORDERS.".config_teams_jobs AS tj ON t.id = tj.teamid
		WHERE t.openid = ".OPEN_ID." AND tj.userid = $userid
		GROUP BY t.id
		ORDER BY t.id ASC ";
		$rows = $this->db->getRows($query);

		$idarr = array();
		if($rows){
			foreach($rows AS $rs){
				$arr[] = $rs["id"];
			}
			$idrows = implode(",",$arr);
		}else{
			return 0;
		}

		//数组格式teamid
		if(count(explode(",",$teamid))>1){
			$where.=" AND t.id IN($teamid) ";
		}else{
			$teamid = (int)$teamid;
			$where.=" AND t.id = $teamid ";
		}

		$query = " SELECT t.id
		FROM ".DB_ORDERS.".config_teams AS t
		WHERE t.openid = ".OPEN_ID." AND t.id IN($idrows) $where ";
		$rows = $this->db->getRow($query);
		return (int)$rows["id"];
	}

	public function checkusers($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$userid = (int)$this->id;
		if($type=="username"){
			$check = $this->checkusername($username);
			if(!$check){ return "用户名格式不正确，请检查！"; }
			if($userid){ $where = " AND userid != $userid "; }
			$query = "SELECT userid FROM ".DB_ORDERS.".users WHERE openid = ".OPEN_ID." AND username = '$username' $where ";
			$info = $this->db->getRow($query);
			if($info){ return '用户名已存在'; }	//用户名已存在
			return 1;
		}elseif($type=="email"){
			$check = $this->checkemail($email);
			if(!$check){ return '邮箱地址格式错误，请检查！'; }
			return 1;
		}else{
			return;
		}
	}

	//取得用户信息
	public function getrow($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			if($userid){ $where = " AND u.userid = $userid "; }
			if($username){ $where = " AND u.username = '$username' "; }
			if($where==""){ return; }
			if($checked!=""){ $where.=" AND u.checked = $checked "; 	}
		 	$query = "SELECT u.*,g.name AS groupname
			FROM ".DB_ORDERS.".users AS u
			INNER JOIN ".DB_ORDERS.".config_group AS g ON u.groupid = g.id
			WHERE u.openid = ".OPEN_ID." $where ";
			$rows = $this->db->getRow($query);
			//print_r($rows);exit;
			return $rows;
	}

	//取得用户
	public function getrows($str="")
	{

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		//关键字搜索
		if($key){
			switch($type){
				case "userid"		:	$where.=" AND u.userid = ".(int)$key." ";			break;
				case "worknum"	:	$where.=" AND u.worknum = '".$key."' ";				break;
				case "email"		:	$where.=" AND u.email like '%".$key."%' ";		break;
				case "name"			:	$where.=" AND u.name like '%".$key."%' ";			break;
				case "username"	:	$where.=" AND u.username like '%".$key."%' ";	break;
				default					:"";
			}
		}
		if($groupid!=""){
			$where.= " AND u.groupid = ".(int)$groupid." ";
		}
		if($useridno!=""){
			$where.= " AND u.userid NOT IN (".(int)$useridno.") ";
		}
		//正常状态
		if($checked!=""){
			$where.=" AND u.checked = $checked ";
		}
		//正常状态
		if($order!=""){
			$desc = ($desc)?$desc:"desc";
			switch($order){
				case "worknum" : $orderd = "u.worknum ".$desc.","; break;
				default : $orderd = "" ;
			}
		}
		$show = ($show)?(int)$show:"0";
		$query = "SELECT u.*,g.name AS groupname
		FROM ".DB_ORDERS.".users AS u
		INNER JOIN ".DB_ORDERS.".config_group AS g ON u.groupid = g.id
		WHERE u.openid = ".OPEN_ID." AND u.hide = 1 $where
		GROUP BY u.userid
		ORDER BY $orderd u.checked DESC, u.lastdate DESC";
		if($page){
			$rows = $this->db->getPageRows($query,$page,$show);
		}else{
			$rows = $this->db->getRows($query);
		}
		return $rows;
	}

	//用户组
	Public function teams($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		//用户ID
		if((int)$userid){
			$userid = (int)$userid;
		}else{
			$userid = (int)$this->cookie->get("userid");
		}
		$users = getModel("users");
		$userinfo = $users->getrow("userid=$userid");

		if($type<>""){ $where.=" AND type = '".(int)$type."' "; }

		if($checked<>""){  $checked = (int)$checked; $where.=" AND checked = $checked "; }

		if((int)$userinfo["isadmin"]=="0"){
			$owhere = "";
			$query = " SELECT t.id
			FROM ".DB_ORDERS.".config_teams AS t
			INNER JOIN ".DB_ORDERS.".config_teams_jobs AS ctj ON t.id = ctj.teamid OR t.parentid = ctj.teamid
			WHERE t.openid = ".OPEN_ID." AND ctj.userid = $userid
			GROUP BY t.id
			ORDER BY t.id ASC ";
			$rows = $this->db->getRows($query);
			$idarr = array();
			if($rows){
				foreach($rows AS $rs){
					$arr[] = $rs["id"];
				}
				$idrows = implode(",",$arr);
				if($id){ $idrows = ",".$idrows; }
				$idarr = $id.$idrows;
				$where.=" AND id IN($idarr) ";
			}else{
				return;
			}
		}

		$show = (int)$show;
		$query = " SELECT id,name,parentid,numbers
		FROM ".DB_ORDERS.".config_teams
		WHERE openid = ".OPEN_ID." AND hide = 1 AND parentid > 0 $where
		ORDER BY numbers ASC,orderd DESC ";
		return $this->db->getRows($query);
	}

	//判断用户名是不正确
	Public function checkusername($username) {
		$guestexp = '\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8';
		$len = $this->dstrlen($username);
		if($len > 20 || $len < 3 || preg_match("/\s+|^c:\\con\\con|[%,\*\"\s\<\>\&]|$guestexp/is", $username)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	//用户名长度检查
	Public function dstrlen($str) {
		$count = 0;
		for($i = 0; $i < strlen($str); $i++){
			$value = ord($str[$i]);
			if($value > 127) {
				$count++;
				if($value >= 192 && $value <= 223) $i++;
				elseif($value >= 224 && $value <= 239) $i = $i + 2;
				elseif($value >= 240 && $value <= 247) $i = $i + 3;
			}
			$count++;
		}
		return $count;
	}

	//电子邮箱格式判断
	Public function checkemail($email) {
		return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
	}

	/*******************  用户权限  ***********************/

	//权限判断
	Public function islevel($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		//print_r($str);exit;
		$userid = (int)$this->cookie->get("userid");
		$userinfo = $this->userinfo("userid=$userid");
		$admined = (int)$admined;
		//print_r($userinfo);exit;
		if($userinfo){

			if($userinfo["isadmin"]==1||($userinfo["isadmin"]&&$admined=="0")){ return 1; }	//管理员直接赋予权限
			if($reqmod){ $where.=" AND cl.reqmod = '".$reqmod."' "; }
			if($reqac) { $where.=" AND cl.reqac  = '".$reqac."'  "; }
			if($reqdo) { $where.=" AND cl.reqdo  = '".$reqdo."'  "; }
			//print_r($_GET);
			//个人权限判断
			$query = " SELECT cl.id
			FROM ".DB_ORDERS.".config_level AS cl
			INNER JOIN ".DB_ORDERS.".config_users_level AS cu ON cl.id = cu.levelid
			WHERE cu.userid = $userid AND cl.checked = 1 AND cl.hide = 1 $where  ";
			$userlevel = $this->db->getRow($query);
			//if($userid==9){echo $query;}

			if($userlevel){  return $userlevel["id"];  }	//返回权限ID

			//群组权限判断
			$groupid = (int)$userinfo["groupid"];
			$query = " SELECT cl.id
			FROM ".DB_ORDERS.".config_level AS cl
			INNER JOIN ".DB_ORDERS.".config_group_level AS cg ON cl.id = cg.levelid
			WHERE cl.checked = 1 AND cl.hide = 1 AND cg.groupid = $groupid $where  ";
			$grouplevel = $this->db->getRow($query);
			if($grouplevel){  return $grouplevel["id"];  }	//返回权限ID

		}
		return 0;
	}

	Public function getlevel($admined="")
	{
		$reqmod = $_GET["mod"];
		$reqac  = $_GET["ac"];
		$reqdo  = $_GET["do"];
		return $checked = $this->islevel("reqmod=$reqmod&reqac=$reqac&reqdo=$reqdo&admined=$admined");
	}

	Public function pagelevel($admined="")
	{
		$reqmod = $_GET["mod"];
		$reqac  = $_GET["ac"];
		$reqdo  = $_GET["do"];
		$checked = $this->islevel("reqmod=$reqmod&reqac=$reqac&reqdo=$reqdo&admined=$admined");
		if(!$checked){  msgbox("","抱歉，你没有权限访问本页面");	}
	}

	Public function dialoglevel($admined="")
	{
		$reqmod = $_GET["mod"];
		$reqac  = $_GET["ac"];
		$reqdo  = $_GET["do"];
		$checked = $this->islevel("reqmod=$reqmod&reqac=$reqac&reqdo=$reqdo&admined=$admined");
		if(!$checked){  dialog("抱歉，你没有权限访问本页面");	}
	}


	/*******************  用户登录  ***********************/

	//记录用户登录状态
	Public function synclogin($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$sessid		=	plugin::random(5);
		$dateline	=	time();
		$this->cookie->set('userid',$userid);
		$this->cookie->set('usertype',$usertype);
		$this->cookie->set('dateline',$dateline);
		$this->cookie->set('sessid',$sessid);
		$paramArr = array(
				'userid'		=> (int)$userid,
				'usertype'	=> (int)$usertype,
				'dateline'	=> (int)$dateline
		);
		$sign = plugin::buildsafe($paramArr,$sessid);	//Sign Key
		$this->cookie->set('sign',$sign);
		$arr = array("sign"=>$sign,"lastdate"=>time(),"lastip"=>plugin::getIP());
		$where = array("userid"=>$userid);
		$this->db->update(DB_ORDERS.".users",$arr,$where);
		return true;
	}

	//判断用户登录
	Public function checked()
	{
		$userid		= $this->cookie->get("userid");
		$usertype	= $this->cookie->get("usertype");
		$dateline	= $this->cookie->get("dateline");
		$sessid		= $this->cookie->get("sessid");
		$sign		  = $this->cookie->get("sign");
		$paramArr = array(
			'userid'	=> (int)$userid,
			'usertype'	=> (int)$usertype,
			'dateline'	=> (int)$dateline
		);
		$signed		= plugin::buildsafe($paramArr,$sessid);	//Sign Key
		if($signed!=$sign){
			return false;
		}
		$userinfo = $this->getrow("userid=$userid&checked=1");
		//print_r($userinfo);echo $sign;exit;
		if($sign!=$userinfo["sign"]){
			return false;
		}
		return true;
	}

	//登录判断验证
	Public function onlogin()
	{
		//页面权限判断
		$this->noie();
		if(!$this->checked()){//未登录
			$this->cookie->set("urlto",plugin::getURL());
			header("location:".S_ROOT."users");
		}else{
			$usertype = $this->cookie->get("usertype");
			$this->tpl->set("usertype",$usertype);
		}
	}

	//登录判断验证
	Public function dialoglogin()
	{
		if(!$this->checked()){//未登录
			dialog("你没有登录系统，请退出后重新登录！");
		}
		//页面权限判断
	}

	Public function noie()
	{
		//判断是否使用chrome内核浏览器//Safari Firefox
		//echo $_SERVER["HTTP_USER_AGENT"];
		if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE")){
			$this->tpl->set("webie","1");
			header("location:".S_ROOT."pages/noie");
		}
	}

	//判断是否管理员
	Public function isadmin()
	{
		$userid = (int)$this->cookie->get("userid");
		$info = $this->userinfo("userid=$userid");
		return $info["isadmin"];
	}

	//退出登陆，注销COOKIE
	Public function logout()
	{
		$this->cookie->dispose();
		return 1;
	}

	//取得用户信息
	Public function userinfo($str)
	{
		if(!$str){ return; }
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		if($userid){ $where.=" AND userid = $userid "; }
		$query = "SELECT * FROM ".DB_ORDERS.".users WHERE openid = ".OPEN_ID." $where ";
		return $this->db->getRow($query);
	}

	//安全加密
	Public function buildsafe($paramArr,$appkey)	//paramArr = array[]
	{
		$sign = "";
		ksort($paramArr);
		foreach($paramArr AS $key=>$val){
			if($key!=""&&$val!=""){
				$sign.=$key.$val;
			}
		}
		$sign = strtoupper(md5($appkey.$sign.$appkey));
		return $sign;
	}

}
?>
