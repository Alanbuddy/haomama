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

  $("#edit-btn").click(function(){
    $(this).toggle();
    $("#finish-btn").toggle();
    $(".edit-box").show();
    $(".unedit-box").hide();
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

  $("#finish-btn").click(function(){
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

  var click_url = null;
	function account_set_remind(event){
    var name = $("#user_name").val().trim();
    if(name != ""){
      click_url = event.currentTarget.href;
      event.preventDefault();
      $("#setModal").modal("show");
    }
    return false;
  }

  var sidebar = document.getElementsByClassName("sidebar");
  var arr_a = sidebar[0].getElementsByTagName("a");
  var len = arr_a.length;
  for(var i=0;i<len;i++){
    arr_a[i].addEventListener("click", account_set_remind);
    $("#set-confirm").click(function(){
      location.href = click_url;
    });
  }

  $("#set-cancel").click(function(){
  	$("#setModal").modal("hide");
  });
  
});
