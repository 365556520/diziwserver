<?php
/**
 * 存档home的路由
 */

Route::get('/homepage', 'HomeController@homepage')->name('homepage');
Route::get('/menus', 'HomeController@menus')->name('menus'); //左侧菜单数据
//图标路由
Route::get('icons', 'MenuController@icons');
/*菜单资源路由*/
Route::resource('menu','MenuController');
//列表数据
Route::group(['prefix' => 'menus'],function () {
    Route::get('ajaxIndex', 'MenuController@ajaxIndex');
});

//修改图像
Route::get('showheadimg','HomeController@showheadimg')->name('showheadimg');
//上传图片
Route::post('headimg','HomeController@headimg')->name('headimg');
//修改用户资料
Route::resource('home','HomeController');
