@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <h1>Tic Tac Toe</h1>
        <div class="scores">
            <x-score player="X" :score="$score->x_score" />
            <x-score player="O" :score="$score->o_score" />
        </div>
        <x-game-board :board="$board" :current-player="$currentPlayer" :is-game-over="$isGameOver" />
        <script id="game-data" type="application/json">
            {!! json_encode([ 'board' => $board, 'currentPlayer' => $currentPlayer, 'isGameOver' => $isGameOver ]) !!}
        </script>
        <form method="POST" action="{{ route('tictactoe.reset') }}" style="display:inline-block;">
            @csrf
            <x-button id="reset-btn" class="resetButton" type="submit">Spielfeld zurücksetzen</x-button>
        </form>
        <form method="POST" action="{{ route('tictactoe.hardreset') }}" style="display:inline-block; margin-left:10px;">
            @csrf
            <x-button id="hardreset-btn" class="resetButton" type="submit">Hardreset (Score &amp; Spielfeld)</x-button>
        </form>
        <a href="{{ route('home') }}" id="back-btn" class="resetButton">Zurück zum Dashboard</a>
        <x-modal />
    </div>
@endsection

@vite(['resources/js/app.js', 'resources/css/app.scss'])
