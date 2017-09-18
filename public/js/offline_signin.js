$(document).ready(function(){
  $("#course-show").click(function(){
    location.href = window.course_show;
  });

  $("#register").click(function(){
    location.href = window.offline_student;
  });

  var temp = `<div class="sign-data" id="test333">test333</div>`;
  var template = $(temp);

  $(".select-style").change(function(){
    var num = $(this).val();
    var cid = $(".course-id").text();
    var qr_src = window.qrcode.replace(/0/, cid).replace(/-1/, num);
    if (num == "-1"){
      $(".code-figure").attr("src", "icon/admin/bigqrcode.png");
    }else{
      $(".code-figure").attr("src", qr_src);
      var link_url = window.sign_people + "?index=" + (parseInt(num) + 1);
      $.ajax({
        type: 'get',
        url: link_url,
        success: function(data){
          console.log(data.length);
          if(data.length > 0){
            for(var i=0;i<data.length;i++){
              
            }
          }
        }
      });
    }

  });

});