<?php
/**
 * 权限路由
 */
Route::group(['prefix' => 'user'],function (){
    Route::get('ajaxIndex','UserController@ajaxIndex');
});
Route::resource('user','UserController');