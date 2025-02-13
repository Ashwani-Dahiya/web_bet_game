<?php

use App\Http\Controllers\GameZoneController;
use App\Http\Controllers\PlaceBetController;
use App\Http\Controllers\PlayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\NotificationController;
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


Route::group(
    ['middleware' => 'guest'],
    function () {
        Route::get('/login', [AuthController::class, 'login_page'])->name('auth.login');
        Route::post('/login', [AuthController::class, 'check_login'])->name('post.login');
        Route::get('/register', [AuthController::class, 'register_page'])->name('auth.register');
        Route::post('/register', [AuthController::class, 'register_post'])->name('post.register');
    }
);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'home'])->name('home.page');
    Route::get('/play', [PlayController::class, 'play_page'])->name('play.page');
    Route::get('/play-zone/{gameName}', [GameZoneController::class, 'play_zone_page'])->name('play.zone.page');
    Route::get('/play-jodi/{gameName}', [PlayController::class, 'play_game'])->name('play.game');
    Route::get('/play-manual/{gameName}', [PlayController::class, 'play_manual'])->name('play.manual');
    Route::get('/play-harraf/{gameName}', [PlayController::class, 'play_harraf'])->name('play.harraf');
    Route::get('/play-crossing/{gameName}', [PlayController::class, 'play_crossing'])->name('play.crossing');
    Route::get('/play-copy-paste/{gameName}', [PlayController::class, 'play_copy_paste'])->name('play.copy');
    Route::get('/play-num-to-num/{gameName}', [PlayController::class, 'play_num_to_num'])->name('play.num-to-num');
    Route::get('/play-tap-play/{gameName}', [PlayController::class, 'play_tap_play'])->name('play.tap-play');


    Route::post('/place-bet-jodi', [PlaceBetController::class, 'place_bet_jodi'])->name('place-bet-jodi');
    Route::post('/place-bet-maual-jodi', [PlaceBetController::class, 'place_bet_maual_jodi'])->name('place-bet-maual-jodi');
    Route::post('/place-bet-harraf', [PlaceBetController::class, 'place_bet_harraf'])->name('place-bet-harraf');
    Route::post('/place-bet-crossing', [PlaceBetController::class, 'place_bet_crossing'])->name('place-bet-crossing');
    Route::post('/place-bet-copy-paste', [PlaceBetController::class, 'place_bet_copy_paste'])->name('place-bet-copy-paste');
    Route::post('/place-bet-num-to-num', [PlaceBetController::class, 'place_bet_num_to_num'])->name('place-bet-num-to-num');
    Route::post('/place-bet-tap-play', [PlaceBetController::class, 'place_bet_tap_play'])->name('place-bet-tap-play');

    Route::get('/play-history', [HistoryController::class, 'play_history'])->name('play.history');
    Route::post('/filter-bet-history', [HistoryController::class, 'filter_bet_history'])->name('filter.bet.history');


    Route::get('/wallet', [WalletController::class, 'wallet'])->name('wallet.page');
    Route::get('/notifications', [NotificationController::class, 'notifications'])->name('notifications.page');

});
