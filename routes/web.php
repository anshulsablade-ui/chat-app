<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('chat.index');
    // return view('layouts.app');
});

// Auth routes
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'loginUser'])->name('login');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerUser'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('login')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

    // Chat send routes
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');


    Route::post('/chat/{id}', [ChatController::class, 'chat'])->name('chat');

});
