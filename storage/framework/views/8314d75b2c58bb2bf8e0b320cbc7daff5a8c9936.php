<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(mix('/css/course-index.css')); ?>">
<link rel="stylesheet" href="/css/swiper-3.4.2.min.css">
<script type="text/javascript">
//<![CDATA[
   window.course_item="<?php echo htmlspecialchars(route('courses.index'),ENT_QUOTES,'UTF-8'); ?>"
   window.course_search="<?php echo htmlspecialchars(route('courses.search'),ENT_QUOTES,'UTF-8'); ?>"
   window.userid = "<?php echo htmlspecialchars(route('users.show',auth()->user()),ENT_QUOTES,'UTF-8'); ?>"
//]]>
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>
<div class="head-div">
  <div class="search-div f12">
    <img <?php echo MtHaml\Runtime::renderAttributes(array(array('class', 'search'), array('src', ('/icon/search.png'))), 'html5', 'UTF-8'); ?>>
    <input class="search-input color5" type="text" placeholder="搜索课程名/老师名" readonly="readonly">
  </div>
  <div class="nav-div">
    <ul class="nav f14">
      <!-- / %li 新课速递 -->
      <!-- / %li 健康教育 -->
      <!-- / %li 心理教育 -->
      <!-- / %li 自我成长 -->
      <?php foreach ($categories as $category ) { ?>
        <li><?php echo htmlspecialchars($category['name'],ENT_QUOTES,'UTF-8'); ?></li>
      <?php } ?>
    </ul>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="swiper-container-banner">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <img <?php echo MtHaml\Runtime::renderAttributes(array(array('class', ('img-size' . ' ' . 'img_1')), array('src', ('/icon/banner.png'))), 'html5', 'UTF-8'); ?>>
    </div>
    <div class="swiper-slide">
      <img <?php echo MtHaml\Runtime::renderAttributes(array(array('class', ('img-size' . ' ' . 'img_1')), array('src', ('/icon/banner.png'))), 'html5', 'UTF-8'); ?>>
    </div>
    <div class="swiper-slide">
      <img <?php echo MtHaml\Runtime::renderAttributes(array(array('class', ('img-size' . ' ' . 'img_1')), array('src', ('/icon/banner.png'))), 'html5', 'UTF-8'); ?>>
    </div>
  </div>
  <div class="swiper-pagination"></div>
</div>
<!-- / .main-div -->
<div class="swiper-container">
  <div class="swiper-wrapper">
    <?php for ($i=0;$i<4;$i++) { ?>
      <div class="swiper-slide">
        <div class="course-title-div">
          <div class="title-row-div">
            <p class="color7 fb f14"><?php echo htmlspecialchars($categories[$i]['name'],ENT_QUOTES,'UTF-8'); ?></p>
            <div class="course-nav f12 color5">
              <span class="course-active">最新</span>
              <span>最热</span>
              <span>好评</span>
            </div>
          </div>
          <div class="course-item-div" style="display:block">
            <?php foreach ($data[$i]['items'] as $item) { ?>
              <div <?php echo MtHaml\Runtime::renderAttributes(array(array('class', 'course-item'), array(('data-id'), ($item['id']))), 'html5', 'UTF-8'); ?>>
                <div class="course-icon-div">
                  <img class="course-recommend" src="/icon/recommend.png">
                  <img <?php echo MtHaml\Runtime::renderAttributes(array(array('class', 'course-icon'), array('src', ($item['cover'] ? $item['cover'] : "/icon/example.png"))), 'html5', 'UTF-8'); ?>>
                </div>
                <div class="word-div">
                  <div class="course-row-div clearfix">
                    <span class="f12 category-class"><?php echo htmlspecialchars($item['category']['name'],ENT_QUOTES,'UTF-8'); ?></span>
                    <span class="course-item-value f14 color5"><?php echo htmlspecialchars("￥". $item['price'],ENT_QUOTES,'UTF-8'); ?></span>
                  </div>
                  <div class="course-row-div color7 unstart">
                    <span class="coures-name f16"><?php echo htmlspecialchars($item['name'],ENT_QUOTES,'UTF-8'); ?></span>
                    <?php if ($item['type'] == 'offline') { ?>
                      <span class="course-status f8">线下</span>
                    <?php } ?>
                  </div>
                  <div class="course-row-div f12 color6">
                    <?php if ($item['type'] == 'offline') { ?>
                      <span class="participate"><?php echo htmlspecialchars($item['users_count']."人已报名",ENT_QUOTES,'UTF-8'); ?></span>
                      <span>.</span>
                      <span><?php echo htmlspecialchars(date_format(date_create($item['begin']),"m月/d日") ."开课",ENT_QUOTES,'UTF-8'); ?></span>
                    <?php } else { ?>
                      <span class="participate"><?php echo htmlspecialchars($item['users_count']."人已学",ENT_QUOTES,'UTF-8'); ?></span>
                      <span>.</span>
                      <span><?php echo htmlspecialchars($item['comments_count'] ."条评论",ENT_QUOTES,'UTF-8'); ?></span>
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="course-item-div">
            <?php foreach ($data[$i]['itemsOrderByUserCount'] as $itemOrderByUserCount) { ?>
              <div <?php echo MtHaml\Runtime::renderAttributes(array(array('class', 'course-item'), array(('data-id'), ($itemOrderByUserCount['id']))), 'html5', 'UTF-8'); ?>>
                <div class="course-icon-div">
                  <img class="course-recommend" src="/icon/recommend.png">
                  <img <?php echo MtHaml\Runtime::renderAttributes(array(array('class', 'course-icon'), array('src', ($itemOrderByUserCount['cover'] ? $itemOrderByUserCount['cover'] : "/icon/example.png"))), 'html5', 'UTF-8'); ?>>
                </div>
                <div class="word-div">
                  <div class="course-row-div clearfix">
                    <span class="category-class f12"><?php echo htmlspecialchars($itemOrderByUserCount['category']['name'],ENT_QUOTES,'UTF-8'); ?></span>
                    <span class="course-item-value f14 color5"><?php echo htmlspecialchars("￥". $itemOrderByUserCount['price'],ENT_QUOTES,'UTF-8'); ?></span>
                  </div>
                  <div class="course-row-div color7 unstart">
                    <span class="coures-name f16"><?php echo htmlspecialchars($itemOrderByUserCount['name'],ENT_QUOTES,'UTF-8'); ?></span>
                    <?php if ($itemOrderByUserCount['type'] == 'offline') { ?>
                      <span class="course-status f8">线下</span>
                    <?php } ?>
                  </div>
                  <div class="course-row-div f12 color6">
                    <?php if ($itemOrderByUserCount['type'] == 'offline') { ?>
                      <span class="participate"><?php echo htmlspecialchars($itemOrderByUserCount['users_count']."人已报名",ENT_QUOTES,'UTF-8'); ?></span>
                      <span>.</span>
                      <span><?php echo htmlspecialchars(date_format(date_create($itemOrderByUserCount['begin']),"m月/d日") ."开课",ENT_QUOTES,'UTF-8'); ?></span>
                    <?php } else { ?>
                      <span class="participate"><?php echo htmlspecialchars($itemOrderByUserCount['users_count']."人已学",ENT_QUOTES,'UTF-8'); ?></span>
                      <span>.</span>
                      <spann><?php echo htmlspecialchars($itemOrderByUserCount['comments_count'] ."条评论",ENT_QUOTES,'UTF-8'); ?></spann>
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="course-item-div">
            <?php foreach ($data[$i]['itemsOrderByCommentRating'] as $itemOrderByCommentRating) { ?>
              <div <?php echo MtHaml\Runtime::renderAttributes(array(array('class', 'course-item'), array(('data-id'), ($itemOrderByCommentRating['id']))), 'html5', 'UTF-8'); ?>>
                <div class="course-icon-div">
                  <img class="course-recommend" src="/icon/recommend.png">
                  <img <?php echo MtHaml\Runtime::renderAttributes(array(array('class', 'course-icon'), array('src', ($itemOrderByCommentRating['cover'] ? $itemOrderByCommentRating['cover'] : "/icon/example.png"))), 'html5', 'UTF-8'); ?>>
                </div>
                <div class="word-div">
                  <div class="course-row-div clearfix">
                    <span class="category-class f12"><?php echo htmlspecialchars($itemOrderByCommentRating['category']['name'],ENT_QUOTES,'UTF-8'); ?></span>
                    <span class="course-item-value f14 color5"><?php echo htmlspecialchars("￥". $itemOrderByCommentRating['price'],ENT_QUOTES,'UTF-8'); ?></span>
                  </div>
                  <div class="course-row-div color7 unstart">
                    <span class="coures-name f16"><?php echo htmlspecialchars($itemOrderByCommentRating['name'],ENT_QUOTES,'UTF-8'); ?></span>
                    <?php if ($itemOrderByCommentRating['type'] == 'offline') { ?>
                      <span class="course-status f8">线下</span>
                    <?php } ?>
                  </div>
                  <div class="course-row-div f12 color6">
                    <?php if ($itemOrderByCommentRating['type'] == 'offline') { ?>
                      <span class="participate"><?php echo htmlspecialchars($itemOrderByCommentRating['users_count']."人已报名",ENT_QUOTES,'UTF-8'); ?></span>
                      <span>.</span>
                      <span><?php echo htmlspecialchars(date_format(date_create($itemOrderByCommentRating['begin']),"m月/d日") ."开课",ENT_QUOTES,'UTF-8'); ?></span>
                    <?php } else { ?>
                      <span class="participate"><?php echo htmlspecialchars($itemOrderByCommentRating['users_count']."人已学",ENT_QUOTES,'UTF-8'); ?></span>
                      <span>.</span>
                      <span><?php echo htmlspecialchars($itemOrderByCommentRating['comments_count'] ."条评论",ENT_QUOTES,'UTF-8'); ?></span>
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<img class="upper" src="/icon/top.png">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('foot-div'); ?>
<div class="foot">
  <div class="foot-item-div" id="home">
    <img class="home" src="/icon/home_selected.png">
    <p class="f10 color8 fb">首页</p>
  </div>
  <div class="foot-item-div" id="mine">
    <img class="mine" src="/icon/mine_normal.png">
    <p class="f10 color5">我的</p>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src= "/js/jquery.event.drag.js"></script>
<script src= "/js/jquery.touchSlider.js"></script>
<script src= "/js/banner.js"></script>
<script src= "<?php echo e(mix('/js/course-index.js')); ?>"></script>
<script src= "/js/swiper-3.4.2.jquery.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>