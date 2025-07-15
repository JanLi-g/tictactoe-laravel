<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Klasse GameScore
 *
 * Diese Klasse repräsentiert den Spielstand für ein Spiel.
 * Sie enthält die Punkte für die Spieler 'x' und 'o'.
 */
class GameScore extends Model
{
    protected $table = 'game_scores';
    protected $fillable = ['x_score', 'o_score'];
    public $timestamps = false;
}
