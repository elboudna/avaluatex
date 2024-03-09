<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <h1>Créer un match</h1>
    <form id="form-create" action="{{ route('game.store') }}" method="POST">
        @csrf
        <label for="receveur">Receveur</label>
        <input type="text" name="receveur" id="receveur">
        <label for="couleur_receveur">Couleur receveur</label>
        <input type="color" name="couleur_receveur" id="couleur_receveur">
        <label for="visiteur">Visiteur</label>
        <input type="text" name="visiteur" id="visiteur">
        <label for="couleur_visiteur">Couleur visiteur</label>
        <input type="color" name="couleur_visiteur" id="couleur_visiteur">
        <label for="duree">Durée mi-temps</label>      
        <input type="number" name="duree" id="duree" min="25" max="45" value="25">
        <label for="arbitre_central">Arbitre central</label>
        <input type="text" name="AC" id="arbitre_central">
        <label for="assistant_1">Assistant 1</label>
        <input type="text" name="AA1" id="assistant_1">
        <label for="assistant_2">Assistant 2</label>
        <input type="text" name="AA2" id="assistant_2">
        <label for="quatrieme_arbitre">Quatrième arbitre</label>
        <input type="text" name="A4" id="quatrieme_arbitre">
        <button type="submit">Créer</button>
    </form>

    <style>
        #form-create{
            display: flex;
            flex-direction: column;
            width: 300px;
        }

        #form-create label{
            margin-top: 10px;
        }

        #form-create input{
            margin-top: 5px;
            padding: 5px;
        }

        #form-create button{
            margin-top: 10px;
            padding: 5px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }

    </style>
    
</body>
</html>