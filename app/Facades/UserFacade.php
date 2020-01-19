<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * 定义Facade定义门面
 * User: 小强
 * Date: 2018/1/14
 * Time: 15:09
 * 说明：
 */
class UserFacade extends Facade {
    /**
 * 获取组件注册名称
 */
    protected static function getFacadeAccessor() {
        return '\App\Repositories\Eloquent\UserFacadeRepository';
    }

}
