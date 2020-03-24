<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group([
    'namespace' => 'Api',
    'middleware' => ['enable-cross']
], function () {
    Route::get('doc', 'DocController@index');
    Route::get('doc/json/{version?}', 'DocController@json')->name('doc')->middleware('cache:-1');;
    // 测试
    Route::get('/user/debug/{id}', 'DefaultController@debug')->middleware('api-response-send');
    Route::get('/user/logout', 'DefaultController@loginOut');
});

require 'api-v1.php';
