<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameScoreController;

Route::get('/score', [GameScoreController::class, 'show']);
Route::post('/score/increment', [GameScoreController::class, 'increment']);
Route::post('/score/reset', [GameScoreController::class, 'reset']);
