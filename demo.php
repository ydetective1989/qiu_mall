<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
    *{
      margin: 0;
      padding: 0;
      color: #fff;
      font-size: 14px;
      text-decoration: none;
    }
    .demo{
      width: 80px;
      border: 1px solid black;
      background: #2E363F;
      transition: all 0.5s;
      /*overflow: hidden;*/

    }
    .demo ul{
      width: 80px;
      /*overflow: hidden;*/
      list-style: none;
      text-align: center;

    }
    .demo li{
      width: 80px;
      height: 20px;
      background: #1F262D;
      overflow: hidden;
      transition: all 0.5s;
    }
    .demo li dl{
      height: 100px;
      width: 80px;
      /*background: gray;*/

    }
    .demo li dl dt{
      width: 80px;
      height: 20px;
      background: gray;
    }
    .demo li dl dt:hover{
      background: pink;
      cursor: pointer;
    }
    .demo li dl dt a:visited{
      background: yellow;
      cursor: pointer;
    }

    .test1{
      width: 100%;
      border: 1px solid black;
    }
    .test{
      width: 50px;
      height: 50px;
      background: red;
      border: 1px solid black;
      float: left;
    }
    .test1::after{
      content: "";
      display: block;
      clear: both;
    }

    </style>
  </head>
  <body>

    <div  class="test1">
      <div class="test">

      </div>
      <div class="test">

      </div>
      <div class="test">

      </div>


    </div>


    <div class="demo">
      <ul>
        <li open="closed">
          <a href="#">快捷列表</a>
          <dl>
            <dt><a href="http://www.baidu.com" target="_blank">百度</a></dt>
            <dt><a href="http://www.jd.com" target="_blank">京东</a></dt>
            <dt><a href="http://www.qq.com" target="_blank">腾讯</a></dt>
            <dt><a href="http://www.taobao.com" target="_blank">淘宝网</a></dt>
            <dt><a href="http://mai.taobao.com" target="_blank">商家后台</a></dt>
          </dl>
        </li>
        <li open="closed">
          <a href="#">列表2</a>
          <dl>
            <dt>哈哈1</dt>
            <dt>哈哈2</dt>
            <dt>哈哈3</dt>
            <dt>哈哈4</dt>
            <dt>哈哈5</dt>
          </dl>
        </li>
        <li open="closed">
          <a href="#">列表3</a>
          <dl>
            <dt>哈哈1</dt>
            <dt>哈哈2</dt>
            <dt>哈哈3</dt>
            <dt>哈哈4</dt>
            <dt>哈哈5</dt>
          </dl>
        </li>
      </ul>
    </div>




      <ul style="width:76px;height:128px;padding:8px 0px;background:white;color:#33363d;border-radius:10px;position:absolute;right:36px;top:34px;text-align:center;">
        <li style="width:76px;height:37px;border:1px solid black;"><a href="#">简中</a></li>
        <li style="width:76px;height:37px;border:1px solid black;"><a href="#">繁重</a></li>
        <li style="width:76px;height:37px;border:1px solid black;"><a href="#">EN</a></li>
      </ul>

      <div style="width:0px;height:0px;border:solid 10px ; border-color:transparent transparent transparent red; " class="">


      </div>


    <script type="text/javascript">
    var div = document.getElementsByClassName("demo")[0];
    var ul  = document.getElementsByTagName("ul")[0];
    var li = ul.getElementsByTagName("li");
    var dl = document.getElementsByTagName("dl")[0];
    var len = li.length;
    ul.onclick = function(e){
      var e = e || window.e;
      var target = e.target || e.srcElement;
      if(target.parentNode.nodeName == "LI"){
        if(target.parentNode.getAttribute("open") == "closed"){
          target.parentNode.style.height = 120 + "px";
          target.parentNode.setAttribute("open","opened");
        }else{
          target.parentNode.style.height = 20 + "px";
          target.parentNode.setAttribute("open","closed");
        }
      }
    }

    </script>

  </body>
</html>
