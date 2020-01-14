<?php
namespace App\Traits;

trait ApiResponseTrait
{
    //api接口统一返回Trait
    public function response($data,$msg = null,$code = null){
        $arr = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        return json_encode($arr, true);
    }
}
