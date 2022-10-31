<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Transaction\TransactionController;
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
});