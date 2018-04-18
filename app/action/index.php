<?php
class indexAction extends Action
{

	Public function oldfrm()
	{

		$this->users->onlogin();	//登录判断

		$level = getModel("level");
		$topmenu = $level->getrows("parentid=1000&checked=1&naved=1");
		$this->tpl->set("topmenu",$topmenu);
		$userid = $this->cookie->get("userid");
		$userinfo = $this->users->getrow("userid=$userid");
		$this->tpl->set("userinfo",$userinfo);

		$this->tpl->display("frm.index.php");

	}


	Public function app()
	{

		$this->users->onlogin();	//登录判断
		$level = getModel("level");
		$menus = $level->getrows("tree=1&naved=1&checked=1&parentid=0");
		$this->tpl->set("menus",$menus);
		$userid = $this->cookie->get("userid");
		$userinfo = $this->users->getrow("userid=$userid");
		$this->tpl->set("userinfo",$userinfo);

		$this->tpl->display("frm.v2.php");

	}

	Public function tree()
	{
		$this->users->onlogin();	//登录判断
		$level = getModel("level");
		$menus = $level->getrows("menued=1&id=1000,1004,1003,1158,1071,1123,1070,1091,1092,1171,1088,1007&tree=1&naved=1&checked=1");
		foreach($menus AS $rs){

			echo $rs["name"]."============<br>";
			foreach($rs["tree"] AS $r){
				echo $r["name"]."<br>";
			}
		}
	}

}
?>
