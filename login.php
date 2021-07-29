<?php

session_start();

require_once "database.php";
require_once "functions.php";

if ($_POST) {

    $nickname = strip_tags(htmlspecialchars($_POST['inputNickname']));
    $password = strip_tags(htmlspecialchars($_POST['inputPassword']));
    
    // Injection SQL
    // $nickname = $_POST['inputNickname']; // - "Dadou';--" - 
    // $password = $_POST['inputPassword'];
    // $pdoStatement = $pdoInstance->query("SELECT * FROM user WHERE nickname = '$nickname' AND password = '$password'");
    // $userFromDB = $pdoStatement->fetch();
    // $_SESSION['user'] = $userFromDB;
    // header('Location: index.php');
    // dump($userFromDB);
    // die;

    $pdoStatement = $pdoInstance->prepare("SELECT * FROM user WHERE nickname = :nickname");
    $pdoStatement->execute([
        ':nickname' => $nickname,
    ]);
    $userFromDB = $pdoStatement->fetch();

    // On vérifie en premier lieu si un utilisateur porte ce pseudo en base de données
    if ($userFromDB && $userFromDB['nickname'] == $nickname) {
        // Ensuite on vérifie que le mot de passe renseigné correspond au mot de passe hashé en base de données
        if (password_verify($password, $userFromDB['password'])) {
            // Si tout match, on ajoute l'utillisateur dans la session
            $_SESSION['user'] = $userFromDB;
            header('Location: index.php');
        } else {
            echo "Mauvais mot de passe.";
        }
    } else {
        echo "Cet utilisateur n'as pas été trouvé dans la base de données.";
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
    <title>Connexion</title>

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
            <h1 class="h3 mb-3 fw-normal">Connexion</h1>
            <form action="" method="post">
    
                <div class="mb-1">
                    <label for="inputNickname">Votre pseudo</label>
                    <input type="text" class="form-control" name="inputNickname" id="inputNickname" placeholder="Votre pseudo">
                </div>

                <div class="mb-3">
                    <label for="inputPassword">Votre mot de passe</label>
                    <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="Votre mot de passe">
                </div>
    
                <button class="w-100 btn btn-lg btn-primary" type="submit">Connexion</button>
            </form>
        </main>
    </div>

</body>
</html>