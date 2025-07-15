<?php

namespace Tests\Unit;

use Tests\TestCase;

class GameLogicTest extends TestCase
{
    public function test_it_detects_winner_correctly()
    {
        $winPatterns = [
            [["X", "X", "X", null, null, null, null, null, null], "X"],
            [[null, null, null, "O", "O", "O", null, null, null], "O"],
            [["X", null, null, "X", null, null, "X", null, null], "X"],
            [[null, "O", null, null, "O", null, null, "O", null], "O"],
            [["X", null, null, null, "X", null, null, null, "X"], "X"],
            [[null, null, "O", null, "O", null, "O", null, null], "O"],
        ];
        foreach ($winPatterns as [$board, $expectedWinner]) {
            $winner = $this->checkWinner($board);
            $this->assertEquals($expectedWinner, $winner);
        }
    }

    private function checkWinner($board)
    {
        $patterns = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8],
            [0, 3, 6], [1, 4, 7], [2, 5, 8],
            [0, 4, 8], [2, 4, 6]
        ];
        foreach ($patterns as $p) {
            [$a, $b, $c] = $p;
            if ($board[$a] && $board[$a] === $board[$b] && $board[$a] === $board[$c]) {
                return $board[$a];
            }
        }
        return null;
    }
}
