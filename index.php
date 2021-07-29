<?php

session_start();

require_once "database.php";
require_once "functions.php";

// $pdoStatement = $pdoInstance->prepare("SELECT * FROM jeux_video");
// $pdoStatement->execute();
// $videoGames = $pdoStatement->fetchAll();
$videoGames = findAllVideogames();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Listing des jeux</title>
</head>
<body>
    <div class="container">
        <h1>Listing des jeux</h1>
        <?php include "nav.php"; ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Possesseur</th>
                    <th scope="col">Console</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Joueur max</th>
                    <th scope="col">Commentaires</th>
                    <?php if (isset($_SESSION['user'])): ?>
                        <th scope="col">Ajouter au panier</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($videoGames as $videoGame): ?>
                <tr>
                    <td><?= $videoGame['ID'] ?></td>
                    <td><a href="view.php?id=<?= $videoGame['ID'] ?>"><?= $videoGame['nom'] ?></a></td>
                    <td><?= $videoGame['possesseur'] ?></td>
                    <td><?= $videoGame['console'] ?></td>
                    <td><?= $videoGame['prix'] ?></td>
                    <td><?= $videoGame['nbre_joueurs_max'] ?></td>
                    <td><?= $videoGame['commentaires'] ?></td>
                    <?php if (isset($_SESSION['user'])): ?>
                        <td><a href="cart.php?action=add&id=<?= $videoGame['ID'] ?>" class="text-decoration-none">+</a></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>
</html>