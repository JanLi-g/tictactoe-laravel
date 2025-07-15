<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Class GameScoreController
 * Handles game score management, including displaying scores, incrementing scores,
 * resetting scores, and managing game state in sessions.
 */
class GameScoreController extends Controller
{
    private function getSessionScore($player)
    {
        return Session::get($player . '_score', 0);
    }

    private function setSessionScore($player, $value)
    {
        Session::put($player . '_score', $value);
    }

    private function resetSessionScores()
    {
        Session::put('x_score', 0);
        Session::put('o_score', 0);
    }

    private function getSessionGameState()
    {
        return [
            'board' => Session::get('board', array_fill(0, 9, null)),
            'currentPlayer' => Session::get('currentPlayer', 'X'),
            'isGameOver' => Session::get('isGameOver', false),
        ];
    }

    private function setSessionGameState($board, $currentPlayer, $isGameOver)
    {
        Session::put('board', $board);
        Session::put('currentPlayer', $currentPlayer);
        Session::put('isGameOver', $isGameOver);
    }

    public function index()
    {
        $score = GameScore::first();
        if (!$score) {
            $score = GameScore::create([
                'x_score' => 0,
                'o_score' => 0,
            ]);
        }

        if (!Session::has('board')) {
            $this->setSessionGameState(array_fill(0, 9, null), 'X', false);
        }
        $gameState = $this->getSessionGameState();
        return view('game', [
            'score' => $score,
            'board' => $gameState['board'],
            'currentPlayer' => $gameState['currentPlayer'],
            'isGameOver' => $gameState['isGameOver'],
        ]);
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
        $score = GameScore::first() ?? GameScore::create([
            'x_score' => 0,
            'o_score' => 0,
        ]);

        $player = $request->input('player'); // 'x' oder 'o'

        if ($player === 'x' || $player === 'o') {
            $score->{$player . '_score'}++;
            $score->save();
            $sessionScore = $this->getSessionScore($player);
            $this->setSessionScore($player, $sessionScore + 1);
        }

        return response()->json([
            'x_score' => $this->getSessionScore('x'),
            'o_score' => $this->getSessionScore('o'),
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
        $this->resetSessionScores();
        return response()->json([
            'x_score' => 0,
            'o_score' => 0,
        ]);
    }

    public function resetGame(Request $request)
    {
        $this->setSessionGameState(array_fill(0, 9, null), 'X', false);
        return redirect()->route('game.index');
    }

    public function hardReset(Request $request)
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
        $this->resetSessionScores();
        $this->setSessionGameState(array_fill(0, 9, null), 'X', false);
        return redirect()->route('game.index');
    }

    public function saveGameState(Request $request)
    {
        $board = $request->input('board', array_fill(0, 9, null));
        $currentPlayer = $request->input('currentPlayer', 'X');
        $isGameOver = $request->input('isGameOver', false);
        $this->setSessionGameState($board, $currentPlayer, $isGameOver);
        return response()->json(['success' => true]);
    }

    public function showSession()
    {
        $x_score = $this->getSessionScore('x');
        $o_score = $this->getSessionScore('o');
        if ($x_score !== null && $o_score !== null) {
            return response()->json([
                'x_score' => $x_score,
                'o_score' => $o_score,
            ]);
        }
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
