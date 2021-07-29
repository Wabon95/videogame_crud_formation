<?php

session_start();

require_once 'database.php';
require_once 'functions.php';

// Si l'utilisateur accède à cette page en renseignant directement l'url, on le redirige automatiquement vers l'index
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

$sql = "SELECT * FROM `message` WHERE author = ? ORDER BY date DESC";
$sth = $pdoInstance->prepare($sql);
$sth->execute([
    $_SESSION['user']['nickname']
]);
$allMessagesFromUser = $sth->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Consulter mes messages envoyés</title>
</head>
<body>
    <div class="container">
        <h1>Mes messages envoyés</h1>
        <?php include "nav.php";
        if ($allMessagesFromUser != false):
        foreach ($allMessagesFromUser as $message): ?>
            <h4>Posté le <?= strftime('%d/%m à %Hh%M', strtotime($message['date'])) ?></h4>
            <p><?= $message['content'] ?></p>
        <?php endforeach; endif; ?>
    </div>
</body>
</html>