<?php

namespace app\admin\model;

use think\Model;

class Base extends Model
{
	public $pk = '';

	protected $autoWriteTimestamp = true;

    //添加新闻信息
    public function add($d)
    {
    	//判断是否为数组
    	if(!is_array($d)){
    		exception('传递的数据不是数组');
    	}

    	$this->allowField(true)->save($d);
    	$id = $this->pk;	//获取到id
    	return $this->$id;
    }
}
