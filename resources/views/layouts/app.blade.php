<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tic Tac Toe')</title>
    @vite(['resources/css/app.scss', 'resources/css/GameBoard.module.scss'])
</head>
<body>
@yield('content')
</body>
</html>
