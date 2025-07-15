<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\GameScore;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameScoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_initializes_scores_to_zero()
    {
        $score = GameScore::create(['x_score' => 0, 'o_score' => 0]);
        $this->assertEquals(0, $score->x_score);
        $this->assertEquals(0, $score->o_score);
    }

    public function test_it_increments_x_score()
    {
        $score = GameScore::create(['x_score' => 0, 'o_score' => 0]);
        $score->x_score++;
        $score->save();
        $this->assertEquals(1, $score->fresh()->x_score);
    }

    public function test_it_increments_o_score()
    {
        $score = GameScore::create(['x_score' => 0, 'o_score' => 0]);
        $score->o_score++;
        $score->save();
        $this->assertEquals(1, $score->fresh()->o_score);
    }
}
