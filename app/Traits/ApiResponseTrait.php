<?php
namespace App\Traits;

trait ResponseTrait
{
    //api接口统一返回Trait
    public function response($code, $desc=null, $result=null){
        $arr = [
            'code' => $code,
            'desc' => $desc,
            'result' => $result
        ];
        print json_encode($arr, true);
        exit(0);
    }
}
