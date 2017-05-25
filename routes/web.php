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

Route::get('/', 'VodController@index');
Route::group(['middleware' => ['web']], function () {
    Route::auth();
    Route::get('/', 'VodController@index');
    Route::get('/video/{video?}', 'VodController@video');
});


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
    Route::resource('courses', 'CourseController');
    Route::resource('lessons', 'LessonController');
    Route::resource('comments', 'CommentController');
    Route::resource('orders', 'OrderController');
    Route::resource('videos', 'VideoController');
    Route::resource('courses', 'Course1Controller');
    Route::get('/settings/message', 'SettingController@message');
    Route::get('/settings/teacher', 'SettingController@teacher');
    Route::get('/settings/creview', 'SettingController@creview');
    Route::resource('settings', 'SettingController');
    Route::resource('mines', 'MineController');
    Route::get('/videos/{video?}/cloud/info', 'VideoController@cloudInfo')->name('video.cloud.info');
    Route::get('/videos/{video?}/cloud/transcode', 'VideoController@cloudTranscode')->name('video.cloud.transcode');
    Route::get('/videos/{video?}/picture/order', 'VideoController@updateAttachmentOrder')->name('video.attachment.order');
    
});

