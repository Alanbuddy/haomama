# 后台签到管理
路由 route('admin.courses.signIn',$course);

课次选择：$lessons

## 后台签到管理->生成二维码
路由 route('courses.lesson.qr',$course,$lesson);
响应 PNG图片
直接吧图片标签的src属性设置成这个路由就可以显示二维码
