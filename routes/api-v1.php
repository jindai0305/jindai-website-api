<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

Route::group([
    'namespace' => 'Api',
    'prefix' => 'v1',
    'middleware' => ['enable-cross', 'api-response-send']
], function () {
    // 测试
    Route::get('/user/debug/{id}', 'DefaultController@debug');
    // 需要登录才能访问的接口
    Route::group([
        'middleware' => ['auth:api'],
    ], function () {
        Route::post('/upload', 'DefaultController@upload');
    });
});

Route::group([
    'namespace' => 'Api\v1',
    'prefix' => 'v1',
    'middleware' => ['enable-cross', 'api-response-send']
], function () {
    // 分类
    Route::get('/cates', 'CateController@index')->name('cate')->middleware('cache:20');
    // 标签
    Route::get('/tags', 'TagController@index');
    // 友链
    Route::get('/links', 'LinkController@index');
    // 用户
    Route::post('/register', 'TokenController@register');
    Route::post('/token', 'TokenController@token');
    Route::post('/refresh-token', 'TokenController@refreshToken')->middleware('refresh-cookie');
    // 文章
    Route::get('/items', 'ItemController@index')->name('item-list');
    Route::get('/item/{id}', 'ItemController@view')->name('item-detail');
    Route::get('/item/{id}/comments', 'CommentController@index');
    Route::get('/comment/{id}', 'CommentController@view');
    // 轮播图
    Route::get('/banners', 'BannerController@index');
    // 项目
    Route::get('/projects', 'ProjectController@index');
    // 设置
    Route::get('/setting', 'SettingController@index')->name('setting')->middleware('cache:-1');
    // 关于我
    Route::get('/about', 'SettingController@aboutMe')->name('about')->middleware('cache:-1');

    // 需要登录才能访问的接口
    Route::group([
        'middleware' => ['auth:api'],
    ], function () {
        Route::get('/user/profile', 'UserController@profile');
        Route::get('/user/login-out', 'UserController@loginOut');
        Route::post('/upload', 'DefaultController@upload');
        Route::put('/item/{id}/approve', 'ItemController@toggleApprove');
        Route::put('/item/{id}/collect', 'ItemController@toggleCollect');
        Route::put('/comment/{id}/approve', 'CommentController@toggleApprove');
        Route::post('/item/{id}/comment', 'CommentController@store');
        Route::delete('/comment/{id}', 'CommentController@destroy');
    });

    Route::group([
        'namespace' => 'Admin',
        'prefix' => 'admin',
        'middleware' => ['auth:api', 'admin'],
    ], function () {
        // 上传资源
        Route::get('/attachments', 'AttachmentsController@list');

        // 分类
        Route::get('/cates', 'CateController@list');
        Route::post('/cate', 'CateController@store');
        Route::put('/cate/{id}', 'CateController@update');
        Route::delete('/cate/{id}', 'CateController@destroy');
        Route::get('/cate/{id}', 'CateController@show');
        Route::put('/cate/{id}/online', 'CateController@online');
        Route::put('/cate/{id}/offline', 'CateController@offline');

        // 标签
        Route::get('/tags', 'TagController@list');
        Route::post('/tag', 'TagController@store');
        Route::put('/tag/{id}', 'TagController@update');
        Route::delete('/tag/{id}', 'TagController@destroy');
        Route::get('/tag/{id}', 'TagController@show');
        Route::put('/tag/{id}/online', 'TagController@online');
        Route::put('/tag/{id}/offline', 'TagController@offline');

        // 友链
        Route::get('/links', 'LinkController@list');
        Route::post('/link', 'LinkController@store');
        Route::put('/link/{id}', 'LinkController@update');
        Route::delete('/link/{id}', 'LinkController@destroy');
        Route::get('/link/{id}', 'LinkController@show');
        Route::put('/link/{id}/online', 'LinkController@online');
        Route::put('/link/{id}/offline', 'LinkController@offline');

        // 文章
        Route::get('/items', 'ItemController@list');
        Route::post('/item', 'ItemController@store');
        Route::put('/item/{id}', 'ItemController@update');
        Route::delete('/item/{id}', 'ItemController@destroy');
        Route::get('/item/{id}', 'ItemController@show');
        Route::put('/item/{id}/online', 'ItemController@online');
        Route::put('/item/{id}/offline', 'ItemController@offline');
        Route::put('/item/{id}/about', 'ItemController@about');

        // 项目
        Route::get('/projects', 'ProjectController@list');
        Route::post('/project', 'ProjectController@store');
        Route::put('/project/{id}', 'ProjectController@update');
        Route::delete('/project/{id}', 'ProjectController@destroy');
        Route::get('/project/{id}', 'ProjectController@show');
        Route::put('/project/{id}/online', 'ProjectController@online');
        Route::put('/project/{id}/offline', 'ProjectController@offline');

        // 轮播图
        Route::get('/banners', 'BannerController@list');
        Route::post('/banner', 'BannerController@store');
        Route::put('/banner/{id}', 'BannerController@update');
        Route::delete('/banner/{id}', 'BannerController@destroy');
        Route::get('/banner/{id}', 'BannerController@show');
        Route::put('/banner/{id}/online', 'BannerController@online');
        Route::put('/banner/{id}/offline', 'BannerController@offline');

        // 评论
        Route::get('/comments', 'CommentController@list');
        Route::delete('/comment/{id}', 'CommentController@destroy');
        Route::put('/comment/{id}/online', 'CommentController@online');
        Route::put('/comment/{id}/offline', 'CommentController@offline');
        Route::get('/comment/{id}', 'CommentController@show');
        Route::put('/comment/{id}', 'CommentController@update');

        // 用户
        Route::get('/users', 'UserController@list');
        Route::get('/user/{id}', 'UserController@show');
        Route::post('/user', 'UserController@store');
        Route::put('/user/{id}', 'UserController@update');
        Route::put('/user/{id}/authority', 'UserController@authority');
        Route::put('/user/{id}/reset-password', 'UserController@resetPassword');
        Route::put('/user/{id}/invalid-token', 'UserController@invalidToken');

        // 日志
        Route::get('/login-logs', 'LogController@loginLog');
        Route::get('/behavior-logs', 'LogController@behaviorLog');
        Route::get('/request-logs', 'LogController@requestLog');
        Route::get('/request-logs/{id}', 'LogController@requestView');

        // 统计
        Route::get('/statistics', 'StatisticsController@index');

        // 设置
        Route::get('/setting/{type}', 'SettingController@view');
        Route::put('/setting/basis', 'SettingController@basis');
        Route::put('/setting/module', 'SettingController@module');
        Route::put('/setting/personal', 'SettingController@personal');
        Route::put('/setting/about', 'SettingController@about');
    });
});
