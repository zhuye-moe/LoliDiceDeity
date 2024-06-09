<?php

namespace app\controller;

use app\BaseController;
use tauthz\facade\Enforcer;

class Index extends BaseController
{
    public function index()
    {
        
            return re_mew('萝莉神的骰子')->success('请求成功');
        
        
        re_mew()->exception('失败');
    }

    public function hello($name = 'ThinkPHP8')
    {
        return 'hello,' . $name;
    }
}
