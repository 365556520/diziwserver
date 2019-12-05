<?php
/**
 * 权限路由
 */
Route::group(['prefix' => 'roles'],function (){
    Route::get('ajaxIndex','RolesController@ajaxIndex');
    //授权
    Route::post('upPermission','RolesController@upPermission');
});
Route::resource('roles','RolesController');
