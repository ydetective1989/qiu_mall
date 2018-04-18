<?php
class wesAction extends Action
{

	public function aux()
	{
			if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')==false){
					//dialog("请使用微信扫码访问");exit;
			}
			$do = $_GET["do"];
			if($do=="feed"){
					if(isset($_POST) && !empty($_POST)){
							$this->auxData("1");
					}else{
							$this->tpl->set("feedtype","服务预约");
							$this->tpl->set("feedpic","产品图片");
							$this->tpl->display("weserver/wes.aux.feed.php");
					}
			}elseif($do=="bug"){

					if(isset($_POST) && !empty($_POST)){
							$this->auxData("2");
					}else{
							$this->tpl->set("feedtype","故障报修");
							$this->tpl->set("feedpic","故障图片");
							$this->tpl->display("weserver/wes.aux.feed.php");
					}
			}else{
					$show = $_GET["show"];
					if($show=="welcome"){
							$this->tpl->display("weserver/auxwater/welcome.php");
					}else{
							if(isset($_POST) && !empty($_POST)){
									$this->auxData("3");
							}else{
								$this->tpl->set("feedtype","商品注册");
								$this->tpl->set("feedpic","安装图片");
								$this->tpl->display("weserver/wes.aux.feed.php");
							}
					}
			}
	}

	public function auxData($type="0")
	{
			//$type = 1 预约  2 报修  3 商品注册
			$wes  = getModel("wes");
			$wes->type = $type;
			$msg  = $wes->feed_add();
			switch($type){
					case "1": $urlto = S_ROOT."wes/aux?do=feed"; break;
					case "2": $urlto = S_ROOT."wes/aux?do=bug";  break;
					default : $urlto = S_ROOT."wes/aux?do=reg";
			}
			if($msg=="1"){
					$this->tpl->display("weserver/auxwater/ok.php");
			}else{
					msgbox("",$msg);
			}
	}






}
?>
