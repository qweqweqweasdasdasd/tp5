<?php 
namespace app\common\validate;

use think\Validate;

class AdminLogin extends Validate
{
	//验证码规则
	protected $rule = [
		'username'=>'require|max:12',
		'password'=>'require|max:12',
		'code|验证码'=>'require|captcha',
	];
}