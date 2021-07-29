<?php

session_start();

require_once 'database.php';
require_once 'functions.php';

// Si l'utilisateur accède à cette page en renseignant directement l'url, on le redirige automatiquement vers l'index
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

$sql = "SELECT * FROM `message` ORDER BY date DESC";
$sth = $pdoInstance->prepare($sql);
$sth->execute();
$allMessagesFromDB = $sth->fetchAll();

if ($_POST) {
    $_POST['inputMessage'] = strip_tags(htmlspecialchars($_POST['inputMessage']));
    if ($_POST['inputMessage'] != '') {
        $sql = "INSERT INTO message (author, content) VALUES (:author, :content)";
        $sth = $pdoInstance->prepare($sql);
        $sth->execute([
            ':author' => $_SESSION['user']['nickname'],
            ':content' => $_POST['inputMessage']
        ]);
        header("Location: minichat.php");
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Minichat</title>
</head>
<body>
    <div class="container">
        <h1>Minichat</h1>
        <?php include "nav.php"; ?>
        <form action="" method="post">
            <div class="mb-3">
                <label for="inputMessage" class="form-label">Votre message</label>
                <input type="text" class="form-control" name="inputMessage" id="inputMessage">
            </div>
            <button type="submit" class="btn btn-primary mb-3">Envoyer</button>
        </form>
        <a href="myMessages.php" class="btn btn-primary mb-3">Voir mes messages postés</a>
        <hr>
        <?php foreach ($allMessagesFromDB as $message): ?>
                <h4>Posté par <?= $message['author'] ?> le <?= strftime('%d/%m à %Hh%M', strtotime($message['date'])) ?></h4>
                <p><?= $message['content'] ?></p>
        <?php endforeach; ?>
    </div>
</body>
</html>