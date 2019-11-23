<?php
namespace App\Repositories\Eloquent;
/**
 * Cos门面
 * User: admin
 * Date: 2018/1/14
 * Time: 9:43
 */

use App\Repositories\Contracts\CosInterface;
use Qcloud\Cos\Client;
class CosFacade implements CosInterface {
    public  $cosClient;
    //获取cos连接对象
    public function __construct(){
        /*    #这里请填写cos-autoloader.php该文件所在的相对路径这个地方说是需要但是目前没导入也没问题
         require(public_path().'/backend/myvebdors/cos-php-sdk-v5-master/cos-autoloader.php');*/
        /*
         * region腾讯COS的区域
         * appId，secretId，secretKey
         * */
        $this->cosClient = new Client(
            array(
                'region' => config('admin.cos.region'),
                'credentials'=> array(
                    'appId' => config('admin.cos.credentials.appId'),
                    'secretId' => config('admin.cos.credentials.secretId'),
                    'secretKey' => config('admin.cos.credentials.secretKey')
                )
            )
        );
    }

    /*
       *   putObject()上传文件(上传文件的内容，可以为文件流或字节流)
        *  $bucketName 类型string 存储桶名称必须为（bucket的命名规则为{name}-{appid} ）
        *  $saveCosFled 类型string  上传文件的路径名和名称，默认从 Bucket 开始 例如:img/head.jpg
        *  $upFled  类型string  上传文件的内容，可以为文件流或字节流
        *  上传成功上传的信息
       * */
    public function putObject($bucketName,$saveCosFled,$upFled){
        try {
            $result =  $this->cosClient->putObject(array(
                'Bucket' => $bucketName,
                'Key' => $saveCosFled,
                'Body' => $upFled
            ));
            return $result;
        } catch (\Exception $e) {
            echo "$e\n";
        }
    }
    /*
     * puCosFled()
     * 说明: 单文件小于5M时，使用单文件上传,反之使用分片上传
     *  $bucketName 类型string 存储桶名称必须为（bucket的命名规则为{name}-{appid} ）
     *  $saveCosFled 类型string  上传文件的路径名和名称，默认从 Bucket 开始 例如:img/head.jpg
     *  $upFled  类型string  本地要上传文件的位置  例如$upFled = public_path().'/backend/images/黄蓉.mp4';
     *  上传成功上传的信息
     * */
    public function puCosFled($bucketName,$saveCosFled,$upFled){
        //上传文件
        try {
            $result =  $this->cosClient->upload(
                $bucket= $bucketName,
                $key = $saveCosFled,
                $body = fopen($upFled,'rb'),
                $options = array(
                    "ACL"=>'public-read-write',
                    'CacheControl' => 'private'
                ));
            return $result;
        } catch (\Exception $e) {
            echo "$e\n";
        }
    }
    /*
     * 删除COS对象
     *  * $bucketName 类型string 存储桶名称必须为（bucket的命名规则为{name}-{appid} ）
     * $deleteObject 要删除的对象
     * */
    public function deleteObject($bucketName,$deleteObject){

        $result = $this->cosClient->deleteObject(array(
            //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
            'Bucket' => $bucketName,
            'Key' => $deleteObject
        ));
        return $result;
    }
    /*
     * 获取cos文件的列表
     * $prefix可选得到文件前缀（可以指某路径下的文件或者特定文件名字）
     * */
    public function listObjects($bucketName,$prefix=''){
        return $this->cosClient->listObjects(array('Bucket' => $bucketName,'Prefix' => $prefix));
    }


}