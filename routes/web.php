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
Route::auth();
Route::get('/', 'HomeController@index')->name('index');

include('test.php');
//Route::get('/', 'VodController@index');
Route::get('/haml', 'TestController@index');

Route::group([
    'middleware' => ['web', 'role:admin'],
    'namespace' => 'Admin',
    'prefix' => 'admin'
], function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('/phpinfo', 'AdminController@info');
});


Route::group([
    'middleware' => ['web','auth'],
], function () {

    Route::get('/tag/{tag}', 'CourseController@search')->name('tag');
    Route::get('/category/{category}', 'HomeController@index')->name('category');


    Route::get('/courses/search', 'CourseController@search')->name('courses.search');
    Route::get('/courses/statistics', 'CourseController@statistics')->name('courses.statistics');
    Route::get('/courses/enrolled', 'CourseController@enrolledCourses')->name('courses.enrolled');//我加入的课程
    Route::get('/courses/favorited', 'CourseController@favoriteCourses')->name('courses.favorited');//我收藏的课程
    Route::resource('courses', 'CourseController');
    Route::get('/courses/{course}/lessons/edit', 'CourseController@editLessons')->name('courses.lessons.edit');
    Route::put('/courses/{course}/lessons/update', 'CourseController@updateLessons')->name('courses.lessons.update');
    Route::get('/courses/{course}/tag/edit', 'CourseController@editTags')->name('courses.tags.edit');
    Route::put('/courses/{course}/tag/update', 'CourseController@updateTags')->name('courses.tags.update');
    Route::get('/courses/{course}/comments', 'CourseController@commentsIndex')->name('courses.comments.index');
    Route::get('/courses/{course}/hot', 'CourseController@toggleHot')->name('courses.hot');//置顶与取消置顶
    Route::get('/courses/{course}/enroll', 'CourseController@enroll')->name('courses.enroll');//加入课程
    Route::get('/courses/{course}/favorite', 'CourseController@favorite')->name('courses.favorite');//收藏课程
    Route::get('/courses/{course}/recommend', 'CourseController@recommend')->name('courses.recommend');//获取推荐的课程
    Route::get('/courses/{course}/lessons/{lesson}/sign-in', 'CourseController@signIn')->name('courses.signIn');//签到

    Route::resource('lessons', 'LessonController');

    Route::get('/comments/{comment}/vote', 'CommentController@vote')->name('comments.vote');
    Route::resource('comments', 'CommentController');
//    Route::resource('comments', 'CommentController',['except'=>'store']);

    Route::post('/orders/pay', 'OrderController@pay')->name('orders.pay');
    Route::resource('orders', 'OrderController',['except'=>'store']);
    Route::get('/orders/{uuid}/query', 'OrderController@queryOrder')->name('orders.payment.query');
    Route::any('/orders/{uuid}/payment/update', 'OrderController@updatePaymentStatus')->name('orders.payment.update');

    Route::any('/profile', 'UserController@profile')->name('user.profile');
    Route::resource('users', 'UserController');

    Route::resource('settings', 'SettingController');

    Route::resource('roles', 'RoleController');

    Route::resource('terms', 'TermController');

    Route::get('/behaviors/latest', 'BehaviorController@latest');
    Route::resource('behaviors', 'BehaviorController');

//    Route::get('/video/{video?}', 'VodController@video');
    Route::resource('videos', 'VideoController');
    Route::resource('settings', 'SettingController');
    Route::get('/videos/{video?}/cloud/info', 'VideoController@cloudInfo')->name('video.cloud.info');
    Route::get('/videos/{video?}/cloud/transcode', 'VideoController@cloudTranscode')->name('video.cloud.transcode');
    Route::get('/videos/{video?}/picture/order', 'VideoController@updateAttachmentOrder')->name('video.attachment.order');


    Route::get('/videos/{video?}/statistics', 'VideoController@statistics')->name('video.statistics');

    Route::get('/wechat/message/get-industry', 'WechatController@getIndustry')->name('wechat.getIndustry');
    Route::get('/wechat/message/template-id', 'WechatController@getTemplateID')->name('wechat.getTemplateID');
    Route::get('/wechat/access-token', 'WechatController@accessToken')->name('wechat.accessToken');
    Route::get('/wechat/payment/notify', 'WechatController@paymentNotify')->name('wechat.payment/notify');
    Route::get('/wechat/login', 'WechatController@login')->name('wechat.login');
    Route::get('/wechat/openid', 'WechatController@openid')->name('wechat.openid');

    Route::any('/sms/send', 'SmsController@send')->name('sms.send');
    Route::any('/sms/residual', 'SmsController@residual')->name('sms.residual');
    Route::get('/sms/verify', 'SmsController@verify')->name('sms.verify');
});

