# 后台签到管理
路由 GET route('admin.courses.signIn',$course);

##课次选择：
$lessons

## 后台签到管理->生成二维码
路由 GET route('courses.lesson.qr',$course,$lesson);

响应 PNG图片
直接把图片标签的src属性设置成这个路由就可以显示二维码
***
# 记录课程分享次数
#####https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141115
路由 POST route('courses.recordSharing')
- 响应 {success:true}

