<?php
define("ROOT",dirname(__file__));
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>邱邱的网页</title>
    <link rel="stylesheet" href="./css/index.css">
    <script type="text/javascript" src="./js/index.js">
    </script>
    <script type="text/javascript" src="jquery-3.2.1.min.js">

    </script>

  </head>
  <body>
    <div class="nav-top"  >
      <div class="btn">
        <a href="javascript:" onclick="layer()">更改</a>
      </div>
    </div>
    <div class="nav-bottom">
        <ul class="nav-list">
          <li><a href="">天猫</a></li>
          <li><a href="">聚划算</a></li>
          <li><a href="">天猫超市</a></li>
          <li><a href="">淘抢购</a></li>
          <li><a href="">电器城</a></li>
          <li><a href="">司法拍卖</a></li>
          <li><a href="">中国制造</a></li>
          <li><a href="">兴农扶贫</a></li>
          <li><a href="">肥猪旅行</a></li>
          <li><a href="">智能生活</a></li>
          <li><a href="">苏宁易购</a></li>
        </ul>
    </div>
    <div class="mainbox">

        <button type="button" name="button">111</button>
      <div class="hidebox">
      </div>
      <div class="laybox">
        <form class="" action="" method="post" enctype="multipart/form-data" >
          <input type="file" name="file" value="">
          <input type="text" name="filename" value="">
          <button type="button" onclick="upfile()" >上传</button>
        </form>
      </div>

    </div>

  </body>
</html>
