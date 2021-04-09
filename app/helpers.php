<?php
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

//导航active用
function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}


//创建帖子保存的时候，生成excerpt字段的数据
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return Str::limit($excerpt, $length);
}

?>