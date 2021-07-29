<?php

require_once "database.php";
require_once "functions.php";

if ($_POST) {
    $pdoStatement = $pdoInstance->prepare("INSERT INTO jeux_video (nom, possesseur, console, prix, nbre_joueurs_max, commentaires) VALUES (:nom, :possesseur, :console, :prix, :joueurs_max, :commentaires)");
    $pdoStatement->execute([
        ':nom' => strip_tags(htmlspecialchars($_POST['inputName'])),
        ':possesseur' => strip_tags(htmlspecialchars($_POST['inputPossesseur'])),
        ':console' => strip_tags(htmlspecialchars($_POST['inputConsole'])),
        ':prix' => strip_tags(htmlspecialchars($_POST['inputPrix'])),
        ':joueurs_max' => strip_tags(htmlspecialchars($_POST['inputJoueursMax'])),
        ':commentaires' => strip_tags(htmlspecialchars($_POST['inputCommentaires']))
    ]);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Ajouter un jeu</title>
</head>
<body>
<div class="container">
        <h1>Ajouter un jeu</h1>
        <?php include "nav.php"; ?>
        <form action="" method="post">

            <div class="mb-3">
                <label for="inputName" class="form-label">Nom</label>
                <input type="text" class="form-control" name="inputName" id="inputName">
            </div>

            <div class="mb-3">
                <label for="inputPossesseur" class="form-label">Possesseur</label>
                <input type="text" class="form-control" name="inputPossesseur" id="inputPossesseur">
            </div>

            <div class="mb-3">
                <label for="inputConsole" class="form-label">Console</label>
                <select name="inputConsole" id="inputConsole" class="form-select">
                    <option value="PC">PC</option>
                    <option value="dreamcast">Dreamcast</option>
                    <option value="xbox">Xbox</option>
                    <option value="ps">PS</option>
                    <option value="ps2">PS2</option>
                    <option value="nes">NES</option>
                    <option value="gba">GBA</option>
                    <option value="gameboy">Gameboy</option>
                    <option value="nintendo_64">Nintendo 64</option>
                    <option value="megadrive">Megadrive</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="inputPrix" class="form-label">Prix</label>
                <input type="number" class="form-control" name="inputPrix" id="inputPrix">
            </div>

            <div class="mb-3">
                <label for="inputJoueursMax" class="form-label">Joueur max</label>
                <input type="number" class="form-control" name="inputJoueursMax" id="inputJoueursMax">
            </div>

            <div class="mb-3">
                <label for="inputCommentaires" class="form-label">Commentaire</label>
                <input type="text" class="form-control" name="inputCommentaires" id="inputCommentaires">
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>

        </form>
    </div>
</body>
</html>