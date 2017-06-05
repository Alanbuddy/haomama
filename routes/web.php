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

include('test.php');
//Route::get('/', 'VodController@index');
Route::get('/haml', 'TestController@index');

Route::group([
    'middleware' => ['web', 'role:admin'],
    'namespace' => 'Admin',
    'prefix' => 'admin'
], function () {
    Route::get('/', 'AdminController@index')->name('admin::index');
    Route::get('/phpinfo', 'AdminController@info');
});


Route::group([
    'middleware' => ['web'],
], function () {
    Route::auth();
    Route::get('/', 'HomeController@index')->name('index');

    Route::get('/tag/{tag}', 'HomeController@index')->name('tag');
    Route::get('/category/{category}', 'HomeController@index')->name('category');

    Route::get('/video/{video?}', 'VodController@video');

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
    Route::get('/courses/{course}/enroll', 'CourseController@enroll')->name('courses.enroll');
    Route::get('/courses/{course}/favorite', 'CourseController@favorite')->name('courses.favorite');
    Route::get('/courses/{course}/recommend', 'CourseController@recommend')->name('courses.recommend');

    Route::resource('lessons', 'LessonController');

    Route::resource('comments', 'CommentController');

    Route::resource('orders', 'OrderController');

    Route::resource('users', 'UserController');

    Route::resource('settings', 'SettingController');

    Route::resource('roles', 'RoleController');

    Route::resource('terms', 'TermController');

    Route::get('/behaviors/latest', 'BehaviorController@latest');
    Route::resource('behaviors', 'BehaviorController');

    Route::resource('videos', 'VideoController');
    Route::get('/videos/{video?}/cloud/info', 'VideoController@cloudInfo')->name('video.cloud.info');
    Route::get('/videos/{video?}/cloud/transcode', 'VideoController@cloudTranscode')->name('video.cloud.transcode');
    Route::get('/videos/{video?}/picture/order', 'VideoController@updateAttachmentOrder')->name('video.attachment.order');

    Route::get('/wechat/access-token', 'WechatController@accessToken');
    Route::get('/wechat/payment/notify', 'WechatController@paymentNotify');

    Route::get('/sms/send', 'SmsController@send');
    Route::get('/sms/residual', 'SmsController@residual');
});

