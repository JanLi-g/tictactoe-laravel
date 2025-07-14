<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Tic Tac Toe')</title>
    @vite(['resources/css/app.scss', 'resources/css/GameBoard.module.scss'])
</head>
<body>
@yield('content')
</body>
</html>
