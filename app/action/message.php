<?php
class messageAction extends Action
{

	Public function app()
	{
		$this->users->onlogin();	//登录判断
	}

	//发送短信
	Public function sendsms()
	{
			if(IS_SMSED=="0"){
				 dialog("此功能暂未启用");
			}
			$this->users->dialoglogin();		//登录判断
			$islevel = $this->users->getlevel();		//权限判断
			$message = getModel("message");
			if(isset($_POST)&&!empty($_POST))
			{
					extract($_POST);
					$ordersid	= (int)base64_decode($_GET["ordersid"]);
					$msg = $message->sms_sendsms("ordersid=$ordersid&mobile=$mobile&content=$content");
					if($msg=="1"){
						echo "1";exit;
					}else{
						echo $msg;exit;
					}
			}else{
					extract($_GET);
					$this->tpl->set("ordersid",$_GET["ordersid"]);
					$this->tpl->set("type",		"sendsms");
					$this->tpl->set("mobile",$_GET["mobile"]);
					$this->tpl->set("message",$_GET["message"]);
					$this->tpl->display("message.dialog.php");
			}
	}

	Public function countsms()
	{
		$this->users->onlogin();		//登录判断
		$this->users->pagelevel();		//权限判断
		$message = getModel("message");
		echo $message->sms_nums();
	}

	Public function updatepass()
	{
		$this->users->onlogin();		//登录判断
		$this->users->pagelevel();		//权限判断
		$message = getModel("message");

		echo $message->updatepass();
	}

	Public function logout()
	{
		$this->users->onlogin();		//登录判断
		$this->users->pagelevel();		//权限判断
		$message = getModel("message");

		echo $message->logout();
	}

	Public function reg()
	{
		$this->users->onlogin();		//登录判断
		$this->users->pagelevel();		//权限判断
		$message = getModel("message");

		echo $message->sms_reg();
	}


}
?>
