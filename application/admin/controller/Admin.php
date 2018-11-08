<?php

namespace app\admin\controller;

use think\Request;
use think\Controller;
use app\common\lib\IAuth;
use app\Admin\model\AdminUser;

class Admin extends Controller
{   
    //添加用户逻辑
    public function add(Request $request,AdminUser $adminuser)
    {
        if($request->isPost()){
        	$data = $request->param();
        	$validate = validate('AdminUser');
        	
        	//出错时候报错信息
        	if(!$validate->check($data)){
        		return $this->error($validate->getError());
        	}

        	// 双重MD5加密
            //$password = md5(md5($data['password'].config('iauth.salt')));
        	$password = IAuth::setPasswordMD5($data['password']);
        	//数据入库
        	$data = [
        		'username'=>$data['username'],
        		'password'=>$password,
        		'desc'=>$data['desc'],
        		'status'=>'1'
        	];
        	try {
        		$mgid = $adminuser->add($data);
        	} catch (\Exception $e) {
        		return $this->error($e->getMessage());
        	}
        	return $this->success('id为:'.$mgid.'用户创建成功!');
        }
        
        return $this->fetch();
    }

   
}
