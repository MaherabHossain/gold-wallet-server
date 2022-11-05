<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Gold\GoldController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Gold\GoldStorageController;
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


Route::post('user/create',  [UserController::class,'create'] );
Route::post('user/login',  [UserController::class,'login'] );

Route::middleware([ 'auth:sanctum'])->group(function () {
    Route::resource('transaction', TransactionController::class);
    Route::get('/balance', [TransactionController::class,'balance']);
    Route::get('/gold-price',[GoldController::class,'goldPrice']);
    Route::get('/news',[NewsController::class,"getNews"]);
    Route::post('/buy-sell-gold',[GoldStorageController::class,'buyGold']);
});