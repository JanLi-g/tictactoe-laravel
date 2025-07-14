<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameScoreController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/tictactoe', [GameScoreController::class, 'index'])->name('tictactoe');
Route::post('/tictactoe/reset', [GameScoreController::class, 'reset'])->name('tictactoe.reset');

require base_path('config/auth.php');
