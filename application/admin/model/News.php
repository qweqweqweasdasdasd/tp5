<?php

namespace app\admin\model;

use think\Model;

class News extends Base
{
	//后台自动分页
	public function getNews()
	{
		//不等于 -1 
		$data['status'] = [
			'<>',config('iauth.status_delete')
		];

		//$order
		$order = ['n_id'=>'desc'];

		//查询
		$result = $this->where($data)
			->order($order)
			->paginate(3);

		return $result;
	}

	//模式二分页
	public function getNewsByCondition($data,$form=0,$size=2)
	{
		//条件约束
    
		//排序
		$order = ['n_id'=>'desc'];

		$result = $this->where(function($query) use($data){
				if(empty($data['status'])){

					$query->where('status','<>', config('iauth.status_delete'));
				}
				//分类id
				if(!empty($data['cateid'])){
					$query->where('cateid',intval($data['cateid']));
				}

				//模拟查询
				if(!empty($data['title'])){
		            $query->where('title','like','%'.$data['title'].'%');
		        }

		        //日期查询
		        if(!empty($data['start_time']) && !empty($data['end_time']) && ($data['end_time'] > $data['start_time'])){
		        	$query->where('create_time','between',[strtotime($data['start_time']),strtotime($data['end_time'])]);
		        }
			})
			->limit($form,$size)	//起始位置
			->order($order)
			->select();

		echo $this->getLastSql();
		return $result;
	}

	//模式二
	public function getNewsCountCondition($condition = [])
	{
		//条件约束
		$condition[] = ['status','<>',config('iauth.status_delete')];
		//获取条件之后的总量
		$result = $this->where($condition)
			->count();
		//echo $this->getLastSql();
		return $result;
	}
}
