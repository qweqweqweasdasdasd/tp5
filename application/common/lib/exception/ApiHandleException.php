<?php 
namespace app\common\lib\exception;

use think\exception\Handle;
/**
 * 自定义api  接口类
 * 重写了exception 类
 */
class ApiHandleException extends Handle
{
	public $httpCode = 500;	//测试的位置
	//重写该方法
	public function render(\Exception $e)
    {
    	if(config('app.app_debug') == true){
    		return parent::render($e);
    	}
    	if($e instanceof ApiException){	//instanceof 判断变量是否属于某个类
    		$this->httpCode = $e->httpCode;
    	}
    	return show_json(0,$e->getMessage(),[],$this->httpCode);
    }
}	