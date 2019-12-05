<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    /*
     * $configk 参数是中间件中config/admin下面permissions中的键名
     * */
    public function __construct()
    {

    }
    //返回数据模式
    public function response($code = 200,$msg = "",$data){
        return ['code' => $code,'msg'=>$msg,'data' => $data];
    }
}
