$(document).ready(function(){
  $("#course-show").click(function(){
    location.href = window.course_show;
  });

  $("#register").click(function(){
    location.href = window.offline_student;
  });

  var node = "";
  var temp = `<div class="sign-data"></div>`;
  var template = $(temp);
  function render(item){
    template.attr("data-id", item['id']);
    template.attr("data-sign", item['hasAttended']);
    template.text(item['name']);
    return template.clone(true);
  }
  $(".select-style").change(function(){
    var num = $(this).val();
    var cid = $(".course-id").text();
    var qr_src = window.qrcode.replace(/0/, cid).replace(/-1/, num);
    if (num == "-1"){
      $(".code-figure").attr("src", "icon/admin/bigqrcode.png");
    }else{
      $(".code-figure").attr("src", qr_src);
      $(".sign-data").remove(); 
      var link_url = window.sign_people + "?index=" + (parseInt(num) + 1);
      $.ajax({
        type: 'get',
        url: link_url,
        success: function(data){
          if(data.length > 0){
            for(var i=0;i<data.length;i++){
              node = render(data[i]);
              if(node.attr("data-sign") == "true"){
                node.addClass('check-in');
              }
              node.appendTo($("#sign-table"));
            }
          }
        }
      });
    }

  });

});