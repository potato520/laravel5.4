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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', 'Backend\MemberController@login'); # 登录

Route::group(['prefix' => 'Backend'], function (){
    Route::post('toLogin', 'Backend\MemberController@toLogin'); # 登录处理

    Route::any('Home', 'Backend\HomeController@index'); # 后台首页

    Route::any('Member', 'Backend\MemberController@lists'); # 用户列表
    Route::any('Member/addUser', 'Backend\MemberController@addUser'); # 添加用户
    Route::any('Member/modUser/{id}', 'Backend\MemberController@modUser'); # 编辑用户 视图
    Route::any('Member/modUserServer', 'Backend\MemberController@modUserServer'); # 编辑用户 提交
    Route::get('Member/delUser/{id}', 'Backend\MemberController@delUser'); # 删除用户

    Route::any('Video', 'Backend\VideoController@lists'); # 视频列表
    Route::any('Video/addVideo', 'Backend\VideoController@addVideo'); # 添加信息
    Route::any('Video/upload', 'Backend\VideoController@upload'); # 上传图片
    Route::any('Video/upload2', 'Backend\VideoController@upload2'); # 上传图片
    Route::any('Video/delimg', 'Backend\VideoController@delimg'); # 删除图片
    Route::get('Video/modVideo/{id}', 'Backend\VideoController@modVideo'); # 编辑视频模板
    Route::post('Video/modVideo2', 'Backend\VideoController@modVideo2'); # 编辑视频 提交
    Route::get('Video/delVideo/{id}', 'Backend\VideoController@delVideo'); # 删除视频

    Route::any('Caiji', 'Backend\CaijiController@lists'); # 采集列表
    Route::any('Caiji/begin', 'Backend\CaijiController@begin'); # 采集列表
    Route::any('Caiji/caijiLists', 'Backend\CaijiController@caijiLists'); # 视频列表

    Route::get('Photo', 'Backend\PhotoController@lists'); # 相册列表








    Route::any('Video/caiji2', 'Backend\VideoController@caiji2'); # 采集
    Route::any('Video/caiji3', 'Backend\VideoController@caiji3'); # 采集
    Route::any('Video/caiji4', 'Backend\VideoController@caiji4'); # 采集
    Route::any('Video/caiji5', 'Backend\VideoController@caiji5'); # 采集



});

