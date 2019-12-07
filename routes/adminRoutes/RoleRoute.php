<?php
/**
 * 权限路由
 */
Route::group(['prefix' => 'roles'],function (){
    Route::get('ajaxIndex','RolesController@ajaxIndex');
    //授权
    Route::post('upPermission','RolesController@upPermission');
    //
    Route::post('destroyPermission','RolesController@destroyPermission');
});
Route::resource('roles','RolesController');
