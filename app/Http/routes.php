<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('admin/index');
    });

});
Route::get('admin/code','Admin\LoginController@code');

//Route::get('admin/code','Admin\LoginController@code');    //验证码

Route::any('admin/login','Admin\LoginController@login');  //登录

Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function () {

    Route::get('index','IndexController@index');   //后台首页
    Route::get('info','IndexController@info');
    Route::get('quit','LoginController@quit');
    Route::any('pass','IndexController@pass');

    Route::resource('category','CategoryController');
    Route::resource('article','ArticleController');
    Route::any('upload','CommonController@upload');
    Route::resource('links','LinksController');
    Route::post('links/changeorder','LinksController@changeorder');

    Route::resource('nav','NavController');
    Route::resource('config','ConfigController');
});

Route::post('admin/category/changeorder','Admin\CategoryController@changeorder');


