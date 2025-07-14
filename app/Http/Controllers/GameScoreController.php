<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Klasse GameScoreController
 *
 * Diese Klasse verwaltet den Spielstand für ein Spiel.
 * Sie ermöglicht das Anzeigen, Erhöhen und Zurücksetzen des Spielstands.
 */
class GameScoreController extends Controller
{

    public function index(){
        return view('game');
    }

    /**
     * Zeigt den aktuellen Spielstand an.
     *
     * @return JsonResponse
     */
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

        Log::info('Spielstand abgerufen', ['x_score' => $score->x_score, 'o_score' => $score->o_score]);

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

    // Spielstand zurücksetzen
    public function reset()
    {
        // Nur den Spielstand in der Session zurücksetzen
        session(['x_score' => 0, 'o_score' => 0]);

        Log::info('Spielstand wurde zurückgesetzt.');

        return response()->json(['message' => 'Spielstand zurückgesetzt.', 'x_score' => 0, 'o_score' => 0]);
    }
}
