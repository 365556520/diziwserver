<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    /*
        * $configk 参数是中间件中config/admin下面permissions中的键名
        * */
    public function __construct($configk)
    {
        //添加自定义路由的权限控制中间件
        $this->middleware('check.permission:'.$configk);
    }
    //返回数据模式
    public function response($code = 200,$msg = "",$data){
        return ['code' => $code,'msg'=>$msg,'data' => $data];
    }
}
