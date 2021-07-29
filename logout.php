<?php

session_start();

require_once "database.php";
require_once "functions.php";

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}
header('Location: index.php');