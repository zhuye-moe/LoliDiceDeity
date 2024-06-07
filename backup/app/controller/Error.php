<?php
namespace app\controller;

class Error
{
    public function __call(string $name,array $arguments)
    {
        // return "不存在该控制器及以下的“".$name."”";
        // return json($arguments);
    }

    public function miss()
    {
        return json([
            'code'=>'404',
            'message'=>'页面不存在',
        ])->code(404);
    }
}