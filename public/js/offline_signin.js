$(document).ready(function(){
  $("#course-show").click(function(){
    location.href = window.course_show;
  });

  $("#register").click(function(){
    location.href = window.offline_student;
  });

  $(".select-style").change(function(){
    var num = $(this).val();
    var cid = $(".course-id").text();
    var qr_src = window.qrcode.replace(/0/, cid).replace(/-1/, num);
    if (num == "-1"){
      $(".code-figure").attr("src", "icon/admin/bigqrcode.png");
    }else{
      $(".code-figure").attr("src", qr_src);
    }
  });

});