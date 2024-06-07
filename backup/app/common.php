<?php
// 应用公共文件


/**
 * 返回API json 数组
 * 
 * @param array $result
 * @return object
 */
function re_mew($result = [])
:object{

    $re_mew = new app\utils\Response();
    return $re_mew->data($result);
}