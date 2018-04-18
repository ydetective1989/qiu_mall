function editlists()
{
	$("#editbtn").attr("value","正在提交...");			//锁定按钮
	$("#editbtn").attr("disabled","disabled");			//锁定按钮
	$("#editlist").submit();
}

  
  function editinfo()
{
  var reg = new RegExp("^[0-9]{1,2}[a-zA-Z]{2,10}$");
//^[a-z]{1,2}[0-9]{2,8}$

  var code = $("#code").val();
  if(code==""){ tipmsg("描述编码不能为空，请检查"); return; }
  // alert(reg.test(code));
  if(!reg.test(code)){ tipmsg("请输入正确格式的描述编码"); return; }

  var detail = $("#detail").val();
  if(detail==""){ tipmsg("描述用语不能为空，请检查"); return; }
 
  $("#editbtn").attr("value","正在提交...");    //锁定按钮
  $("#editbtn").attr("disabled","disabled");    //锁定按钮
  $("#editfrm").submit();
}

function userslock()
{
	var disabled = $("#username").attr("disabled");
	if(disabled=="disabled"){
	  　　$('#username').removeAttr("disabled");//去除input元素的disabled属性
	}else{
		 $('#username').attr("disabled","disabled")//将input元素设置为disabled
	}
}

function grouped(userid,groupid)
{
	//alert(S_ROOT);
	$("#levelspace").load(S_ROOT+"system/users?do=level&userid="+userid+"&groupid="+groupid+"&"+Math.random());
}

function del(id)
{
    if(!confirm('确定要删除吗？\n一旦删除，不可恢复！')){
      return false;
    }else{
      $.ajax({
        url: S_ROOT+"system/fastadm?do=del",
        type: 'get',
        dataType: 'json',
        data: 'id='+id,
        success:function(data){
          alert(data.mes);
          if(data.state==200){
              var url = data.url;
              window.location.href = url;              
          }
        }
      });
  
      
    }
  }