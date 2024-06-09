<?php
declare (strict_types = 1);

namespace app\controller;

use app\model\User;
use think\Request;

class UserController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示用户信息
     *
     * @return \think\Response
     */
    public function read()
    {
        //
        // $user = Auth::user();
        $user = auth()->user();
        // $user_data = [
        //     'username' => $user->username,
        //     'token' => $user->test_token
        // ];
        return re_mew($user)->success('请求成功');
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

    /**
     * 登录
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function login(Request $request)
    {
        $login = auth()->login(User::find(1), $remember = false);
        
        return re_mew($login)->success('登录成功');
    }

    /**
     * 退出登录
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function logout(Request $request)
    {
        $logout = auth()->logout();
        return re_mew($logout)->success('请求成功');
    }

}
