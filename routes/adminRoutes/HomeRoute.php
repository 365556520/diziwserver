<?php
/**
 * 存档home的路由
 */

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/menus', 'HomeController@menus')->name('menus'); //左侧菜单数据
//图标路由
Route::get('icons', 'MenuController@icons');
/*菜单资源路由*/
Route::resource('menu','MenuController');
//列表数据
Route::group(['prefix' => 'menus'],function () {
    Route::get('ajaxIndex', 'MenuController@ajaxIndex');
});
