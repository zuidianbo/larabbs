<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{

//    首页
    public function root()
    {

//        测试 是否已经验证了邮箱

//        dd(\Auth::user()->hasVerifiedEmail());
        return view('pages.root');

    }



}
