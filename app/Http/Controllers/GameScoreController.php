<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class GameScoreController extends Controller
{
    public function index()
    {
        $score = GameScore::first();
        if (!$score) {
            $score = GameScore::create([
                'x_score' => 0,
                'o_score' => 0,
            ]);
        }
        // Immer die DB-Scores anzeigen, unabhängig von Session
        $score->x_score = $score->x_score;
        $score->o_score = $score->o_score;
        // Spielfeld beim Reload zurücksetzen
        $board = array_fill(0, 9, null);
        $currentPlayer = 'X';
        $isGameOver = false;
        Session::put('board', $board);
        Session::put('currentPlayer', $currentPlayer);
        Session::put('isGameOver', $isGameOver);
        return view('game', compact('score', 'board', 'currentPlayer', 'isGameOver'));
    }

    public function show()
    {
        // Immer die Scores aus der Datenbank zurückgeben
        $score = GameScore::first();
        if (!$score) {
            $score = GameScore::create([
                'x_score' => 0,
                'o_score' => 0,
            ]);
        }
        return response()->json([
            'x_score' => $score->x_score,
            'o_score' => $score->o_score,
        ]);
    }

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
        return response()->json([
            'x_score' => $score->x_score,
            'o_score' => $score->o_score,
        ]);
    }

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
        return response()->json([
            'x_score' => $score->x_score,
            'o_score' => $score->o_score,
        ]);
    }

    public function resetSessionScore(Request $request)
    {
        Session::put('x_score', 0);
        Session::put('o_score', 0);
        return response()->json([
            'x_score' => 0,
            'o_score' => 0,
        ]);
    }

    public function resetGame(Request $request)
    {
        // Reset board state
        Session::put('board', array_fill(0, 9, null));
        Session::put('currentPlayer', 'X');
        Session::put('isGameOver', false);

        // Reset session scores
        Session::put('x_score', 0);
        Session::put('o_score', 0);

        return redirect()->route('game.index');
    }

    public function saveGameState(Request $request)
    {
        $board = $request->input('board', array_fill(0, 9, null));
        $currentPlayer = $request->input('currentPlayer', 'X');
        $isGameOver = $request->input('isGameOver', false);

        Session::put('board', $board);
        Session::put('currentPlayer', $currentPlayer);
        Session::put('isGameOver', $isGameOver);

        return response()->json(['success' => true]);
    }
}
