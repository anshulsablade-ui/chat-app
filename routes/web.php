<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConversationController;
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

    Route::post('/search-user', [ChatController::class, 'searchUser'])->name('search-user');

    Route::post('/get-users', [ChatController::class, 'getUsers'])->name('get-users');

    // create group conversation
    Route::post('/create-group', [ConversationController::class, 'createGroup'])->name('create-group');

    // create private conversation
    Route::post('/create-conversation', [ConversationController::class, 'createConversation'])->name('create-conversation');
});
