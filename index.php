<?php
require_once 'include.php';

$pdo = Bd::getInstance()->getConnexion();
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


$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $chienControleur->liste();
        break;
    case 'create':
        $chienControleur->creer();
        break;
    case 'store':
        $chienControleur->enregistrer();
        break;
    case 'edit':
        $chienControleur->modifier();
        break;
    case 'update':
        $chienControleur->mettreAJour();
        break;
    case 'delete':
        $chienControleur->supprimer();
        break;
    default:
        $chienControleur->liste();
        break;
}
?>
