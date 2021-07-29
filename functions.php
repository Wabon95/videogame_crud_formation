<?php

function dump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function findAllVideogames() : array | bool {
    global $pdoInstance;
    $pdoStatement = $pdoInstance->prepare("SELECT * FROM jeux_video");
    $pdoStatement->execute();
    $videoGames = $pdoStatement->fetchAll();
    if($videoGames) {
        return $videoGames;
    }
    return false;
}

function findOneVideogame(int $id) : array | bool {
    global $pdoInstance;
    $pdoStatement = $pdoInstance->prepare("SELECT * FROM jeux_video WHERE id = ?");
    $pdoStatement->execute([
        $id
    ]);
    $videoGame = $pdoStatement->fetch();
    if($videoGame) {
        return $videoGame;
    }
    return false;
}