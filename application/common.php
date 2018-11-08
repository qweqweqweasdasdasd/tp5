<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function pagination($obj)
{
	if(!$obj){
		return '';
	}
	$params = request()->param();

	return $obj->appends($params)->render();
}

//获取栏目名称
function getCateName($cateId)
{
	if(!$cateId){
		return '';
	}
	$cate = config('cate.lists');

	return !empty($cate[$cateId]) ? $cate[$cateId] :'';
}

//是否推荐
function isYesOrNo($int)	// 1 || 0
{
	return $int ? '<span style="color: red">是</span>' : '<span >否</span>';
}

//状态数值
function status($id,$status)
{
	$controller = request()->controller();

	$sta = $status == 1 ? 0 :1;
	$url = url($controller.'/status',['id'=>$id,'status'=>$sta]);

	if($status == 1){
		$str = '<a herf="javascript:;" title="正常" status_url="'.$url.'" onclick="app_status(this)" ><span class="label label-success radius">正常<span></a>';
	}else if($status == 0){
		$str = '<a herf="javascript:;" title="待审" status_url="'.$url.'" onclick="app_status(this)"><span class="label label-danger radius">待审</span></a>';
	}

	return $str;
}

//接口数据通用化封装
function show_json($status,$message,$data=[],$httpCode=200)
{
	$data = [
		'status'=>$status,
		'message'=>$message,
		'data'=>$data,
	];
	return json($data,$httpCode);
}
