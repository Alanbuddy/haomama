<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(mix('/css/course-index.css')); ?>">
<link rel="stylesheet" href="/css/swiper-3.4.2.min.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>
<div class="head-div">
  <div class="search-div f12">
    <img <?php echo MtHaml\Runtime::renderAttributes(array(array('class', 'search'), array('src', ('/icon/search.png'))), 'html5', 'UTF-8'); ?>>
    <input class="search-input color5" type="text" placeholder="搜索课程名/老师名">
  </div>
  <div class="nav-div">
    <ul class="nav f14">
      <li class="active">新课速递</li>
      <li>健康教育</li>
      <li>心理教育</li>
      <li>自我成长</li>
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
    <div class="swiper-slide">
      <div class="course-title-div">
        <div class="title-row-div">
          <p class="color7 fb f14">新课速递</p>
          <div class="course-nav f12 color5">
            <span class="course-active">最新</span>
            <span>最热</span>
            <span>好评</span>
          </div>
        </div>
        <div class="course-item-div" style="display:block">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="health-title f12">健康养育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="psychology-title f12">心理教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7 status-flex">
                <span class="name-span f16">名字很长很长很长</span>
                <span class="course-status f8">线下</span>
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已报名</span>
                <span>.</span>
                <span>5月9日开课</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="health-title f12">健康教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
        <div class="course-item-div">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="health-title f12">健康养育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
        <div class="course-item-div">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="swiper-slide">
      <div class="course-title-div">
        <div class="title-row-div">
          <p class="color7 fb f14">健康教育</p>
          <div class="course-nav f12 color5">
            <span class="course-active">最新</span>
            <span>最热</span>
            <span>好评</span>
          </div>
        </div>
        <div class="course-item-div" style="display:block">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="health-title f12">健康养育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="health-title f12">健康教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7 status-flex">
                <span class="name-span f16">名字很长很长很长</span>
                <span class="course-status f8">线下</span>
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已报名</span>
                <span>.</span>
                <span>5月9日开课</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="health-title f12">健康教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
        <div class="course-item-div">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="health-title f12">健康教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
        <div class="course-item-div">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="health-title f12">健康教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="swiper-slide">
      <div class="course-title-div">
        <div class="title-row-div">
          <p class="color7 fb f14">心理教育</p>
          <div class="course-nav f12 color5">
            <span class="course-active">最新</span>
            <span>最热</span>
            <span>好评</span>
          </div>
        </div>
        <div class="course-item-div" style="display:block">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="psychology-title f12">心理教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="psychology-title f12">心理教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7 status-flex">
                <span class="name-span f16">名字很长很长很长</span>
                <span class="course-status f8">线下</span>
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已报名</span>
                <span>.</span>
                <span>5月9日开课</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="psychology-title f12">心理教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="psychology-title f12">心理教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="psychology-title f12">心理教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="psychology-title f12">心理教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
        <div class="course-item-div">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="psychology-title f12">心理教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
        <div class="course-item-div">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="psychology-title f12">心理教育</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="swiper-slide">
      <div class="course-title-div">
        <div class="title-row-div">
          <p class="color7 fb f14">自我成长</p>
          <div class="course-nav f12 color5">
            <span class="course-active">最新</span>
            <span>最热</span>
            <span>好评</span>
          </div>
        </div>
        <div class="course-item-div" style="display:block">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7 status-flex">
                <span class="name-span f16">名字很长很长很长</span>
                <span class="course-status f8">线下</span>
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已报名</span>
                <span>.</span>
                <span>5月9日开课</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
        <div class="course-item-div">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
        <div class="course-item-div">
          <div class="course-item">
            <div class="course-icon-div">
              <img class="course-recommend" src="/icon/recommend.png">
              <img class="course-icon" src="/icon/example.png">
            </div>
            <div class="word-div">
              <div class="course-row-div clearfix">
                <span class="grow-title f12">自我成长</span>
                <span class="course-item-value f14 color5">200</span>
              </div>
              <div class="course-row-div color7">
                <span class="coures-name f16">名字很长很长很长</span>
                <!-- / %span.course-status.f8 线下 -->
              </div>
              <div class="course-row-div f12 color6">
                <span class="participate">2315人已学</span>
                <span>.</span>
                <span>810条评论</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
</section>
<?php $__env->startSection('script'); ?>
<script src= "/js/jquery.event.drag.js"></script>
<script src= "/js/jquery.touchSlider.js"></script>
<script src= "/js/banner.js"></script>
<script src= "<?php echo e(mix('/js/course-index.js')); ?>"></script>
<script src= "/js/swiper-3.4.2.jquery.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>