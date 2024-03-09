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
        <!-- using game->receveur.. -->
        <div id="score">
            <!-- form for button to add goal to db -->
            <form action="{{ route('game.but_receveur')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $game->id }}">
                <button id="btn-rec" type="submit">But receveur</button>
            </form>

            <h1>{{ $game->receveur }} {{ $game->but_receveur}} - {{ $game->but_visiteur}} {{ $game->visiteur }}</h2>

                <form action="{{ route('game.but_visiteur')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $game->id }}">
                    <button id="btn-vis" type="submit">But visiteur</button>
                </form>
        </div>
        <h2 id="chrono">00:00</h2>
    </div>

    <form action="{{ route('game.commencer')}}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $game->id }}">
        <button type="submit">Commencer</button>
    </form>

    <!-- form pour commencer deuxieme mi-temps -->
    <form action="{{ route('game.mitemps')}}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $game->id }}">
        <input type="hidden" name="duree" value="{{ $game->duree }}">
        <button type="submit">Mi-temps</button>
    </form>

    <button id="add-event">Ajouter evenement</button>

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
        <button id="save-icons">Save Icons</button>

    </section>
</body>

<script>
    window.onload = function() {
        var chrono = document.getElementById('chrono');
        var debut_chrono = document.getElementById('debut_chrono').innerText;
        // reduce 6 hours from debut_chrono to get the right time
        debut_chrono = new Date(debut_chrono);
        debut_chrono.setHours(debut_chrono.getHours());

        // Create a new Date object representing the current date and time
        var now = new Date();

        // Calculate the difference in seconds between the two dates
        var difference = now.getTime() - debut_chrono.getTime();

        // using the difference in seconds, calculate the number of minutes and seconds
        var minutes = Math.floor(difference / 60000);
        var seconds = ((difference % 60000) / 1000).toFixed(0);

        // Display the result
        chrono.innerHTML = minutes + ":" + (seconds < 10 ? '0' : '') + seconds;

        // Update the display every 1 second
        setInterval(function() {
            // Create a new Date object representing the current date and time
            var now = new Date();

            // Calculate the difference in seconds between the two dates
            var difference = now.getTime() - debut_chrono.getTime();

            // using the difference in seconds, calculate the number of minutes and seconds
            var minutes = Math.floor(difference / 60000);
            var seconds = ((difference % 60000) / 1000).toFixed(0);

            // Display the result
            chrono.innerHTML = minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
        }, 1000);

        // get the minute in the chrono display, add 1 to it and store it in the hidden input
        var minute = document.getElementById('minute');
        setInterval(function() {
            var chrono = document.getElementById('chrono').innerText;
            var minute = chrono.split(':')[0];
            minute = parseInt(minute) + 1;
            document.getElementById('minute').value = minute;
        }, 1000);


        var addEvent = document.getElementById('add-event');
        addEvent.addEventListener('click', function() {
            var formEvent = document.getElementById('form-event');
            formEvent.style.display = 'block';
        });




        var pitch = document.getElementById('pitch');
        var iconsContainer = document.getElementById('icons-container');

        // Event listener for clicking on the pitch to add icons
        pitch.addEventListener('click', function(event) {
            // Get mouse coordinates relative to the pitch
            var rect = pitch.getBoundingClientRect();
            var mouseX = event.clientX;
            var mouseY = event.clientY;

            // Create new icon element
            var icon = document.getElementById('cj');
            var newIcon = icon.cloneNode(true);
            newIcon.style.position = 'absolute';
            newIcon.style.left = mouseX + 'px';
            newIcon.style.top = mouseY + 'px';

            // Append icon to icons container
            iconsContainer.appendChild(newIcon);
        });

        // Event listener for saving icons (to be implemented)
        document.getElementById('save-icons').addEventListener('click', function() {
            // Get all icon positions
            var icons = document.querySelectorAll('.icon');
            var iconPositions = [];
            icons.forEach(function(icon) {
                iconPositions.push({
                    x: parseInt(icon.style.left),
                    y: parseInt(icon.style.top)
                });
            });

            // Send icon positions to the server for saving (to be implemented)
            console.log(iconPositions);
        });
    };
</script>

</html>