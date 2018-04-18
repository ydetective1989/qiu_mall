// 轮播图，功能完善
    var imgindex = 0 ;//定义一个图片和选择器下标
    //
    var div = document.getElementsByClassName("showbox")[0];
    var arrow = document.getElementsByClassName("arrow");
    var chose = document.getElementsByTagName("div")[3].getElementsByTagName("div");
    var choselen = chose.length;
    //自动轮播 考虑是否加入onload事件
    function automove(){//轮播图下标原点变换
      for(var i = 0 ; i < choselen ; i++){
        chose[i].className = "chose";
      }
      chose[imgindex].className = "chosed";
    }
    // 自动轮播创建
    var timer = setInterval("next()",1000);
    var timers = setInterval("automove()",1000);
    //自动轮播重新执行
    function automoveagin(){
    timer = setInterval("next()",1000);
    timers = setInterval("automove()",1000);
    }
    function stopmove(){
      clearInterval(timer);
      clearInterval(timers);
      timer = "";//timer值变为空
      timers = "";
    }

    function next(){
      div.style.left = parseInt(div.style.left) - 990 + "px";
      imgindex ++;
      for(var i = 0 ; i < choselen ; i++){
        chose[i].className = "chose";
      }
      if(parseInt(div.style.left) < - 3960){
        div.style.left = 0 + "px";
        imgindex = 0;
      }
      chose[imgindex].className = "chosed";
    }

    function previous(){
      div.style.left = parseInt(div.style.left) + 990 + "px";
      imgindex --;
      for(var i = 0 ; i < choselen ; i++){
        chose[i].className = "chose";
      }
      if(parseInt(div.style.left) > 0){
        div.style.left = - 3960 + "px";
        imgindex = choselen - 1;
      }
      chose[imgindex].className = "chosed";

    }
    //选择器


    //给轮播绑定事件
    div.addEventListener("mouseenter",stopmove,true);
    div.addEventListener("mouseleave",automoveagin,false);
    arrow[0].addEventListener("mouseover",stopmove,false);
    arrow[1].addEventListener("mouseover",stopmove,false);
    arrow[0].addEventListener("mouseleave",automoveagin,false);
    arrow[1].addEventListener("mouseleave",automoveagin,false);
    arrow[0].addEventListener("click",previous,false);
    arrow[1].addEventListener("click",next,false);
    //给选择器绑定事件，后续优化为addEventListener
    for(var i = 0 ; i < choselen; i ++ ){
      (function(s){
        chose[s].onclick = function(){
          for(var m = 0 ; m < choselen ; m ++){
            chose[m].className = "chose";
          }
          div.style.left = - s * 990 + "px";
          this.className = "chosed";
          imgindex = s ;
          }
      }(i));
    }
