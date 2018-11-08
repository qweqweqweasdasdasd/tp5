<?php 
namespace app\common\lib;

use OSS\OssClient;
use OSS\Core\OssException;
/**
 * 上传图片到阿里云 oos
 */
class  Upload 
{
	public static function image()
	{
		if(empty($_FILES['file']['tmp_name'])){	//没有必要
			exception('您提交的图片不合法',404);
		}
		//实例化 阿里云连接 oos
		try {
			//实例化对象把配置专递进去
			$client = new OssClient(config('aliyun.ak'),config('aliyun.sk'),config('aliyun.endpoint'));
			//这里有md5 加密 生成文件名 之后连接后缀
			$ext = explode('.',$_FILES['file']['name'])[1];		//后缀名称
			$filename = date('Y').'/'.date('m').'/'.uniqid().'.'.$ext;

			//执行阿里云上传
			$result = $client->uploadFile(config('aliyun.bucket'),$filename,$_FILES['file']['tmp_name']);

			
			//返回数据
			return ['code'=>config('iauth.success'),'url'=>$result['info']['url']];
			//var_dump($client);
		} catch (OssException $e) {
			return ['code'=>config('iauth.error'),'error'=>$e->getMessage()];
		}
		
	}
}