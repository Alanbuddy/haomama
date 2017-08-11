@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_teacher_show.css') }}">

:javascript
  window.teacher_index = "#{route('users.index')}"
  window.token = "#{csrf_token()}"
  window.teacher_show = "#{route('admin.user.show', -1)."?type=teacher"}"

@endsection
@section('search-input')
%a{href: route('users.index')."?type=teacher"}
  %img.back{src: "icon/admin/back.png"}
@endsection

@section('content')

.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li
          %a.f16.font-color1#teacher-desc 讲师详情
          %span.teacher-id{style: "display:none;"}= $user->id
        %li.active
          %a.f16.font-color1#course 开设课程
      .tab-content.bg3
       
        #tab2.tab-pane.active
          .desc-div
            - if($items->total()==0) 
              .undiscover.f14
                %img.undiscover-icon{src: "icon/admin/undiscover.png"}
            - else
              .table-box
                %table.table.table-hover.table-height.f14
                  %thead.th-bg.font-color2
                    %tr
                      %th 课程名
                      %th 上课方式
                      %th 课程类型
                      %th 课程节数
                      %th 购买人数
                      %th 课程总收入
                      
                  %tbody.font-color3
                    - foreach($items as $course)
                      %tr
                        %td= $course->name
                        %td= $course->type == "online" ? "线上课程" : "线下课程"
                        %td= $course->category->name
                        %td= count(json_decode($course->titles))
                        %td= $course->orders_count
                        %td= $course->total_income
              .tag2-foot.clearfix
                %span.num-div.font-color3.f16
                  %span 总购买人次:
                  %span.mr30= $ordersCount
                  %span 总课程收入:
                  %span= $totalIncome

                %span.select-page.tag2-page
                  %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                  %span.choice-page
                    != $items->links()           
@endsection

@section('script')
<script src="js/teacher_course.js"></script>

@endsection