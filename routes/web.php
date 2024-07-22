<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false, 'reset' => false, 'verify' => true]);

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return redirect()->route('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('usuarios', 'App\Http\Controllers\UserController')->middleware('verified');
