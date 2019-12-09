<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::group(['namespace'=>'Auth'],function () {
    //成功页面
    Route::get('auth/success/{massage}', 'RegisterController@success');
    // 引导用户到新浪微博的登录授权页面
    /*  guest 中间件，该中间件的用途是登录用户访问该路由会跳转到指定认证后页面，而非登录用户访问才会显示登录页面*/
    Route::get('auth/{social}', 'LoginController@getSocialRedirect')->middleware('guest');
// 用户授权后新浪微博回调的页面
    Route::get('auth/{social}/callback', 'LoginController@getSocialCallback')->middleware('guest');
    //第三方绑定本网用户页面
    Route::get('auth/correlation', 'LoginController@correlation');
});
Route::group(['prefix' => 'admin','namespace'=>'Admin','middleware' => ['auth']],function (){
    //后台页面__DIR__表示当前目录
    require(__DIR__.'/adminRoutes/HomeRoute.php');
    //权限路由
    require(__DIR__.'/adminRoutes/PermissionsRoute.php');
    //角色路由
    require(__DIR__.'/adminRoutes/RoleRoute.php');
    //用户路由
    require(__DIR__.'/adminRoutes/UserRoute.php');
});

