<?php

namespace app\admin\controller;

use think\Request;
use think\Controller;

class Index extends Base
{
    //显示管理后台主页
    public function index()
    {

        //dump(session(config('iauth.admin'),'',config('iauth.app_scope')));die();
        return $this->fetch();
    }

    //显示welcome
    public function welcome()
    {
        return $this->fetch();
    }

    //退出登录 清除session 跳转到登陆页面
    public function logout()
    {
        //清除session 删除作用域下的session
        session(null);     //删除当前的session session('name', null);
        //跳转到指定的登录页面
        return $this->redirect('login/index');
    }
}
