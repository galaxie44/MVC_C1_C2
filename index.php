<?php
require_once 'include.php';

$pdo = Bd::getInstance()->getConnexion();
try{
if (isset($_GET['controleur'])) {
    $controleurName = $_GET['controleur'];
 }else {
    $controleurName = "";
 }
 if (isset($_GET['methode'])) {
    $methode = $_GET['methode'];
 }
 else {
    $methode = "";
 }
 if ($controleurName == "" && $methode == "") {
    $controleurName = "Chien";
    $methode = "liste";
 }
 if ($controleurName == "") {
    throw new Exception("Le controleur n'est pas defini");
 }
 if ($methode == "") {
    throw new Exception("La methode n'est pas definie");
 }
 $controleur = ControleurFactory::getController($controleurName, $loader, $twig, $pdo);

 $controleur->call($methode);
} catch (Exception $e) {
    die("Erreur : ".$e->getMessage());
 }

$action = $_GET['action'] ?? 'list';


?>
