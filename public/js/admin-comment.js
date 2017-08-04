$(document).ready(function(){
  $(".review-operation").click(function(){
    var put = "PUT";
    var rid = $(this).closest(".review-items").find(".review-id").text();
    var validity = $(this).closest('.review-items').find(".validity").text();
    $.ajax({
      url: window.review.replace(/-1/, rid),
      type: 'post',
      data: {
        _token: window.token,
        validity: validity,
        _method: put
      },
      success: function(data){
        if(data.success){
          if($(".review-operation").text() == "显示评论")
            $(".review-operation").removeClass('finish-normal').addClass('edit-normal').text("隐藏评论");
          else{
            $(".review-operation").removeClass('edit-normal').addClass('finish-normal').text("显示评论");
          }
        }
      }
    });
  });
});