@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <h1>Tic Tac Toe</h1>
        <div class="scores">
            <div id="score-x" class="score active">X: {{ $score->x_score }}</div>
            <div id="score-o" class="score">O: {{ $score->o_score }}</div>
        </div>
        <div id="game-board" class="board"></div>
        <script id="game-data" type="application/json">
            {!! json_encode([ 'board' => $board, 'currentPlayer' => $currentPlayer, 'isGameOver' => $isGameOver ]) !!}
        </script>
        <form method="POST" action="{{ route('tictactoe.reset') }}">
            @csrf
            <button type="submit" id="reset-btn" class="resetButton">Reset</button>
        </form>
        <a href="{{ route('home') }}" id="back-btn" class="resetButton">Zurück zum Dashboard</a>
    </div>
@endsection

@vite(['resources/js/app.js', 'resources/css/app.scss'])
