!!!
%html
  %head
    %meta{:charset => "utf-8"}
    %meta{:content => "IE=edge", "http-equiv" => "X-UA-Compatible"}
    %meta{:content => "width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0", :name => "viewport"}
    %meta{"content:" => "telephone=no", :name => "format-detection"}
    %meta{"content:" => "email=no", :name => "format-detection"}
    %title
      @yield('title') VOD
    %link{:href => "/css/bootstrap.min.css", :rel => "stylesheet"}
    %link{:href => "/css/mobile-notification.css", :rel => "stylesheet"}
    %link{:href => "/css/admin-layout.css", :rel => "stylesheet"}

    @yield('css')
    :javascript
      window.logout = "#{route('logout')}"
      window.login = "#{route('login')}"
      window.token = "#{csrf_token()}"
      window.teacher = "#{route('users.index')}"
  %body
    .wrapper
      .layout-left
        %img.logo2{src: "/icon/admin/logo2.png"}
        .avatar-div.f16
          %img.layout-avatar{ src: empty($user['avatar']) ?  "/icon/avatar.png" : $user['avatar'] }
          %p.layout-name= empty($user['name']) ? "欢迎您" : $user['name']
        .main
          .sidebar
            %ul
              %li
                %a{href: route('courses.index')}
                  %img.mini-icon{src: "/icon/admin/1class.png"}
                  %span.f18.sidebar-title 课程管理
              %li
                %a{:href => route("lessons.index")}
                  %img.mini-icon{src: "/icon/admin/2single.png"}
                  %span.f18.sidebar-title 课时管理
              %li
                %a{:href => route('users.index')."?type=teacher"}
                  %img.mini-icon{src: "/icon/admin/3teacher.png"}
                  %span.f18.sidebar-title 讲师管理
              %li
                %a{:href => "#"}
                  %img.mini-icon{src: "/icon/admin/4announcement.png"}
                  %span.f18.sidebar-title 宣传管理
              %li
                %a{:href => "#"}
                  %img.mini-icon{src: "/icon/admin/5user.png"}
                  %span.f18.sidebar-title 用户管理
              %li
                %a{:href => "#"}
                  %img.mini-icon{src: "/icon/admin/6statistic.png"}
                  %span.f18.sidebar-title 统计数据
      @yield('content')
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src = "/js/ajax.js"></script>
    <script src = "/js/regex.js"></script>
    <script src= "{{mix('/js/admin-layout.js')}}"></script>

    
    @yield('script')