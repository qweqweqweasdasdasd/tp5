<?php  
namespace app\common\validate;

use think\Validate;

class AdminUser extends Validate
{
	protected $rule = [
		'username'=>'require|max:12',
		'password'=>'require|confirm|max:12',
		'desc'=>'max:255',
	];

	
}
