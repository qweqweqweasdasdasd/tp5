<?php 
namespace app\admin\controller;

use think\Request;
use think\Controller;

//后台基类
class Base extends Controller
{
	//当前的页码
	protected $page = '';
	//显示条数
	protected $size = '';

	//起始位置
	protected $form = '';

	//定义 
	protected $model = '';

	//基类初始化方法
	public function initialize()
	{
		//判断用户是否存在
		$isLogin = $this->isLogin();
		if(!$isLogin){
			return $this->redirect('login/index');
		}

	}

	//判断用户是否登录
	public function isLogin()
	{
		$user = session(config('iauth.admin'),'',config('iauth.app_scope'));
		//var_dump($user);
		if($user && $user->mg_id){
			return true;
		}
		return false;
	}

	//获取到当前页 和 显示条数
	public function getPageAndSize($data)
	{
		$this->page = !empty($data['page']) ? $data['page']:1;
        $this->size = !empty($data['size']) ? $data['size']:config('iauth.size');
        //起始位置
		$this->form = ($this->page - 1) * $this->size;
	}

	//通用化的指定删除
	public function delete(Request $request,$id = 0)
	{
		if(!intval($id)){
			return ['code'=>config('iauth.error'),'error'=>'id不合法!'];
		}
		
			$model = $this->model ? $this->model :$request->controller();
		
		try {
			$res = model($model)->save(['status'=>'-1'],['n_id'=>$id]);
		} catch (\Exception $e) {
			return ['code'=>config('iauth.error'),'error'=>$e->getMessage()];	
		}

		//留给接口的
		if($res){
			return ['code'=>config('iauth.success'),'url'=>$_SERVER['HTTP_REFERER']];
		}
		return ['code'=>config('iauth.error')];

	}

	//新闻状态修改
    public function status(Request $request)
    {
        if($request->ispost()){
            $data = $request->param();
            //tp5 valite 机制

            //通过id 查询库内的是否有次记录
            $model = $this->model ? $this->model : $request->controller();

            try {

				$res = model($model)->save(['status'=>$data['status']],['n_id'=>$data['id']]);

			} catch (\Exception $e) {
				return ['code'=>config('iauth.error'),'error'=>$e->getMessage()];	
			}

			if($res){
				return ['code'=>config('iauth.success'),'url'=>$_SERVER['HTTP_REFERER']];
			}
			return ['code'=>config('iauth.error')];
        }

    }

}