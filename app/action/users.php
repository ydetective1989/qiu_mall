<?php
class usersAction extends Action
{

	Public function app()
	{
		if(isset($_POST)&&!empty($_POST))
		{
			//分裂数组(简化变量的访问)
			extract($_POST);

			$vi = getFunc("verifyimg");
			if(!$vi->checked(strtoupper($authnum))){
				msgbox("","验证码输入错误！");exit;
			}

			$users = getModel("users");
			$userinfo = $this->users->getrow("username=$username");
			$userid = (int)$userinfo["userid"];
			$passdb = $userinfo["password"];
			$passwd 	= MD5($password);
			//echo $password."||".$passwd."||".$passdb;exit;

			//日志引用
			$logs = getModel('logs');

			if(!$userinfo){
					$logs->insert("type=update&userid=$userid&ordersid=0&name=用户帐号[登录]&detail=帐号[".$username."]:抱歉，你的帐户信息不存在！&sqlstr=");
					msgbox(S_ROOT,"抱歉，你的帐户信息不存在，非法来源！");
			}
			if($passwd!=$passdb){
					$logs->insert("type=update&userid=$userid&ordersid=0&name=用户帐号[登录]&detail=帐号[".$username."]:抱歉，你的帐户密码错误！&sqlstr=");
					msgbox(S_ROOT,"抱歉，用户密码错误！");
			}
			if((int)$userinfo["isadmin"]=="0"){
					if((int)$userinfo["checked"]=="0"){
							$logs->insert("type=update&userid=$userid&ordersid=0&name=用户帐号[登录]&detail=帐号[".$username."]:抱歉，你没有进入系统权限！&sqlstr=");
							msgbox(S_ROOT,"抱歉，你没有进入系统权限！");
					}
					if((int)$userinfo["groupid"]=="0"){
							$logs->insert("type=update&userid=$userid&ordersid=0&name=用户帐号[登录]&detail=帐号[".$username."]:抱歉，你没有系统操作权限！&sqlstr=");
							msgbox(S_ROOT,"抱歉，你没有系统操作权限！");
					}
			}

			//同步登录
			$this->users->synclogin("userid=".$userid."&usertype=1");	//同步登录
			//操作日志记录
			$logs->insert("type=update&userid=$userid&ordersid=0&name=用户帐号[登录]&detail=帐号[".$username."]用户登录系统&sqlstr=");
			toplink(S_ROOT,"");

		}else{
			$this->tpl->display("users.login.php");
		}
	}


	Public function logout()
	{
		$this->users->logout();
		toplink(S_ROOT."users","");
	}

	//修正用户信息
	Public function editinfo()
	{
		$this->users->onlogin();	//登录判断
		if(isset($_POST)&&!empty($_POST))
		{
			$this->users->userid = (int)$this->cookie->get("userid");
			$msg = $this->users->editinfo();
			msgbox(S_ROOT."pages","OK，信息更新成功！");
		}else{
			$userid = $this->cookie->get("userid");
			$userinfo = $this->users->getrow("userid=$userid");
			$this->tpl->set("info",$userinfo);
			$this->tpl->display("system.users.editinfo.php");
		}
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
