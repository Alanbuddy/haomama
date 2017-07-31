$(document).ready(function(){

  $(".status").each(function(){
    if($(this).text() == "enabled"){
      $(this).text("正常");
    }else if($(this).text() == "disabled"){
      $(this).text("关闭");
    }
  });

  
  $(".operation").click(function(){
    var uid = $(this).closest("td").attr("data-id");
    _this = $(this);
    if($(this).text() == "关闭"){
      $.ajax({
        url: window.enable.replace(/-1/, uid),
        type: "get",
        success: function(data){
          console.log(data);
          if(data.success){
            _this.text("开通");
            _this.removeClass("available");
            _this.addClass("unavailable");
            _this.closest("td").siblings('.status').text("关闭");
          }
        }
      });
    }
    if($(this).text() == "开通"){
      $.ajax({
        url: window.disable.replace(/-1/, uid),
        type: "get",
        success: function(data){
          console.log(data);
          if(data.success){
            _this.text("关闭");
            _this.removeClass("unavailable");
            _this.addClass("available");
            _this.closest("td").siblings('.status').text("正常");
          }
        }
      });
    }  
  });


  $(".delete-tr").click(function(){
    var uid = $(this).closest('td').siblings('.open-close').attr("data-id");
    console.log(uid);
    _this = $(this);
    $.ajax({
      url: window.delete.replace(/-1/, uid),
      type: 'get',
      success: function(data){
        console.log(data);
        if(data.success){
          _this.closest('tr').remove();
        }
      }
    });
  });
});