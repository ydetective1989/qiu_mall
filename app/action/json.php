<?php
class jsonAction extends Action
{

	Public function areas()
	{
		$areas = getModel("areas");
		$area1 = '';
		$areasid = $_GET["areasid"];
		$c = $areas->getrows("areasid=$areasid");
		if($c){
			foreach($c AS $r){
				$c1 = $areas->getrows("parentid=".$r["areaid"]);
				$area2 = '';
				if($c1){
					foreach($c1 AS $rs){
						$c2 = $areas->getrows("parentid=".$rs["areaid"]);
						$area3 = '';
						if($c2){
							foreach($c2 AS $rd){
								$area3_t= $this->strWrap($rd["name"],"\"").":".$this->strWrap($rd["areaid"],"\"").",";
								$area3 = $area3.$area3_t;
							}
							$area3_t= $this->strWrap("其它","\"").":".$this->strWrap("10000","\"").",";
							$area3 = $area3.$area3_t;
							$default3 = '"选择区县":"",';
							$area3 = $default3.substr($area3,0,strlen($area3)-1);
						}
						$area2_t=$this->strWrap($rs["name"],"\"").":{val:".$this->strWrap($rs["areaid"],"\"").",items:{".$area3."}},";
						$area2 = $area2.$area2_t;
					}
					$default2 = '"选择城市":{val:"",items:{"选择区县":""}},';
					$area2 = $default2.substr($area2,0,strlen($area2)-1);
				}
				$area1_t = $this->strWrap($r["name"],"\"").":{val:".$this->strWrap($r["areaid"],"\"").",items:{".$area2."}},";
				$area1   = $area1.$area1_t;
			}
			$area1 = substr($area1,0,strlen($area1)-1);
		}
		$def_val="\"选择省份\":{val:\"\",items:{\"选择城市\":{val:\"\",items:{\"选择区县\":\"\"}}}}";
		$ret_code="var areasData = {".$def_val.",".$area1."};";
		echo $ret_code;
	}

	Public function team()
	{
		$type = (int)$_GET["type"];	//用户类型
		if($type=="1"){
			$typename = "销售";
		}elseif($type=="2"){
			$typename = "售后";
		}elseif($type=="3"){
			$typename = "服务";
		}
		$parentid	= (int)$_GET["parentid"];
		$numberd	= (int)$_GET["numberd"];
		$no = (int)$_GET["no"];
		$extname = ($parentid||(!$parentid&&$no))?"中心":"范围";
		$teams = getModel("teams");
		$str = "<option value=''>请选择".$typename.$extname."</option>";
		$rows = $teams->getrows("checked=1&type=".$type."&parentid=".$parentid);
		if($rows&&!$no){
			foreach($rows AS $rs){
				if($numberd==1){ $number = $rs["numbers"]."_"; }else{ $number=""; }
				$str.="<option value=\"".$rs["id"]."\">".$number.$rs["name"]."</option>";
			}
		}
		echo $str;
	}

	Public function teams()
	{
		$type = (int)$_GET["type"];	//用户类型
		if($type=="1"){
			$typename = "销售";
		}elseif($type=="2"){
			$typename = "售后";
		}elseif($type=="3"){
			$typename = "服务";
		}
		$echoval = $_GET["val"];

		$level = (int)$_GET["level"];
		$numberd = (int)$_GET["numberd"];

		$teams = getModel("teams");
		$area1 = '';
		$areasid = $_GET["areasid"];
		$c = $teams->getrows("areasid=$areasid&checked=1&level=$level&type=".$type);
		if($c){
			foreach($c AS $r){
				$c1 = $teams->getrows("checked=1&level=$level&type=".$type."&parentid=".$r["id"]);
				$area2 = '';
				if($c1){
					foreach($c1 AS $rs){
						//$c2 = $teams->users($rs["id"]);
						$area3 = '';
						if($c2){
							foreach($c2 AS $rd){
								$area3_t= $this->strWrap($rd["name"],"\"").":".$this->strWrap($rd["userid"],"\"").",";
								$area3 = $area3.$area3_t;
							}
							$default3 = '"选择'.$typename.'人员":"",';
							$area3 = $default3.substr($area3,0,strlen($area3)-1);
						}
						if($numberd==1){ $number = $rs["numbers"]."_"; }else{ $number=""; }
						$area2_t=$this->strWrap($number.$rs["name"],"\"").":{val:".$this->strWrap($rs["id"],"\"").",items:{".$area3."}},";
						$area2 = $area2.$area2_t;
					}
					$default2 = '"选择'.$typename.'中心":{val:"",items:{"选择'.$typename.'人员":""}},';
					$area2 = $default2.substr($area2,0,strlen($area2)-1);
				}
				$area1_t = $this->strWrap($r["name"],"\"").":{val:".$this->strWrap($r["id"],"\"").",items:{".$area2."}},";
				$area1   = $area1.$area1_t;
			}
			$area1 = substr($area1,0,strlen($area1)-1);
		}
		$def_val="\"选择".$typename."范围\":{val:\"\",items:{\"选择".$typename."中心\":{val:\"\",items:{\"选择".$typename."人员\":\"\"}}}}";
		$ret_code="var ".$echoval." = {".$def_val.",".$area1."};";
		echo $ret_code;
	}


	/***********************************************/
	Public function strWrap($s,$ws){
		return $ws.$s.$ws;
	}

}
?>
