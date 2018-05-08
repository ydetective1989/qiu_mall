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
    <div class="minisit-wrapper">
      <div class="minisit">
        <div class="minisit-left">
          <ul>
            <li class="county">
              <div class="">
                <a href="#">中国大陆</a>
              </div>
            </li>
            <li class="tmall">
              <div class="">
                <a href="#">汉斯希尔亿家专卖店</a>
              </div>
            </li>
            <li class="msg">
              <div class="">
                <a href="#">消息</a>
              </div>
            </li>
            <li class="movetophone">
              <div class="">
                <a href="#">手机逛淘宝</a>
              </div>
            </li>
          </ul>

        </div>
        <div class="minisit-right">
          <ul>
            <li class="mytaobao">
              <div class="">
                <a href="#">我的淘宝</a>
            </div>
          </li>
            <li class="shopcar">
              <div class="">
                  <a href="#">购物车</a>
            </div>
          </li>
            <li class="favor">
              <div class="">
                <a href="#">收藏夹</a>
            </div>
          </li>
            <li class="item-list">
              <div class="">
                <a href="#">商品分类</a>
            </div>
            </li>
            <li class="pipe">
              |
            </li>
            <li class="seller">
              <div class="">
                <a href="#">卖家中心</a>
              </div></li>
            <li class="callhelp">
              <div class="">
                  <a href="#">联系客服</a>
              </div>
            </li>
            <li class="webnav">
              <div class="">
                <a href="#">网站导航</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="top">
      <div class="top-main">
        <div class="top-main-left">
          <div class="top-main-left-log">
              <a href="#"></a>
          </div>
        </div>
        <!-- 搜索框 -->
        <div class="top-main-search">
          <div class="top-main-search-bd">
            <div class="top-main-search-list">
              <ul>
                <li class="top-main-search-list-ul-li-hover">宝贝</li>
                <li class="top-main-search-list-ul-li">天猫</li>
                <li class="top-main-search-list-ul-li">店铺</li>
              </ul>
            </div>
            <!-- 搜索输入区域 -->
            <div class="top-main-search-input">
              <!-- 搜索文字input -->
              <div class="top-main-search-input-left">
                <input type="text" name="" value="">
              </div>
              <!-- 搜索button -->
              <div class="top-main-search-input-right">
                <button type="button" name="button">搜索</button>
              </div>
            </div>
          </div>

          <!-- 快捷关键字 -->
          <div class="top-search-bottom">

              <a>前置过滤器</a>
              <a>包装设计</a>
              <a>实木沙发</a>
              <a>电风扇</a>
              <a>自拍杆</a>
              <a>热水器</a>
              <a>充电宝</a>
              <a>摄像头</a>
              <a>饮水机</a>
              <a>扫地机器人</a>
              <a>收音机</a>
              <a class="top-search-bottom-more">
                更多>

              </a>

          </div>

        </div>
        <!-- 二维码 -->
        <div class="top-main-qc">
        </div>
      </div>
    </div>

    <!-- 导航条 -->
    <div class="nav-wrapper">
      <div class="nav-main">
        <h2>主题市场</h2>
        <ul class="nav-main-left">
          <li>
            <a href="#">天猫</a>
        </li>
        <li>
          <a href="#">聚划算</a>
        </li>
       <li>
        <a href="#">天猫超市</a>
       </li>
       </ul>
       <ul class="nav-main-mid">
         <li>|</li>
         <li><a href="#">淘抢购</a></li>
         <li><a href="#">电器城</a></li>
         <li><a href="#">司法拍卖</a></li>
         <li><a href="#">中国质造</a></li>
         <li><a href="#">兴农扶贫</a></li>
       </ul>
       <ul class="nav-main-right">
         <li>|</li>
         <li><a href="#">肥猪旅行</a></li>
         <li><a href="#">智能生活</a></li>
         <li><a href="#">苏宁易购</a></li>
       </ul>
      </div>
    </div>

    <!-- 首焦轮播和广告部分 -->
    <div class="main">

    </div>

  <script type="text/javascript" >
  var toplist_ul = document.getElementsByClassName("top-main-search-list")[0].getElementsByTagName("ul")[0];
  function toplist_hover(){
    var li = toplist_ul.getElementsByTagName("li");
    var len = li.length;
    var e = e || window.event;
    var target = e.target || e.srcElement;
    for(var i = 0; i < len ; i++){
      li[i].className = "top-main-search-list-ul-li"
    }
    if(target.nodeName == "LI"){
      target.className = "top-main-search-list-ul-li-hover";
    }
  }
  toplist_ul.addEventListener("click",toplist_hover,false);

  </script>


  </body>
</html>
