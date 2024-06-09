<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::miss(route:'Error/miss');//当没有定位到路由时的跳转

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('/', 'index');
Route::get('hello/:name', 'index/hello');

//用户登录
Route::group('user',function(){
    Route::get('login','userController/login');
    Route::get('logout','userController/logout');
    Route::get('read','userController/read');
});
