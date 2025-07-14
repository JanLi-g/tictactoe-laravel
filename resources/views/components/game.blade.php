@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <h1>Tic Tac Toe</h1>
        <div class="scores">
            <div id="score-x" class="score active">X: 0</div>
            <div id="score-o" class="score">O: 0</div>
        </div>
        <div id="game-board" class="board"></div>
        <button id="reset-btn" class="resetButton">Reset</button>
        <button id="back-btn" class="resetButton">Zurück zum Dashboard</button>
    </div>
@endsection

@vite(['resources/js/gameboard.js', 'resources/css/app.scss'])
