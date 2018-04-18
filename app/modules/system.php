<?php

  class systemModules extends Modules
  {
      //开票公司
      public function company_row($str="")
      {
          $str = plugin::extstr($str);//处理字符串
          extract($str);
          $id = (int)$id;
          $sql  = "SELECT *
          FROM ".DB_ORDERS.".config_invoice
          WHERE openid = ".OPEN_ID." AND id = $id ";
          $data = $this->db->getRow($sql,20);
          if($data["openid"]!=OPEN_ID){ appError(); }
          return $data;
      }

      public function company_rows($str="")
      {
          $str = plugin::extstr($str);//处理字符串
          extract($str);
          $show = (int)$show;
          $nums = ($nums)?$nums:"50";
          $sql  = "SELECT id,name,encoded,orderd
          FROM ".DB_ORDERS.".config_invoice
          WHERE openid = ".OPEN_ID." AND hide = 1
          ORDER BY orderd ASC  ";
          $data = $this->db->getRows($sql,$nums);
          return $data;
      }

      public function company_add()
      {
          extract($_POST);
          $check = $this->company_checked("name=$name");
          if($check){ return $name."<br>名称已经存在"; }
          $check = $this->company_checked("encoded=$encoded");
          if($check){ return $encoded."<br>编码已经存在"; }
          $arr = array(
              "openid"			=>  OPEN_ID,
              "name"				=>	$name,
              "encoded"			=>	$encoded,
              "orderd"	    =>	$orderd
          );
          $this->db->insert(DB_ORDERS.".config_invoice",$arr);
          return 1;
      }

      public function company_edit()
      {
          extract($_POST);
          $id = $this->id;
          $where = array("id"=>$id);
          $check = $this->company_checked("id=$id&name=$name");
          if($check){ return $name."<br>名称已经存在"; }
          $check = $this->company_checked("id=$id&encoded=$encoded");
          if($check){ return $encoded."<br>编码已经存在"; }
          $arr = array(
              "name"				=>	$name,
              "encoded"				=>	$encoded,
              "orderd"	=>	$orderd
          );//print_r($arr);exit;
          $this->db->update(DB_ORDERS.".config_invoice",$arr,$where);
          return 1;
      }

      public function company_checked($str=""){
          $str = plugin::extstr($str);//处理字符串
          extract($str);
          if($name){ $where.=" AND name = '$name' "; }
          if($encoded){ $where.=" AND encoded = '$encoded' "; }
          if($id){
              $id = (int)$id;
              $where.=" AND id <> $id ";
          }
          $query = " SELECT id FROM ".DB_ORDERS.".config_invoice WHERE openid = ".OPEN_ID." $where ";
          $row = $this->db->getRow($query);
          return $row;
      }

      public function company_del($str=""){
          $id = (int)$this->id;
          $where = array("id"=>$id);
          $arr = array("hide"=>1);
          $row = $this->db->update(DB_ORDERS.".config_invoice",$arr,$where);
          return $row;
      }

      //==================仓库管理==========================//
      /*
      */
      public function storehouse_row($str="")
      {
          $str = plugin::extstr($str);//处理字符串
          extract($str);
          $id = (int)$id;
          $sql  = "SELECT *
          FROM ".DB_ORDERS.".config_store
          WHERE openid = ".OPEN_ID." AND id = $id ";
          $data = $this->db->getRow($sql,20);
          if($data["openid"]!=OPEN_ID){ appError(); }
          return $data;
      }

      public function storehouse_rows($str="")
      {
          $str = plugin::extstr($str);//处理字符串
          extract($str);
          $show = (int)$show;
          $nums = ($nums)?$nums:"50";
          $sql  = "SELECT id,openid,name,encoded,hide,orderd
          FROM ".DB_ORDERS.".config_store
          WHERE openid = ".OPEN_ID." AND hide = 1
          ORDER BY orderd ASC  ";
          $data = $this->db->getRows($sql,$nums);
          return $data;
      }

      public function storehouse_add()
      {
          extract($_POST);
          $check = $this->storehouse_checked("name=$name");
          if($check){ return $name."<br>名称已经存在"; }
          $check = $this->storehouse_checked("encoded=$encoded");
          if($check){ return $encoded."<br>编码已经存在"; }
          $arr = array(
              "openid"			=>  OPEN_ID,
              "name"				=>	$name,
              "encoded"			=>	$encoded,
              "orderd"	    =>	$orderd
          );
          $this->db->insert(DB_ORDERS.".config_store",$arr);
          return 1;
      }

      public function storehouse_edit()
      {
          extract($_POST);
          $id = $this->id;
          $where = array("id"=>$id);
          $check = $this->storehouse_checked("id=$id&name=$name");
          if($check){ return $name."<br>名称已经存在"; }
          $check = $this->storehouse_checked("id=$id&encoded=$encoded");
          if($check){ return $encoded."<br>编码已经存在"; }
          $arr = array(
              "name"				=>	$name,
              "encoded"				=>	$encoded,
              "orderd"	=>	$orderd
          );//print_r($arr);exit;
          $this->db->update(DB_ORDERS.".config_store",$arr,$where);
          return 1;
      }

      public function storehouse_checked($str=""){
          $str = plugin::extstr($str);//处理字符串
          extract($str);
          if($name){ $where.=" AND name = '$name' "; }
          if($encoded){ $where.=" AND encoded = '$encoded' "; }
          if($id){
              $id = (int)$id;
              $where.=" AND id <> $id ";
          }
          $query = " SELECT id FROM ".DB_ORDERS.".config_store WHERE openid = ".OPEN_ID." $where ";
          $row = $this->db->getRow($query);
          return $row;
      }

}

 ?>
