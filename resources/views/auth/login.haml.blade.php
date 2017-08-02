!!!
%html{user: !empty($user)?$user->id:''}
  %head
    %base{:href => $base_href}
    %meta{:charset => "utf-8"}
    %meta{:content => "IE=edge", "http-equiv" => "X-UA-Compatible"}
    %meta{:content => "width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0", :name => "viewport"}
    %meta{"content:" => "telephone=no", :name => "format-detection"}
    %meta{"content:" => "email=no", :name => "format-detection"}
    %title 好妈妈微学院
    %link{:href => "css/bootstrap.min.css", :rel => "stylesheet"}
    %link{:href => "css/sign-layout.css", :rel => "stylesheet"}
    
    :javascript
      window.register = "#{route('register')}"
      window.forget = "#{route('password.request')}"
      window.login = "#{route('login')}"
      window.course_index = "#{route('courses.index')}"
      window.token = "#{csrf_token()}"
  %body
    .wrapper
      .content-area
        .input-div
          %img.logo{src: "icon/admin/logo.png"}
          .input-group
            %span.input-group-addon.miniphoto
            %input.form-box.f16#mobile{placeholder: "请输入您的手机号", type: "text"} 
          .input-group.no-margin-bottom
            %span.input-group-addon.password-photo
            %input.form-box.f16#password{placeholder: "请输入密码", type: "password"} 
          %p.notice.f14#error_notice 手机号或密码错误
          %button.btn.click-btn.f24#signin_btn{type: "button"} 立即登录
          .footer-div.clearfix
            %span.left.f16.fl.pointer#to_signup 立即注册
            %span.right.f16.fr.pointer#to_forget_password 忘记密码?
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src = "js/ajax.js"></script>
    <script src = "js/regex.js"></script>
    <script src= "{{mix('/js/signin.js')}}"></script>
    <script src= "js/admin-signin.js"></script>

    