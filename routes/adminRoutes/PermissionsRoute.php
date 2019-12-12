<?php
/**
 * 权限路由
 */
Route::group(['prefix' => 'permission'],function (){
    Route::get('ajaxIndex','PermissionsController@ajaxIndex');
});
Route::resource('permission','PermissionsController');
