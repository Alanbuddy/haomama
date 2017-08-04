$(document).ready(function(){
  $(".review-operation").click(function(){
    var put = "PUT";
    var rid = $(this).closest(".review-items").find(".review-id").text();
    var validity = $(this).closest('.review-items').find(".validity").text();
    validity=1-parseInt(validity);
    var _this = $(this);
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
          if(_this.text() == "显示评论"){
            _this.closest('.review-items').find(".validity").text(validity);
            _this.closest('.review-items').find(".review-operation").removeClass('finish-normal').addClass('edit-normal').text("隐藏评论");
          }else{
            _this.closest('.review-items').find(".validity").text(validity);
            _this.closest('.review-items').find(".review-operation").removeClass('edit-normal').addClass('finish-normal').text("显示评论");
          }
        }
      }
    });
  });
});