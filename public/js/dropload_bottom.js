$(document).ready(function(){

  var page = 1;
  // 每页展示5个
  var size = 10;
  // dropload
  $('.swiper-slide').dropload({
      scrollArea : window,
      // autoLoad: false,
      loadDownFn : function(me){
          page++;
          console.log(1111111111111111111111);
          // 拼接HTML
          var result = '';
          var category_id = $(".swiper-slide-active>.category_id").text();
          console.log(category_id);
          var node = "";
          $.ajax({
              type: 'GET',
              url: window.load_bottom.substring(0, window.load_bottom.length - 2) + 0+ "?page=" + page ,
              dataType: 'json',
              success: function(data){
                  console.log(data);
                  var arrLen = data[0].data.length;
                  if(arrLen > 0){
                    for(var i=0;i<data[0].length;i++){
                      node=render(data[0][i]);
                      node.appendTo($('.swiper-slide-active .course-item-div'));
                      me.resetload();
                      
                    }
                    // callbackHandle(data[0]);

                  }else{
                      // 锁定
                      me.lock();
                      // 无数据
                      me.noData();
                  }
                  
              },
              error: function(xhr, type){
                  alert('Ajax error!');
                  // 即使加载出错，也得重置
                  me.resetload();
              }
          });
      }
  });

  var temp=`<div class="course-item" data-id="12">
    <div class="course-icon-div">
           <img class="course-recommend" src="icon/recommend.png">
           <img class="course-icon" src="/storage/a.png">
    </div>
    <div class="word-div">
      <div class="course-row-div clearfix">
        <span class="f12 category-class grow-title">健康养育</span>
        <span class="course-item-value f14 color5">￥32</span>
      </div>
      <div class="course-row-div color7 unstart">
        <span class="course-name f16">VlAxqQY</span>
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
  // function  callbackHandle(data){
  //   for(var i=0;i<data.length;i++){
  //     var node=render(data[i]);
  //     node.appendTo('.course-item-div');
  //   }
  // }
  function render(item){
    template.find('.course-recommend').remove();
    if(item['type'] == 'offline'){
      template.find('[extra]').text(item['comments_count'] +"条评论");
    }else{
      template.find('.course-status').remove();
      template.find('[extra]').text(item['comments_count'] +"开课");
    }
    template.find('.participate').text(item['users_count']+(item['type'] == 'offline' ?'人已报名':'人已学'));
    template.find('.course-icon').attr('src', item['cover'] ? substr(item['cover'],1) : "icon/example.png");
    template.find('.category-class').text(item['category']['name']);
    template.find('.course-item-value').text(item['price']);
    template.find('.we-course-name').text(item['name']);
    return template;
  }


});


