$(document).ready(function(){

  var page = 0;
  // 每页展示5个
  var size = 10;
  // dropload
  $('.wrapper').dropload({
      scrollArea : window,
      // autoLoad: false,
      loadDownFn : function(me){
          page++;
          // 拼接HTML
          var node = "";
          var currenturl = location.pathname+'?'+location.search.match(/key=([^&]*)/)[0];
          $.ajax({
              type: 'GET',
              url: currenturl + "&page=" + page,
              dataType: 'json',
              success: function(data){
                  console.log(data);
                  var arrLen = data.data.length;
                  if(arrLen > 0){
                    for(var i=0;i<data.data.length;i++){
                      node = render(data.data[i]);
                      node.appendTo($('.course-item-div'));
                    }
                    // callbackHandle(data[0]);

                  }else{
                      // 锁定
                      me.lock();
                      // 无数据
                      me.noData();
                  }
                  me.resetload();
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
           <img class="course-icon" src="storage/a.png">
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
  //   for(var i=0;i<data.data.length;i++){
  //     var node=render(data.data[i]);
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
    template.find('.course-icon').attr('src', item['cover'] ? item['cover'] : "icon/example.png");
    template.find('.category-class').text(item['category']['name']);
    template.find('.course-item-value').text("￥" + item['price']);
    template.find('.we-course-name').text(item['name']);
    return template;
  }


});


