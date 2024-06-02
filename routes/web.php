<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('authentication')->group(function(){
    Route::get('/chat', [ChatController::class, 'chat'])->name('chat');
    Route::post('/sent', [ChatController::class, 'sent'])->name('sent');

    Route::get('/list-user', [UserController::class, 'showListUser'])->name('showListUser');
    Route::post('/post-add-user', [UserController::class, 'postAddUser'])->name('postAddUser');
    Route::post('/post-detal-user', [UserController::class, 'postDetalUser'])->name('postDetalUser');
    Route::post('/post-update-user', [UserController::class, 'postUpdateUser'])->name('postUpdateUser');
    Route::post('/post-delete-user', [UserController::class, 'postDeleteUser'])->name('postDeleteUser');

});
