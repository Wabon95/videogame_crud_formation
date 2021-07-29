<?php

session_start();

require_once "database.php";
require_once "functions.php";

if ($_POST) {

    $nickname = strip_tags(htmlspecialchars($_POST['inputNickname']));
    $password = strip_tags(htmlspecialchars($_POST['inputPassword']));

    $pdoStatement = $pdoInstance->prepare("SELECT * FROM user WHERE nickname = :nickname");
    $pdoStatement->execute([
        ':nickname' => $nickname,
    ]);
    $userFromDB = $pdoStatement->fetch();

    // On vérifie que ce pseudo n'est pas déj`s pris par quelqu'un d'autre dans la base de données
    if (!$userFromDB || $userFromDB['nickname'] != $nickname) {
        // On vérifie que l'utilisateur à bien renseigné les champs
        if (trim($nickname) != '' && trim($password) != '') {
            $pdoStatement = $pdoInstance->prepare("INSERT INTO user (nickname, password) VALUES (:nickname, :password)");
            $pdoStatement->execute([
                ':nickname' => $nickname,
                // Insérer d'abord le mot de passe non hashé, pour montrer une injection SQL ensuite
                ':password' => password_hash($password, PASSWORD_BCRYPT), // On insère le mot de passe hashé en base de données
            ]);
            header('Location: login.php');
        }
    } else {
        echo 'Ce pseudo est déjà utilisé';
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
    <title>Inscription</title>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
    </style>

</head>
<body>
    <div class="container">
        <main class="form-signin text-center">
            <h1 class="h3 mb-3 fw-normal">Inscription</h1>
            <form action="" method="post">
    
                <div class="mb-1">
                    <label for="inputNickname">Votre pseudo</label>
                    <input type="text" class="form-control" name="inputNickname" id="inputNickname" placeholder="Votre pseudo">
                </div>

                <div class="mb-3">
                    <label for="inputPassword">Votre mot de passe</label>
                    <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="Votre mot de passe">
                </div>
    
                <button class="w-100 btn btn-lg btn-primary" type="submit">Inscription</button>
            </form>
        </main>
    </div>

</body>
</html>