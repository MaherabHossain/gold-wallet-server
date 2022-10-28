<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Gold\GoldController;
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
Route::get("/users",[UserController::class,'index'])->name('users');
Route::delete("/users",[UserController::class,'delete'])->name('users-delete');
Route::resource('/news', NewsController::class);
Route::resource('/gold', GoldController::class);