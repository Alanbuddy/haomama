$(document).ready(function(){

  $(".status").each(function(){
    if($(this).text() == "enabled"){
      $(this).text("开通");
    }else{
      $(this).text("关闭");
    }
  });
});