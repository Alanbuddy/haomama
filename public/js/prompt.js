
$(document).ready(function($){
  function check_status(){
    var enroll = window.enroll;
    var img = $("<img class='free-icon' src= 'icon/free.png'>");
    $(".nums-div a:eq(0)").find("span").before(img);
    if (!enroll) {
      $(".nums-div a:eq(0)").addClass("red-border");
      $(".nums-div a:gt(0)").addClass("unopen").click(function(e){
         e.preventDefault();
         $("#confirmModal").modal("show");
      });
    } else {
      $(".nums-div a").each(function(){
        var status = $(this).attr("data-status");
        var  an = $(this);
        if (status != "publish") {
          an.addClass('unopen');
        }
      });
    }
    $(".nums-div a").each(function(){
      var newest = $(this).attr("data-newest");
      var new_img = $("<img class='new-icon' src= 'icon/new.png'>");
      if (newest == true) {
        $(this).find("span").before(new_img);
      }
    });
  }
	check_status();

	$("#confirmModal").on("touchmove", function(event){
		event.preventDefault();
	});

  //需要与后台商量 决定提交lesson-id 还是course-id
  var order = null;
  var signPackage = null;
  var lid = $(".lesson-id").attr("data-id");
  $("#register").click(function(){
    $.ajax({
      url: window.order,
      type: 'post',
      data: {
          lesson_id: lid,
          _token: window.token,
      },
      success: function (resp) {
          // alert(JSON.stringify(resp));
          if(resp.success){
            $("#confirmModal").modal("hide");
          }
          signPackage = resp.data;
          order=resp.data.order;
          jsBrage();
      }
    });
  });

  $("#delivery").click(function(){
    var content = $(".review-input").val();
    var course_id = $(".course-id").attr("data-id");
    var lesson_id = $(".lesson-id").attr("data-id");
    console.log(content);
    console.log(course_id);
    console.log(lesson_id);
    $.postJSON(
      window.comment,
      {
        content: content,
        course_id: course_id,
        lesson_id: lesson_id,
        _token: window.token
      },
      function(data){
        console.log(data);
        if (data.success){
          $(".review-input").val("");
          showMsg("评论完成", "center");
        }
      }
    );
  });

});
