@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <h1 class="title">Tic Tac Toe</h1>
        <h2 class="subtitle"> Score:</h2>
        <div class="scores">
            <x-score player="X" :score="$score->x_score" :active="$currentPlayer === 'X'" />
            <x-score player="O" :score="$score->o_score" :active="$currentPlayer === 'O'" />
        </div>
        <x-game-board :board="$board" :current-player="$currentPlayer" :is-game-over="$isGameOver" />
        <div class="button-row">
            <a href="{{ route('home') }}" id="back-btn" class="resetButton">Zurück zum Dashboard</a>
            <form method="POST" action="{{ route('tictactoe.reset') }}">
                @csrf
                <x-button id="reset-btn" class="resetButton" type="submit">Spielfeld zurücksetzen</x-button>
            </form>
            <x-button id="hardreset-btn" class="resetButton" type="button">Hardreset (Score &amp; Spielfeld)</x-button>
        </div>
        <x-modal />
        <script id="game-data" type="application/json">
            {!! json_encode([ 'board' => $board, 'currentPlayer' => $currentPlayer, 'isGameOver' => $isGameOver ]) !!}
        </script>
    </div>
@endsection

@vite(['resources/js/app.js', 'resources/css/app.scss'])
