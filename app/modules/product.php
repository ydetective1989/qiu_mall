<?php
class productModules extends Modules
{

	public function getrow($str="")
	{

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$id = (int)$id;
		$query = " SELECT p.*,b.name AS brandname,c.name AS catename
		FROM ".DB_PRODUCT.".product AS p
		INNER JOIN ".DB_PRODUCT.".brand AS b ON b.brandid = p.brandid
		INNER JOIN ".DB_PRODUCT.".category AS c ON c.categoryid = p.categoryid
		WHERE p.id = $id ";
		$rows = $this->db->getRows($query);
		if($rows["openid"]<>OPEN_ID){ appError(); }
		return $rows;
	}

	public function getrows($str="")
	{

		$str = plugin::extstr($str);//处理字符串
		extract($str);
		//产品分类
		if($categoryid)	{
				$where.=" AND p.categoryid = $categoryid ";
		}
		//产品品牌
		if($brandid)	{
				$where.=" AND p.brandid = $brandid ";
		}else{
				if(OPEN_BRANDID){
					$where.=" AND p.brandid IN(".OPEN_BRANDID.") ";
				}
		}
		//产品编号
		if($encoded)	{
				$where.=" AND p.encoded = '$encoded'  ";
		}
		//产品名称模糊搜索
		if($title)		{
				$where.=" AND p.title like '%".$title."%' ";
		}
		if(IS_PRODUCTED=="1"){
				$where.=" AND p.openid = '".OPEN_ID."' ";
		}
		if($where==""){ return; }
		echo $query = " SELECT p.productid,p.title,p.encoded,p.price_users_c AS price
		FROM ".DB_PRODUCT.".product AS p
		INNER JOIN ".DB_PRODUCT.".brand AS b ON b.brandid = p.brandid
		INNER JOIN ".DB_PRODUCT.".category AS c ON c.categoryid = p.categoryid
		WHERE p.hide = 0 $where
		ORDER BY p.importance DESC,p.productid DESC ";
		if($page=="1"){
				$nums = ($nums)?(int)$nums:"20";
				$show = (int)$show;
				$rows = $this->db->getPageRows($query,$nums,$show);
		}else{
				$rows = $this->db->getRows($query);
		}
		return $rows;
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
			if(IS_PRODUCTED=="1"){
					$where.=" openid = '".OPEN_ID."' AND ";
			}else{
					$where.=" categoryid IN(".OPEN_CATEID.") AND ";
			}
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
			if(IS_PRODUCTED=="1"){
					$where.=" openid = '".OPEN_ID."' AND ";
			}else{
					$where.=" brandid IN(".OPEN_BRANDID.") AND ";
			}
			$query = "SELECT brandid,name
			FROM ".DB_PRODUCT.".brand
			WHERE $where hide = 0
			ORDER BY orderid ASC";
			$rows = $this->db->getRows($query);
			return $rows;
	}



}
?>
