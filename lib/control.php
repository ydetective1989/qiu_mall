<?php
/**
+------------------------------------------------------------------------------
* Spring Framework 工厂模式
+------------------------------------------------------------------------------
* @date		2011-01-17
* @QQ		28683
* @Author	Jeffy (darqiu@gmail.com)
* @version	2.0
+------------------------------------------------------------------------------
*/

//加载工厂配置
require_once(LIB."app.php");

//组件加载工厂
Function getFunc($object)
{
	GLOBAL $msg;
	$objectfile = LIB.$object.".php";
	if(file_exists($objectfile)){
		require_once($objectfile);
		if(!class_exists($object)){
			if(DEBUG){
				dialog("组件 $object 对象未找到!");
			}else{
				appError();
			}
		}
		return new $object();
	}else{
		if(DEBUG){
			dialog("ERROR：组件 $object 不存在！");
		}else{
			appError();
		}
	}
}

//加载视图
Function getAction($action)
{
	GLOBAL $allfunc,$msg;
	if(!isset($action)){ $action="index"; }
	//加载视图
	$mod = ACTION.$action.".php";
	if(!file_exists($mod)){
		//$mod = ACTION."index.php";
		if(DEBUG){
			dialog("错误，页面不存在！");
		}else{
			appError();
		}
	}
	require_once($mod);
	$classname = $action.'Action';
	if(!class_exists($classname)){
		//$classname = 'indexAction';
		if(DEBUG){
			dialog("控制器 $action 对象未找到!");
		}else{
			appError();
		}
	}
	$mp = new $classname();
	foreach($allfunc AS $id=>$fun){
		$mp->$id = $fun;
	}
	return $mp;
}

//加载模块
Function getModel($model)
{
	GLOBAL $allfunc,$msg;
	//加载model,写入属性
	$mod = MODEL.$model.".php";
	if(!file_exists($mod)){
		if(DEBUG){
			dialog("模块[$model]不存在");
			//dialog("你所访问的页面不存在！<!-- <br>ERROR：模块[$model]不存在 -->");else{
			//msgBox
		}else{
			appError();
		}
	}
	require_once($mod);
	$classname = $model.'Modules';
	if(!class_exists($classname)){
		if(DEBUG){
			dialog("模块 $classname 对象未找到!");
		}else{
			appError();
		}
	}
	$mp = new $classname();
	foreach($allfunc AS $id=>$fun){
		$mp->$id = $fun;
	}
	return $mp;
}

?>
