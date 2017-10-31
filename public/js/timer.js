$(document).ready(function(){
  $("#code").click(function(){
    var mobile = $("#mobile").val();
    var mobile_retval = $.regex.isMobile(mobile);
    if (mobile_retval === false) {
      showMsg("手机号不正确", 'center');
      return false;
    }
    time("#code");
  });
// $("#code").click ->
//   mobile = $("#mobile").val()
//   alert('aaaaaa')
//   mobile_retval = $.regex.isMobile(mobile)
//   if mobile_retval == false
//     $.mobile_page_notification("手机号不正确", 1000)
//     return false
//   $.postJSON(
//     url,
//     {
//       mobile: mobile
//       captcha: captcha
//     },
//     (data) ->
//       if data.success
//         uid = data.uid
//         if timer != null
//           clearTimeout(timer)
//         time("#code")
//       #需要修改
//       else
        
//   )
//   return false
});