<?php
class uploadModules extends Modules
{

	//+--------------------------------------------------------------------------------------------
	  //Desc:记入图片信息
	Public function picture()
	{
		$pic = $this->pic;
		$hash= $this->cookie->get("pichash");	//取得当前
		if(is_file(".".$pic)){
			$size = @round(filesize(".".$pic)/1024,0);
			//获得文件扩展名
			$temp_arr = explode(".", $pic);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			$arr = array(
				'pic'		=>$pic,
				'pichash'	=>md5($pic),
				'size'		=>$size,
				'type'		=>$file_ext,
				'dateline'	=>time(),
				'hash'		=>$hash
			);
			//print_r($arr);exit;
			$this->db->insert(DB_ORDERS.".articlepic",$arr);
		}
		return 1;
	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:删除图片信息
	Public function del()
	{
		$pic = $this->pic;
		if(is_file(".".$pic)){
			@unlink(".".$pic);
		}
		$pichash = md5($pic);
		$where = array('pichash'=>$pichash);
		$this->db->delete(DB_ORDERS.".articlepic",$where);
	}

}
?>
