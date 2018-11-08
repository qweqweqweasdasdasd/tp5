<?php 
namespace app\common\lib;

class IAuth
{
	//返回 MD5 双重加密
	public static function setPasswordMD5($pwd)
	{
		return md5(md5($pwd.config('iauth.salt')));
	}

}