$(document).ready(function(){

  
  //autoload.js自动加载写法
  // $('.wrapper').dropload({
  //     scrollArea : window,
  //     // autoLoad: false,
  //     loadDownFn: function(me){
  //         page++;
  //         // 拼接HTML
  //         var isSearchByInput=location.href.indexOf('key')>0;
  //         var currenturl = location.pathname+(isSearchByInput ? '?'+location.search.match(/key=([^&]*)/)[0]:'');
  //         $.ajax({
  //             type: 'GET',
  //             url: currenturl + (isSearchByInput?"&":"?")+"page=" + page,
  //             dataType: 'json',
  //             success: function(data){
  //                 console.log(data);
  //                 var arrLen = data.data.length;
  //                 if(arrLen > 0){
  //                   callbackHandle(data);
  //                 }else{
  //                     // 锁定
  //                     me.lock();
  //                     // 无数据
  //                     me.noData();
  //                 }
  //                 me.resetload();
  //             },
  //             error: function(xhr, type){
  //                 // alert('Ajax error!');
  //                 // 即使加载出错，也得重置
  //                 showMsg("服务器返回数据错误", "center");
  //                 me.resetload();
  //             }
  //         });
  //     }
  // });

  var node = "";
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
  function  callbackHandle(data){
    for(var i=0;i<data.data.length;i++){
      node=render(data.data[i]);
      if(node.find('.category-class').text() ==  "健康养育"){
        node.find('.category-class').addClass('health-title');
      }else if(node.find('.category-class').text() ==  "心理教育"){
        node.find('.category-class').addClass('psychology-title');
      }else{
        node.find('.category-class').addClass('grow-title');
      }
      // node.appendTo($('.course-item-div'));
      node.insertBefore($(".load"));
    }
  }
  
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
    template.find('.course-item-value').text(item['price'] ? "￥" + item['price'] : "￥" + item['original_price']);
    if(item['name'].length > 13){
      var name = item['name'].substr(0, 13) + "...";
      template.find('.we-course-name').text(name);
    }else{
      template.find('.we-course-name').text(item['name']);
    }
    
    return template.clone(true);
  }


  var page = 2;
  var isSearchByInput=location.href.indexOf('key')>0;
  var currenturl = location.pathname+(isSearchByInput ? '?'+location.search.match(/key=([^&]*)/)[0]:'');
  var loading = false;
  $(window).scroll(function(){
    var scrollTop = $(this).scrollTop();
    var scrollHeight = document.documentElement.scrollTop==0? document.body.scrollHeight : document.documentElement.scrollHeight;
    var windowheight = $(this).height();
    if(scrollTop + windowheight >= scrollHeight){
      $(".loading").show();
      if(!loading){
        alert(2);
        loading = true;
        $.ajax({
          type: 'get',
          url: currenturl + (isSearchByInput?"&":"?")+"page=" + page,
          success: function(data){
            var lastpage = data.last_page;
            $(".loading").hide();
            var len = data.data.length;
            if(len > 0 && page <= lastpage){
              page++;
              callbackHandle(data);
            }else{
              $(".notice").show();
            }
            loading = false;
          }
        });
      }
    }
  });
});


