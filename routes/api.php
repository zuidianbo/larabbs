<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//测试

Route::prefix('v1')->name('api.v1.')->group(function() {
    Route::get('version', function() {
//        abort(403, '88888888');
        return 'this is version v1';
    })->name('version');
});


//Route::prefix('v2')->name('api.v2.')->group(function() {
//    Route::get('version', function() {
//        return 'this is version v2';
//    })->name('version');
//});

//namespace是控制器所在的命名空间
Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {
    // 短信验证码
//    Route::post('verificationCodes', 'VerificationCodesController@store')
//        ->name('verificationCodes.store');
});


//构建用户注册接口
//版本 控制器的命名空间 版本名 限流中间件(1分钟1次)  路由代码
Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
//    ->middleware('throttle:1,1')
    ->group(function () {
    // 短信验证码
//    Route::post('verificationCodes', 'VerificationCodesController@store')
//        ->name('verificationCodes.store');
//    // 用户注册
//    Route::post('users', 'UsersController@store')
//        ->name('users.store');

//        登录相关
        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function () {
                // 图片验证码
                Route::post('captchas', 'CaptchasController@store')
                    ->name('captchas.store');
                // 短信验证码
                Route::post('verificationCodes', 'VerificationCodesController@store')
                    ->name('verificationCodes.store');
                // 用户注册
                Route::post('users', 'UsersController@store')
                    ->name('users.store');
            });


//        访问频率相关
        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {

            });


        // 用户注册
        Route::post('users', 'UsersController@store')
            ->name('users.store');
        // 第三方登录
        Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->where('social_type', 'weixin')
            ->name('socials.authorizations.store');

        // 登录
        Route::post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');



        // 刷新token
        Route::put('authorizations/current', 'AuthorizationsController@update')
            ->name('authorizations.update');
        // 删除token
        Route::delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('authorizations.destroy');


//        返回用户信息
        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {
                // 游客可以访问的接口

                // 某个用户的详情
                Route::get('users/{user}', 'UsersController@show')
                    ->name('users.show');


                // 分类列表
                Route::get('categories', 'CategoriesController@index')
                    ->name('categories.index');

                // 当前登录用户的信息
                // 登录后可以访问的接口
                Route::middleware('auth:api')->group(function() {
                    // 当前登录用户信息
                    Route::get('user', 'UsersController@me')
                        ->name('user.show');

                    // 编辑登录用户信息
                    Route::patch('user', 'UsersController@update')
                        ->name('user.update');

                    // 上传图片
                    Route::post('images', 'ImagesController@store')
                        ->name('images.store');
                });
            });



// 游客可以访问的接口

        // 话题列表，详情
        Route::resource('topics', 'TopicsController')->only([
            'index', 'show'
        ]);


        // 登录后可以访问的接口

        // 发布话题
        Route::resource('topics', 'TopicsController')->only([
            'store', 'update', 'destroy'
        ]);



    });