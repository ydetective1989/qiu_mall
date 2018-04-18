<?php
class wesModules extends Modules
{
      //feed_add   extract($POST)
      public function feed_add()
      {
          extract($_POST);
    			$do = $_GET["do"];
          if($itemcontract!=""&&$do=="reg"){
              $check = $this->feed_checked("itemcontract=$itemcontract");
              if($check){ return $itemcontract."<br>编号已经存在"; }
          }
          $files = $this->upload("files_upload");
          if($files){
              //将图片上传到Alioss
              include_once(LIB.'alioss/upload.php');
              $alioss = new Alioss();
              $filedir  = UPFILE."wes/";
              $ossfile = "wes/".date("Y")."/".date("m")."-".date("d")."/".$files;//print_r($object);//要上传图片位置
              $filePath  = ".".$filedir.$files;
              $alioss->uploadFile($filePath,$ossfile);//print_r($files);exit;
              //$filePath = ".".$files;//print_r($filePath);exit;//本地上传图片位置
              @unlink($filePath);
              $files = $ossfile;//print_r($files);exit;//oss上传图片位置
          }
          //echo "OSS:".$files;exit;
          $type = (int)$this->type;
          $arr = array(
              "openid"			=>  OPEN_ID,
              "type"        =>  (int)$type,
              "itemcontract"=>	$itemcontract,
              "itemname"    =>  $itemname,
              "name"        =>  $name,
              "provid"      =>  (int)$provid,
              "cityid"      =>  (int)$cityid,
              "areaid"      =>  (int)$areaid,
              "address"     =>  $address,
              "phone"       =>  $phone,
              "itembuy"     =>  $itembuy,
              "upfiles"     =>  $files,
              "setupdate"   =>  $setupdate,
              "detail"      =>  $detail,
              "dateline"    =>  time(),
              'ip'        	=>	plugin::getIP()
          );
          $this->db->insert(DB_ORDERS.".job_feedback",$arr);
          return 1;
      }

      public function feed_checked($str=""){
    			$str = plugin::extstr($str);//处理字符串
    			extract($str);
    			if($itemcontract){ $where.=" AND itemcontract = '$itemcontract' "; }
    			if($id){
    					$id = (int)$id;
    					$where.=" AND id <> $id ";
    			}
    			$query = " SELECT id FROM ".DB_ORDERS.".job_feedback WHERE openid = ".OPEN_ID." $where ";
    			$row = $this->db->getRow($query);
    			return $row;
    	}

      //+--------------------------------------------------------------------------------------------
      //Desc:上传图片
      Public function upload($upfile)
    	{
    		if(isset($_FILES[$upfile]) && is_uploaded_file($_FILES[$upfile]["tmp_name"]) && $_FILES[$upfile]["error"] == '0')
    		{
    			$uploader = getFunc("upload");
          $filedir  = UPFILE."wes/";
    			$uploader->path = ".".$filedir;	//上传路径
    			$uploader->maxSize = "8192000";						//文件大小
    			$uploader->upType = "jpg|gif|png";					//文件类型
    			$fileName = $uploader->upload($_FILES[$upfile],true);
    			if(!$fileName){//返回错误信息
    				    msgbox(S_ROOT,$uploader->msg);
    			}
    			$files = $uploader->upFile;
    			$allfiles = ".".$filedir.$files;
    			$rarimg = getFunc("rarimg");
    			$rarimg->makethumb($allfiles,$allfiles);
    			return $files;
    		}
    		return false;
    	}


}
?>
