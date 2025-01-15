<?php
// config/database.php

$dsn = 'mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=eclemence001_bd;charset=utf8';
$username = 'eclemence001_bd';
$password = 'eclemence001_bd';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}
?>
