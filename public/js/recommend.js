$(document).ready(function(){
  $("#edit-btn").click(function(){
    $(this).toggle();
    $("#finish-btn").toggle();
    $(".unedit-box").toggle();
    $(".edit-box").toggle();
    uploader.refresh();
  });

  $("#course").click(function(){
    location.href = window.set_recommend;
  });

  $("#announce").click(function(){
    location.href = window.img_index;
  });



});