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
    //七牛存储对象实例
    public function getQiniuAuth(){
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = env('QINIU_ACCESSKEY');
        $secretKey = env('QINIU_SECRETKEY');
        // 构建鉴权对象
        return new Auth($accessKey, $secretKey);
    }

    //获取七牛上传token
    public function getQiniuToken(){
        // 构建鉴权对象
        $auth = $this->getQiniuAuth();
        // 要上传的空间
        $bucket = env('QINIU_BUCKET');
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        return $token;
    }
    /*删除空间中的文件
        $auth 为七牛的token令牌
        $bucket 要删除的空间
         $key 要删除的文件
    */
    public function qiniuDataDel($bucket,$key){
        $auth = $this->getQiniuAuth();
        $config = new \Qiniu\Config();
        $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
        $err = $bucketManager->delete($bucket,$key);
        if ($err) {

            return false;
        }
        return true;
    }
}
