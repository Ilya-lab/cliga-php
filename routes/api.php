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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        //Route::get('register', '\HomeController@index');
        Route::post('register', 'RegisterController');
        Route::post('login', 'LoginController');
        Route::post('logout', 'LogoutController')->middleware('auth:api');
        //Route::post('users', 'UserController')->middleware('auth:api');

    });

});
Route::get('/tournlist', 'Sport\TournListController@tournList')->middleware('auth:api');
Route::post('/tournlist', 'Sport\TournListController@store')->middleware('auth:api');;
/*Route::group(['prefix'=>'api','middleware'=>'auth'], function() {
    Route::get('user', '\HomeController@index');
});*/
Route::get('/leagues', 'Sport\LeaguesController@all')->middleware('auth:api');

// Фото
Route::post('/images/load', 'Images\ImageController@upload')->middleware('auth:api');


