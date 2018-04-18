//页面弹出框模块
function layer(){
  // var btn = document.getElementsByClassName("btn")[0].getElementsByTagName("a")[0];
  var laybox = document.getElementsByClassName("laybox")[0];
  var hidebox = document.getElementsByClassName("hidebox")[0];
    laybox.style.display = "block";
    hidebox.style.display = "block";
}
function upfile(){
  var form = document.getElementsByTagName("form")[0];
  var formData = new FormData(form);
  var laybox = document.getElementsByClassName("laybox")[0];
  var hidebox = document.getElementsByClassName("hidebox")[0];
  var file = document.getElementsByClassName("laybox")[0].getElementsByTagName("input")[0].value;
  var filename = document.getElementsByClassName("laybox")[0].getElementsByTagName("input")[1].value;
  var nav = document.getElementsByClassName("nav-top")[0];
    $.ajax({
    type:"POST",
    url:"upload_file.php",
    processData: false,
    data:formData,
    contentType: false,
    success:function(da){
      alert(da);
        nav.style.backgroundImage = "url(" + da + ")";
        // nav.innerHTML = data;
        laybox.style.display = "none";
        hidebox.style.display = "none";
    }
  });
}
