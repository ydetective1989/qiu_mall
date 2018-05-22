<?php
define("ROOT",dirname(__file__));
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>邱邱的网页</title>
    <link rel="stylesheet" href="./css/index.css?<?php echo date("Ymds");?>">
    <script type="text/javascript" src="./js/index.js">
    </script>
    <script type="text/javascript" src="layui.js">

    </script>
    <link rel="stylesheet" href="./css/layui.css">
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
                <span></span>
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
    <div  class="main">
      <div class="main-left">
        <div class="main-left-left">
          <div class="main-left-left-main">
            <ul>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>
              <li><a href="#">女装</a>/<a href="#">男装</a>/<a href="#">内衣</a></li>

            </ul>
          </div>
        </div>

        <div class="main-left-mid">
          <div class="main-left-mid-top">
            <div class="main-left-mid-top-main"  >
              <div class="layui-carousel" id="lunbo1">
                <div carousel-item >
                  <div class=""><a href="#"><img src="1.png" alt=""></a>                  </div>
                  <div class=""><a href="#"><img border="0" src="https://img.alicdn.com/simba/img/TB1zW8opx9YBuNjy0FfSutIsVXa.jpg" width="520px" height="280px" data-spm-anchor-id="a21bo.2017.201862.i2.5af911d9KwuiTA"></a></div>
                  <div><a href="#"><img src="//img.alicdn.com/tfs/TB16OTaqpOWBuNjy0FiXXXFxVXa-520-280.jpg_q90_.webp" alt=""></a></div>
                  <div><a href="#"><img src="//img.alicdn.com/tfs/TB14aoFpwmTBuNjy1XbXXaMrVXa-520-280.jpg_q90_.webp" alt=""></a></div>
                </div>
              </div>

            </div>
          </div>
          <div class="main-left-mid-bottom">
            <div class="main-left-mid-bottom-main">
              <div class="main-left-mid-bottom-main-top">
                <div class="main-left-mid-bottom-main-top-main">
                  <span></span>
                  <em>理想生活上天猫</em>

                </div>
              </div>
              <div class="main-left-mid-bottom-main-bottom">
                <div class="layui-carousel" id="lunbo2">
                  <div carousel-item>
                    <div class="main-left-mid-bottom-main-bottom-lunbo1">
                      <a class="mo1" href="#"><img src="//img.alicdn.com/imgextra/i3/5/TB296UXppXXXXabXpXXXXXXXXXX_!!5-2-yamato.png?activityId=533&appid=3362_210x1000q90.jpg" alt=""></a>
                      <a class="mo2" href="#"><img src="//img.alicdn.com/imgextra/i4/88/TB2igHicr5K.eBjy0FfXXbApVXa_!!88-0-yamato.jpg?activityId=1702&appid=3362&report_date=2016-11-10_210x1000q90.jpg" alt=""></a>
                      <a class="mo2" href="#"><img src="//img.alicdn.com/imgextra/i3/47/TB2DBhcg3xlpuFjSszgXXcJdpXa_!!47-0-yamato.jpg?activityId=52469&positionId=5&appid=3362&report_date=2017-03-07_210x1000q90.jpg" alt=""></a>
                      <a class="mo2" href="#"><img src="//img.alicdn.com/imgextra/i4/5/TB2AZHNsXXXXXbmXXXXXXXXXXXX_!!5-0-yamato.jpg?activityId=1708&appid=3362&report_date=2016-11-01_210x1000q90.jpg" alt=""></a>
                      <a class="mo2" href="#"><img src="//img.alicdn.com/imgextra/i2/156/TB2G9JLXgCN.eBjSZFoXXXj0FXa_!!156-0-yamato.jpg?activityId=18099&appid=3362&report_date=2016-10-10_210x1000q90.jpg" alt=""></a>
                    </div>

                    <div class="main-left-mid-bottom-main-bottom-lunbo2">
                        <a class="lubo2-mo" href="#"><img src="https://img.alicdn.com/simba/img/TB1fIeYeL6TBKNjSZJiSuvKVFXa.jpg" alt=""></a>
                        <a class="lubo2-mo" href="#"><img src="https://img.alicdn.com/simba/img/TB1zgKpgStYBeNjSspaSuuOOFXa.jpg" alt=""></a>
                    </div>

                    <div class="main-left-mid-bottom-main-bottom-lunbo3">
                      <a class="lunbo3-mo" href="#"><img src="//img.alicdn.com/imgextra/i4/80/TB2F._1p29TBuNjy1zbXXXpepXa_!!80-0-lubanu.jpg_200x200q90.jpg" alt=""></a>
                      <a class="lunbo3-mo" href="#"><img src="//img.alicdn.com/imgextra/i1/136/TB2_F4MqmtYBeNjSspaXXaOOFXa_!!136-0-lubanu.jpg_200x200q90.jpg" alt=""></a>
                      <a class="lunbo3-mo" href="#"><img src="//img.alicdn.com/imgextra/i3/184/TB24XJRpFGWBuNjy0FbXXb4sXXa_!!184-0-lubanu.jpg_200x200q90.jpg" alt=""></a>
                      <a class="lunbo3-mo" href="#"><img src="//img.alicdn.com/imgextra/i4/182/TB2B_vNbSMmBKNjSZTEXXasKpXa_!!182-0-lubanu.jpg_200x200q90.jpg" alt=""></a>
                    </div>
                    <div class="main-left-mid-bottom-main-bottom-lunbo3">
                      <a class="lunbo3-mo" href="#"><img src="//img.alicdn.com/imgextra/i2/86/TB2qgMChRmWBuNkSndVXXcsApXa_!!86-0-luban.jpg_200x200q90.jpg" alt=""></a>
                      <a class="lunbo3-mo" href="#"><img src="//img.alicdn.com/imgextra/i1/38/TB2HmOopKuSBuNjy1XcXXcYjFXa_!!38-0-lubanu.jpg_200x200q90.jpg" alt=""></a>
                      <a class="lunbo3-mo" href="#"><img src="//img.alicdn.com/imgextra/i4/175/TB20F3ueZUrBKNjSZPxXXX00pXa_!!175-2-luban.png_200x200q90.jpg" alt=""></a>
                      <a class="lunbo3-mo" href="#"><img src="//img.alicdn.com/imgextra/i2/25/TB2b4MbpWSWBuNjSsrbXXa0mVXa_!!25-0-luban.jpg_200x200q90.jpg" alt=""></a>

                    </div>
                    <div class="main-left-mid-bottom-main-bottom-lunbo5">
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1y7u7dCYH8KJjSspdXXcRgVXa?abtest=_AB-LR65-PR65&pos=1&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1JKbUmxPI8KJjSspoXXX6MFXa?abtest=_AB-LR65-PR65&pos=2&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1GJzSbQfb_uJjSsrbXXb6bVXa?abtest=_AB-LR65-PR65&pos=3&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1ZGCLmFmWBuNjSspdXXbugXXa?abtest=_AB-LR65-PR65&pos=4&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1r23ZRXXXXXaxXXXXXXXXXXXX?abtest=_AB-LR65-PR65&pos=5&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1pdkcRXXXXXa6XXXXXXXXXXXX?abtest=_AB-LR65-PR65&pos=6&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1MyCXRpXXXXa0XFXXXXXXXXXX?abtest=_AB-LR65-PR65&pos=7&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1CZmleQKWBuNjy1zjXXcOypXa?abtest=_AB-LR65-PR65&pos=8&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1Xi1EOpXXXXbMapXXSutbFXXX.jpg_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB16Hcrj7CWBuNjy0FaXXXUlXXa?abtest=_AB-LR65-PR65&pos=10&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1adJ5X21TBuNjy0FjXXajyXXa?abtest=_AB-LR65-PR65&pos=11&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>
                      <a class="lunbo5-mo" href="#"><img src="//img.alicdn.com/i2/2/TB1D1.Mo8DH8KJjSspnXXbNAVXa?abtest=_AB-LR65-PR65&pos=12&abbucket=_AB-M65_B15&acm=03014.1003.1.765824&scm=1007.13143.56636.100200300000000_90x90q90.jpg" alt=""></a>

                    </div>
                    <div class="main-left-mid-bottom-main-bottom-lunbo6">
                      <a class="lunbo6-mo" href="#"><img src="//img.alicdn.com/tps/i4/TB1No_YhTdYBeNkSmLySutfnVXa.jpg_240x240q90.jpg" alt=""></a>
                      <a class="lunbo6-mo" href="#"><img src="//img.alicdn.com/tps/i4/TB155r9c4uTBuNkHFNRSuw9qpXa.jpg_240x240q90.jpg" alt=""></a>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="main-left-right">
          <div class="main-left-right-top">
            <a href="#"><img src="3.jpg" alt=""></a>
          </div>
          <div class="main-left-right-bottom">
            <h5>今日热卖</h5>
            <div class="main-left-right-bottom-main">
              <a href="#"><img src="4.png" alt=""></a>
            </div>
          </div>
        </div>

        <div class="main-left-bottom">
          <div class="main-left-bottom-main">
            <h3><p>让你的生活更有趣</p></h3>

            <div class="main-left-bottom-right">
              <a href="#">
                <img src="http://img.alicdn.com/tfscom/tuitui/i4/0/TB2budZjx6I8KJjSszfXXaZVXXa_!!0-arctic.jpg_120x120q90.jpg_.webp" alt="">
                <h4>米家蓝牙温湿度计体验：智能家居枢纽</h4>
                <p>IT之家12月21日消息?在11月28日小米举行的首届小米IoT开发者大会（MIDC）上，米家带来了一款蓝牙温湿度计产品，售价69元。IT之家编辑部已经收到了这款新产品，接下来小编为大家带来开箱图赏。米家蓝牙温湿度计售价69元，很明显，带有“米家”名字的产品都可以与小米手机智能互</p>
              </a>


            </div>

          </div>


        </div>


      </div>

      <!-- 最右边便民服务层 -->


      <div class="main-right">
        <div class="main-right-top">
          <div class="main-right-top-main">
            <div class="main-right-top-main-top">
              <div class="main-right-top-main-top-logwrapper">
                <a href="#"><img src="6.jpg" alt=""></a>
              </div>
              <span>Hi!亲爱的</span>
              <div class="main-right-top-main-top-mid">
                <a href="#"><span></span>领金币抵钱</a>
                <a href="#"><span></span>会员俱乐部</a>
              </div>
              <div class="main-right-top-main-top-bottom">
                  <a href="#"><span>2</span>待收货</a>
                  <a href="#"><span>11</span>待发货</a>
                  <a href="#"><span>2</span>待付款</a>
                  <a href="#"><span>5</span>待评价</a>
              </div>
            </div>
          </div>
        </div>

            <div class="main-right-mid">
              <a href="#">网上有害信息举报专区<span></span></a>

            </div>

            <div class="main-right-bottom">
              <ul>
                <li>公告</li>
                <li>规则</li>
                <li>论坛</li>
                <li>安全</li>
                <li>公益</li>

              </ul>
              <div class="main-right-bottom-mid">
                <span>约旦首笔中企捐助来自马云 用于妇女儿童教育</span>
                <span>阿里全资收购Daraz 最强量子模拟器在阿里</span>
              </div>
            </div>

            <div class="main-right-bottom-easy">
              <div class="main-right-bottom-easy-main">
                <ul>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item1"></span><p>充话费</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item2"></span><p>旅行</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item3"></span><p>车险</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item4"></span><p>游戏</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item5"></span><p>彩票</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item6"></span><p>电影</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item7"></span><p>酒店</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item8"></span><p>理财</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item9"></span><p>找服务</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item10"></span><p>演出</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item11"></span><p>水电煤</p></a></li>
                  <li><a href="#"><span class="main-right-bottom-easy-main-span item12"></span><p>火车票</p></a></li>
                </ul>
              </div>
            </div>

            <div class="apps">
              <div class="apps-main">
                <h3>阿里APP<a href="#">更多></a></h3>
                <ul class="apps-main-nav">
                  <li><img src="data:image/webp;base64,UklGRtIFAABXRUJQVlA4WAoAAAAQAAAAOwAAOwAAQUxQSC0BAAANT8OwbdtIJ7nt/fuvm3SKiMiDLS0tfSHhpOWhRpaxMpexJsFFhZbtNYopea2fCotyUgtx0JEYNqDbtq0s2XR3d2MrYYvYdHd3vv8LNOh3fjtGRP8Tu2yjx2FWcfD3WauUSVaXOMRy3inAEFdtcbhb9znsCyMGMMpxhdMPU+yI42CcFzKfTbARxEHh953PsGK9gOZEF8XKbgVROFFm34JKGHjWa0HmzXtAJ7TbQGg3gdCsAaFaBEI5KKWgZOG/4AyUo4EMdP2GFnT1ohV0pYwDdOmUiw+qQaGd84MqhtVjQAya3hdWldgTCxSLIDbvvEtQRFnYLK4NVywwvYiMsTO/mb3KwGwnwMLe8vPj4lQG5ro/3zhYf0uaHWa1UoIVT4jfjqdYDfvNYraGPQAAAFZQOCB+BAAA0BYAnQEqPAA8AD6JOJdHpSOiISwYDzCgEQlsAMa1QVheDH3H8XPw5+Turf2PgFjqelPwPOV8wD9H/Mz/WD3AeYD9o/Vy/wH6ze4D9bPYA/aPrAPQA/Yj0zP2V+C/9zP3O9ph5Lo122ryda/Zofj9+p+mZ9hnogfsAj1tQXuVcitM5RQRoK4Bz6pXzH/zUc4VrcbDF0986A/R1QF3urllnqUU+UC1cMLEKOGPIeGWdCiBjsLBn+EB+lsEDEnn8ywA/v6/y7bkzLN/krBc33mDwaOzw6inxwQ2JrG4taZSSft5W/k4oFIMRWk8D/5VwIcOGueTfZ5aV1IZ/+lhUKfQfiUFyLveN4O7U1vHXMWO7V/ix06/O3zrhj/iJrPqF4FfjYv7JqXCypcE3zIXAwn+4/PMKZ51mYYKwdGEFC/YCq2e7k1K3zvTDfyJEM8j06UYQ6cbx+lSyZaGjVyZmrTOPN97ke5p+EMbmN9cJjoqWYNZ0Nruzijk4rtTJC35Y2/sBePYdqbm8jop8aLGu/LhKmU6cSjBdCjkejimS8K/q9zeptKioHz2CzkDfEeNAZNa7OMjN5jZ6fahqMTSsfF8/kZZHAhc0BKFqIPSee+POyPv3npNB6KL9RQw9QMupGBIPjM1O7VPSe5m/fvQGcj5ODMyyVuStIB8C3E7/w3dnFzUwtW/Tjxts3VtLSeWLiYHtIT6ipw5fb048qoC9FcQJap5gNhOt4/J9tkyB35CkEx7labVClYVDF4VbrxKotehrZu0CB8viRnZxoqwS6jyyvSAGb8E8F/ktk3u36OzTffqJ08g/b/6f4mWMfMfBIiVQhf4LrmCyqgUPdqxqagfg9deMHTJTZwO+snYPBQO4sQNej3UFoBH97UkJ77xXA5rDYmqUhEWN/2pikatYMXnl8gT/il8nUZ30udx/Ly/qICtacT6ITXlf4wN9BlwXJEjDd+yUzpgqAQyfeHHLRylz7SCOHBP3k2sxy0Zw1ihuNYsizlkGRwOG8dx6FtOUBQU2acvdvE9EjqIOrvzt0/oshM2wKxAiX6d2Kue6Bb02Rbe1gPoLFrMNRrAh+K0qtI/s5S4vApopBWWYzUryIawg/qyHLsAG3zfJd+7yndRi8SFc8U0kWXVaNWozdZESUbeDycER437GxzDLSFIJv+wGr9Hx9dCB9mT8xoSzovU0BlCd9CJB45NfEBuCuQ+OSKK3SPQdVWIfzzsvOzpi0yTcJ8aq9K8shP0R6SbBYLN7aBqORmktnHAx8oAer9vgel9MUebUSlFaOqRGdncFe836BHHlpop6wF7MHw7QFjCRUey6N2Xp8BDA6nMx7+/juDC7/a0gyzu59G+tFuQ9euKcxIRJ3My/tzx2PyBBma8rUDafyKangqwmHLiYwpD6/7z117KfgarAvvMpkSbNpa0qFD8pwhGzg97GDHm5AAAAFQjxvzt5qLwyHPdV9VgM+epHXH2V9GytP10q238TxwtvKy75X8zR74vXM7fZbJ/zrn2V1+/+MgADOZX4jAAAA==" alt="">
                  </li>
                  <li><img src="data:image/webp;base64,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" alt="">
                  </li>
                  <li><img src="data:image/webp;base64,UklGRrwEAABXRUJQVlA4WAoAAAAQAAAAOwAAOwAAQUxQSNcAAAANz8GgbSRH57nv/Z8/2F8WEZHNnyHi88wGgzcm43aqSZ3baJLXYDA/PlFDAJYk2aatWte2bdt7/hO7fu/t/n8R0f/kFUwXM4mQ4cddtsvJ6spHshvGo4USmcKpseGtXMV7IN8YjHhW8ihi/dmQe7KKxvqDTbCHKtqqpyLI8scSOitmEWbjCOMhhCFDaPyr4gydu4TQXXZxdLtFFt1iXDRUbrI+5lHNgtd6K4rm0Oa+GfQNhavxHM76Mfzva7yNBs1cAL+3eYePTf1cyCRChh932S6nQV4AAABWUDggvgMAANASAJ0BKjwAPAA+kUCXSKWkIiEoG/6osBIJbADJvGRO1sz5zEOP0G2g8wH2gcIB/VeoA9ADyy/2S+Cv9wv2q9pa5tdFgiT/H+Vl1d+h4S9I7My8ZWoZ0jvQdPQ6ECxXJzL6ihzp9BH1kimsWNbKtACjfrnqF8xbeucoStbwnvSwLTlZDQxs+XsN/DebZ/v+mTOyZbwCgJRKkSB1jDAYAAD+/pCtcriOsduNFTdTp+eV5s5r8aGSf9yz/u5zP7gJBNRmRb5H8e9ifcS2//7DrXl3RbzOv3Gf94z/OfdW/466IRRgAypADHgNsa+3fw6fJ4mk579qCP0FcSd92iDkKmcWoH/8B3HBguo/ZkWU5ReePNc2a8aKsCQBBwkXYShT7mgwnEDlgbmV/yCunZrzf8pDnSgHtiI8GKWW38/FTwNx9otkRUuJ9imbYOn+1/JNa/LzjMuUn+tLY+f/A6dbYctmc40NEdWqsUg4CcKZiGhDk1oewtY5RHQD3t4tFDrwB0j5mfenAmEXkVka5Uj+PEqGb4pz3JKwKI77zjNOWSas4/C56VRZ8POP0XL8JrmPKUdxlgKEEvKEv33HtmmCf02BgOrINpAkM+Pq0d82Vs2qz9+8KB8GpnmPDBVNaIzze2jDuRKvzfdSkOyTgkABVUm9oWTqEsrKwfV5d4wGrTGIaTtD7RFaftj72KOERAUXsJlF80OPQRBbfa1vUZa+TkixZ2BSYnFYDYpMke3M/adcvsallRByw3yKFJrwT/Pb+krn+CdoGYSHbnyMxvV8/Po0z6MP+Wg11g2pOpymYCaG+/G9fdwYUzHjMDGEHn65q6pprlE0ZEogU8/aNTMJdDxZZ+KsicW40dxzEGB7vcUfH/L7Nk9nZ+DQEubfNMaXIOcaczO/RYaSaeeS6Wl14mo40Fe2Zfgr2CnH+iJYc5RV1tmgiA3qHb8t7/3N0m03pRJ+w+G5oHJc0gdhFqPu9UejjMi9zd/o/Zmf5YO8NzmfHJtkZKZp9P28W3Qk7qoaEuaxOFG6I5x97XyoO1Khf76jHV+suKpkiJ+hy6tJS5TsL7kT3Lqmy1BHL58d102Q6Mv2xQWx8Tl0+PKuTsQDZ8+/cEt81WPc9nOk+e6o8s9aNe7ZHmbbWBZQ31QqNCGUl3APHpzVW5wCFaDh7I4yGmeJkVnqxK0Q+sWJEXZA1HuuG1PuspuVGuYfSrrLqhf+n5EE73V12Dog5GuNUI0F2MC/oVQQ0EV0yWf0CKS7uMadC1sVJj//nxVGCxgAAAA=" alt="">
                  </li>
                  <li><img src="data:image/webp;base64,UklGRgAEAABXRUJQVlA4WAoAAAAQAAAAOwAAOwAAQUxQSHwAAAABT6AmAJA2yoZrtiCCaYyIACzbn+8CTmvbjqq3UgMLnS7QODpgIXH4+fu5gAyn2+By/RcR/U8r/Z6p+o2N3f5N9eKsrAid+YTwcDNS+0QaAtKUkB4Z6cdfXUb6JaRHQJqeSMOM1PqE8HC2InRW/Jvqxdnd75mq39hYAQAAVlA4IF4DAACwEwCdASo8ADwAPok0l0elIqIhMBgO+KARCWwAyB3A2X4bfO/xa/GPrq9sHzTwNuv1AflX/gdMd+gHuA/aD1Afxz+y/tF7yPoW/xnpGdQB6AHSl/u96U7wAcIKpmpY+TN7h+qqM4ubmG0ibBoLmlceXOfIo1GB/JWlEudV+hsr7TReEdtF0wwDPiYyc+UbAImXs8SWeQZwifHtnxT/I9qz9KyhuRpgAP78Dxd8z1Vb9U2kwkidDgtf7DFdtwP4K0aa3/+e9SHl/j0Sg/7fSBX/9kENOfG2BdkMHdb9gsAzQuvoY/QPaf82UlHGNsmN+D5d6ek42ZH9CPwLH2rz7+rC8ZV9CgNcfWUipMaFt6E3ibUUc9EEs2+IvRDf+Jh9fgpQIvw+4KU26J84baTcd1Sxff6CXuuZ3jrGAL7kG4we1j9pNJd1HTUzuon8cCeH24QYKsFiHQMceVDAcM2ncC2PKGFAnmRyrP7gz9VbqLO1U4tR2Nrseb97L8ZlZbMI6/rtCYycK7HzliXWoFKZtQ0Q1lf04Z8xwfkgVJhRD7amTUS3k39GoKRZK7HseimRPn6IdciQ4Mayeb7NV7divHxrqBIeWuYoSx5Jl2JB7Legtf6lnz66P9prafB+Egk+CkPgMf/9mQEqrf12NYigDLeLumA606lzar3axkXDx3yVW0GUJMoIeHmKiDF9VUBXFAWDolXLOA4YFN6Ha5XyYYXejO2M5t4DRXVmt5jd14dLKgyuJny4sSriJxnWN12nBissK9y0f8yD0bRMy60iACxIen9YeRUw0RhKYoJQLc5EsyKhcnFus2LItQTQxL5laAHB1MCbyIe68FRH26JPslw3zvytP42IxDUn0HG9rr79c6YCACTppy/6zbVaOvHcN3NKeu46PX9I3n0kiYr8xK/Uh1m/WWvDB9zr15i3jMz3Sndcug57tORpKnFudPUMaBsl1fFqdu4CYxP2u9mQZqyderFI3v6inLvqbM+50mRzreYHnttgLcf/JY3d73OtUTLoPabMPDtk9n71p2Ne+dtPaiSQFQ3+Jd97McsJKIx4zpruD08IggE2KNnK+nU3yIRlu/i3TUVedAAnfpZoK/KeDelXSxzVB+LTqsT4XZaeUvjl4U6yqNXKw7VsWSAA" alt="">
                  </li>
                  <li><img src="data:image/webp;base64,UklGRm4FAABXRUJQVlA4WAoAAAAQAAAAOwAAOwAAQUxQSO0CAAABd8agbSNJl8zxx9zZ945BROTDJ5nSBhkyZZFIXiISGbKXJZGWFGthkaKLiCyySaRltdkl0oYh/yHttm0zlnaSZ5tt27Zt27Zt27Zt213O/k1Vndzk5lbrY0T/E38NrU7NDMRN23p/XfMExKut33y9qV4K4pO6j7EXcyoiLtqA74wFLvfJ1xGHurdphU+NaJwK5aVnafc/ODijcWaiBpXFZ+j4btfYthUSoaz2LbqYr8+u6VkANfpoP93N0NctfSslwHuVO5QMnJ1ZCR6NhqcpH3wyo7IGLx1umPQSOdctBdLJAx/Ro/l+XhYkjVEf6D2ytgKkEge/oYrA7mzIDHlLRWsL4F7nCVV9n5gIt2oXqc7XDi7GsiAVPN7/g9axfDh3DFLS9zZM8WHj9OGf+evHGANOxccp+WlO59U/KazWkHuA1pliOOjDvlNyWzoy11Poi1h/WqHOcMg5TdleiNV8TntjxAp9tDbAoWWQstURS1tu0jaudlF2+nVa93IgLqV0VR2x3p9pN1/ubbqL1rtWEDIvUfritglt8uvfp+CbW7CS1vchEJo8padD5Rdp/zxFN1bQCk2D0OsjvVxtoB2j7du0DCRspmXOhzAqQA8X6mrYQ9uTGogm36JtAYTJJuUftERUP0Hbj+Ea6odomfMgTKX8t6E6oiXXaL/Sou5h2kLTIUwyKR1ZmIxoxzcUHj6I0OYbBWGkn/If26eWbo/Q/VMXCL0+0cOLZfsjlHhVC0KzZ1R+MwVC3jUqXwJR20jVZmc4dDKp+GIpHIrvUW1odhIcEqYFqfROLTjWvk2lszU4GmMiVGdeKYNLxkmqe91Nh4vW+g5VBaekwFXr+pFqfKuSIGGM/0IV4XUlkErs/4zePy1KgKTR4y69vh+eBWmt0rpP9PJ5Rx0dXjIHnqF06PygHHjU8/odfROme+jJke55OhSkdZh18oNJp/CTHVMapUBVYlH1HtM3nrz2IHrj/M7Fw5tXzjHwXwAAAABWUDggWgIAAHAPAJ0BKjwAPAA+hTSVR6UjIiE59OqooBCJbADG8Yf+5dYJrDwHDa7Sd995JsvtgPMB0APNr6kPn2vZUwDBig3wNIFMw8Rz3j0AP1VZ9EAsqy7/Na13sOtWGDKvg3z927BHUeklR7VFdIMkgYZryg+mda0huVbKUxeLeWezrWp/wyxWAAD++94SxGdmbXHzjQOlteL+xhPMfwU40n5Fr9kln1JgqxKXhro6NDAyu4wMfsQiIAIKravDThY0fPBaTpZ3G0+4/uDESTEW5r4MTbwqQycJcbV+NHRBc9/PYTOVY2B+h94YIbVngkwjWprpsNPmjnofE/60bRWezaaIecnYcjC7ERzHyvjPsq+1WPqd0Bq029xVJu5bT2xX/wfwHtyO/vfIOXKOrTb9mWPAM/lDgnQNDUXuAvNACY9fwOdR65beAaH19VObGzY8e1CSjIUPTrtwNsyfFQjhffqvVenLwjn+6zccovFEhl1EaayRbSVQiCIOANuaRF2aXvA5rSIKOFkp4k74KxwHyvWyf4wO8oMZgOavvDqhrE/j8nTN6gTPkQ+cYacyjhtsZIp4qepIOfcyVjtDkRQyZ4NFg/L20gGl5+qC9fGcRoo7tT9939AlqCuaEQ3jSlI1IJHmXRx+6ywxQYMZEWTOIU+2Cd+0WgvpWLPBSKJe1JUbEQzMI9iLEeeAO7k31oFrLGPC9FTO0L9zYJklv3FLa2PbQ/V0xiiJoHz4Kj37Dik25kNzvrmBA5vSksCCnraEEAPukIdn8kEHmYiB9haMHsmxDR63JVeRmR7/AAAA" alt=""></li>
                  <li><img src="data:image/webp;base64,UklGRs4DAABXRUJQVlA4WAoAAAAQAAAAOwAAOwAAQUxQSBsBAAANL8OgkSRF1zNzz+Df7ZGIiMjCKnoUmlpMVyPyzc50dmORzaqo0eKKHHaZvqeqhfwxQy2biRBTALpt28abfW/spI5dW7FtJ7W+777/K9S4539HRP8Tn/j6ZtDj0kDGy9Wg25io+GY1uSFeIUlndwdjg8QUn9nuoYBMxnXxg1pV4J1dLEO61rn3mBF423eBwLC0Myvj1b8NEm5IFSbsFFTWk8u1FVCx+GhLBZk+GgGdJuADHXObQehgINTiXwbBQPd8ZwHddd8LulE7BLpOPWYE1UNzPAuDSGlyNXlkZaBQFkW89kspEwjEbQ7vlfmZFvLv8wzvIj1K2yD75pzhk6gUjuMmBmkqnppZfDNJjGKvHgukKIthr8XxCQAAAFZQOCCMAgAA0A8AnQEqPAA8AD6NOpdHpSOiITAZ/ACgEYlmAHfEEE1A9QG2A8wG2zdYB+uXAf/uJ6QGrOpxV0H9lgQJVPMo8jf0f7A/6s/77+edmD0AP0ATblSzsUVa0XfarqM3zBr9TQKIrqnVLuOuQwt3LqtWa2Qd/ckwCcPjHWNaDSGfBBph70aikQAAAP7+8xPc1kPgyDbnfpARUcHcrUiszWz6TD21ggt6+s28R8+vKWxck2lh0OmzZuYfEC0osKPkntb/C/BOVogcQGlQ2IekPBWaNfRQjUvTD5i/sbvYMe2CHc0mgESytobyUwvfMa4auD0BVDQpKct9UrjowOp0fn8zDiCDEgecjj/Ewzf8CxtP/mc7/XNE4fqoxdS/E8h/6TfWAObSlHI1XBwxEhemt29we4TrnS0XPJldMPWuSTju4uufFAy6Dn6ESPimP84DmrVHl+/q6EHgFUXrsCj00mrBYm2TCzt4lwv7DRds96meM4gLU/YMrVyXF3CYFNiv/8bNz4qigIgizFs2I0QurZDx//w6BzxMU8E94JyaepjS8zu7wsXrdQu9PnQVr4jux19rN18U8VgW6LRj6svREja1n34zIdA+tIjJFo+52CklnSyAnxol1A75O+5tFNghJNDst3hXpCXD+qKuQz8nKgz70GGJrMs6q0Ik3TuqQvedVYTLU0Nhwso9ImgIWec9hTJ7H3g7GqlhjDupn8OPFL7vrmXFrKZvecwLmZMaaykJq6V5ISDKIBdtaY+/WYXykXPEfGrHzs/5UQ7Ke/JAMF+CdOEQPst9zc6KS4I6z8Ws0Fc8dShxyFPTaGC2sjjbmJv7l+xROKq/IFuFpc+Ios7yxDR+7G8tVcXZ2AAAAA==" alt=""></li>
                  <li><img src="data:image/webp;base64,UklGRrQEAABXRUJQVlA4WAoAAAAQAAAAOwAAOwAAQUxQSJYAAAAN78EokiRF1zBzzPc+/zJbRkTkIDBouhGqfwaqMK40EWMhUjDFLKCLH9aeTqQYwJFk20pz8Lgr8RAn7rr/bQFD7jwV0f8kzvSaRdK+bdcPkvIcQald8y9E1S6awmZyzgao3NAfo8s1Wgg7HsI8f4E/NrrnqY5uP+07qF7hdRcYaH5DotV9ZqF4D0iWh1HFJO3vcUEMAABWUDgg+AMAANATAJ0BKjwAPAA+kUibSqWkoiGmGqpwsBIJbADJP72qf8BuhZ5q+3rV+4D1LemX5kv2U9aTpAP7t1FHoAdKrWma7zwY78ZUnAfSWTQvIk98/cD2TSZ5Uv3mCoGK8tS4NjAD4RIeOlTe6d7pCo5CxvvWkdAWVeiyJULCxf916FZx1sLdTlTS0NRretbphDgmxE0RN31/PKE5tPnJHMVoaVhU5Yv0Mu5IAPa//Kv9Oe049/EJEC13lpBwt02QzC+yZ0o/LV3ltRoMW4W2b88wgWXMwBE1NeA40TRcTIzJhkcIz/mdCTqhuvZl5xF6zGVixXvhP6fIWiCehsLafwK86jwk242cG6e8ocMB74quxXhnFXuYrWiSavO7leUFgxOJ1O5PnzI7QcYTLMasqBwb+Tf7H8FqRypOjfJ4FU/XhLoMNOjkKK++7G8zVATrhcPii1mbTelGqwl8DzruDLqvWWBpEAGBQxAz7vtujPHcjDVqel4rKoEdHsYkh+iXWlmcqHR97qcuSqMRv9WJ+oo63Trf3fWqAc6lvQWVYK0rDHP2dJ37s8ZD6QSG/6oP5delvlIFkzNxz/H/XWVcSLeNBU2u0hUX3KYdiSJbJ7IgoYoBbHmle9lW5u+t+KHw2GdpupnTjdaiks74BvHJOv7Y4iEyfgZExOWcL5LTXmLwlMkgKg6GpJP+hTbkHmGn8K5IOCoiOO/bjIaQN7AHDatxSyRznEhXsXF2fUurmLpu61wBuOWo3aGddyTDN5MmB+Hi6O6fiDNLsejqQNnvvp5t+Tq2ZPf4vc/EIz8hzbamMgxwSjaY1kW3ofl3/ke4jJ/DKZ2PAdLXwD5HGxM57oNhqQGMi4sgW8TAZyU/L9sJxwLMdY5AdnVAaPpZiIZ4wT/6HnKGxS8mWlyW1pF9alWe1gO8nN1pnCWKfebUA2Q3xknB/AquGLyimoAK6VLReKXMMU9Pb5pLt7/a2Kv6Qy/P+AQkOOOJFq9rIvYAMlmvDyOUvTilUTa2DA1Mtw8nwjXcpuZF+utwG6tSmQ3jM6om6l2XaIpKhpIMjTuDnfpg/8ZCHicxVgoOo+JNT61GG2aPqFPE4csXY7nA5Vrt1dYS0EYoMvS/sUPPnrZTa/nK/p/zIiD1NzKF0M1VuZy017nbZ6/zO53+V0aiHBMXtRoD643p5iKWLLXR1+GHxP9P3fwzmuT7hdfMRX9scejomHbYEWH9k1XQX97FJTmLsjMb3+HfLRfp4oiVYVDXO6zmDgJWuXeyjlllDS11m14TxB1JHw9QZLDIRxbgowXqLfkkBSZSG8OYETnGlasMeyPgrzFmpE7/uP1Q8HjLjflu9QRnTVEsbvVAAAAA" alt=""></li>
                  <li><img src="data:image/webp;base64,UklGRmwGAABXRUJQVlA4IGAGAADQJQCdASo8ADwAPh0MhUEhBgKBgAQAcS2HjAgFkv6ifzb8Vf7N1o/xP8KNQA/h/4l44D+Ifwn+m/znuO/4DlAP5n+Nf8z2wH49/yHl6/xP9V/zPrI9k/5n2Ofz3+Xf6LhVSAAPwA2gD+Kf0D8K8cBrtveFvy78Q/yK56jbnvB+2f9Jy3zlf/J/ar8APUf5gH6l/qP1gP1w9QH8b/qf+y/oHtAfsB7lPQA/on8Y9ID2CvQA/gH979VT/X/tL8F/7hfsv8B37If/G6jdAh1u9e8mL9izj/9Q/ID8Zsx59x2o9flVrx/9v9s3xj/0Plf+Zv8P+ZX0F/x7+vf5L8zP7WiulRq3Sa9rvp0XyzRxCIZrPMAb/tlfwZeRPkd7b/n48bKnLXdI4LvyEtSREdGA2XUNznhUFW/VgAD+//6XAO8hcHDsdM5mRxSBC2pbB+/7yovpaue8RH7Q+fJfz5KfJf/VxeOI+Qwn9TasgAGwVq5my/FcGZx9Fnjq83C/vluirA9SMXjQv/xnsY8fpRr26WVco/igbIvtil+xHynNKyeXOygv5RuX/aB3if6ScDpH88H/EYp7c7aFl+GSIOLtAY6OOAxgUUe9/IWqASxGjgV/LXfYAP/E9es/mNBNbMolNmpOKfqn9Wkpt33MvyF9NPZbqxFYy9AMNZYULu1+YHQYgxz/XBzwIlV8acL9dkpiwInbvDDOUWloiXYl8Bh5DL7EblVNMyZNP71P/+////1B3/68P//+GDcjpy3IM5HW5CB94hfspjEavZTGLvQW+MB7DyesjSu1jeBVCDxxCr/0d0bfj0oNYVcnozOHfKs1w7BHJmtCA2BGnSd1k5luxiyHJxB2E/SPaVdGRNk1s0u0j0Ig006eXgtgYwIY3Z50sLt3GnIzSuW3qlYmjuS/Nu9OXQePZ1/CtFZHM+OsbPFlXeseA1xoryyW7IkATy5opn/5sVHgYt/+wn6p//uQ3/1wWPsGwrHN37/yG7n9mN//4L9WTjQpumg/KCUiWf2UDa+kxelbts/EJzWqpM7Lvbq43P59GNyC6U6jxzFVwjLg5///M/CqJfQqaUAkSS95VAiswG3+n43x3/BtrbYiIeGtlGya+igFTWgPDtfPrOrF4XctjNrbfGi609z2hpEDab0Ld3PN4v0aljZq/+PAcLH6Cc+yTXYMRQL9HeNspULQHc9v7lH/4BupCM29BtOwj7rPptFmjLM+vIrPJANJ4i11yxpetFABB3qNOJVnB6DksTt+QKbt/jjVytDg4tAYKUzE/X3mo+WU68f/Ei5QLBMk9z8ziqm+FpW28f1O2etG5DpHE1B8cXkKn+pv84qWqpf/4rjqnYU77NRmC/+enbI/DwdXHjuKB+SDJae/+7nrwmHf9XTJ33EX3//a/GQ7W4C9oDOp4F2x/+lA7dZp/QOm4sddkgZpST6UjX0cW6wdXG9aYbd+YEutXCBOP7fjIcYXzmdA1GOl+MIUIDf2//4DYf//dRT//tpyf/qi/cz0xQBIHp6///Xo85VX/UvzZ/u0hKCCyx8cN6zG0JP//G3UcssddCdmQi+17KrnIyvB5PiBOt051Xs7dU71rrXK2eRRefGDPNQ5zH/yyRLo7/9TE+2B8HELAU5IoDgMro5mtddtUzvj5DzJgq+m/fpbJLihBz2RUMUMDMsJRHeOjLz+Yi6k/ZWGn68J0H+5Udof6TrQkzP807yP38+n+GGD/TyWU6nM2cr70Rf/VVPgaCNwQDKu/+ncsFpApUZKm9Udbe8L8ILQD4/hNNj01o98dwzIQc1aFhFMiCwqbqBMh/8UW571OB7TsmkwuJh6zkC823WHBhzquJ2ZffvV+BKB+K6Y6IUHxKNt3G943PBFsZP4WbpbqR9cT/stxFz/86Jz8kVrX4J+KgWqLO0iqsyjg6Sof6Yv70V/Sv/5r/kXfIFMXpz//2Pf5wtieDNpAx7ijg+uNCTzT7q8BP0Z4yC8UNT68mrsi2hcj28sqze6rsGA+IuCeAcUloP+F+frQTWO9ICty2BlDRp6+/iyq7JTBS9ntjXKSNNsohNyI9f5/hX/VsThx1+jX8nxde21CMDcR1scKPEMf7Sb6AbI2xIyb5FHC7t8eW/WPcSXdSWCCoVLB1TxEIEPBtSl7B177CusR3JLq5jzC8mTtD7IgJh9AAA=" alt=""></li>
                  <li><img src="data:image/webp;base64,UklGRqQDAABXRUJQVlA4WAoAAAAQAAAAOwAAOwAAQUxQSPUAAAANP8IwkiQlNO5O/qm+kUNEZOU3y2ej0cijtFv12k/4Wv0epElqtM2pFma1BFeSbZvOfn6xbdu6cZ7nP6MY9/ynIvqfeCiRfCkd0sHHOK4m872FF18z7oKfHkoXAtv+BQ8p0bbBWYxVUl3m4JZoeeAv52o9hqu/7YFCSNa7Z6Vhg0bIpgaRBKjkKsu7IIsGy6ATiykQpsIgDGsg1PBXxdRAZx7CoDusU6Bbj4siqNzpPBgF1e60Z1UZNPZItQaprAAKb7HC9dytJwXw9zZD3FmvnpXB214MJdwd1slUoiJ4urvREi+XPgsWMiENfMzjcnZS8QAAAABWUDggiAIAALAOAJ0BKjwAPAA+kTqZSKWjIqEqFm3IsBIJbAC/cex4AdjF0ntn4jfkB05XAOIDwz0AbZrzAebX6AN4U3j7+9sEDSBTQPH0+IFspyuO/2ZK4XPUzO6+339kMZIaBJUS5UgmlcUTBuV6UwzSj/w5LCaKd+mbcGZNd6VLdCt7IAD+/HZeMGsdWiNDdKJN0b/BtAHTNRITSE631R03AH/XQiwkylEIoEP+rn1doZJLPLeH+GHgh84VRfZxbdZiDAVr01Vd7nMtYUbu+7H3mcDMZkPvQ0+rqaYJ84/Z7XSGrYuxscTlhehX5Bz9Z+z+HrwzHmbgmdYw4KvURAh0nwfqTArl2/xEqQ/tdybFE8YLmMJpM81z4paFU9q5BiTFPNNhFhQ89joA4E9417j3KJv7R/CBw26TCBwwV9vKno5mW83nd8fT1jtulm2h116lSCXj89/ydD8/jRdaeH//eLA3waFSgUhwLz1bCzzwdYWMY4nwO5NoWREdQen5KIYOuexulT2mHgFKWGOnM9O/0nkWg2beGv8wW3T0hYIMh58y0gj8wI3bo1IdpgvBdzOCFrLxzS+TUjrOm890AOo8i7sZVOt7xQk3iEenBp0PbHWKn57OmALerOwD3Am5pn2L9K2KZH6qlD2/2voadVV7gr1Kq4FFSomulzZAVdp+VqtgLqB2HYbdcSoiCVSCI8J6Niequyk0mXyquvW96CyFOvdW4Cj0WEO32+0Ym73apRFsN9/I/F19f8hHpAdTBejxwoPXzKPav/1l1Ct0UXYgpQ0/gbohhREZb3/ak0EPpRKpTPIAjJNt0otORYk06G72M4eJ5/HGOJgXQexc98ZI40Q+iABnip/BlAAAAA==" alt=""></li>
                  <li><img src="data:image/webp;base64,UklGRtAEAABXRUJQVlA4WAoAAAAQAAAAOwAAOwAAQUxQSCQBAAANN8OwbdtIJyX373P7j+b0loiI3JA4LMOUpA0jI55UcNGGuOr4zl1+w1RHLEam3y5aRH5JAZZt26ajHdu27bLzUkZsO7f/TSjjnu8aI6L/ic9ipSGWC2tF+DPrPZdr4wXDd4Zg3L8GF5E1ktI0HtoLfPUVzeAnUriSjtZtF5/jaQbOzpJEaOMj/roDd2XaJXTw5kvvQCBP2C4H0BdBIzuYVcQhC4jER3fKGMjcNmMAdIXYBnTePAiVERCK1SAU4d/+wAQ69hQF3e4qIwfZpKp1gqw5qmZAxc4Wj047iOpz1nzdV4BkdCzB8kackYNgeqrDW1dwJWTgPr1e46Mt2Pek4Dw8X+Fz52J96AFP9nKiw9d+5d6W9aokInBg23GzvJDgAwAAVlA4IIYDAADQEQCdASo8ADwAPpFCmUqlo6IhqBgIqLASCWwAxQv7sDegfjX+W/UZcYuZn1vL3+n6QH5p/zu+A8wH65dQn0AP7F1D3oAeW77JX7r+k5c9K7Ws/0L+IrSQM/eSfvgH6AItFkkzHVOYmp22Ug33ONO/msRIHGlznK5lqZGjDeJj7NupF1Pu8w3cvP2XnJ7qS8HhuUjCzOuQAP7/G3qHp7lA+T56E+x9ZECDUoQsIef/vG7752RQb4v/+MEW9AQyDF458XDi//lxcpjc5nvF4GHPfrf7b8zrtkox79uAzvheQU1juYkGlZ/6dgqga/eumWe1oqo8m62rMldM+tMnv/IM57N9zq83lALlnovj/f7mOFRuhudGr8H6IPh5yogk3iEDD2wimrfYCmehfeY1RN3Q3VzydAMGK/BHVY1EmO8wIaMztIxRVAS38r6cJhTXIbSX2qJE8eDEZuBDjuysbAjVpqVZ1kirBytroMLCcsPuDRs17UlrmCyWbSB+b9De+muKWfVvYh+vqyBynrRv/5hUKFaLYiMKfIvkEiMv3m0Yhc336Ov9cMWYdHADzZOAPBjqxmVWBv7aQTOVShpeN0TpbrQH852nOaQzhYjzZITqrO+Gvc10IVlYCJppJ3pRTBxK8Pqw/LhgIdK8Bth+AsBgMqr7uwrbokZBYoOlm64phL0KVAwxPKlmqj481mNFsPEYHHUls/gVO7pc/p+kRqbTGl1RuyqeYSkJtwHJs/VPCsPImD0QODm1iWatMllnUJ1bfEQIs4USNZjw7/VSJpvsDG17hM/3cuoFBn+OpywKlX6ef7V4/6qgWfCEEllTzokMpBsbFq4bLw3fEiJIartQBvhvmAS9Do47ECpgRDlw/mXmOUeXgVdhGk3W+YXfTMF3KMdAhD2wgYxK26/so+e7OpDSowu3SSH68OZ2X+0K+KyX5WaGqHfi5H5NA8oY2u9R0bH2jX56wU04k6PRwrCz0394wEgIa2z/1k0HyrPKLWI1MtfPvkgWubq2j+IcCAZwiXfllWxSZjVyhn5XT1lbubiwqY7c8NOklLR6/yRi/DR/9gEzYBkOauOQsIAksFh2q73SSlIQf8O5rdxt9kA3JEAuMdGa8Xoofag0+wMwKZXM6Pq7dd5qvVDf4aLeeUx6Q0PIo4ik4WpoC2brcgy48Skym6vsj1aWsTBLbSwvwJIWQwAAAA==" alt="">
                  </li>
                </ul>
              </div>
            </div>
          </div>
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

  layui.use(["carousel","layer"],function(){
    var carousel = layui.carousel;
    carousel.render({
      elem:'#lunbo1'
      ,width: '520px'
      ,height:'280px' //设置容器宽度
      ,anim:"default"
      ,autoplay:true
      ,arrow:"hover"
      ,indicator:"inside"
    });
    carousel.render({
      elem:'#lunbo2'
      ,width: '520px'
      ,height:'201px' //设置容器宽度
      ,anim:"default"
      ,autoplay:true
      ,arrow:"hover"
      ,indicator:"inside"
    });
  });

  </script>



  </body>
</html>
