<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;


class CheckPermission
{
    /**
     * 后台自定义中间件
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$model){
        if(\auth()->user()->hasRole('admin')){//判断角色是否超级管理员 如果是超级管理员直接通过
            return $next($request);
        }
        if ($model == config('admin.permissions.system.login')) {
            $this->check($request,$model);
        }
        //获取当前用户路由名称
        $routeName = Route::currentRouteName();

        $permission = '';
        //用switch获取链接对应的权限
        switch ($routeName) {
            case $model.'.index':
                $permission = config('admin.permissions.'.$model.'.list','');
                break;
            case $model.'.create':
            case $model.'.store':
                $permission = config('admin.permissions.'.$model.'.add','');
                break;
            case $model.'.edit':
            case $model.'.update':
                $permission = config('admin.permissions.'.$model.'.edit','');
                break;
            case $model.'.show':
                $permission = config('admin.permissions.'.$model.'.show','');
                break;
            case $model.'.destroy':
            case $model.'.destroys':
                $permission = config('admin.permissions.'.$model.'.delete','');
                break;
            default:
                return $next($request); //其他情况直接通过
        }
       $this->check($request,$permission);
        return $next($request);
    }
    private function check($request,$permission){
        //判断有没有登录后台权限
        if (!\auth()->user()->hasPermissionTo($permission)) {
            abort(500,trans('admin/errors.permissions'));
        }
    }
}
