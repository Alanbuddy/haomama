$(document).ready(function(){

  $("#imghead").mouseover(function() {
    $(".figure").show();
  });
  $(".figure").mouseout(function() {
    $(".figure").hide();
  });

  $(".figure").click(function(){
    $("#imghead").trigger("click");
  });

  $("#finish").click(function(){
  	var avatar = $("#imghead").attr("src");
    var name = $("#user_name").val().trim();
    $.postJSON(
      window.account_set,
      {
        avatar: avatar,
        name: name,
        _token: window.token
      },
      function(data){
        if(data.success){
          location.href = window.account_set;
        }
      }
      );
  });

	function account_set_remind(event){
    var name = $("#user_name").val().trim();
    if(name != ""){
      event.preventDefault();
      $("#setModal").modal("show");
    }
    return false;
  }

  var sidebar = document.getElementsByClassName("sidebar");
  var arr_a = sidebar[0].getElementsByTagName("a");
  var len = arr_a.length;
  var unset = true;    //有了数据后从页面数据获得
  for(var i=0;i<len;i++){
    if(unset){
      arr_a[i].addEventListener("click", account_set_remind);
    }else{
      arr_a[i].removeEventListener("click", account_set_remind);
    }
  }

  $("#set-cancel").click(function(){
  	$("#setModal").modal("hide");
  });
  
});
