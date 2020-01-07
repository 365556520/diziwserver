<?php
/**
 * 商品管理
 */
//商品分类
Route::group(['prefix' => 'goodscategorys'],function (){
    //列表数据
    Route::get('ajaxIndex','GoodsCategorysController@ajaxIndex');
});
Route::resource('goodscategorys','GoodsCategorysController');
//商品管理
Route::group(['prefix' => 'goods'],function (){
    //列表数据
    Route::get('ajaxIndex','GoodsController@ajaxIndex');
    //树形列表
    Route::post('dtree','GoodsController@dtree');
    //商品信息统计
    Route::get('goodshome','GoodsController@goodshome');

});
Route::resource('goods','GoodsController');
//进货
Route::group(['prefix' => 'goodsstock'],function (){
    //列表数据
    Route::get('ajaxIndex','GoodsStockController@ajaxIndex');

});
Route::resource('goodsstock','GoodsStockController');

//订单
Route::group(['prefix' => 'goodsorder'],function (){
    //列表数据
    Route::get('ajaxIndex','GoodsOrderController@ajaxIndex');
});
Route::resource('goodsorder','GoodsOrderController');