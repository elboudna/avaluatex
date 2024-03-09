<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Document</title>
</head>

<style>


</style>

<body>

    <table>
        <tr>
            <th>Arbitre Centre</th>
            <th>Assistant 1</th>
            <th>Assistant 2</th>
            <th>Quatrième arbitre</th>
        </tr>
        <tr>
            <td>{{ $game->AC }}</td>
            <td>{{ $game->AA1 }}</td>
            <td>{{ $game->AA2 }}</td>
            <td>{{ $game->A4 }}</td>
        </tr>
    </table>

    <div id="score-chrono">
        <p id="debut_chrono" style="display: none;">{{ $game->debut_chrono }}</p>
        <p id="mitemps_chrono" style="display: none;">{{ $game->mitemps_chrono }}</p>

        <!-- using game->receveur.. -->
        <div id="score">
            <!-- form for button to add goal to db -->
            <form action="{{ route('game.but_receveur')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $game->id }}">
                <button style="background-color: {{$game->couleur_receveur}};" type="submit">But receveur</button>
            </form>

            <h1>{{ $game->receveur }} {{ $game->but_receveur}} - {{ $game->but_visiteur}} {{ $game->visiteur }}</h2>

                <form action="{{ route('game.but_visiteur')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $game->id }}">
                    <button style="background-color: {{$game->couleur_visiteur}};" type="submit">But visiteur</button>
                </form>
        </div>
        <h2 id="chrono">00:00</h2>
    </div>


    <div id="flex-btn">
        <button id="add-event">Ajouter evenement</button>

        <form action="{{ route('game.commencer')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $game->id }}">
            <button type="submit">Coup d'envoi</button>
        </form>
        
        <!-- form pour commencer deuxieme mi-temps -->
        <form action="{{ route('game.mitemps')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $game->id }}">
            <input type="hidden" id="duree_mitemps" name="duree" value="{{ $game->duree }}">
            <button type="submit">Mi-temps</button>
        </form>
        
    </div>

    <section id="event-map">

        <div id="events">


            <form id="form-event" style="display:none;" action="{{ route('evenement.store') }}" method="POST">
                @csrf
                <input type="hidden" name="game_id" value="{{ $game->id }}">
                <label for="arbitre">Arbitre</label>
                <select name="arbitre">
                    <option value="AC">Arbitre central</option>
                    <option value="AA1">Assistant 1</option>
                    <option value="AA2">Assistant 2</option>
                    <option value="A4">Quatrième arbitre</option>
                </select>

                <label for="point">Point</label>
                <select name="point" id="point">
                    <option value="P">Pos</option>
                    <option value="N">Nég</option>
                </select>

                <label for="evenement">Evenement</label>
                <select name="evenement" id="evenement">
                    <option value="faute">Faute</option>
                    <option value="hors_jeu">Hors jeu</option>
                    <option value="positionnement">Positionnement</option>
                    <option value="penalty">Penalty</option>
                    <option value="autre">Autre</option>
                </select>

                <label for="equipe">Equipe</label>
                <select name="equipe" id="equipe">
                    <option value=""></option>
                    <option value="{{ $game->receveur }}">{{ $game->receveur }}</option>
                    <option value="{{ $game->visiteur }}">{{ $game->visiteur }}</option>
                </select>

                <label for="joueur">Joueur</label>
                <input type="number" min="1" max="99" name="joueur">

                <label for="sanction">Sanction</label>
                <select name="sanction" id="sanction">
                    <option value=""></option>
                    <option value="jaune">Jaune</option>
                    <option value="rouge">Rouge</option>
                </select>

                <label for="commentaire">Commentaire</label>
                <input type="text" name="commentaires">

                <input id="minute" type="hidden" name="minute">

                <button type="submit">Ajouter</button>

            </form>

            <table>
                <tr>
                    <th>Minute</th>
                    <th>Arbitre</th>
                    <th>Point</th>
                    <th>Evenement</th>
                    <th>Equipe</th>
                    <th>Joueur</th>
                    <th>Sanction</th>
                    <th>Commentaire</th>
                    <th>icone</th>
                    <th>Add</th>
                </tr>
                @foreach($evenements as $evenement)
                <tr>
                    <td>{{ $evenement->minute }}</td>
                    <td>{{ $evenement->arbitre }}</td>
                    <td>{{ $evenement->point }}</td>
                    <td>{{ $evenement->evenement }}</td>
                    <td>{{ $evenement->equipe }}</td>
                    <td>{{ $evenement->joueur }}</td>
                    <td>{{ $evenement->sanction }}</td>
                    <td>{{ $evenement->commentaires }}</td>
                    <td id="icon-change">
                        <!-- first check if $evenemenent->icone = 1 or 0, if its 0 put N/A if 1 put the icon src -->
                        @if($evenement->icone == 1)
                            @if($evenement->evenement == 'hors_jeu')
                            <img src="{{ asset('icone/hj.png') }}" alt="Hors jeu">
                            @elseif($evenement->evenement == 'positionnement')
                            <img src="{{ asset('icone/p.png') }}" alt="Positionnement">
                            @elseif(in_array($evenement->evenement, ['faute', 'penalty']) && empty($evenement->sanction))
                            <img src="{{ asset('icone/f.png') }}" alt="Faute ou penalty">
                            @elseif($evenement->sanction == 'jaune')
                            <img src="{{ asset('icone/cj.png') }}" alt="Carton jaune">
                            @elseif($evenement->sanction == 'rouge')
                            <img src="{{ asset('icone/cr.png') }}" alt="Carton rouge">
                            @else
                            <!-- Default icon or placeholder -->
                            <img src="{{ asset('icons/default.png') }}" alt="Default">
                            @endif
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        <!-- form to add the icon to imgaEvenement database -->
                        <form action="{{ route('imageEvenement.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $evenement->id }}">
                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                            <button type="submit">Ajouter icone</button>
                        </form>
                        
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div id="map">
            <img id="pitch" src="{{ asset('icone/pitch.jpg') }}" alt="pitch">
            <div id="icons-container">
                <div id="icons" style="display:none;">
                    <img id="cj" src="{{ asset('icone/cj.png') }}" alt="cj">
                    <img id="cr" src="{{ asset('icone/cr.png') }}" alt="cr">
                    <img id="hj" src="{{ asset('icone/hj.png') }}" alt="hors-jeu">
                    <img id="p" src="{{ asset('icone/p.png') }}" alt="position">
                    <img id="f" src="{{ asset('icone/f.png') }}" alt="faute">
                </div>
            </div>
        </div>
        

    </section>
</body>

<script src = "{{ asset('js/game.js') }}"></script>

</html>