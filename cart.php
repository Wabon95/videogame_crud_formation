<?php

session_start();

require_once "database.php";
require_once "functions.php";

if ($_SESSION) {
    // dump($_SESSION);
}

// S'il y a un id dans l'url c'est que l'utilisateur souhaite ajouter ou supprimer un jeu dans son panier
if (isset($_GET['id']) && $_GET['id'] != '') {
    // On récupère le jeu depuis la BDD grâce à son ID
    $pdoStatement = $pdoInstance->prepare("SELECT * FROM jeux_video WHERE id = ?");
    $pdoStatement->execute([strip_tags(htmlspecialchars($_GET['id']))]);
    $videoGame = $pdoStatement->fetch();

    // On créer un clé 'cart' dans la SESSION qui contiendra notre panier
    // On vérifie au préalable si cette clé n'as pas déjà été crée grâce à un isset()
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Si l'utilisateur souhaite ajouter un jeu à son panier
    if (isset($_GET['action']) && $_GET['action'] == 'add') {
        // On vérifie si le jeu que l'utilisateur souhaite ajouter ne possède pas déjà une clé à son ID dans le tableau 'cart'
        if (array_key_exists($videoGame['ID'], $_SESSION['cart'])) {
            // Si oui, le jeu était déjà présent dans son panier, on va simplement simuler l'ajout d'un deuxième jeu en créant une clé 'count' que l'on incrémentera à chaque fois
            $_SESSION['cart'][$videoGame['ID']]['count']++; 
        } else {
            // Si le jeu n'était pas déjà présent dans son panier, on insère toutes les données du jeu dans une clé dans le lableau 'cart'
            // Clé qui sera l'ID du jeu que l'on souhaite ajouter
            $_SESSION['cart'][$videoGame['ID']] = $videoGame;
            // On défini pour la première fois la valeur du nombre du jeu déjà présent dans le tableau
            // Si on arrive ici, c'est que le jeu est ajouté pour la première fois, on peut donc directement définir la valeur à 1
            $_SESSION['cart'][$videoGame['ID']]['count'] = 1;
        }
    }

    // Si l'utilisateur souhaite enlever un jeu de son panier, ou plutôt diminuer sa quantité de 1
    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        // On vérifie que le jeu est présent au moins 2 fois dans la session pour diminuer la valeur de la clé 'count' de 1.
        // Pour ne pas avoir une valeur de 'count' égale à 0, ou pire, à un nombre négatif
        if ($_SESSION['cart'][$videoGame['ID']]['count'] > 1) {
            $_SESSION['cart'][$videoGame['ID']]['count']--;
        } elseif ($_SESSION['cart'][$videoGame['ID']]['count'] == 1) {
            // Si on est ici, c'est qu'il n'y a plus qu'un seul exemplaire du jeu dans la session
            // On peut donc directement supprimer la clé entière contenant toutes les données de notre jeu en session.
            unset($_SESSION['cart'][$videoGame['ID']]);
        }
    }
    header('Location: cart.php');
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Panier</title>
</head>
<body>
    <div class="container">
        <h1>Listing des jeux présents dans mon panier</h1>
        <?php include "nav.php"; ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Possesseur</th>
                    <th scope="col">Console</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Joueur max</th>
                    <th scope="col">Commentaires</th>
                    <th scope="col">Quantité</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($_SESSION['cart'])):
                        foreach($_SESSION['cart'] as $videoGame): ?>
                            <tr>
                                <td><a href="view.php?id=<?= $videoGame['ID'] ?>"><?= $videoGame['nom'] ?></a></td>
                                <td><?= $videoGame['possesseur'] ?></td>
                                <td><?= $videoGame['console'] ?></td>
                                <td><?= $videoGame['prix'] ?></td>
                                <td><?= $videoGame['nbre_joueurs_max'] ?></td>
                                <td><?= $videoGame['commentaires'] ?></td>
                                <td><?= $videoGame['count'] ?></td>
                                <td><a href="?action=add&id=<?= $videoGame['ID'] ?>" class="text-decoration-none">Ajouter</a>, <a href="?action=delete&id=<?= $videoGame['ID'] ?>" class="text-decoration-none">Retirer</a></td>
                            </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>