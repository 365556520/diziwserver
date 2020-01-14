<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
/*定义基于 Dingo 路由器的 API 路由
Dingo\Api\Facade\API：该门面主要用于 API 调度；
Dingo\Api\Facade\Route：该门面主要用于 API 路由，可用于获取当前路由、请求、检查路由名称等
*/
$api = app(\Dingo\Api\Routing\Router::class);
$api->version('v1', function ($api) {
    $api->group(['namespace'=>'\App\Http\Controllers\Api'],function($api) {
        $api->group(['namespace'=>'\Articles'],function($api) {
            //分类
            $api->get('getCategorys','ApiCategorysController@getCategorys');
        });
    });
});
$api->version('v2', function ($api) {
    $api->get('/task/{id}', function ($id) {
        return '我是版本2'.$id;
    });
});
