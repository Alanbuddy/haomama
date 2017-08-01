!!!
%html
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
    
    <link rel="stylesheet" href="{{ mix('/css/forget.css') }}">  
    :javascript
      window.sms_send = "#{route('password.sms.send')}"
      window.sms_verify = "#{route('sms.verify')}"
      window.token = "#{csrf_token()}"
      window.login = "#{route('login')}"
      window.validmobile = "#{route('validate.phone')}"
      window.forget = "#{route('password.request')}" 

  %body
    .wrapper
      .content-area
        .input-div
          .input-group.no-margin-bottom
            %span.input-group-addon.miniphoto
            .input-inside-div
              %input.form-box.form-verify-box.f16#mobile{placeholder: "请输入您的手机号", type: "text"}
              %button.btn.verify-code-btn.f16#verifycode{type: "button"} 获取验证码
          %p.notice.f14#mobile_notice 请输入正确的手机号
          .input-group.no-margin-bottom
            %span.input-group-addon.verify-photo
            %input.form-box.f16#mobilecode{placeholder: "请输入验证码", type: "text"}
          %p.notice.f14#code_notice 验证码错误 
          .input-group
            %span.input-group-addon.password-photo
            %input.form-box.f16#password{placeholder: "请设置密码", type: "password"} 
          .input-group.no-margin-bottom
            %span.input-group-addon.password-photo
            %input.form-box.f16#password_again{placeholder: "请再次输入密码", type: "password"}
          %p.notice.f14#password_notice 两次输入的密码不一致
          %button.btn.click-btn.f24#confirm_btn{type: "button"} 确&nbsp&nbsp定
          .footer-div.clearfix
            %span.right.f16.fr.pointer#to_signin 未忘密码?立即登录
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src = "js/ajax.js"></script>
    <script src = "js/regex.js"></script>
    <script src= "{{mix('/js/forget.js')}}"></script>
    <script src= "js/admin-forget.js"></script>

    