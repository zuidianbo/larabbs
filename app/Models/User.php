<?php

//namespace App\Models;
//
//use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
//use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
//use Spatie\Permission\Traits\HasRoles;
//use Auth;

namespace App\Models;

use Auth;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;


//class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmailContract,JWTSubject
{
//    use Notifiable;

//    use Notifiable, MustVerifyEmailTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use Traits\ActiveUserHelper;


    use Traits\LastActivedAtHelper;
//    {
//        getLastActivedAtAttribute as protected getLastActivedAtAttribute1;
//    }



    use HasRoles;

    use MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }





    protected $fillable = [
        'name', 'phone', 'email', 'password', 'introduction', 'avatar',
        'weixin_openid', 'weixin_unionid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'weixin_openid', 'weixin_unionid'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    public function topics()
    {
        return $this->hasMany(Topic::class);
    }



    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

//第七章 帖子回复
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

//    清空消息

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

//修改器
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {

            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }


    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! \Str::startsWith($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }





    public function getJWTIdentifier()
    {
//        返回user的id
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
