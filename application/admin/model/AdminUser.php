<?php

namespace app\Admin\model;

use think\Model;

class AdminUser extends Model
{
	protected $pk = 'mg_id';

	protected $autoWriteTimestamp = true;

    //创建模型数据方法
    public function add($d)
    {
    	if(!is_array($d)){
    		exception('传递的数据不是数组');
    	}

    	$this->allowField(true)->save($d);

    	return $this->mg_id;
    }

}
