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
  
  var timer = null;
  var audio = document.querySelector("#audio");
  audio.addEventListener("play", function(){
    timer = setInterval(function(){
      $(".audio-poster").attr("src", "icon/banner.png");
    }, 1000);
  });
});