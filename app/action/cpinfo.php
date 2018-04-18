<?php
class cpinfoAction extends Action
{

	Public function app()
	{
		$this->users->onlogin();	//登录判断
	}

	public function brand()
	{
		if(IS_PRODUCTED!="1"){ msgbox("","没有启用Product模块"); }
			$this->users->onlogin();	//登录判断
			$this->users->pagelevel();//判断权限
			$do = $_GET["do"];
			$cpinfo = getModel("cpinfo");
			//取得品牌页URL
			$backurl = $this->cookie->get("show");
			$this->tpl->set("urlto",$backurl);
			if($do=="add"){
					if(isset($_POST)&&!empty($_POST))
					{
							$msg = $cpinfo->brand_add();
							if($msg=="1"){
									msgbox($backurl,"操作成功！");
							}else{
									msgbox($backurl,$msg);
							}
					}else{
							$this->tpl->set("info",$info);
							$this->tpl->display("cpinfo.brand.info.php");
					}
			}elseif($do=="edit"){
					$id = (int)$_GET["id"];
					$info = $cpinfo->brand_row("id=$id");
					if(isset($_POST)&&!empty($_POST))
					{
							$cpinfo->id = $id;
							$msg = $cpinfo->brand_edit();
							if($msg=="1"){
									msgbox($backurl,"操作成功！");
							}else{
									msgbox($backurl,$msg);
							}
					}else{
							$this->tpl->set("info",$info);
							$this->tpl->display("cpinfo.brand.info.php");
					}
			}elseif($do=="checked"){
					$id = (int)$_GET["id"];
					$cpinfo->brand_status("id=$id");
					msgbox($backurl,"操作成功！");
			}elseif($do=="del"){
					$id = (int)$_GET["id"];
					$info = $cpinfo->brand_row("id=$id");
					$cpinfo->id = $id;
					$cpinfo->brand_del();
					msgbox($backurl,"操作成功！");
			}else{
					if($_GET["show"]=="lists"){
							$rows = $cpinfo->brand_rows();
							$this->tpl->set("list",$rows["record"]);
							$this->tpl->set("page",$rows["pages"]);
							$this->tpl->set("type","lists");
					}else{
							$this->tpl->set("type","iframe");
					}
					$this->tpl->display("cpinfo.brand.php");
			}
	}


	public function cates()
	{
		if(IS_PRODUCTED!="1"){ msgbox("","没有启用Product模块"); }
			$this->users->onlogin();	//登录判断
			$this->users->pagelevel();//判断权限
			$do = $_GET["do"];
			$cpinfo = getModel("cpinfo");
			//取得品牌页URL
			$backurl = $this->cookie->get("show");
			$this->tpl->set("urlto",$backurl);
			if($do=="add"){
					if(isset($_POST)&&!empty($_POST))
					{
							$msg = $cpinfo->cates_add();
							if($msg=="1"){
									msgbox($backurl,"操作成功！");
							}else{
									msgbox($backurl,$msg);
							}
					}else{
							$this->tpl->set("info",$info);
							$this->tpl->display("cpinfo.cates.info.php");
					}
			}elseif($do=="edit"){
					$id = (int)$_GET["id"];
					$info = $cpinfo->cates_row("id=$id");
					if(isset($_POST)&&!empty($_POST))
					{
							$cpinfo->id = $id;
							$msg = $cpinfo->cates_edit();
							if($msg=="1"){
									msgbox($backurl,"操作成功！");
							}else{
									msgbox($backurl,$msg);
							}
					}else{
							$this->tpl->set("info",$info);
							$this->tpl->display("cpinfo.cates.info.php");
					}
			}elseif($do=="del"){
					$id = (int)$_GET["id"];
					$info = $cpinfo->cates_row("id=$id");
					$cpinfo->id = $id;
					$cpinfo->cates_del();
					msgbox($backurl,"操作成功！");
			}elseif($do=="checked"){
					$id = (int)$_GET["id"];
					$cpinfo->cates_status("id=$id");
					msgbox($backurl,"操作成功！");
			}else{
					if($_GET["show"]=="lists"){
							$rows = $cpinfo->cates_rows();
							$this->tpl->set("list",$rows["record"]);
							$this->tpl->set("page",$rows["pages"]);
							$this->tpl->set("type","lists");
					}else{
							$this->tpl->set("type","iframe");
					}
					$this->tpl->display("cpinfo.cates.php");
			}
	 }


 	public function product()
 	{
		if(IS_PRODUCTED!="1"){ msgbox("","没有启用Product模块"); }
 			$this->users->onlogin();	//登录判断
 			$this->users->pagelevel();//判断权限
 			$do = $_GET["do"];
 			$cpinfo = getModel("cpinfo");
 			//取得品牌页URL
 			$backurl = $this->cookie->get("show");
 			$this->tpl->set("urlto",$backurl);
 			if($do=="add"){
 					if(isset($_POST)&&!empty($_POST))
 					{
 							$msg = $cpinfo->product_add();
 							if($msg=="1"){
 									msgbox($backurl,"操作成功！");
 							}else{
 									msgbox($backurl,$msg);
 							}
 					}else{
							$cates = $cpinfo->category();
 							$this->tpl->set("cates",$cates);
							$brand = $cpinfo->brand();
 							$this->tpl->set("brands",$brand);
 							$this->tpl->set("info",$info);
 							$this->tpl->display("cpinfo.product.info.php");
 					}
 			}elseif($do=="edit"){
 					$id = (int)$_GET["id"];
 					$info = $cpinfo->product_row("id=$id");
 					if(isset($_POST)&&!empty($_POST))
 					{
 							$cpinfo->id = $id;
 							$msg = $cpinfo->product_edit();
 							if($msg=="1"){
 									msgbox($backurl,"操作成功！");
 							}else{
 									msgbox($backurl,$msg);
 							}
 					}else{
							$cates = $cpinfo->category();
 							$this->tpl->set("cates",$cates);
							$brand = $cpinfo->brand();
 							$this->tpl->set("brands",$brand);
 							$this->tpl->set("info",$info);
 							$this->tpl->display("cpinfo.product.info.php");
 					}
 			}elseif($do=="del"){
 					$id = (int)$_GET["id"];
 					$info = $cpinfo->product_row("id=$id");
 					$cpinfo->id = $id;
 					$cpinfo->product_del();
 					msgbox($backurl,"操作成功！");
			}elseif($do=="checked"){
					$id = (int)$_GET["id"];
					$cpinfo->product_status("id=$id");
					msgbox($backurl,"操作成功！");
 			}else{
 					if($_GET["show"]=="lists"){
							extract($_GET);
 							$rows = $cpinfo->product_rows("checked=$checked&sotype=$sotype&keyval=$keyval&categoryid=$categoryid&brandid=$brandid");
 							$this->tpl->set("list",$rows["record"]);
 							$this->tpl->set("page",$rows["pages"]);
 							$this->tpl->set("type","lists");
 					}else{
							$cates = $cpinfo->category();
 							$this->tpl->set("cates",$cates);
							$brand = $cpinfo->brand();
 							$this->tpl->set("brands",$brand);
 							$this->tpl->set("type","iframe");
 					}
 					$this->tpl->display("cpinfo.product.php");
 			}
 	 }

}
?>
