<?php
class systemAction extends Action
{

	Public function app()
	{
		$this->tpl->display("page.main.php");

	}

	//系统设置侧边菜单
	Public function menu()
	{
		$this->users->onlogin();	//登录判断

		$level = getModel("level");
		$menus = $level->getrows("id=1007,1017,1088,1120&tree=1&naved=1&checked=1");
		$this->tpl->set("menus",$menus);
		$this->tpl->display("frm.menu.php");
	}

	//用户管理模块
	Public function users()
	{
		$this->users->onlogin();	//登录判断

		$group = getModel("group");
		$level = getModel("level");
		$do = $_GET["do"];
		if($do=="add"){
			$this->users->pagelevel();	//权限判断
			$urlto = $this->cookie->get("list");
			$this->tpl->set("urlto",$urlto);
			if(isset($_POST)&&!empty($_POST))
			{
				$msg = $this->users->add();
				if($msg=="1"){
					msgbox($urlto,"增加操作完成");
				}else{
					msgbox("",$msg);
				}
			}else{
				if(IS_STORE=="1"){
					$store = getModel("store");
					$stores = $store->store();
					$this->tpl->set("stores",$stores);
				}
				$grouplist = $group->getrows("checked=1");
				$this->tpl->set("grouplist",$grouplist);
				$this->tpl->display("system.users.info.php");
			}

		}elseif($do=="edit"){

			$this->users->pagelevel();	//权限判断
			$id = $_GET["id"];
			$urlto = $this->cookie->get("list");
			$this->tpl->set("urlto",$urlto);
			if(isset($_POST)&&!empty($_POST))
			{
				$this->users->id = $id;
				$msg = $this->users->edit();
				if($msg=="1"){
					msgbox($urlto,"修改操作完成");
				}else{
					msgbox("",$msg);
				}
			}else{
				if($_GET["type"]){
					$this->users->status("id=$id&type=".$_GET["type"]);
					msgbox($urlto,"状态变更成功");
				}
				$info = $this->users->getrow("userid=$id");
				$this->tpl->set("info",$info);

				$userid = (int)$this->cookie->get("userid");
				if($info["userid"]==$userid){
					msgbox("","抱歉，您不能操作你自己的信息！");
				}
				$grouplist = $group->getrows("checked=1");
				$this->tpl->set("grouplist",$grouplist);

				if(IS_STORE=="1"){
					$store = getModel("store");
					$stores = $store->store();
					$this->tpl->set("stores",$stores);
				}

				$this->tpl->display("system.users.info.php");
			}
		}elseif($do=="level"){

				$userid = (int)$_GET["userid"];
				$groupid = (int)$_GET["groupid"];
				if($groupid == "0"){ echo "无"; exit; }

				$grouplevel = $group->level("id=$groupid");
				$this->tpl->set("grouplevel",$grouplevel);

				if($userid){
					$userslevel = $this->users->level("id=$userid");
					$this->tpl->set("userslevel",$userslevel);
				}

				$levels = $level->getrows("parentid=0&tree=1&checked=1");
				$this->tpl->set("levels",$levels);
				$this->tpl->display("system.users.ajaxlevel.php");

		}elseif($do=="del"){

			$this->users->pagelevel();	//权限判断
			$urlto = $this->cookie->get("list");
			$id = $_GET["id"];
			if($id){
				$group->del();
			}
			msgbox($urlto,"修改操作完成");

		}elseif($do=="list"){

			extract($_GET);
			$this->users->pagelevel();	//权限判断
			$userid = (int)$this->cookie->get("userid");
			$list = $this->users->getrows("page=30&type=$type&key=$key&checked=$checked&useridno=$userid&groupid=$groupid");
			$this->tpl->set("list",$list["record"]);
			$this->tpl->set("page",$list["pages"]);
			$this->tpl->display("system.users.list.php");

		}else{

			$this->users->pagelevel();	//权限判断
			$grouplist = $group->getrows("checked=1");
			$this->tpl->set("grouplist",$grouplist);
			$this->tpl->display("system.users.index.php");
		}

	}

	//岗位管理
	Public function group()
	{

		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断

		$group = getModel("group");
		$level = getModel("level");
		$do = $_GET["do"];
		if($do=="add"){
			$urlto = $this->cookie->get("group");
			$this->tpl->set("urlto",$urlto);
			if(isset($_POST)&&!empty($_POST))
			{
				$msg = $group->add();
				if($msg=="1"){
					msgbox($urlto,"增加操作完成");
				}else{
					msgbox($urlto,$msg);
				}
			}else{
				$levels = $level->getrows("parentid=0&tree=1&checked=1");
				$this->tpl->set("levels",$levels);
				$this->tpl->display("system.group.info.php");
			}
		}elseif($do=="edit"){
				$id = $_GET["id"];
				$urlto = $this->cookie->get("group");
				$this->tpl->set("urlto",$urlto);
				if(isset($_POST)&&!empty($_POST))
				{
					$group->id = $id;
					$msg = $group->edit();
					if($msg=="1"){
						msgbox($urlto,"修改操作完成");
					}else{
						msgbox($urlto,$msg);
					}
				}else{
					if($_GET["type"]){
						$group->status("id=$id&type=".$_GET["type"]);
						msgbox($urlto,"状态变更成功");
					}
					$info = $group->getrow("id=$id");
					$this->tpl->set("info",$info);

					$levels = $level->getrows("parentid=0&tree=1&checked=1");
					$this->tpl->set("levels",$levels);

					$grouplevel = $group->level("id=$id");
					$this->tpl->set("grouplevel",$grouplevel);
					$this->tpl->display("system.group.info.php");
				}
		}elseif($do=="del"){
			$urlto = $this->cookie->get("group");
			$id = $_GET["id"];
			if($id){
				$group->del();
			}
			msgbox($urlto,"修改操作完成");
		}else{
			$urlto = $this->cookie->get("group");
			if(isset($_POST)&&!empty($_POST))
			{
				$group->editlist();
				msgbox($urlto,"批量修改完成");
			}else{
				$list = $group->getrows();
				$this->tpl->set("list",$list);
				$this->tpl->display("system.group.list.php");
			}
		}
	}

	//权限管理
	Public function level()
	{
		$this->users->onlogin();	//登录判断
		$this->users->pagelevel();	//权限判断

		$level = getModel("level");

		$do = $_GET["do"];
		if($do=="add"){
			$urlto = $this->cookie->get("level");
			$this->tpl->set("urlto",$urlto);
			if(isset($_POST)&&!empty($_POST))
			{
				$msg = $level->add();
				if($msg=="1"){
					msgbox($urlto,"修改操作完成");
				}else{
					msgbox($urlto,$msg);
				}
			}else{
				$list = $level->getrows("parentid=0");
				$this->tpl->set("list",$list);
				$this->tpl->display("system.level.info.php");
			}
		}elseif($do=="edit"){
			$id = $_GET["id"];
			$urlto = $this->cookie->get("level");
			$this->tpl->set("urlto",$urlto);
			if(isset($_POST)&&!empty($_POST))
			{
				$level->id = $id;
				$msg = $level->edit();
				if($msg=="1"){
					msgbox($urlto,"修改操作完成");
				}else{
					msgbox($urlto,$msg);
				}
			}else{
				if($_GET["type"]){
					$level->status("id=$id&type=".$_GET["type"]);
					msgbox($urlto,"状态变更成功");
				}
				$info = $level->getrow("id=$id");
				$this->tpl->set("info",$info);
				$list = $level->getrows("parentid=0&idno=$id");
				$this->tpl->set("list",$list);
				$this->tpl->display("system.level.info.php");
			}
		}elseif($do=="del"){
			$urlto = $this->cookie->get("level");
			$id = (int)$_GET["id"];
			if($id){
				$level->id = $id;
				$level->del();
			}
			msgbox($urlto,"修改操作完成");
		}else{	//列表
			$urlto = $this->cookie->get("level");
			if(isset($_POST)&&!empty($_POST))
			{
				$level->editlist();
				msgbox($urlto,"批量修改完成");
			}else{
				$id = (int)$_GET["id"];
				$list = $level->getrows("parentid=$id");
				$this->tpl->set("list",$list);
				$this->tpl->display("system.level.list.php");
			}
		}

	}

	//组织结构管理
	Public function teams()
	{
		$this->users->onlogin();	//登录判断

		$do = $_GET["do"];
		if($do=="sales"){			//销售网点
			$this->opteams(1);
		}elseif($do=="service"){	//客服中心
			$this->opteams(2);
		}elseif($do=="after"){		//服务网点
			$this->opteams(3);
		}elseif($do=="treeajax"){		//ajax tree
			//echo 222;exit;
			$teams = getModel("teams");
			$type	= $_GET["type"];	//调用类型
			$val	= $_GET["val"];		//字段名称
			$userid	= $_GET["userid"];	//字段名称
			$this->tpl->set("val",$val);
			$teamed = $teams->teamed("userid=".$userid."&val=".$val);
			//print_r($teamed);
			$this->tpl->set("teamed",$teamed);
			$list	= $teams->tree("type=$type");
			$this->tpl->set("list",$list);
			$this->tpl->display("system.teams.ajaxtree.php");
		}
	}

	Public function opteams($type)
	{
		$this->users->pagelevel();	//权限判断
		$teams = getModel("teams");
		$to = $_GET["to"];
		$do = $_GET["do"];
		$type = (int)$type;
		if($to=="add"){
			if(isset($_POST)&&!empty($_POST))
			{
				$id = $_POST["parentid"];
				$urlto = S_ROOT."system/teams?do=".$do."&show=lists&id=".$id;
				$teams->type = $type;
				$msg = $teams->add();
				if($msg=="1"){
					msgbox($urlto,"增加操作完成");
				}else{
					msgbox("",$msg);
				}
			}else{
				$list = $teams->getrows("type=$type&parentid=0");
				$this->tpl->set("list",$list);
				$this->tpl->set("urlto",S_ROOT."system/teams?do=".$do."&show=lists");
				$this->tpl->display("system.teams.info.php");
			}
		}elseif($to=="edit"){
			$id = (int)$_GET["id"];
			if(isset($_POST)&&!empty($_POST))
			{
				$teams->id = $id;
				$teams->type = $type;
				$msg = $teams->edit();
				if($msg=="1"){
					$id = $_POST["parentid"];
					$urlto = S_ROOT."system/teams?do=".$do."&show=lists&id=".$id;
					msgbox($urlto,"修改操作完成");
				}else{
					msgbox("",$msg);
				}
			}else{
				if($_GET["type"]){
					$teams->status("id=$id&type=".$_GET["type"]);
					msgbox($urlto,"状态变更成功");
				}
				$info = $teams->getrow("id=$id");
				$this->tpl->set("info",$info);
				$this->tpl->set("urlto",S_ROOT."system/teams?do=".$do."&show=lists&id=".$info["parentid"]);
				$list = $teams->getrows("type=$type&parentid=0&idno=$id");
				$this->tpl->set("list",$list);
				$this->tpl->display("system.teams.info.php");
			}
		}elseif($to=="del"){


		}elseif($to=="users"){


			$list = $teams->getrows("type=$type&parentid=0");
			//print_r($list);
			$arr = array();
			foreach($list AS $rs){
				$trees = $teams->getrows("type=$type&parentid=".$rs["id"]);
				if($trees){
					$au = array();
					foreach($trees AS $ru){
						$ru["users"] = $teams->users("type=$type&checked=1&teamid=".$ru["id"]);
						$au[] = $ru;
					}
					$rs["tree"] = $au;
				}
				$arr[] = $rs;
			}
			$lists = $arr;
			//print_r($lists);
			$this->tpl->set("lists",$lists);
			$this->tpl->set("tempd","users");
			$this->tpl->display("system.teams.list.php");

		}else{

			$show = $_GET["show"];
			if($show=="lists"){
				$id = (int)$_GET["id"];
				if(isset($_POST)&&!empty($_POST))
				{
					$urlto = S_ROOT."system/teams?do=".$do."&show=lists&id=".$id;
					$teams->editlist();
					msgbox($urlto,"批量修改完成");
				}else{
					$key = $_GET["key"];
					switch($_GET["type"]){
						case "numbers": $numbers = trim($key); break;
						case "name"	  : $name = trim($key); break;
						default : $name = "";
					}
					//echo $numbers;
					//echo "page=15&type=$type&name=$name&numbers=$numbers&parentid=$id";
					$list = $teams->getrows("page=100&type=$type&name=$name&numbers=$numbers&parentid=$id");
					$this->tpl->set("list",$list["record"]);
					$this->tpl->set("page",$list["pages"]);
					$this->tpl->display("system.teams.list.php");
				}
			}else{
				$list = $teams->getrows("type=$type&parentid=0");
				$this->tpl->set("list",$list);
				$this->tpl->display("system.teams.index.php");
			}
		}
	}

	function trimall($str)//删除空格
	{
	    $qian=array(" ","　","\t","\n","\r");
	    $hou=array("","","","","");
	    return str_replace($qian,$hou,$str);
	}
		//开票公司
	function invoice()
	{
				$this->users->onlogin();	//登录判断
				$show = $_GET["show"];
				$system = getModel("system");
				if($show=="add"){
						if(isset($_POST)&&!empty($_POST))
						{
							 	$msg = $system->company_add();
								if($msg=="1"){
										msgbox(S_ROOT."system/invoice?show=lists","操作成功！");
								}else{
										msgbox("",$msg);
								}
						}else{
								$this->tpl->display("system.invoice.info.php");
						}
				}elseif($show=="edit"){
						$id = (int)$_GET["id"];
						$info = $system->company_row("id=$id");
						if(isset($_POST)&&!empty($_POST))
						{
								$system->id = $id;
								$msg = $system->company_edit();
								if($msg=="1"){
										msgbox(S_ROOT."system/invoice?show=lists","操作成功！");
								}else{
										msgbox("",$msg);
								}
						}else{
								$this->tpl->set("info",$info);
								$this->tpl->display("system.invoice.info.php");
						}
				}elseif($show=="del"){
						$id = (int)$_GET["id"];
						$system->company_row("id=$id");
						$system->id = $id;
						$system->company_del();
						msgbox(S_ROOT."system/invoice?show=lists","操作成功！");
				}else{
						if($_GET["show"]=="lists"){
								$rows = $system->company_rows();
								$this->tpl->set("list",$rows);
								$this->tpl->set("type","lists");
						}else{
								$this->tpl->set("type","iframe");
						}
						$this->tpl->display("system.invoice.index.php");
				}



	}


		//仓库管理
		Public function storehouse()
		{
					$this->users->onlogin();	//登录判断
					$show = $_GET["show"];
					$system = getModel("system");
					if($show=="add"){//添加仓库
							if(isset($_POST)&&!empty($_POST))
							{
									$msg = $system->storehouse_add();
									if($msg=="1"){
											msgbox(S_ROOT."system/storehouse?show=lists","操作成功！");
									}else{
											msgbox("",$msg);
									}
							}else{
									$this->tpl->display("system.storehouse.info.php");
							}
					}elseif($show=="edit"){
							$id = (int)$_GET["id"];
							$info = $system->storehouse_row("id=$id");
							if(isset($_POST)&&!empty($_POST))
							{
									$system->id = $id;
									$msg = $system->storehouse_edit();
									if($msg=="1"){
											msgbox(S_ROOT."system/storehouse?show=lists","操作成功！");
									}else{
											msgbox("",$msg);
									}
							}else{
									$this->tpl->set("info",$info);
									$this->tpl->display("system.storehouse.info.php");
							}
					}else{
							if($_GET["show"]=="lists"){
									$rows = $system->storehouse_rows();
									$this->tpl->set("list",$rows);
									$this->tpl->set("type","lists");
							}else{
									$this->tpl->set("type","iframe");
							}
							$this->tpl->display("system.storehouse.index.php");
					}



		}







}
?>
