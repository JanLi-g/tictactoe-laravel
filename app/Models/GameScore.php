<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
    /**
     * @property int $x_score
     * @property int $o_score
     */
    protected $table = 'game_scores';
    protected $fillable = ['x_score', 'o_score'];
    public $timestamps = false;
}
