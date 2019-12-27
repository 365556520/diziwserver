<?php
/**
 * 班车和班车线路路由
 */
Route::group(['prefix' => 'busesroute'],function (){
    //列表数据
    Route::get('ajaxIndex','BusesRouteController@ajaxIndex');
});
Route::resource('busesroute','BusesRouteController');
/* 班车路由
*/
Route::group(['prefix' => 'buses'],function (){
    //列表数据
    Route::get('ajaxIndex','BusesController@ajaxIndex');
});
Route::resource('buses','BusesController');
/**
 * 驾驶员
 */
Route::group(['prefix' => 'driver'],function (){
    //列表数据
    Route::get('ajaxIndex','DriverController@ajaxIndex');
    //上传驾驶员照片图片
    Route::post('upload','DriverController@upload');
    //批量删除
    Route::post('destroys/{id}','DriverController@destroys');
});
Route::resource('driver','DriverController');

/*
 * 视频路由
 * */
Route::group(['prefix' => 'video'],function () {
    Route::get('ajaxIndex','VideoClassController@ajaxIndex');
    //上传图片
    Route::post('upload','VideoClassController@upload');
    //上传视频
    Route::get('uploadvideo','VideoClassController@uploadvideo');
});
Route::resource('video','VideoClassController');