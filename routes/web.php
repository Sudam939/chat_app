<?php

use App\Http\Controllers\ChatController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('dashboard', compact('users'));
    })->name('dashboard');

    Route::get('/chat/{id}', [ChatController::class, 'chat'])->name('chat');

    Route::post('/sendMessage/{id}', [ChatController::class, 'sendMessage'])->name('sendMessage');

    Route::view('profile', 'profile')
        ->name('profile');
});

require __DIR__ . '/auth.php';
