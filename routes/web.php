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

//首页

//Route::get('/', 'PagesController@root')->name('root');

Route::get('/', 'TopicsController@index')->name('root');

//--------------------

//Auth::routes();

// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

//--------------------

//第四章 用户相关


Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
//相当于
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');
//Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
//Route::patch('/users/{user}', 'UsersController@update')->name('users.update');


//--------------------

//第五章 帖子列表

//Route::resource('topics', 'TopicsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
//重写了show
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');



//分类列表
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);


//第六章 上传图片
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

//第七章 帖子回复

//Route::resource('replies', 'RepliesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

//通知列表

Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

//第八章
//后台 无权限提醒
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');