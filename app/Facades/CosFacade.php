<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * 定义Cos使用门面
 * User: 小强
 * Date: 2018/1/14
 * Time: 15:09
 * 说明：
 */
class CosFacade extends Facade {
    /**
 * 获取组件注册名称
     * 注册这里后门面就可以用静态方法了
 */
    protected static function getFacadeAccessor() {
        return 'CosFacade';
    }

}