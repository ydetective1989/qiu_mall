<?php

if(isset($_FILES['file'])&&!empty($_FILES['file'])){
  extract($_POST);
  $end = explode(".",$_FILES['file']['name']);
  $_FILES['file']['name'] = $filename.".".$end[1];
      if (file_exists("upload/" . $_FILES["file"]["name"]))
    {
    echo $_FILES["file"]["name"] . " 已存在. ";
    }
  else
    {
      if(move_uploaded_file($_FILES["file"]["tmp_name"],
      iconv("UTF-8", "gb2312", "upload/".$_FILES["file"]["name"])))
      {
        echo "upload/".$_FILES['file']['name'];

      }else{
        echo "上传失败";
      }

    }

}

 ?>
