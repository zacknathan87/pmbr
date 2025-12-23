<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/cron/testGame', 'CronController@testGame');
Route::get('/cron/createGame/{date?}', 'CronController@createGame');
Route::get('/cron/createGame2/{date?}', 'CronController@createGame');
Route::get('/cron/checkGame', 'CronController@checkGame');
Route::get('/cron/checkGame2', 'CronController@checkGame');
Route::get('/cron/seedBet', 'CronController@seedBet');

Route::get('/cron/robotBet', 'CronController@robotBet');
Route::get('/cron/deleteRobotBet', 'CronController@deleteRobotBet');

Route::get('/admin-management/login', 'Admin\AuthController@login');
Route::post('/admin-management/login', 'Admin\AuthController@login');
Route::get('/admin-management/logout', 'Admin\AuthController@logout');

Route::get('locale/{locale?}', array('as'=>'set-locale-web', 'uses'=>'LanguageController@setLocale'));


Route::group(array('prefix' => 'admin-management', 'middleware' => ['BeforeMiddlewareAdminWeb']), function () {
    Route::get('/', 'Admin\AdminController@index');
    Route::get('/dashboard', 'Admin\DashboardController@index');


    Route::get('/users/list', 'Admin\UserController@list');
    Route::get('/users/view/{username?}', 'Admin\UserController@details');
    Route::get('/users/new', 'Admin\UserController@new');
    Route::post('/users/new', 'Admin\UserController@new');
    Route::get('/users/edit/{username?}', 'Admin\UserController@edit');
    Route::post('/users/edit/{username?}', 'Admin\UserController@edit');
    Route::get('/users/transaction_list', 'Admin\UserController@transaction');
    Route::get('/users/transaction_add', 'Admin\UserController@transactionAdd');
    Route::post('/users/transaction_add', 'Admin\UserController@transactionAdd');
    Route::get('/users/transaction/view/{id?}', 'Admin\UserController@transactionView');
    Route::post('/users/suspend', 'Admin\UserController@suspend');
    Route::post('/users/activate', 'Admin\UserController@activate');

    Route::get('/users/getList', 'Admin\UserController@getList');
    Route::post('/users/getList', 'Admin\UserController@getList');

    Route::get('/operator/list', 'Admin\OperatorController@list');
    Route::get('/operator/view/{id?}', 'Admin\OperatorController@details');
    Route::get('/operator/new', 'Admin\OperatorController@new');
    Route::post('/operator/new', 'Admin\OperatorController@new');
    Route::get('/operator/edit/{id?}', 'Admin\OperatorController@edit');
    Route::post('/operator/edit/{id?}', 'Admin\OperatorController@edit');
    Route::get('/operator/add_balance/{id?}', 'Admin\OperatorController@addBalance');
    Route::post('/operator/add_balance/{id?}', 'Admin\OperatorController@addBalance');
    Route::get('/operator/transaction_list', 'Admin\OperatorController@transaction');
    Route::get('/operator/transaction_add', 'Admin\OperatorController@transactionAdd');
    Route::post('/operator/transaction_add', 'Admin\OperatorController@transactionAdd');
    Route::get('/operator/transaction/view/{id?}', 'Admin\OperatorController@transactionView');


    Route::get('/wallet/list', 'Admin\WalletController@list');
    Route::get('/wallet/view/{id?}', 'Admin\WalletController@details');
    Route::get('/wallet/add_balance/{id?}', 'Admin\WalletController@addBalance');
    Route::post('/wallet/add_balance/{id?}', 'Admin\WalletController@addBalance');
    Route::get('/wallet/withdrawal/{id?}', 'Admin\WalletController@withdrawal');
    Route::post('/wallet/withdrawal/{id?}', 'Admin\WalletController@withdrawal');

    Route::get('/game/list', 'Admin\GameController@list');
    Route::get('/game/view/{id?}', 'Admin\GameController@details');
    Route::get('/game/new', 'Admin\GameController@new');
    Route::post('/game/new', 'Admin\GameController@new');
    Route::post('/game/set_winning_number', 'Admin\GameController@setWin');
    Route::post('/game/set_winning_number2', 'Admin\GameController@setWin2');
    Route::get('/game/edit/{id?}', 'Admin\GameController@edit');
    Route::post('/game/edit/{id?}', 'Admin\GameController@edit');
    Route::post('/game/set_limit', 'Admin\GameController@setLimit');
    
    Route::get('/game/getList', 'Admin\GameController@getList');
    Route::post('/game/getList', 'Admin\GameController@getList');
    Route::get('/game/getBetList', 'Admin\GameController@getBetList');
    Route::post('/game/getBetList', 'Admin\GameController@getBetList');

    Route::get('/game/live_game', 'Admin\GameController@liveGame');

    Route::get('/game_channel/list', 'Admin\GameChannelController@list');
    Route::get('/game_channel/view/{id?}', 'Admin\GameChannelController@details');
    Route::get('/game_channel/new', 'Admin\GameChannelController@new');
    Route::post('/game_channel/new', 'Admin\GameChannelController@new');
    Route::get('/game_channel/edit/{id?}', 'Admin\GameChannelController@edit');
    Route::post('/game_channel/edit/{id?}', 'Admin\GameChannelController@edit');
    Route::post('/game_channel/delete', 'Admin\QuestionController@delete');

    Route::get('/game_room/list', 'Admin\GameRoomController@list');
    Route::get('/game_room/view/{id?}', 'Admin\GameRoomController@details');
    Route::get('/game_room/new', 'Admin\GameRoomController@new');
    Route::post('/game_room/new', 'Admin\GameRoomController@new');
    Route::get('/game_room/edit/{id?}', 'Admin\GameRoomController@edit');
    Route::post('/game_room/edit/{id?}', 'Admin\GameRoomController@edit');
    Route::post('/game_room/delete', 'Admin\GameRoomController@delete');


    Route::get('announcement/new', 'Admin\AnnouncementController@new');
    Route::post('announcement/new', 'Admin\AnnouncementController@new');
    Route::get('announcement/list', 'Admin\AnnouncementController@list');
    Route::get('announcement/view/{aid?}', 'Admin\AnnouncementController@view');
    Route::get('announcement/edit/{aid?}', 'Admin\AnnouncementController@edit');
    Route::post('announcement/edit/{aid?}', 'Admin\AnnouncementController@edit');
    Route::post('announcement/delete', 'Admin\AnnouncementController@delete');


    Route::get('banner/new', 'Admin\BannerController@new');
    Route::post('banner/new', 'Admin\BannerController@new');
    Route::get('banner/list', 'Admin\BannerController@list');
    Route::get('banner/view/{aid?}', 'Admin\BannerController@view');
    Route::get('banner/edit/{aid?}', 'Admin\BannerController@edit');
    Route::post('banner/edit/{aid?}', 'Admin\BannerController@edit');
    Route::post('banner/delete', 'Admin\BannerController@delete');


    

    Route::get('/monitor', 'Admin\MonitorController@index');

    Route::get('/withdrawal_request', 'Admin\WithdrawalController@index');
    Route::get('/withdrawal_request/view/{id?}', 'Admin\WithdrawalController@details');
    Route::post('/withdrawal_request/approve', 'Admin\WithdrawalController@approve');
    Route::post('/withdrawal_request/reject', 'Admin\WithdrawalController@reject');

    Route::get('/setting', 'Admin\SettingController@index');
    Route::post('/setting/update', 'Admin\SettingController@update');


    Route::get('/account/change_password', 'Admin\AccountController@changePassword');
    Route::post('/account/change_password', 'Admin\AccountController@changePassword');


    Route::get('/bets', 'Admin\GameController@betList');


    Route::get('rank/new', 'Admin\RankController@new');
    Route::post('rank/new', 'Admin\RankController@new');
    Route::get('rank/list', 'Admin\RankController@list');
    Route::get('rank/view/{aid?}', 'Admin\RankController@view');
    Route::get('rank/edit/{aid?}', 'Admin\RankController@edit');
    Route::post('rank/edit/{aid?}', 'Admin\RankController@edit');
    Route::post('rank/delete', 'Admin\RankController@delete');


    Route::get('investor/new', 'Admin\InvestorController@new');
    Route::post('investor/new', 'Admin\InvestorController@new');
    Route::get('investor/list', 'Admin\InvestorController@list');
    Route::get('investor/view/{aid?}', 'Admin\InvestorController@view');
    Route::get('investor/edit/{aid?}', 'Admin\InvestorController@edit');
    Route::post('investor/edit/{aid?}', 'Admin\InvestorController@edit');
    Route::post('investor/delete', 'Admin\InvestorController@delete');


    Route::get('report', 'Admin\ReportController@index');
    Route::get('report/getList', 'Admin\ReportController@getList');
    
});

Route::get('/{vue_capture?}', 'AppController@index')->where('vue_capture', '[\/\w\.-]*');