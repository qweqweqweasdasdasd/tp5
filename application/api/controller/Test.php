<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\common\lib\exception\ApiException;


class Test extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return json_encode(['123123','234']);
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
     * 保存新建的资源  201
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->param();
        if($data['mt'] != 1){
            //return exception('你提交的数据不合法!',400);
            throw new ApiException('你提交的数据不合法',400);

              
        }
        //解决方案一
        /*try {
            model('12312'); //错误app识别不了
            
        } catch (\Exception $e) {
            return show_json(0,$e->getMessage(),400);   //{"status":0,"message":"class not exists:app\\common\\model\\12312","data":400}
        }*/
        //model('12312312');
        //方案二
        
        //return json_encode($request->param());
        //return json_encode($request->param());  //config 文件不管用    
        //接口数据返回给app

       /* $data = [
            'status'=>1,
            'message'=>'ok',
            'data'=>$request->param()
        ];
        return json($data,201);*/

        return show_json(1,'ok',$request->param(),201);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
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
        $d = $request->param();    // 
        return json_encode($d); //
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
}
