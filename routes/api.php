<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('locale/{locale?}', array('as'=>'set-locale', 'uses'=>'LanguageController@setLocaleApi'));

Route::prefix('auth')->group(function () {
    // Below mention routes are public, user can access those without any restriction.
    // Create New User
    Route::post('register', 'AuthController@register');
    // Login User
    Route::post('login', 'AuthController@login');

    // Refresh the JWT Token
    Route::get('refresh', 'AuthController@refresh');

    // Below mention routes are available only for the authenticated users.
    Route::middleware('auth:api')->group(function () {
        // Get user info
        Route::get('user', 'AuthController@user');
        // Logout user from application
        Route::post('logout', 'AuthController@logout');
    });
});


Route::middleware('auth:api')->group(function () {
    Route::prefix('game')->group(function () {
        Route::get('getGame/{type?}/{category?}/', 'GameController@getGame');
        Route::post('placeBetDice', 'PlayController@placeBetDice');
        Route::post('placeBetNum', 'PlayController@placeBetNum');
    });

    Route::get('my-trades', 'MyBetsController@getMyBets');

    Route::prefix('account')->group(function () {
        Route::post('changePassword', 'AccountController@changePassword');
        Route::post('updateProfile', 'AccountController@updateProfile');
        Route::get('downline', 'AccountController@getDownline');
    });
});

Route::get('result', 'ResultController@getResult');

Route::prefix('misc')->group(function () {
    Route::get('gameType', 'MiscController@gameType');
    Route::get('gameChannel/{gameTypeId?}', 'MiscController@gameChannel');
    Route::get('gameHall/{gameChannelId?}', 'MiscController@gameHall');

    Route::get('betType/{type?}', 'MiscController@betType');
    Route::get('announcement', 'MiscController@announcement');
    Route::get('news', 'MiscController@news');
    Route::get('banner', 'MiscController@banner');
    Route::get('ranks', 'MiscController@ranks');
    Route::get('investors', 'MiscController@investors');
    Route::get('referrer/{username?}', 'MiscController@referrer');

    Route::get('latestBet', 'MiscController@latestBet');
    Route::get('latestWinner', 'MiscController@latestWinner');

    Route::get('getRss', 'MiscController@getRss');
});
