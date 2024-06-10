<?php
// declare (strict_types = 1);

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
        if($user){
            return re_mew($user->toArray())->success('获取成功');
        }
        return re_mew()->success('数据错误');
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
        $login = auth()->attempt(['username'=>'admin',"password" => "123456"]);
        if ($login){ 
            $user = auth()->user();
            // 暂时先不管token吧
            // $token = $user->createToken("test-token");
            $data = [
                'user' => auth()->user(),
                // 'access_token' => $token,
                // 'token_type' => 'bearer',
                // 'expires_in' => auth('jwt')->factory()->getTTL() * 60,
                // 'claims' => auth('jwt')->getPayload()
            ];
            return re_mew($data)->success('登录成功');
        } else{
            return re_mew()->success('登录失败');
        }
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
