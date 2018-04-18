<?php
class teamsAction extends Action
{
	
	Public function app()
	{

	}
	
	
	//取得结构中的用户列表
	Public function users()
	{
		$this->users->onlogin();	//登录判断
		extract($_GET);
		//print_r($_GET);
		
		if($type=="1"){
			$typename = "销售";
		}elseif($type=="2"){
			$typename = "售后";
		}elseif($type=="3"){
			$typename = "服务";
		}
	
		$str = "";
		$teams = getModel("teams");
		//echo $parentid;
		//订购信息
		$users = $teams->users("type=$type&idno=$userid&checked=1&usertype=1&&parentid=$parentid&teamid=$teamid");
	
		$userid = (int)$userid;
		if($userid){
			$userinfo = $this->users->getrow("userid=$userid");
			$str.= "<option value=\"".$userinfo["userid"]."\">".$userinfo["worknum"]."_".$userinfo["name"]."</option>";
		}else{
		}

		$str.= "<option value=\"\">选择".$typename."人员</option>";
		if($users&&$no!=1){
			foreach($users AS $rs){
				if($rs["userid"]){
					$name = $rs["name"];
				}else{ 
					$name = "系统录入";
				}
				$str.="<option value=\"".$rs["userid"]."\">".$rs["worknum"]."_".$name."</option>";
			}
		}else{
			if(!$users&&$no!=1){
				$str.= "<option value=\"1\">默认".$typename."人员</option>";
			}
		}
		echo $str;
		exit;
	}
	
}
?>
