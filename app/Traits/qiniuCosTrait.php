<?php
namespace App\Traits;

// 引入
use Qiniu\Auth;
/**
 * 获取七牛COS存储
 * User: 小强
 * Date: 2018/3/20
 * Time: 8:59
 * 说明：
 */
trait qiniuCosTrait{
    //获取七牛token
    public function getQiniuToken(){
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = env('QINIU_ACCESSKEY');
        $secretKey = env('QINIU_SECRETKEY');
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 要上传的空间
        $bucket = env('QINIU_BUCKET');
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        return $token;
    }

}
