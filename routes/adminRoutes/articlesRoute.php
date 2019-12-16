<?php
/**
 * 文章管理
 */
//文章
Route::group(['prefix' => 'articles'],function (){
    //列表数据
    Route::get('ajaxIndex','ArticlesController@ajaxIndex');
    //上传图片
    Route::post('upload','ArticlesController@upload');
    //删除图片
    Route::post('calldel','ArticlesController@calldel');
    //批量删除文章
    Route::post('destroys/{id}','ArticlesController@destroys');
    //文章审核
    Route::post('state','ArticlesController@state');
});
Route::resource('articles','ArticlesController');
//文章分类
Route::group(['prefix' => 'categorys'],function (){
    //列表数据
    Route::get('ajaxIndex','CategorysController@ajaxIndex');
    //删除文章分类
    Route::get('destroys/{data}','CategorysController@destroys');
});
Route::resource('categorys','CategorysController');
//评论
Route::group(['prefix' => 'comments'],function (){
    //列表数据
    Route::get('ajaxIndex','CommentsController@ajaxIndex');
    //批量删除评论
    Route::get('destroys/{id}','CommentsController@destroys');
});
Route::resource('comments','CommentsController');
//便签
Route::group(['prefix' => 'note'],function (){
    //列表数据
    Route::get('ajaxIndex','NoteController@ajaxIndex');
    //批量删除评论
    Route::get('destroys/{id}','NoteController@destroys');
});
Route::resource('note','NoteController');