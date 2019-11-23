<?php
namespace App\Repositories\Contracts;
/**
 * Cos对象存储接口
 * User: Administrator
 * Date: 2018/1/14
 * Time: 9:28
 * 自定义接口
 */
interface CosInterface
{
        /*
     *   putObject()上传文件(上传文件的内容，可以为文件流或字节流)
      *  $bucketName 类型string 存储桶名称必须为（bucket的命名规则为{name}-{appid} ）
      *  $saveCosFled 类型string  上传文件的路径名和名称，默认从 Bucket 开始 例如:img/head.jpg
      *  $upFled  类型string  上传文件的内容，可以为文件流或字节流
      *  上传成功上传的信息
     * */
    public function putObject($bucketName,$saveCosFled,$upFled);
    /*
   * puCosFled()
   * 说明: 单文件小于5M时，使用单文件上传,反之使用分片上传
   *  $bucketName 类型string 存储桶名称必须为（bucket的命名规则为{name}-{appid} ）
   *  $saveCosFled 类型string  上传文件的路径名和名称，默认从 Bucket 开始 例如:img/head.jpg
   *  $upFled  类型string  本地要上传文件的位置  例如$upFled = public_path().'/backend/images/黄蓉.mp4';
   *  上传成功上传的信息
   * */
    public function puCosFled($bucketName,$saveCosFled,$upFled);
}