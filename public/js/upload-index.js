$(document).ready(function(){
  $(document).on('click', '.course-item', function(){
    var cid = $(this).attr('data-id');
    location.href = window.course_item + "/" +cid;
  });
    
 
  var temp=`<div class="course-item">
    <div class="course-icon-div">
           <img class="course-recommend" src="icon/recommend.png">
           <img class="course-icon" src="storage/a.png">
    </div>
    <div class="word-div">
      <div class="course-row-div clearfix">
        <span class="f12 category-class">健康养育</span>
        <span class="course-item-value f14 color5">￥32</span>
      </div>
      <div class="course-row-div color7 unstart">
        <span class="we-course-name f16">VlAxqQY</span>
        <span class="course-status f8">线下</span>
       </div>
      <div class="course-row-div f12 color6">
          <span class="participate">人已报名</span>
          <span>.</span>
          <span extra>07月/24日开课</span>
      </div>
    </div>
  </div>`;
  
  var template=$(temp);
  
  function render(item){
    template.attr("data-id", item['id']);
    template.find('.course-recommend').remove();
    if(item['type'] == 'offline'){
      var date = new Date(item['begin']);
      var d = date.getDate();
      if(d<10){
        d="0" + d;
      }
      var m = date.getMonth() +1;
      if(m<10){
        m = "0" + m;
      }
      template.find('[extra]').text(m + "月" + d +"日开课");
      template.find('.course-status').show();
    }else{
      template.find('.course-status').hide();
      template.find('[extra]').text(item['comments_count'] +"条评论");
    }
    template.find('.participate').text(item['users_count']+(item['type'] == 'offline' ?'人已报名':'人已学'));
    template.find('.course-icon').attr('src', item['cover'] ? item['cover'] : "icon/example.png");
    template.find('.category-class').text(item['category']['name']);
    template.find('.course-item-value').text(item['price'] ? "￥" + item['price'] : "无");
    template.find('.we-course-name').text(item['name']);
    return template.clone(true);
  }

  var page = 2;
  $(".wrapper").scroll(function(){
    var category_id = $(".list-div:visible").find(".category_id").text();
    var tab_word = ["time", "hot", "rate"];
    var index = $(".list-div:visible").find(".course-item-div:visible").index();
    var scrollTop = $(this).scrollTop();
    var scrollHeight = document.querySelector(".wrapper").scrollHeight;
    var windowheight = $(this).height();
    if(scrollTop + windowheight >= scrollHeight){
      $(".list-div:visible").find('.course-item-div:visible').find(".loading").show();
      $.ajax({
        type: 'get',
        url: window.load_bottom.replace(/-1/, category_id) + "?page=" + page + "&orderBy=" + tab_word[index - 1],
        success: function(data){
          console.log(data);
          $(".list-div:visible").find('.course-item-div:visible').find(".loading").hide();
          var len = data[0].data.length;
          if(len > 0){
            page++;
            for(var i=0;i<data[0].data.length;i++){
              var node=render(data[0].data[i]);
              if(node.find('.category-class').text() ==  "健康养育"){
                node.find('.category-class').addClass('health-title');
              }else if(node.find('.category-class').text() ==  "心理教育"){
                node.find('.category-class').addClass('psychology-title');
              }else{
                node.find('.category-class').addClass('grow-title');
              }
              node.insertBefore($(".list-div:visible").find(".course-item-div:visible").find(".load"));
            }
          }else{
             $(".list-div:visible").find('.course-item-div:visible').find(".notice").show();
          }
        }
      });
    }
  });
  
});