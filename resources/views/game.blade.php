<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Document</title>
</head>

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
        <p id="timeline" style="display: none;">{{ $game->timeline }}</p>

        <!-- using game->receveur.. -->
        <div id="score">
            <!-- form for button to add goal to db -->
            <form id="score-rec" action="{{ route('game.but_receveur')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $game->id }}">
                <button style="background-color: {{$game->couleur_receveur}};" type="submit">But receveur</button>
            </form>

            <h1>{{ $game->receveur }} {{ $game->but_receveur}} - {{ $game->but_visiteur}} {{ $game->visiteur }}</h2>

                <form id="score-vis" action="{{ route('game.but_visiteur')}}" method="POST">
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
            <button id="btn-pm" type="submit">Coup d'envoi</button>
        </form>

        <form action="{{ route('game.pause')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $game->id }}">
            <button id="btn-pause" type="submit">Pause</button>
        </form>
        
        <!-- form pour commencer deuxieme mi-temps -->
        <form action="{{ route('game.mitemps')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $game->id }}">
            <input type="hidden" id="duree_mitemps" name="duree" value="{{ $game->duree }}">
            <button id="btn-sm" type="submit">Coup d'envoi 2eme MT</button>
        </form>

        <form action="{{ route('game.fin')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $game->id }}">
            <button id="btn-fin" type="submit">Fin</button>
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
                    <option value="Amé">Amé</option>
                    <option value="P">Pos</option>
                </select>

                <label for="evenement">Evenement</label>
                <select name="evenement" id="evenement">
                    <option value="faute">Faute</option>
                    <option value="penalty">Penalty</option>
                    <option value="hors_jeu">Hors jeu</option>
                    <option value="positionnement">Positionnement</option>
                    <option value="TE">Trav Equ</option>
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
                    <th>Num</th>
                    <th>Min</th>
                    <th>Ref</th>
                    <th>Point</th>
                    <th>Event</th>
                    <th>Team</th>
                    <th>Joueur</th>
                    <th>Card</th>
                    <th>Comment</th>
                    <th>icon</th>
                    <th>Add</th>
                </tr>
                @foreach($evenements as $evenement)
                <tr>
                    <!-- increment the numero of the table for each element foing from 1, 2, 3 ... -->
                    <td>{{ $loop->iteration }}</td>
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
                            N/A
                            @endif
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        <!-- if  icon =  N/A do not show the form-->
                        @if($evenement->icone == 0)
                        <p>N/A</p>
                        @else
                        <form action="{{ route('imageEvenement.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="evenement_id" value="{{ $evenement->id }}">
                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                            <input type="hidden" name="position_x" value="" require>
                            <input type="hidden" name="position_y" value="" require>
                            <input type="hidden" name="image_url" value="" require>
                            <input type="hidden" name="numero_evenement" value="" require>
                            <!-- if the input name position_x and position_y and image_url are empty do not show the button else show it -->

                            <button class="addIcone" type="submit">add</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div id="map">
            <img id="pitch" src="{{ asset('icone/pitch.jpg') }}" alt="pitch">
        </div>
        

    </section>
</body>

@foreach ($images as $image)
    <img class="newIcon" src="{{ ($image->image_url) }}" alt="{{ $image->numero_evenement }}" title="{{ $image->numero_evenement }}" style="position: absolute; z-index: 1000; top: {{ $image->position_y }}px; left: {{ $image->position_x }}px;">
@endforeach

<script src = "{{ asset('js/game.js') }}"></script>

</html>