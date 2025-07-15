<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Controller für die Verwaltung von Spielständen im Tic Tac Toe Spiel.
 */
class GameScoreController extends Controller
{
    /**
     * Erlaubte Spieler-Keys.
     */
    private const PLAYERS = ['x', 'o'];

    /**
     * Holt den Score für einen Spieler aus der Session.
     *
     * @param string $player Der Spieler, dessen Score geholt werden soll ('x' oder 'o').
     * @return int Der aktuelle Score des Spielers.
     */
    private function getSessionScore(string $player): int
    {
        return Session::get($player . '_score', 0);
    }

    /**
     * Setzt den Score für einen Spieler in der Session.
     *
     * @param string $player Der Spieler, dessen Score gesetzt werden soll ('x' oder 'o').
     * @param int $value Der Wert, auf den der Score gesetzt werden soll.
     */
    private function setSessionScore(string $player, int $value): void
    {
        Session::put($player . '_score', $value);
    }

    /**
     * Setzt die Scores in der Session zurück.
     * Diese Methode wird aufgerufen, wenn das Spiel neu gestartet wird.
     */
    private function resetSessionScores(): void
    {
        foreach (self::PLAYERS as $player) {
            Session::put($player . '_score', 0);
        }
    }

    /**
     * Holt den aktuellen Spielstand aus der Session.
     *
     * @return array Das aktuelle Spielfeld, der aktuelle Spieler und ob das Spiel beendet ist.
     */
    private function getSessionGameState(): array
    {
        return [
            'board' => Session::get('board', array_fill(0, 9, null)),
            'currentPlayer' => Session::get('currentPlayer', 'X'),
            'isGameOver' => Session::get('isGameOver', false),
        ];
    }

    /**
     * Setzt den Spielstand in der Session.
     *
     * @param array $board Das aktuelle Spielfeld.
     * @param string $currentPlayer Der aktuelle Spieler ('X' oder 'O').
     * @param bool $isGameOver Gibt an, ob das Spiel beendet ist.
     */
    private function setSessionGameState(array $board, string $currentPlayer, bool $isGameOver): void
    {
        Session::put('board', $board);
        Session::put('currentPlayer', $currentPlayer);
        Session::put('isGameOver', $isGameOver);
    }

    /**
     * Holt den aktuellen Score aus der Datenbank oder erstellt einen neuen, falls keiner existiert.
     *
     * @return GameScore
     */
    private function getOrCreateScore(): GameScore
    {
        return GameScore::first() ?? GameScore::create([
            'x_score' => 0,
            'o_score' => 0,
        ]);
    }

    /**
     * Erhöht den Score für den angegebenen Spieler und aktualisiert die Session-Scores.
     *
     * @param string $player Der Spieler, dessen Score erhöht werden soll ('x' oder 'o').
     */
    private function incrementScore(string $player): void
    {
        if (!in_array($player, self::PLAYERS)) {
            return;
        }
        $score = $this->getOrCreateScore();
        $score->{$player . '_score'}++;
        $score->save();
        $this->setSessionScore($player, $this->getSessionScore($player) + 1);
    }

    /**
     * Zeigt das Spiel-View mit aktuellem Spielstand.
     */
    public function index()
    {
        $score = $this->getOrCreateScore();
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

    /**
     * Gibt die aktuellen Scores als JSON zurück.
     */
    public function show()
    {
        $score = $this->getOrCreateScore();
        return response()->json([
            'x_score' => $score->x_score,
            'o_score' => $score->o_score,
        ]);
    }

    /**
     * Erhöht den Score für einen Spieler und gibt die Session-Scores zurück.
     */
    public function increment(Request $request)
    {
        $player = strtolower($request->input('player'));
        if (!in_array($player, self::PLAYERS)) {
            return response()->json(['error' => 'Ungültiger Spieler'], 400);
        }
        $this->incrementScore($player);
        return response()->json([
            'x_score' => $this->getSessionScore('x'),
            'o_score' => $this->getSessionScore('o'),
        ]);
    }

    /**
     * Setzt die Scores in der Datenbank zurück.
     */
    public function reset()
    {
        $score = $this->getOrCreateScore();
        foreach (self::PLAYERS as $player) {
            $score->{$player . '_score'} = 0;
        }
        $score->save();
        return response()->json([
            'x_score' => $score->x_score,
            'o_score' => $score->o_score,
        ]);
    }

    /**
     * Setzt die Session-Scores zurück.
     */
    public function resetSessionScore(Request $request)
    {
        $this->resetSessionScores();
        return response()->json([
            'x_score' => 0,
            'o_score' => 0,
        ]);
    }

    /**
     * Setzt den Spielstand in der Session zurück.
     */
    public function resetGame(Request $request)
    {
        $this->setSessionGameState(array_fill(0, 9, null), 'X', false);
        return response()->json(['success' => true]);
    }

    /**
     * Setzt Scores und Spielstand komplett zurück.
     */
    public function hardReset(Request $request)
    {
        $score = $this->getOrCreateScore();
        foreach (self::PLAYERS as $player) {
            $score->{$player . '_score'} = 0;
        }
        $score->save();
        $this->resetSessionScores();
        $this->setSessionGameState(array_fill(0, 9, null), 'X', false);
        return response()->json([
            'x_score' => $score->x_score,
            'o_score' => $score->o_score,
            'success' => true
        ]);
    }

    /**
     * Speichert den aktuellen Spielstand in der Session.
     */
    public function saveGameState(Request $request)
    {
        $board = $request->input('board', array_fill(0, 9, null));
        $currentPlayer = $request->input('currentPlayer', 'X');
        $isGameOver = $request->input('isGameOver', false);
        $this->setSessionGameState($board, $currentPlayer, $isGameOver);
        return response()->json(['success' => true]);
    }

    /**
     * Gibt die Session-Scores als JSON zurück.
     */
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
        $score = $this->getOrCreateScore();
        return response()->json([
            'x_score' => $score->x_score,
            'o_score' => $score->o_score,
        ]);
    }
}
