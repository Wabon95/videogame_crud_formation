<?php

try {
    $pdoInstance = new PDO('mysql:host=localhost;dbname=videogames', 'root', '');
    $pdoInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage();
}