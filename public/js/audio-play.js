$(document).ready(function(){
  var pictures = [];
  var pic_item = {};
  $(".picture-item").each(function(){
    var pic = $(this).find(".picture").text();
    var pic_time = $(this).find(".picture-time").text();
    pic_item = {
      src: pic,
      time: parseInt(pic_time)
    };
    pictures.push(pic_item);
  });
  console.log(pictures);

  var timer = null;
  var audio = document.querySelector("#audio");
  audio.addEventListener("play", function(){
    timer = setInterval(function(){
      var current_time = Math.ceil(audio.currentTime);
      var len = pictures.length;
      for(let i=0; i<len;i++){
        if(pictures[i].time <= current_time && current_time < pictures[i+1].time){
          $(".audio-poster").attr("src", pictures[i].src);
        }
      }
    }, 1000);
    var $audio_div = $(".audio-div");
    var $div = $('<div>').addClass('barrage');
    $(".feed-review-items-div .review-content").each(function(){
      var comment_content = $(this).text();
      var $span = $("<span>");
      if(comment_content.length <= 15){
        $span.addClass('comment-span').text(comment_content);
      }
      $div.append($span);
    });
    $audio_div.append($div).css('overflow', 'hidden');
    $div.animate({left: '-' + $div.width() + 'px'}, 10000, 'linear').queue(function (next) {
      $(this).hide() ;
      next();
    });
  });

  audio.addEventListener("pause", function(){
    clearInterval(timer);
  });
});