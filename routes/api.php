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
    Route::post('verificationCodes', 'VerificationCodesController@store')
        ->name('verificationCodes.store');
});