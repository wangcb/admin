<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;


Route::get('user/:id$', 'user/detail')->pattern(['id' => '\d+']);//详情
Route::get('user/menu$', 'user/menu');
Route::get('user$', 'user/lists');//列表
Route::post('user$', 'user/create');//新增
Route::put('user/state$', 'user/state');//修改状态
Route::put('user$', 'user/edit');//修改
Route::delete('user$', 'user/delete');//删除

Route::post('role/users', 'role/users');
Route::post('role/permission$', 'role/permission');
Route::get('role/:id$', 'role/detail')->pattern(['id' => '\d+']);
Route::get('role/menu$', 'role/menu');
Route::get('role$', 'role/lists');
Route::post('role$', 'role/create');
Route::put('role$', 'role/edit');
Route::delete('role$', 'role/delete');

Route::get('permission$', 'permission/lists');
Route::post('permission$', 'permission/create');
Route::put('permission$', 'permission/edit');
Route::delete('permission$', 'permission/delete');

Route::get('attribute/meun$','attribute/meun');//获取
Route::get('attribute$','attribute/lists');//获取
Route::post('attribute$','attribute/create');//添加
Route::put('attribute$','attribute/edit');//更新
Route::delete('attribute','attribute/delete');//更新

Route::get('attribute/value/:id$','attribute/values');//获取属性键值
Route::post('attribute/value$','attribute/createValue');//添加
Route::put('attribute/value$','attribute/editValue');//更新
Route::delete('attribute/value$','attribute/deleteValue');//更新

Route::group('media',function(){
    Route::get('$', 'media/lists');//列表
    Route::get('/:id$', 'media/detail');
    Route::post('$', 'media/create');//添加
    Route::put('$', 'media/edit');//添加
    Route::delete('$', 'media/delete');//添加
});

Route::group('article',function(){
    Route::get('$', 'article/lists');//
    Route::get('/:id$', 'article/detail');//
    Route::post('$', 'article/create');//
    Route::put('state$', 'article/state');//
});

Route::group('order',function(){
    Route::post('$', 'order/create');//
});

Route::group('transaction',function(){
    Route::get('$', 'user/transaction');//
});

Route::get('verify$', 'index/verify')->ext('html');//