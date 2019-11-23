<?php
/**
 * 存档home的路由
 */

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/menus', 'HomeController@menus')->name('menus');
