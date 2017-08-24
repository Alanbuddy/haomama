<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//		$a=DB::table('user')->get();
//    return view('welcome');
//});
use Illuminate\Support\Facades\Route;

Route::auth();
Route::get('/', 'HomeController@index')->name('index');
Route::get('/tag/{tag}', 'CourseController@search')->name('tag');
Route::get('/category/{category}', 'HomeController@index')->name('category');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/validate/phone', 'SmsController@isOccupied')->name('validate.phone');
Route::any('/sms/send', 'SmsController@send')->name('sms.send');
Route::any('/sms/residual', 'SmsController@residual')->name('sms.residual');
Route::get('/sms/verify', 'SmsController@verify')->name('sms.verify');
Route::any('/password/sms/send', 'Auth\ResetPasswordController@sendResetSms')->name('password.sms.send');

include('test.php');

Route::any('/haml', 'TestController@index');

Route::group([
    'middleware' => ['auth', 'role:admin|operator'],
    'namespace' => 'Admin',
    'prefix' => 'admin'
], function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::any('/profile', 'AdminController@profile')->name('admin.profile');
    Route::get('/phpinfo', 'AdminController@info');
});


Route::group([
    'middleware' => ['auth'],
], function () {
    Route::get('/statistics/lessons', 'StatisticsController@lessonsStatistics')->name('statistics.lessons');//视频播放情况统计列表页
    Route::get('/statistics/lessons/{lesson?}/', 'StatisticsController@lessonStatistics')->name('statistics.lesson');//视频播放情况统计详情页


    Route::get('/courses/search', 'CourseController@search')->name('courses.search');
    Route::get('/courses/statistics', 'CourseController@statistics')->name('courses.statistics');//课程相关统计信息
    Route::get('/courses/enrolled', 'CourseController@enrolledCourses')->name('courses.enrolled');//我加入的课程
    Route::get('/courses/favorited', 'CourseController@favoriteCourses')->name('courses.favorited');//我收藏的课程
    Route::get('/courses/admin/search', 'CourseController@adminSearch')->name('admin.courses.search');
    Route::get('/courses/{course}/admin', 'CourseController@adminShow')->name('admin.courses.show');//后台课程详情页面
    Route::get('/courses/{course}/admin/students', 'CourseController@adminStudents')->name('admin.courses.students');//后台课程学员列表
    Route::get('/courses/{course}/admin/comments', 'CourseController@adminComments')->name('admin.courses.comments');//后台课程评论列表
    Route::get('/courses/{course}/admin/comments/search', 'CommentController@search')->name('admin.courses.comments.search');//后台课程评论搜索
    Route::get('/courses/{course}/admin/sign-in', 'CourseController@signInAdmin')->name('admin.courses.signIn');//后台签到管理
    Route::get('/courses/{course}/share', 'CourseController@recordSharing')->name('courses.recordSharing');//课程分享统计
    Route::resource('courses', 'CourseController');
    Route::get('/courses/{course}/lessons/edit', 'CourseController@editLessons')->name('courses.lessons.edit');
    Route::put('/courses/{course}/lessons/update', 'CourseController@updateLessons')->name('courses.lessons.update');
    Route::get('/courses/{course}/tag/edit', 'CourseController@editTags')->name('courses.tags.edit');
    Route::put('/courses/{course}/tag/update', 'CourseController@updateTags')->name('courses.tags.update');
    Route::get('/courses/{course}/comments', 'CourseController@commentsIndex')->name('courses.comments.index');//课程评论
    Route::get('/courses/{course}/hot', 'CourseController@toggleHot')->name('courses.hot');//置顶与取消置顶
    Route::get('/courses/{course}/publish', 'CourseController@togglePublish')->name('courses.publish');//发布与取消发布课程
    Route::get('/courses/{course}/enroll', 'CourseController@enrollHandle')->name('courses.enroll');//加入课程
    Route::get('/courses/{course}/favorite', 'CourseController@favorite')->name('courses.favorite');//收藏课程
    Route::get('/courses/{course}/recommend', 'CourseController@recommend')->name('courses.recommend');//获取推荐的课程
    Route::get('/courses/{course}/lessons/{lesson}/sign-in', 'CourseController@signIn')->name('courses.signIn');//签到
    Route::get('/courses/{course}/lessons/{lesson}/qr', 'CourseController@qr')->name('courses.lesson.qr');//获取签到二维码
    Route::get('/courses/{course}/lessons/{lesson}/comments', 'CommentController@commentsOfLesson')->name('courses.lesson.comments');//课时评论
//    Route::get('/courses/{course}/lessons/{lesson}/order', 'CourseController@updateLessonOrder')->name('courses.lessons.order');//调整课时顺序

    Route::get('/courses/{course}/lessons/{lesson}', 'LessonController@detail')->name('courses.lessons.show');//课时详情
    Route::get('/lessons/admin/search', 'LessonController@adminSearch')->name('admin.lessons.search');//课时搜索
    Route::get('/lessons/{lesson}/admin', 'LessonController@adminShow')->name('admin.lesson.show');//课时详情管理

    Route::resource('lessons', 'LessonController');

    Route::get('/comments/{comment}/vote', 'CommentController@vote')->name('comments.vote');
    Route::resource('comments', 'CommentController');

    Route::get('/orders/statistics', 'OrderController@statistics')->name('orders.statistics');//课程相关统计信息
    Route::get('/orders/tmp', 'OrderController@tmp')->name('orders.finish');//跳转到完成支付提示页
    Route::post('/orders/pay', 'OrderController@pay')->name('orders.pay');//初始化支付
    Route::get('/orders/{uuid}/refund', 'OrderController@refund')->name('orders.refund');//退款
    Route::resource('orders', 'OrderController', ['except' => 'store']);
    Route::get('/orders/{uuid}/query', 'OrderController@queryOrder')->name('orders.payment.query');//从微信服务器查询订单
    Route::any('/orders/{uuid}/payment/update', 'OrderController@updatePaymentStatus')->name('orders.payment.update');

    Route::any('/profile', 'UserController@profile')->name('user.profile');
    Route::get('/operators/new/count', 'UserController@newOperatorCount')->name('operator.count');
    Route::get('/admin/users/{user}', 'UserController@showAdmin')->name('admin.user.show');
    Route::get('/admin/teachers/{user}/courses', 'UserController@coursesOfTeacher')->name('admin.teacher.course');//后台讲师开设课程
    Route::get('/users/{user}/enable', 'UserController@enable')->name('admin.user.enable');
    Route::get('/users/{user}/disable', 'UserController@disable')->name('admin.user.disable');
    Route::get('/users/{user}/log', 'UserController@log')->name('admin.user.log');//用户访问记录
    Route::get('/users/{user}/order', 'UserController@order')->name('admin.user.order');//用户订单记录
    Route::get('/users/{user}/courses/{course}/attendance', 'UserController@attendance')->name('admin.user.course.attendance');//用户课程考勤记录
    Route::get('/users/{user}/vote', 'UserController@vote')->name('users.vote');
    Route::get('/users/search', 'UserController@search')->name('users.search');
    Route::resource('users', 'UserController');

    Route::resource('roles', 'RoleController');

    Route::resource('terms', 'TermController');//分类和标签

    Route::get('/behaviors/latest', 'BehaviorController@latest');
    Route::resource('behaviors', 'BehaviorController');


    Route::get('/files/upload/init', 'FileController@initChunkUpload')->name('file.upload.init');
    Route::post('/upload', 'FileController@upload')->name('file.upload');
    Route::post('/files/merge', 'FileController@mergeFile')->name('files.merge');

    Route::resource('settings', 'SettingController');//系统设置

    Route::resource('messages', 'MessageController');//消息

//    Route::get('/video/{video?}', 'VodController@video');
    Route::get('/videos/upload/init', 'VideoController@initUpload')->name('videos.upload.init');
    Route::post('/videos/merge', 'VideoController@mergeVideo')->name('videos.merge');
    Route::resource('videos', 'VideoController');
    Route::get('/videos/{video?}/cloud/info', 'VideoController@cloudInfo')->name('video.cloud.info');
    Route::get('/videos/{video?}/cloud/transcode', 'VideoController@cloudTranscode')->name('video.cloud.transcode');
    Route::get('/videos/{video?}/picture/order', 'VideoController@updateAttachmentOrder')->name('video.attachment.order');
    Route::get('/videos/{video?}/statistics', 'VideoController@statistics')->name('video.statistics');

});

Route::get('/wechat/message/get-industry', 'WechatController@getIndustry')->name('wechat.getIndustry');
Route::get('/wechat/message/get-template', 'WechatController@getTemplate')->name('wechat.getTemplate');
Route::get('/wechat/message/template-id', 'WechatController@getTemplateID')->name('wechat.getTemplateID');
Route::get('/wechat/access-token', 'WechatController@accessToken')->name('wechat.accessToken');
Route::get('/wechat/login', 'WechatController@login')->name('wechat.login');
Route::get('/wechat/openid', 'WechatController@openid')->name('wechat.openid');
Route::get('/wechat/send', 'WechatController@send')->name('wechat.send');
Route::get('/wechat/users/{user}/userinfo', 'WechatController@userInfo')->name('wechat.userinfo');

//用户支付完成后，微信服务器通知商启系统支付情况的回调地址
Route::any('/wechat/payment/notify', 'WechatController@paymentNotify')->name('wechat.payment.notify');

Route::get('/3rd/map/render', 'TestController@renderReverse')->name('api.map.render.reverse');
