<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameScoreController;

/**
 * Web Routes
 *
 * Diese Datei definiert die Web-Routen für die Anwendung.
 * Sie enthält Routen für die Startseite und das Tic Tac Toe Spiel.
 */
Route::get('/', function () {
    return view('welcome');
})->name('home');

/**
 * Routen für das Tic Tac Toe Spiel
 *
 * Diese Routen ermöglichen den Zugriff auf die Spielseite und die Verwaltung des Spielstands.
 */
Route::get('/game', [GameScoreController::class, 'index'])->name('game.index');
Route::post('/game/reset', [GameScoreController::class, 'resetGame'])->name('tictactoe.reset');

require base_path('config/auth.php');
