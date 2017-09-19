!!!
%html
  %head
    %base{:href => $base_href}
    %meta{:charset => "utf-8"}
    %meta{:content => "IE=edge", "http-equiv" => "X-UA-Compatible"}
    %meta{:content => "width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0", :name => "viewport"}
    %meta{"content:" => "telephone=no", :name => "format-detection"}
    %meta{"content:" => "email=no", :name => "format-detection"}
    %title
      @yield('title') 好妈妈微课
    %link{:href => "css/bootstrap.min.css", :rel => "stylesheet"}
    %link{:href => "css/notification.css", :rel => "stylesheet" }
    %link{:href => "css/admin-layout.css", :rel => "stylesheet"}
    %link{:href => "css/plugin/pagination.css", :rel => "stylesheet"}
    %link{:href => "css/plugin/wangEditor.min.css", :rel => "stylesheet"}

    @yield('css')
    :javascript
      window.logout = "#{route('logout')}"
      window.login = "#{route('login')}"
      window.token = "#{csrf_token()}"
      window.teacher = "#{route('users.index')}"
      window.fileupload = "#{route('file.upload')}"
      window.red_dot = "#{route('operator.count')}"
  %body
    .wrapper
      .layout-left
        %img.logo2{src: "icon/admin/logo2.png"}
        .avatar-div.f16
          - if(auth()->user())
            %img.layout-avatar{ src: empty(auth()->user()->avatar) ?  "icon/avatar.png" : auth()->user()->avatar }
            %p.layout-name= empty(auth()->user()->name) ? "欢迎您" : auth()->user()->name
        .main
          .sidebar
            %ul
              %li
                %a{href: route('courses.index')}
                  %img.mini-icon{src: "icon/admin/1class.png"}
                  %span.f18.sidebar-title 课程管理
              %li.lesson-li
                %a{:href => route("lessons.index")."?type=video"}
                  %img.mini-icon{src: "icon/admin/2single.png"}
                  %span.f18.sidebar-title 课时管理
              %li.teacher_li
                %a{:href => route('users.index')."?type=teacher"}
                  %img.mini-icon{src: "icon/admin/3teacher.png"}
                  %span.f18.sidebar-title 讲师管理
              %li.setting_li
                %a{:href => route('settings.index')."?key=carousel"}
                  %img.mini-icon{src: "icon/admin/4announcement.png"}
                  %span.f18.sidebar-title 宣传管理
              %li.user_li
                %a{:href => route('users.index')}
                  %img.mini-icon{src: "icon/admin/5user.png"}
                  %span.f18.sidebar-title 用户管理
              %li
                %a{:href => route('statistics.index')}
                  %img.mini-icon{src: "icon/admin/6statistic.png"}
                  %span.f18.sidebar-title 统计数据
      .content-area
        .main-top.direction
          @yield('search-input')
          %ul.set
            -if(auth()->user()->hasRole('admin'))
              %li            
                %a.f16.right-border{href: route('users.index')."?type=operator"} 人员管理
                .dot
            %li
              %a.f16{href: route('admin.profile')} 账号设置
            %li
              %a.f16.set-left-border#exit{href: "javascript:void(0)"} 退出登录
      @yield('content')
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src = "js/ajax.js"></script>
    <script src = "js/regex.js"></script>
    <script src = "js/mobile-notification.js"></script>
    <script src="js/plugin/jquery.pagination.js"></script>

    <script src= "{{mix('/js/admin-layout.js')}}"></script>


    @yield('script')