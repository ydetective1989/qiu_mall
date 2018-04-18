<?php
// if(isset($_POST['bgimg'])&&!empty($_POST['bgimg'])){
//   if($_FILES['bgimg']['error'] > 0){
//     echo "上传失败";
//   }else{
//     $bgimg = $_POST['bgimg'];
//     echo "Upload: " . $_FILES["bgimg"]["name"] . "<br />";
//     echo "Type: " . $_FILES["bgimg"]["type"] . "<br />";
//     echo "Size: " . ($_FILES["bgimg"]["size"] / 1024) . " Kb<br />";
//     echo "Stored in: " . $_FILES["bgimg"]["tmp_name"];
//   // move_uploaded_file($_FILES["file"]["tmp_name"],
//   // "upload/".$_FILES["file"]['name']
//   }
//
// }
// if(isset($_FILES['file'])&&!empty($_FILES['file'])){
//   if ($_FILES['file']["error"] > 0)
//     {
//     echo "Error: " . $_FILES['file']["error"] . "<br />";
//     }
//   else
//     {
//     echo "Upload: " . $_FILES['file']["name"] . "<br />";
//     echo "Type: " . $_FILES['file']["type"] . "<br />";
//     echo "Size: " . ($_FILES['file']["size"] / 1024) . " Kb<br />";
//     echo "Stored in: " . $_FILES['file']["tmp_name"];
//     }
// }
// define("ROOT",dirname(__file__));
// if(isset($_FILES['file'])&&!empty($_FILES['file'])){
//   extract($_POST);
//   if ($_FILES['file']["error"] > 0)
//       {
//       echo "Error: " . $_FILES['file']["error"] . "<br />";
//       }
//     else
//       {
//       echo "Upload: " . $_FILES['file']["name"] . "<br />";
//       echo "Type: " . $_FILES['file']["type"] . "<br />";
//       echo "Size: " . ($_FILES['file']["size"] / 1024) . " Kb<br />";
//       echo "Stored in: " . $_FILES['file']["tmp_name"]."<br />";
//       echo $filename;
//       }
//       if (file_exists(ROOT."upload/" . $_FILES["file"]["name"]))
//     {
//     echo $_FILES["file"]["name"] . " 已存在. ";
//     }
//   else
//     {
//       if(move_uploaded_file($_FILES["file"]["tmp_name"],
//       ROOT."upload/")){
//         echo "上传完成 " . ROOT."upload/" . $_FILES["file"]["name"];
//
//       }else{
//         echo "上传失败";
//       }
//
//     }
//
// }


?>

<!--
 <form action="upload_file.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="Submit" />
</form> -->
 <form class="" action="upload_file.php" method="post" enctype="multipart/form-data" >
   <input type="file" name="file" value="">
   <input type="text" name="filename" value="">
   <input type="submit"  value="上传">

 </form>
