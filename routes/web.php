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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('game', App\Http\Controllers\GameController::class)->only('index', 'create', 'store', 'show');

Route::resource('game.deposit', App\Http\Controllers\GameDepositController::class)->only('create', 'store');
Route::resource('game.cashout', App\Http\Controllers\GameCashoutController::class)->only('create', 'store');

Route::resource('player', App\Http\Controllers\PlayerController::class)->only('index', 'create', 'store', 'show');

Route::resource('deposit', App\Http\Controllers\DepositController::class)->only('index', 'create', 'store');

Route::resource('cashout', App\Http\Controllers\CashoutController::class)->only('index', 'create', 'store');
