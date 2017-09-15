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
          <span extra>07月24日开课</span>
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
    if(item['name'].length > 12){
      var name = item['name'].substr(0, 12) + "...";
      template.find('.we-course-name').text(name);
    }else{
      template.find('.we-course-name').text(item['name']);
    }
    return template.clone(true);
  }

  
  $(".nav li").click(function(){
    i = $(this).index();
    $(".nav li").removeClass('active');
    $(this).addClass('active');
    $(".list-div").css("display", "none");
    $(".list-div").eq(i).css("display", "block");
    $(".list-div").eq(i).find(".course-nav span").click(function(){
      $(".list-div").eq(i).find(".course-nav span").removeClass('course-active');
      $(this).addClass('course-active');
      $(".list-div").eq(i).find(".course-item-div").css('display', 'none');
      $(".list-div").eq(i).find(".course-item-div").eq($(this).index()).css('display', 'block');
    });
  });
    
  
  $(".list-div").eq(0).find(".course-nav span").click(function(){
    $(".list-div").eq(0).find(".course-nav span").removeClass('course-active');
    $(this).addClass('course-active');
    $(".list-div").eq(0).find(".course-item-div").css('display', 'none');
    $(".list-div").eq(0).find(".course-item-div").eq($(this).index()).css('display', 'block');
  });
  
  // if(/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)){
  //   $(".wrapper").on("touchmove" , function(){
  //     var category_id = $(".list-div:visible").find(".category_id").text();
  //     var tab_word = ["time", "hot", "rate"];
  //     var index = $(".list-div:visible").find(".course-item-div:visible").index();
  //     var scrollTop = $(this).scrollTop();
  //     var scrollHeight = $(".object-wrap").height();
  //     var windowheight = $(this).height();
  //     var page = $(".list-div:visible").find(".course-active").attr("data-page");
  //     var lastpage = null;
  //     if(scrollTop + windowheight >= scrollHeight){
  //       if(lastpage != page){
  //         lastpage = page;
  //         $(".list-div:visible").find('.course-item-div:visible').find(".loading").show();
  //         $.ajax({
  //           type: 'get',
  //           url: window.load_bottom.replace(/-1/, category_id) + "?page=" + page + "&orderBy=" + tab_word[index - 1],
  //           success: function(data){
  //             // console.log(data);
  //             $(".list-div:visible").find('.course-item-div:visible').find(".loading").hide();
  //             var len = data[0].data.length;
  //             if(len > 0){
  //               page++;
  //               for(var i=0;i<data[0].data.length;i++){
  //                 var node=render(data[0].data[i]);
  //                 if(node.find('.category-class').text() ==  "健康养育"){
  //                   node.find('.category-class').addClass('health-title');
  //                 }else if(node.find('.category-class').text() ==  "心理教育"){
  //                   node.find('.category-class').addClass('psychology-title');
  //                 }else{
  //                   node.find('.category-class').addClass('grow-title');
  //                 }
  //                 node.insertBefore($(".list-div:visible").find(".course-item-div:visible").find(".load"));
  //                 $(".list-div:visible").find(".course-active").attr("data-page", page);
  //               }
  //             }else{
  //               $(".list-div:visible").find('.course-item-div:visible').find(".notice").show();
  //             }
  //           },
  //           error: function(e){
  //             lastpage = lastpage - 1;
  //           }
  //         });
  //       }
        
  //     }
  //   });
  // }
  // if(/(Android)/i.test(navigator.userAgent)){
  //   $(".wrapper").scroll(function(){
  //     var category_id = $(".list-div:visible").find(".category_id").text();
  //     var tab_word = ["time", "hot", "rate"];
  //     var index = $(".list-div:visible").find(".course-item-div:visible").index();
  //     var scrollTop = $(this).scrollTop();
  //     var scrollHeight = $(".object-wrap").height();
  //     var windowheight = $(this).height();
  //     var page = $(".list-div:visible").find(".course-active").attr("data-page");
  //     var lastpage = null;
  //     if(scrollTop + windowheight >= scrollHeight){
  //       if(lastpage != page){
  //         lastpage = page;
  //         $(".list-div:visible").find('.course-item-div:visible').find(".loading").show();
  //         $.ajax({
  //           type: 'get',
  //           url: window.load_bottom.replace(/-1/, category_id) + "?page=" + page + "&orderBy=" + tab_word[index - 1],
  //           success: function(data){
  //             // console.log(data);
  //             $(".list-div:visible").find('.course-item-div:visible').find(".loading").hide();
  //             var len = data[0].data.length;
  //             if(len > 0){
  //               page++;
  //               for(var i=0;i<data[0].data.length;i++){
  //                 var node=render(data[0].data[i]);
  //                 if(node.find('.category-class').text() ==  "健康养育"){
  //                   node.find('.category-class').addClass('health-title');
  //                 }else if(node.find('.category-class').text() ==  "心理教育"){
  //                   node.find('.category-class').addClass('psychology-title');
  //                 }else{
  //                   node.find('.category-class').addClass('grow-title');
  //                 }
  //                 node.insertBefore($(".list-div:visible").find(".course-item-div:visible").find(".load"));
  //                 $(".list-div:visible").find(".course-active").attr("data-page", page);
  //               }
  //             }else{
  //               $(".list-div:visible").find('.course-item-div:visible').find(".notice").show();
  //             }
  //           },
  //           error: function(e){
  //             lastpage = lastpage - 1;
  //           }
  //         });
  //       }
  //     }
  //   });
  // }
  var loading=false;
  
  $(".wrapper").scroll(function(){
    var category_id = $(".list-div:visible").find(".category_id").text();
    var tab_word = ["time", "hot", "rate"];
    var index = $(".list-div:visible").find(".course-item-div:visible").index();
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(".object-wrap").height();
    var windowheight = $(this).height();
    var page = $(".list-div:visible").find(".course-active").attr("data-page");
    if(scrollTop + windowheight >= scrollHeight){
      $(".list-div:visible").find('.course-item-div:visible').find(".loading").show();
      if(!loading){
          loading=true;
          $.ajax({
            type: 'get',
            url: window.load_bottom.replace(/-1/, category_id) + "?page=" + page + "&orderBy=" + tab_word[index - 1],
            success: function(data){
              console.log(data);
              var lastpage = data[0].last_page;
              console.log(lastpage);
              $(".list-div:visible").find('.course-item-div:visible').find(".loading").hide();
              var len = data[0].data.length;
              if(len > 0 && page <= lastpage){
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
                  $(".list-div:visible").find(".course-active").attr("data-page", page);
                }
              }else{
                $(".list-div:visible").find('.course-item-div:visible').find(".notice").show();
              }
              loading=false;
            }
          });
          // if(lastpage != page){
          //   lastpage = page;
          //   $(".list-div:visible").find('.course-item-div:visible').find(".loading").show();
          //   $.ajax({
          //     type: 'get',
          //     url: window.load_bottom.replace(/-1/, category_id) + "?page=" + page + "&orderBy=" + tab_word[index - 1],
          //     success: function(data){
          //       // console.log(data);
          //       $(".list-div:visible").find('.course-item-div:visible').find(".loading").hide();
          //       var len = data[0].data.length;
          //       if(len > 0){
          //         page++;
          //         for(var i=0;i<data[0].data.length;i++){
          //           var node=render(data[0].data[i]);
          //           if(node.find('.category-class').text() ==  "健康养育"){
          //             node.find('.category-class').addClass('health-title');
          //           }else if(node.find('.category-class').text() ==  "心理教育"){
          //             node.find('.category-class').addClass('psychology-title');
          //           }else{
          //             node.find('.category-class').addClass('grow-title');
          //           }
          //           node.insertBefore($(".list-div:visible").find(".course-item-div:visible").find(".load"));
          //           $(".list-div:visible").find(".course-active").attr("data-page", page);
          //         }
          //       }else{
          //         $(".list-div:visible").find('.course-item-div:visible').find(".notice").show();
          //       }
          //     },
          //     error: function(e){
          //       lastpage = lastpage - 1;
          //     }
          //   });
          // }
        }
      }
  });
});