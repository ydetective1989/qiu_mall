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
