<?php
class cpinfoModules extends Modules
{

	public function brand_row($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$id = (int)$id;
			$sql  = "SELECT *
			FROM ".DB_PRODUCT.".brand
			WHERE openid = ".OPEN_ID." AND brandid = $id ";
			$data = $this->db->getRow($sql,20);
			if($data["openid"]!=OPEN_ID){ appError(); }
			return $data;
	}

	public function brand_rows($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$show = (int)$show;
			$nums = ($nums)?$nums:"50";
			$sql  = "SELECT brandid,name,tags,checked,orderid
			FROM ".DB_PRODUCT.".brand
			WHERE openid = ".OPEN_ID." AND hide = 0
			ORDER BY checked DESC,orderid ASC  ";
			$data = $this->db->getPageRows($sql,$nums);
			return $data;
	}

	public function brand_add()
	{
			extract($_POST);
			$check = $this->brand_checked("name=$name");
			if($check){ return $name."<br>名称已经存在"; }
			$check = $this->brand_checked("tags=$tags");
			if($check){ return $tags."<br>英文标签已经存在"; }
			$arr = array(
					"openid"			=>  OPEN_ID,
					"name"				=>	$name,
					"tags"				=>	$tags,
					"description"	=>	$description,
					"checked"			=>	(int)$checked
			);
			$this->db->insert(DB_PRODUCT.".brand",$arr);
			return 1;
	}

	public function brand_edit()
	{
			extract($_POST);
			$id = $this->id;
			$where = array("brandid"=>$id);
			$check = $this->brand_checked("id=$id&name=$name");
			if($check){ return $name."<br>名称已经存在"; }
			$check = $this->brand_checked("id=$id&tags=$tags");
			if($check){ return $tags."<br>英文标签已经存在"; }
			$arr = array(
					"name"				=>	$name,
					"tags"				=>	$tags,
					"description"	=>	$description,
					"checked"			=>	(int)$checked
			);//print_r($arr);exit;
			$this->db->update(DB_PRODUCT.".brand",$arr,$where);
			return 1;
	}

	public function brand_status($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$id  = (int)$id;
			$row = $this->brand_row("id=$id");
			if($row["checked"]=="1"){ $checked = 0; }else{ $checked = 1; }
			$arr = array("checked"=>$checked);
			$where = array("brandid"=>$id);
			$this->db->update(DB_PRODUCT.".brand",$arr,$where);
			return 1;
	}

	public function brand_checked($str=""){
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			if($name){ $where.=" AND name = '$name' "; }
			if($tags){ $where.=" AND tags = '$tags' "; }
			if($id){
					$id = (int)$id;
					$where.=" AND brandid <> $id ";
			}
			$query = " SELECT brandid FROM ".DB_PRODUCT.".brand WHERE openid = ".OPEN_ID." $where ";
			$row = $this->db->getRow($query);
			return $row;
	}

	public function brand_del($str=""){
			$id = (int)$this->id;
			$where = array("brandid"=>$id);
			$arr = array("hide"=>1);
			$row = $this->db->update(DB_PRODUCT.".brand",$arr,$where);
			return $row;
	}

	public function cates_row($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$id = (int)$id;
			$sql  = "SELECT *
			FROM ".DB_PRODUCT.".category
			WHERE openid = ".OPEN_ID." AND categoryid = $id ";
			$data = $this->db->getRow($sql,20);
			if($data["openid"]!=OPEN_ID){ appError(); }
			return $data;
	}

	public function cates_rows($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$show = (int)$show;
			$nums = ($nums)?$nums:"50";
			$sql  = "SELECT categoryid,name,tags,checked,orderid
			FROM ".DB_PRODUCT.".category
			WHERE openid = ".OPEN_ID." AND hide = 0
			ORDER BY checked DESC,orderid ASC   ";
			$data = $this->db->getPageRows($sql,$nums);
			return $data;
	}

	public function cates_add()
	{
			extract($_POST);
			$check = $this->cates_checked("name=$name");
			if($check){ return $name."<br>名称已经存在"; }
			$check = $this->cates_checked("tags=$tags");
			if($check){ return $tags."<br>英文标签已经存在"; }
			$arr = array(
					"openid"			=>  OPEN_ID,
					"name"				=>	$name,
					"tags"				=>	$tags,
					"description"	=>	$description,
					"checked"			=>	(int)$checked
			);
			$this->db->insert(DB_PRODUCT.".category",$arr);
			return 1;
	}

	public function cates_edit()
	{
			extract($_POST);
			$id = $this->id;
			$check = $this->cates_checked("id=$id&name=$name");
			if($check){ return $name."<br>名称已经存在"; }
			$check = $this->cates_checked("id=$id&tags=$tags");
			if($check){ return $tags."<br>英文标签已经存在"; }
			$arr = array(
					"name"				=>	$name,
					"tags"				=>	$tags,
					"description"	=>	$description,
					"checked"			=>	(int)$checked
			);
			$where = array("categoryid"=>$id);
			$this->db->update(DB_PRODUCT.".category",$arr,$where);
			return 1;
	}

	public function cates_status($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$id  = (int)$id;
			$row = $this->cates_row("id=$id");
			if($row["checked"]=="1"){ $checked = 0; }else{ $checked = 1; }
			$arr = array("checked"=>$checked);
			$where = array("categoryid"=>$id);
			$this->db->update(DB_PRODUCT.".category",$arr,$where);
			return 1;
	}

	//判断产品类目
	public function cates_checked($str=""){
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			if($name){ $where.=" AND name = '$name' "; }
			if($tags){ $where.=" AND tags = '$tags' "; }
			if($id){
					$id = (int)$id;
					$where.=" AND categoryid <> $id ";
			}
			$query = " SELECT categoryid FROM ".DB_PRODUCT.".category WHERE openid = ".OPEN_ID." $where ";
			$row = $this->db->getRow($query);
			return $row;
	}

	//删除产品类目
	public function cates_del($str=""){
			$id = (int)$this->id;
			$where = array("categoryid"=>$id);
			$arr = array("hide"=>1);
			$row = $this->db->update(DB_PRODUCT.".category",$arr,$where);
			return $row;
	}


	public function product_row($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$id = (int)$id;
			$sql  = "SELECT p.*,pi.units AS units,pi.locality AS locality
			FROM ".DB_PRODUCT.".product AS p
			INNER JOIN ".DB_PRODUCT.".productinfo AS pi ON pi.productid = p.productid
			WHERE p.productid = $id AND p.openid = ".OPEN_ID." ";
			$data = $this->db->getRow($sql);
			if($data["openid"]!=OPEN_ID){ appError(); }
			return $data;
	}

	public function product_rows($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			if($keyval){
					if($sotype=="title"){
							$where.=" p.title like '%".$keyval."%' AND ";
					}elseif($sotype=="encoded"){
							$where.=" p.encoded = '$keyval' AND ";
					}
			}
			if($brandid){
					$brandid = (int)$brandid;
					$where.=" p.brandid = $brandid AND ";
			}
			if($categoryid){
					$categoryid = (int)$categoryid;
					$where.=" p.categoryid = $categoryid AND ";
			}
			if($checked!=""){
	        $where.= " p.checked = ".(int)$checked." AND ";
			}

			$show = (int)$show;
			$nums = ($nums)?$nums:"20";
			$sql  = "SELECT p.productid,p.title,p.erpname,p.encoded,p.checked,c.name AS catename,b.name AS brandname
			FROM ".DB_PRODUCT.".product AS p
			INNER JOIN ".DB_PRODUCT.".category AS c ON c.categoryid = p.categoryid
			INNER JOIN ".DB_PRODUCT.".brand AS b ON b.brandid = p.brandid
			WHERE $where p.openid = ".OPEN_ID." AND p.hide = 0
			ORDER BY p.checked DESC,p.productid DESC   ";
			$data = $this->db->getPageRows($sql,$nums);
			return $data;
	}

	public function product_add()
	{
			extract($_POST);
			$check = $this->product_checked("title=$title");
			if($check){ return $title."<br>名称已存在"; }
			$check = $this->product_checked("encoded=$encoded");
			if($check){ return $encoded."<br>编码已存在"; }
			$arr = array(
					"openid"			=>  OPEN_ID,
					"title"				=>	$title,
					"erpname"			=>	$erpname,
					"numbers"			=>	$numbers,
					"encoded"			=>	$encoded,
					"models"			=>	$models,
					"categoryid"	=>	(int)$categoryid,
					"brandid"			=>	(int)$brandid,
					"detail"			=>	$detail,
					"price_users_a"=>	@round($price_users_a,2),
					"price_users_c"=>	@round($price_users_c,2),
					"dateline"		=>	time(),
					"updateline"	=>	time(),
					"userid"			=>	$userid,
					"upuserid"		=>	$userid,
					"checked"			=>	(int)$checked
			);
			$this->db->insert(DB_PRODUCT.".product",$arr);
			$productid = $this->db->getLastInsId();
			$arr = array(
					"productid"		=>	$productid,
					"locality"		=>	$locality,
					"units"				=>	$units
			);
			$this->db->insert(DB_PRODUCT.".productinfo",$arr);
			return 1;
	}

	public function product_edit()
	{
			extract($_POST);
			$id = (int)$this->id;
			$userid = (int)$this->cookie->get("userid");
			$check = $this->product_checked("id=$id&title=$title");
			if($check){ return $title."<br>名称已存在"; }
			$check = $this->product_checked("id=$id&encoded=$encoded");
			if($check){ return $encoded."<br>编码已存在"; }
			$where = array("productid"=>$id);
			$arr = array(
					"title"				=>	$title,
					"erpname"			=>	$erpname,
					"numbers"			=>	$numbers,
					"encoded"			=>	$encoded,
					"models"			=>	$models,
					"categoryid"	=>	(int)$categoryid,
					"brandid"			=>	(int)$brandid,
					"detail"			=>	$detail,
					"price_users_a"=>	@round($price_users_a,2),
					"price_users_c"=>	@round($price_users_c,2),
					"updateline"	=>	time(),
					"upuserid"		=>	$userid,
					"checked"			=>	(int)$checked
			);
			$this->db->update(DB_PRODUCT.".product",$arr,$where);
			$productid = $this->db->getLastInsId();
			$arr = array(
					"locality"		=>	$locality,
					"units"				=>	$units
			);
			$this->db->update(DB_PRODUCT.".productinfo",$arr,$where);
			return 1;
	}

	public function product_status($str="")
	{
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$id  = (int)$id;
			$row = $this->product_row("id=$id");
			if($row["checked"]=="1"){ $checked = 0; }else{ $checked = 1; }
			$arr = array("checked"=>$checked);
			$where = array("productid"=>$id);
			$this->db->update(DB_PRODUCT.".product",$arr,$where);
			return 1;
	}

	public function product_del()
	{
			$id = (int)$this->id;
			$where = array("productid"=>$id);
			$arr = array("hide"=>1);
			$this->db->update(DB_PRODUCT.".product",$arr,$where);
			return 1;
	}

	//判断产品类目
	public function product_checked($str=""){
			$str = plugin::extstr($str);//处理字符串
			extract($str);
			if($title)	{	$where.=" AND title = '$title' "; }
			if($encoded){	$where.=" AND encoded = '$encoded' "; }
			if($id){
					$id = (int)$id;
					$where.=" AND productid <> $id ";
			}
			$query = " SELECT productid FROM ".DB_PRODUCT.".product WHERE openid = ".OPEN_ID." $where ";
			$row = $this->db->getRow($query);
			return $row;
	}


	//产品类目
	Public function category($str="")
	{

			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$where = "";
			if($checked!=""){
	        $where.= " checked = ".(int)$checked." AND ";
			}
			$where.=" openid = '".OPEN_ID."' AND ";
			$query = "SELECT categoryid,name
			FROM ".DB_PRODUCT.".category
			WHERE $where hide = 0
			ORDER BY orderid ASC";
			return $this->db->getRows($query);
	}

	//产品品牌
	Public function brand($str="")
	{

			$str = plugin::extstr($str);//处理字符串
			extract($str);
			$where = "";
			if($checked!=""){
	        $where .= " checked = ".(int)$checked." AND ";
			}
			$where.=" openid = '".OPEN_ID."' AND ";
			$query = "SELECT brandid,name
			FROM ".DB_PRODUCT.".brand
			WHERE $where hide = 0
			ORDER BY orderid ASC";
			$rows = $this->db->getRows($query);
			return $rows;
	}

}
?>
