@extends('layouts.app')

@section('content')
    <div class="wrapper" style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
        <h1 class="title">Tic Tac Toe</h1>
        <h2 class="subtitle "> Score:</h2>
        <div class="scores" style="display: flex; gap: 1rem;">
            <x-score player="X" :score="$score->x_score" :active="$currentPlayer === 'X'" />
            <x-score player="O" :score="$score->o_score" :active="$currentPlayer === 'O'" />
        </div>
        <x-game-board :board="$board" :current-player="$currentPlayer" :is-game-over="$isGameOver" />
        <div class="button-row" style="display: flex; gap: 0.5rem; margin-top: 0.5rem; margin-bottom: 2rem; align-items: center;">
            <a href="{{ route('home') }}" id="back-btn" class="resetButton">Zurück zum Dashboard</a>
            <form method="POST" action="{{ route('tictactoe.reset') }}" style="display:inline-block;">
                @csrf
                <x-button id="reset-btn" class="resetButton" type="submit">Spielfeld zurücksetzen</x-button>
            </form>
            <form method="POST" action="{{ route('tictactoe.hardreset') }}" style="display:inline-block;">
                @csrf
                <x-button id="hardreset-btn" class="resetButton" type="submit">Hardreset (Score &amp; Spielfeld)</x-button>
            </form>
        </div>
        <x-modal />
        <script id="game-data" type="application/json">
            {!! json_encode([ 'board' => $board, 'currentPlayer' => $currentPlayer, 'isGameOver' => $isGameOver ]) !!}
        </script>
    </div>
@endsection

@vite(['resources/js/app.js', 'resources/css/app.scss'])
