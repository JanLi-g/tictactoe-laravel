<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;

class GameScoreController extends Controller
{
    // Spielstände abrufen
    public function show()
    {
        $score = GameScore::first();
        // Falls noch kein Eintrag existiert, einen anlegen
        if (!$score) {
            $score = GameScore::create([
                'x_score' => 0,
                'o_score' => 0,
            ]);
        }
        return response()->json($score);
    }

    // Spielstand erhöhen
    public function increment(Request $request)
    {
        $score = GameScore::first();
        if (!$score) {
            $score = GameScore::create([
                'x_score' => 0,
                'o_score' => 0,
            ]);
        }

        $player = $request->input('player'); // 'x' oder 'o'

        if ($player === 'x') {
            $score->x_score++;
        } elseif ($player === 'o') {
            $score->o_score++;
        }
        $score->save();

        return response()->json($score);
    }

    // Spielstände zurücksetzen
    public function reset()
    {
        $score = GameScore::first();
        if (!$score) {
            $score = GameScore::create([
                'x_score' => 0,
                'o_score' => 0,
            ]);
        } else {
            $score->x_score = 0;
            $score->o_score = 0;
            $score->save();
        }

        return response()->json($score);
    }
}
