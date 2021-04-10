<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;
use App\Models\User;git add -A
git config --global core.autocrlf false
git add -A
class CategoriesController extends Controller
{
//    public function show(Category $category)
//    {
//        // 读取分类 ID 关联的话题，并按每 20 条分页
//        $topics = Topic::where('category_id', $category->id)->paginate(20);
//        // 传参变量话题和分类到模板中
//        return view('topics.index', compact('topics', 'category'));




//        public function show(Category $category, Request $request, Topic $topic)
//    {
//        // 读取分类 ID 关联的话题，并按每 20 条分页
//        $topics = $topic->withOrder($request->order)
//            ->where('category_id', $category->id)
//            ->with('user', 'category')   // 预加载防止 N+1 问题
//            ->paginate(20);
//
//        // 传参变量话题和分类到模板中
//        return view('topics.index', compact('topics', 'category'));
//    }




    public function show(Category $category, Request $request, Topic $topic, User $user)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = $topic->withOrder($request->order)
            ->where('category_id', $category->id)
            ->with('user', 'category')   // 预加载防止 N+1 问题
            ->paginate(20);
        // 活跃用户列表
        $active_users = $user->getActiveUsers();

        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category', 'active_users'));
    }


    }
//}
