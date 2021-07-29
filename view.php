<?php

require_once "database.php";
require_once "functions.php";

if (isset($_GET['delete']) && $_GET['delete'] == true) {
    $pdoStatement = $pdoInstance->prepare("DELETE FROM jeux_video WHERE id = ?");
    $pdoStatement->execute([strip_tags(htmlspecialchars($_GET['id']))]);
    header('Location: index.php');
}

if (isset($_GET['id']) && $_GET['id'] != '') {
    // $pdoStatement = $pdoInstance->prepare("SELECT * FROM jeux_video WHERE id = ?");
    // $pdoStatement->execute([strip_tags(htmlspecialchars($_GET['id']))]);
    // $videoGame = $pdoStatement->fetch();
    $videoGame = findOneVideogame($_GET['id']);
}



if ($_POST) {
    $pdoStatement = $pdoInstance->prepare("UPDATE jeux_video SET nom = :nom, possesseur = :possesseur, console = :console, prix = :prix, nbre_joueurs_max = :joueurs_max, commentaires = :commentaires WHERE id = :id");
    $pdoStatement->execute([
        ':nom' => strip_tags(htmlspecialchars($_POST['inputName'])),
        ':possesseur' => strip_tags(htmlspecialchars($_POST['inputPossesseur'])),
        ':console' => strip_tags(htmlspecialchars($_POST['inputConsole'])),
        ':prix' => strip_tags(htmlspecialchars($_POST['inputPrix'])),
        ':joueurs_max' => strip_tags(htmlspecialchars($_POST['inputJoueursMax'])),
        ':commentaires' => strip_tags(htmlspecialchars($_POST['inputCommentaires'])),
        ':id' => $videoGame['ID']
    ]);
}

$pdoStatement = $pdoInstance->prepare("SELECT * FROM jeux_video WHERE id = ?");
$pdoStatement->execute([strip_tags(htmlspecialchars($_GET['id']))]);
$videoGame = $pdoStatement->fetch();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= $videoGame['nom'] ?></title>
</head>
<body>
    <div class="container">
        <h1><?= $videoGame['nom'] ?></h1>
        <?php include "nav.php"; ?>
        <form action="" method="post">

            <div class="mb-3">
                <label for="inputName" class="form-label">Nom</label>
                <input type="text" class="form-control" name="inputName" id="inputName" value="<?= $videoGame['nom'] ?>">
            </div>

            <div class="mb-3">
                <label for="inputPossesseur" class="form-label">Possesseur</label>
                <input type="text" class="form-control" name="inputPossesseur" id="inputPossesseur" value="<?= $videoGame['possesseur'] ?>">
            </div>

            <div class="mb-3">
                <label for="inputConsole" class="form-label">Console</label>
                <input type="text" class="form-control" name="inputConsole" id="inputConsole" value="<?= $videoGame['console'] ?>">
            </div>

            <div class="mb-3">
                <label for="inputPrix" class="form-label">Prix</label>
                <input type="number" class="form-control" name="inputPrix" id="inputPrix" value="<?= $videoGame['prix'] ?>">
            </div>

            <div class="mb-3">
                <label for="inputJoueursMax" class="form-label">Joueur max</label>
                <input type="number" class="form-control" name="inputJoueursMax" id="inputJoueursMax" value="<?= $videoGame['nbre_joueurs_max'] ?>">
            </div>

            <div class="mb-3">
                <label for="inputCommentaires" class="form-label">Commentaire</label>
                <input type="text" class="form-control" name="inputCommentaires" id="inputCommentaires" value="<?= $videoGame['commentaires'] ?>">
            </div>

            <button type="submit" href="?id=<?= $videoGame['ID'] ?>" class="btn btn-primary">Modifier</button>
            <a href="?delete=true&id=<?= $videoGame['ID'] ?>" class="btn btn-danger">Supprimer</a>

        </form>
    </div>
</body>
</html>