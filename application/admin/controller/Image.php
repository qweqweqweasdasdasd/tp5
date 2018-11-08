<?php

namespace app\Admin\controller;

use think\Request;
use think\Controller;
use app\common\lib\Upload;

class Image extends Controller
{
    //图片上传== 本地服务器
    public function uploadLocal(Request $request)
    {
        //获取到文件
        $file = $request->file('file');
        //移动到框架指定的位置
        $info = $file->rule('md5')->move('upload');
        if($info && $info->getPathname()){
            $data = [
                'path'=> '/'.$info->getPathname(),
            ];
            return $this->result($data,config('iauth.success'),'上传成功','json');
        }
        return ['code'=>config('iauth.error'),'error','上传失败'];
    }

    //图片上传== aliyun
    public function upload()
    {
        //抛出异常
        try {
            $image = Upload::image();
        } catch (\Exception $e) {
            return ['code'=>config('iauth.error'),'error'=>$e->getMessage()];  
        }

        if($image['code'] == 1){
            $data = [
                'path'=>$image['url'],
            ];
            return $this->result($data,config('iauth.success'),'上传成功','json');
        }   
        return ['code'=>config('iauth.error'),'error'=>$image['error']];
    }
}
