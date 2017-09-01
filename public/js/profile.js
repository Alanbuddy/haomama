$(document).ready(function($) {
  $(".replace").click(function(){
      $("#mobileModal").modal("show");
    });

  // $('#mobileModal').on('hidden.bs.modal', function(){
  //   if (timer != null) {
  //     clearTimeout(timer);
  //     $('#code').text('发送验证码');
  //     wait = 60;
  //   }
  // });
	var timer = null;
	var wait = 120;
	var time = function(o) {
		$(o).attr("disabled", true);
		if (wait == 0) {
			$(o).attr("disabled", false);
			$(o).text('发送验证码');
		  wait = 120;
		} else {
			$(o).text('重发(' + wait + ')');
			wait--;
			timer = setTimeout(function(){
				time(o);
			}, 1000);
		}
		return false;
	};

	$("#code").click(function(){
	  var mobile = $("#mobile").val();
	  var mobile_retval = $.regex.isMobile(mobile);
	  if (mobile_retval === false) {
	    showMsg("手机号不正确", 'center');
	    return false;
	  }
    $.getJSON(
      window.sms_send,
      {
        phone: mobile
      },
      function(data){
        console.log(data);
        if (data.success){
          if (timer !== null) {
            clearTimeout(timer);
          }
          time('#code');
        }
      }
    );
    return false;
	});

  $('#confirm-replace').click(function(){
    var mobile = $('#mobile').val();
    var mobile_retval = $.regex.isMobile(mobile);
    var code = $('.verify-code').val();
    if (mobile_retval === false) {
      showMsg("手机号不正确", 'center');
      return false;
    }
    if (code == "") {
      showMsg('验证码未填写', 'center');
      return false;
    }
    $.getJSON(
      window.sms_verify,
      {
        phone: mobile,
        code: code
      },
      function(data) {
        console.log(data);
        if (data.success) {
          $("#mobileModal").modal("hide");
          $('#mobile-span').text(mobile);
          if($(".replace").text() == "添加"){
            $(".replace").text("更换");
          }
        } else {
          showMsg('验证码错误', 'center');
        }
      }
      );
    return false;
  });

  var parent_edit = false;
  var baby_edit = false;
  var add_baby = false;
  $('#parent-edit').click(function(){
    parent_edit = true;
    $(this).hide();
    var parent = $(this).closest(".right-div");
    var span = parent.find("span");
    var select = parent.find("select");
    var replace = parent.find(".replace");
    span.toggle();
    select.toggle();
    replace.toggle();
    $('#edit-end').show();
  });

  $('.edit').click(function(){
    baby_edit = true;
    $(this).hide();
    var parent = $(this).closest(".right-div");
    var span = parent.find("span");
    var input = parent.find("input");
    var select = parent.find("select");
    span.toggle();
    input.toggle();
    select.toggle();
    $("#edit-end").show();
  });

  $("#another-baby").click(function(){
    add_baby = true;
    baby_dom = document.createElement("div");
    $(baby_dom).addClass("baby-item").html($(".add-baby-div").html());
    $(baby_dom).insertBefore("#another-baby");
    $('#edit-end').show();
  });

  $(document).on('click', '.close-add-item', function(){
    $(this).closest('.baby-item').hide();
    if (parent_edit === false && baby_edit === false && $('.baby-item:visible').length == 1) {
      $('#edit-end').hide();
    }
  });

  $('#edit-end').click(function(){
    var baby = [];
    var name = [];
    var gender = [];
    var birthday = [];
    var parenthood = null;
    var mobile = $("#mobile-span").text();
    var mobile_retval = $.regex.isMobile(mobile);
    if (parent_edit) {
      parenthood = $("#parent").val();
    } else {
      parenthood = $("#parent-span").text();
    }
    if (mobile_retval === false) {
      showMsg("手机号不正确", 'center');
      return false;
    }
    console.log(parenthood);
    console.log(mobile);
    $(".baby-item:visible").each(function(i){
      name[i] = $(this).find(".baby-name:visible").val() || $(this).find(".name-span").text();
      gender[i] = $(this).find(".gender:visible").val() || $(this).find(".gender-span").text();
      birthday[i] = $(this).find(".birthday:visible").val() || $(this).find(".birthday-span").text();
      baby[i] = {
        name: name[i],
        gender: gender[i],
        birthday: birthday[i]
      };
    });
    console.log(baby);
    $.postJSON(
      window.user_profile,
      {
        parenthood: parenthood,
        phone: mobile,
        baby: JSON.stringify(baby),
        _token: window.token 
      },
      function(data) {
        console.log(data);
        if (data.success) {
         location.href = window.user_profile;
        }
      }
      );
  });
});