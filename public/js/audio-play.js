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
        if(current_time == pictures[i].time){
          $(".audio-poster").attr("src", pictures[i].src);
        }
      }
    }, 1000);
  });

  audio.addEventListener("pause", function(){
    clearInterval(timer);
  });
});