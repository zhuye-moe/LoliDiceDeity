<?php
use think\facade\Route;

Route::miss(route:'Error/miss');//当没有定位到路由时的跳转

Route::get('loli', function () {
    return '_(:з」∠)_';
});

Route::get('/', 'index');
Route::get('hello/:name', 'index/hello');

//用户登录
Route::group('user',function(){
    Route::post('login','userController/login');
    Route::get('logout','userController/logout');
    Route::get('read','userController/read');
});

//暂时先不弄用户权限校验和角色权限控制

//
