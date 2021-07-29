<?php if (isset($_SESSION['user'])): ?>
    <p>Bonjour <?= $_SESSION['user']['nickname'] ?> !</p>
<?php endif; ?>
<nav>
    <li class="d-inline-block p-2" ><a href="index.php" class="text-decoration-none">Listing des jeux</a></li>
    <li class="d-inline-block p-2" ><a href="add.php" class="text-decoration-none">Ajouter un jeu</a></li>
    <!-- Si l'utilisateur est dans la session il est connecté, alors on ne lui affiche pas les liens pour s'inscrire ou se connecter -->
    <!-- À la place on va lui afficher un lien pour consulter son panier ainsi que pour se déconnecter -->
    <?php if (isset($_SESSION['user'])): ?>
        <li class="d-inline-block p-2" ><a href="minichat.php" class="text-decoration-none">Minichat</a></li>
        <li class="d-inline-block p-2" ><a href="cart.php" class="text-decoration-none">Voir mon panier</a></li>
        <li class="d-inline-block p-2" ><a href="logout.php" class="text-decoration-none">Se déconnecter</a></li>
        <!-- En revanche, s'il n'y a pas d'utilisateur dans la session, alors on affiche les liens d'inscription et de connexion -->
    <?php elseif(!isset($_SESSION['user'])): ?>
        <li class="d-inline-block p-2" ><a href="register.php" class="text-decoration-none">S'inscrire</a></li>
        <li class="d-inline-block p-2" ><a href="login.php" class="text-decoration-none">Se connecter</a></li>
    <?php endif; ?>
</nav>