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
	var wait = 60;
	var time = function(o) {
		$(o).attr("disabled", true);
		if (wait == 0) {
			$(o).attr("disabled", false);
			$(o).text('发送验证码');
		  wait = 60;
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
        mobile: mobile
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
        mobile: mobile,
        code: code
      },
      function(data) {
        console.log(data);
        if (data.success) {
          $("#mobileModal").modal("hide");
          $('#mobile-span').text(mobile);
        } else {
          // 需要修改
            showMsg('验证码错误', 'center');

          // if (data.message == "WRONG_VERIFY_CODE") {
          //   showMsg('验证码错误', 'center');
          // }
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
    $('#another-baby').show();
    $("#edit-end").show();
  });

  $("#another-baby").click(function(){
    add_baby = true;
    baby_dom = document.createElement("div");
    $(baby_dom).addClass("item").html($(".add-baby-div").html());
    $(baby_dom).insertBefore("#another-baby");
    $('#edit-end').show();
  });

  $(document).on('click', '.close-add-item', function(){
    $(this).closest('.item').hide();
    if (parent_edit === false && baby_edit === false && $('.item:visible').length == 2) {
      $('#edit-end').hide();
    }
  });

  $('#edit-end').click(function(){
    var baby_name = [];
    var gender = [];
    var birthday = [];
    if (parent_edit && baby_edit === false && add_baby === false) {
      var parenthood = $("#parent").val();
      var mobile = $("#mobile-span").text();
      var mobile_retval = $.regex.isMobile(mobile);
      if (mobile_retval === false) {
        showMsg("手机号不正确", 'center');
        return false;
      }
      console.log(parenthood);
      console.log(mobile);
      $.postJSON(
        window.user_profile,
        {
          parenthood: parenthood,
          mobile: mobile,
          _token: window.token 
        },
        function(data) {
          console.log(data);
          if (data.success) {
            parent_edit = false;
            $('#parent-span').show();
            $('#parent-span').text(parenthood);
            $('#parent').hide();
            $('#mobile-span').text(mobile);
            $('.replace').hide();
            // location.href = window.user_profile;
          }
        }
        );
    }
    if (baby_edit && parent_edit === false) {
      $('.baby-name:visible').each(function(i){
         baby_name[i] = $(this).val();
      });
      $('.gender:visible').each(function(i){
         gender[i] = $(this).val();
      });
      $('.birthday:visible').each(function(i){
         birthday[i] = $(this).val();
      });
      console.log(baby_name);
      console.log(gender);
      console.log(birthday);
      $.postJSON(
        url,  //只提交baby，未有数据时创建，有就更新
        {
          baby_name: baby_name,
          gender: gender,
          birthday: birthday
        },
        function(data) {
          if (data.success) {
            location.href = '';
          }
        }
        );
    }
    if (add_baby && baby_edit === false && parent_edit === false) {
      $('.baby-name:visible').each(function(i){
        baby_name[i] = $(this).val();
      });
      $('.gender:visible').each(function(i){
        gender[i] = $(this).val();
      });
      $('.birthday:visible').each(function(i){
        birthday[i] = $(this).val();
      });
      console.log(baby_name);
      console.log(gender);
      console.log(birthday);
      $.postJSON(
        url,  //只提交add-baby，只创建数据
        {
          baby_name: baby_name,
          gender: gender,
          birthday: birthday
        },
        function(data) {
          if (data.success) {
            location.href = '';
          }
        }
        );
    }
    if (parent_edit && baby_edit) {
      var parenthood = $("#parent").val();
      var mobile = $("#mobile-span").text();
      var mobile_retval = $.regex.isMobile(mobile);
      if (mobile_retval === false) {
        showMsg("手机号不正确", 'center');
        return false;
      }
      $('.baby-name:visible').each(function(i){
         baby_name[i] = $(this).val();
      });
      $('.gender:visible').each(function(i){
         gender[i] = $(this).val();
      });
      $('.birthday:visible').each(function(i){
         birthday[i] = $(this).val();
      });
      console.log(parenthood);
      console.log(mobile);
      console.log(baby_name);
      console.log(gender);
      console.log(birthday);
      $.postJSON(
        url,   // 提交parent and baby，未有数据时创建，有就更新
        {
          parenthood: parenthood,
          mobile: mobile,
          baby_name: baby_name,
          gender: gender,
          birthday: birthday
        },
        function(data) {
          if (data.success) {
            location.href = '';
          }
        }
        );
    }
  });
  
	
});