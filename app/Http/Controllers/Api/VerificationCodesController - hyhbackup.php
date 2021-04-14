<?php

namespace App\Http\Controllers\Api;

//use App\Http\Controllers\Controller;
//这样会 自动 继承相同命名空间下的 Controller。


use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerificationCodeRequest;

class VerificationCodesController extends Controller
{
//    public function store()
//    {
//        return response()->json(['test_message' => 'store verification code','test_message1' => 'store verification code']);
//    }

    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {


//        发送真实的短信 好用
        $phone = $request->phone;

        // 生成4位随机数，左侧补0
//        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
//
//        try {
//            $result = $easySms->send($phone, [
//                'template' => config('easysms.gateways.aliyun.templates.register'),
//                'data' => [
//                    'code' => $code
//                ],
//            ]);
//        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
//            $message = $exception->getException('aliyun')->getMessage();
//            abort(500, $message ?: '短信发送异常');
//        }

//

//        用本段代码代替上面被屏蔽的部分，可以生成假的验证码1234 ,节约短信费用。
        if (!app()->environment('production')) {
            $code = '1234';
        } else {
            // 生成4位随机数，左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            try {
                $result = $easySms->send($phone, [
                    'template' => config('easysms.gateways.aliyun.templates.register'),
                    'data' => [
                        'code' => $code
                    ],
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('aliyun')->getMessage();
                abort(500, $message ?: '短信发送异常');
            }
        }
//        ---用本段代码代替上面被屏蔽的部分，可以生成假的验证码1234 ,节约短信费用。

        $key = 'verificationCode_'.Str::random(15);
        $expiredAt = now()->addMinutes(5);
        // 缓存验证码 5 分钟过期。
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return response()->json([
            'key' => $key,
            'code' => $code,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);



    }

}
