<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//路由  获取方式 名称          控制器   方法//字符串格式//前台主页路由器
Route::get("/","Home\IndexController@index");
//路由分组
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){

    Route::get("manager/login","ManagerController@login");
//后台主页路由
    Route::get("index/index","IndexController@index");
//后台欢迎页面路由
    Route::get("index/welcome","IndexController@welcome");
//后台管理员列表路由
    Route::get("manager/showlist","ManagerController@showlist");
    Route::match(['get','post'],"manager/tianjia","ManagerController@tianjia");
    Route::match(['get','post'],"manager/xiugai/{manager}","ManagerController@xiugai");
    Route::match(['get','post'],"manager/del/{manager}","ManagerController@del");

});
//后台登录路由
