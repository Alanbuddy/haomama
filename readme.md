# 后台签到管理
路由 GET route('admin.courses.signIn',$course);

##课次选择：
$lessons

## 后台签到管理->生成二维码
路由 GET route('courses.lesson.qr',$course,$lesson);

响应 PNG图片
直接吧图片标签的src属性设置成这个路由就可以显示二维码
***
# 页面访问记录 
路由 POST route('behaviors.store')
##开始访问某个页面
###POST参数
- type:'pv.begin'
- data:{"url":"/index","time":"2017-8-9 10:10:10"}
##结束访问某个页面
###POST参数
- type:'pv.end'
- data:{"url":"/index","time":"2017-8-9 10:10:10"}

