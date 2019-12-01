<?php
/**
 * 权限路由
 */
Route::group(['prefix' => 'permissions'],function (){
    Route::get('ajaxIndex','PermissionsController@ajaxIndex');
});
Route::resource('permissions','PermissionsController');
