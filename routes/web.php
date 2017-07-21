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

Route::group([
    'middleware' => ['web']
], function () {
    Route::auth();
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/logout', 'Auth\LoginController@logout');

    Route::get('/validate/phone', 'SmsController@isOccupied')->name('validate.phone');
    Route::any('/sms/send', 'SmsController@send')->name('sms.send');
    Route::any('/sms/residual', 'SmsController@residual')->name('sms.residual');
    Route::get('/sms/verify', 'SmsController@verify')->name('sms.verify');

});
Route::any('/password/sms/send', 'Auth\ResetPasswordController@sendResetSms')->name('password.sms.send');

include('test.php');

Route::any('/haml', 'TestController@index');

Route::group([
    'middleware' => ['web', 'auth', 'role:admin'],
    'namespace' => 'Admin',
    'prefix' => 'admin'
], function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::any('/profile', 'AdminController@profile')->name('admin.profile');
    Route::get('/phpinfo', 'AdminController@info');
});


Route::group([
    'middleware' => ['web', 'auth'],
], function () {
    Route::get('/statistics/lessons', 'StatisticsController@lessonsStatistics')->name('statistics.lessons');//视频播放情况统计列表页
    Route::get('/statistics/lessons/{lesson?}/', 'StatisticsController@lessonStatistics')->name('statistics.lesson');//视频播放情况统计详情页

    Route::get('/tag/{tag}', 'CourseController@search')->name('tag');
    Route::get('/category/{category}', 'HomeController@index')->name('category');


    Route::get('/courses/search', 'CourseController@search')->name('courses.search');
    Route::get('/courses/statistics', 'CourseController@statistics')->name('courses.statistics');
    Route::get('/courses/enrolled', 'CourseController@enrolledCourses')->name('courses.enrolled');//我加入的课程
    Route::get('/courses/favorited', 'CourseController@favoriteCourses')->name('courses.favorited');//我收藏的课程
    Route::get('/admin/courses/{course}', 'CourseController@adminShow')->name('admin.courses.show');//后台课程详情页面
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
//    Route::get('/courses/{course}/lessons/{lesson}/order', 'CourseController@updateLessonOrder')->name('courses.lessons.order');//调整课时顺序
    Route::get('/courses/{course}/lessons/{lesson}/comments', 'CommentController@commentsOfLesson')->name('courses.lesson.comments');//课时评论

    Route::get('/courses/{course}/lessons/{lesson}', 'LessonController@detail')->name('courses.lessons.show');//课时详情
    Route::get('/admin/lessons/{lesson}/', 'LessonController@adminShow')->name('admin.lesson.show');//课时详情管理
    Route::resource('lessons', 'LessonController');

    Route::get('/comments/{comment}/vote', 'CommentController@vote')->name('comments.vote');
    Route::resource('comments', 'CommentController');

    Route::post('/orders/pay', 'OrderController@pay')->name('orders.pay');
    Route::get('/orders/{uuid}/refund', 'OrderController@refund')->name('orders.refund');
    Route::resource('orders', 'OrderController', ['except' => 'store']);
    Route::get('/orders/{uuid}/query', 'OrderController@queryOrder')->name('orders.payment.query');
    Route::any('/orders/{uuid}/payment/update', 'OrderController@updatePaymentStatus')->name('orders.payment.update');

    Route::any('/profile', 'UserController@profile')->name('user.profile');
    Route::get('/admin/users/{user}', 'UserController@showAdmin')->name('admin.user.show');
    Route::get('/admin/users/{user}/enable', 'UserController@enable')->name('admin.user.enable');
    Route::get('/admin/users/{user}/disable', 'UserController@disable')->name('admin.user.disable');
    Route::get('/users/{user}/vote', 'UserController@vote')->name('users.vote');
    Route::get('/users/search', 'UserController@search')->name('users.search');
    Route::resource('users', 'UserController');

    Route::resource('roles', 'RoleController');

    Route::resource('terms', 'TermController');//分类和标签

    Route::get('/behaviors/latest', 'BehaviorController@latest');
    Route::resource('behaviors', 'BehaviorController');

//    Route::get('/video/{video?}', 'VodController@video');
    Route::get('/videos/upload/init', 'VideoController@initUpload')->name('videos.upload.init');
    Route::post('/videos/merge', 'VideoController@mergeVideo')->name('videos.merge');
    Route::resource('videos', 'VideoController');

    Route::get('/files/upload/init', 'FileController@initChunkUpload')->name('file.upload.init');
    Route::post('/upload', 'FileController@upload')->name('file.upload');
    Route::post('/files/merge', 'FileController@mergeFile')->name('files.merge');

    Route::resource('settings', 'SettingController');//系统设置

    Route::resource('messages', 'MessageController');//消息

    Route::get('/videos/{video?}/cloud/info', 'VideoController@cloudInfo')->name('video.cloud.info');
    Route::get('/videos/{video?}/cloud/transcode', 'VideoController@cloudTranscode')->name('video.cloud.transcode');
    Route::get('/videos/{video?}/picture/order', 'VideoController@updateAttachmentOrder')->name('video.attachment.order');
    Route::get('/videos/{video?}/statistics', 'VideoController@statistics')->name('video.statistics');

});

Route::group([
    'middleware' => ['web'],
], function () {
    Route::get('/wechat/message/get-industry', 'WechatController@getIndustry')->name('wechat.getIndustry');
    Route::get('/wechat/message/get-template', 'WechatController@getTemplate')->name('wechat.getTemplate');
    Route::get('/wechat/message/template-id', 'WechatController@getTemplateID')->name('wechat.getTemplateID');
    Route::get('/wechat/access-token', 'WechatController@accessToken')->name('wechat.accessToken');
    Route::get('/wechat/login', 'WechatController@login')->name('wechat.login');
    Route::get('/wechat/openid', 'WechatController@openid')->name('wechat.openid');
    Route::get('/wechat/send', 'WechatController@send')->name('wechat.send');
});

//用户支付完成后，微信服务器通知商启系统支付情况的回调地址
Route::any('/wechat/payment/notify', 'WechatController@paymentNotify')->name('wechat.payment.notify');

Route::get('/3rd/map/render', 'TestController@renderReverse')->name('api.map.render.reverse');
