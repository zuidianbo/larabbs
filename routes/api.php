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




});