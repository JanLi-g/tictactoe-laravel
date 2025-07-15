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

        $board = array_fill(0, 9, null);
        $currentPlayer = 'X';
        $isGameOver = false;
        Session::put('board', $board);
        Session::put('currentPlayer', $currentPlayer);

        if (!Session::has('isGameOver')) {
            Session::put('isGameOver', $isGameOver);
        }
        return view('game', compact('score', 'board', 'currentPlayer', 'isGameOver'));
    }

    public function show()
    {
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
        $x_session = Session::get('x_score', 0);
        $o_session = Session::get('o_score', 0);
        if ($player === 'x') {
            $x_session++;
        } elseif ($player === 'o') {
            $o_session++;
        }
        Session::put('x_score', $x_session);
        Session::put('o_score', $o_session);
        return response()->json([
            'x_score' => $x_session,
            'o_score' => $o_session,
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
        // Status nur setzen, wenn nicht vorhanden
        if (!Session::has('isGameOver')) {
            Session::put('isGameOver', $isGameOver);
        }

        return response()->json(['success' => true]);
    }

    public function showSession()
    {
        $x_score = Session::get('x_score');
        $o_score = Session::get('o_score');
        if ($x_score !== null && $o_score !== null) {
            return response()->json([
                'x_score' => $x_score,
                'o_score' => $o_score,
            ]);
        }
        // Fallback: Score aus Datenbank
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
}
