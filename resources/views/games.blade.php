<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @foreach($games as $game)
    <div>
        <h2>{{ $game->receveur }} - {{ $game->visiteur }}</h2>
        <p>Arbitre central: {{ $game->AC }}</p>
        <p>Assistant 1: {{ $game->AA1 }}</p>
        <p>Assistant 2: {{ $game->AA2 }}</p>
        <p>Quatrième arbitre: {{ $game->A4 }}</p>

        <!-- bouton pour commencer le game -->
        <form action="{{ route('game.go')}}" method="GET">
            @csrf
            <input type="hidden" name="id" value="{{ $game->id }}">
            <button type="submit">Acceder</button>
        </form>
    </div>
    @endforeach
</body>

</html>