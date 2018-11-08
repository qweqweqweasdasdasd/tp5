<?php 
namespace app\common\lib\exception;

use think\Exception;
/**
 * 自定义api  接口类
 * 重写了exception 类
 */
class ApiException extends Exception
{
	public $message = '';
	public $httpCode = 500;
	public $code = 0;

	public function __construct($message = '',$httpCode = 0,$code =0)
	{
		$this->httpCode = $httpCode;
		$this->message = $message;
		$this->code = $code;
	}
}	