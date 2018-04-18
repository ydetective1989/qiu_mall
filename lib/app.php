<?php
/**
+------------------------------------------------------------------------------
* Spring Framework 架构配置
+------------------------------------------------------------------------------
* @date		2011-01-17
* @QQ		28683
* @Author	Jeffy (darqiu@gmail.com)
* @version	2.0
+------------------------------------------------------------------------------
*/

//载入工厂资源
require_once(MVC."action.php");
require_once(MVC."modules.php");
require_once(LIB."plugin.php");
require_once(LIB."config.php");

//工厂设置实始化
$allfunc = array();

//数据库库名
define('DB_ORDERS'	,"openyws");						//DB_SALES
define('DB_LOGS'		,"openyws_logs");				//DB_LOGS
define('DB_PRODUCT'	,"openyws_product"	);		//启用独立的产品数据库
define('DB_CONFIG'	,"configure");					//DB_CONFIG
define('DB_FUWU'		,'fuwu');

//COOKIE前缀
if(!defined("COOKIE_PRE")){ define('COOKIE_PRE','openyws'); }


//DATABASE
$db = getFunc("dbpdo");//getFunc('dbpdo')=dbpdo.php
$db->dbType='mysql';
$db->connectNum='yws';
$db->configFile = CONFIG."ydb.php";	//亿家网站 数据库配置
$allfunc["db"]=$db;


//else{
// 		$odb = getFunc("dbpdo");
// 		$odb->dbType='mysql';
// 		$odb->connectNum='logs';
// 		$odb->configFile = CONFIG."odb.php";	//亿家网站 数据库配置
// 		$allfunc["odb"]=$odb;
// }

//COOKIE
$cookie = getFunc("cookie");//cookie.php 实例化new cookie
$cookie->cookiePre = COOKIE_PRE;//COOKIE_PRE=openyws  公共变量已经赋值为$cookiepre=openyws
// $cookie->secure = getFunc("secure");
$allfunc["cookie"]=$cookie; //给数组$allfunc加入值 cookie.php

Function xdb()
{
	$xdb = getFunc("dbpdo");
	$xdb->dbType='mysql';
	$xdb->connectNum='xdb';
	$xdb->configFile = CONFIG."xdb.php";	//数据库配置
	return $xdb;
}

//VIEWS
$tpl = getFunc("view");
$tpl->tplDir	= VIEW;
$tpl->msg		= $msg;
$allfunc["tpl"]	= $tpl;

Function appError()
{
	echo "页面不存在";
	exit;
}

Function msgbox($urlto="",$msgbox="",$timeout=3000)
{
	GLOBAL $tpl;
	$tpl->set("timeout",$timeout);
	$tpl->set("urlto",$urlto);
	$tpl->set("msgbox",$msgbox);
	$tpl->display("msgbox.php");
	exit;
}

Function jsmsg($script="",$msgbox="",$timeout=3000)
{
	GLOBAL $tpl;
	$tpl->set("timeout",$timeout);
	$tpl->set("script",$script);
	$tpl->set("msgbox",$msgbox);
	$tpl->display("msgbox.script.php");
	exit;
}

Function dialog($msgbox="")
{
	GLOBAL $tpl;
	if(wapfun::checked()){
			$tpl->set("wapfun","1");
	}
	$tpl->set("msgbox",$msgbox);
	$tpl->display("msgbox.dialog.php");
	exit;
}

Function toplink($urlto="",$msgbox="")
{
	GLOBAL $msg;
	msgbox($urlto,"",5);
	exit;
}

Function apimsg($arr="",$http="404")
{
	$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
	header($protocol." ".$http);
	echo json_encode($arr);
	exit;
}

?>
