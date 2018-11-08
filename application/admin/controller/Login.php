<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\lib\IAuth;
use app\Admin\model\AdminUser;

class Login extends Base
{
    //重写基类的方法
    public function initialize(){}  //方法重写之后 登录判断是否登录登陆的话跳转到index/index
    //用户登录的逻辑
    public function index(Request $request,AdminUser $user)
    {
        if($request->isPost()){
            $data = $request->param();

            //validate
            $validate = validate('AdminLogin');

            //验证码是否ok
            if(!$validate->check($data)){
                return $this->error($validate->getError());
            }

            try {
                //验证用户是否存在
                $u = AdminUser::where('username',$data['username'])->find();
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }

            if(!$u || ($u->status != config('iauth.status_normal'))){
                return $this->error('该用户不存在!');
            }

            //验证用户密码是否正确
            //$password = md5(md5($data['password'].config('iauth.salt')));
            if($u->password != IAuth::setPasswordMD5($data['password'])){
                return $this->error('密码有问题!');
            }
            try {
                //1,更新数据库 登录时间 登录ip
                $update = [
                    'last_login_ip'=>$request->ip(0,true),
                    'last_login_time'=>time()
                ];
                $user->save($update,['mg_id'=>$u->mg_id]);
            } catch (\Exception $e) {  
                return $this->error($e->getMessage());
            }
            // session 存放到 session  三个参数 key value 作用域
            session(config('iauth.admin'),$u,config('iauth.app_scope'));
            $this->success('登录成功','index/index');
        }
        $isLogin = $this->isLogin();
        if($isLogin){
            return redirect('index/index');
        }
        return $this->fetch();
    }
}
