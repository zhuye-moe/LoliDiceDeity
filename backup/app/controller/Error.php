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
            'message'=>'试图插入一个不存在接口呢，真是扎古～扎—~古～(*ノ` ▽｀) ～♡',
        ])->code(404);
    }
}