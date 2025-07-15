<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameScoreController;

Route::middleware(['web'])->group(function () {
    Route::get('/scores', [GameScoreController::class, 'show']);
    Route::post('/scores/increment', [GameScoreController::class, 'increment']);
    Route::post('/scores/reset', [GameScoreController::class, 'reset']);
    Route::post('/scores/reset-session', [GameScoreController::class, 'resetSessionScore']);
    Route::post('/game/save-state', [GameScoreController::class, 'saveGameState']);
});
