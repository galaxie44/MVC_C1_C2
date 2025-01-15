<?php
    class ControleurFactory {
        public static function getController($controleur, Twig\Loader\FilesystemLoader $loader, Twig\Environment $twig, $pdo) {
            $controllerName = ucFirst($controleur) . "Controleur";
            if (!class_exists($controllerName)) {
                throw new Exception("La classe $controllerName n'existe pas !");
            }
            return new $controllerName($twig, $loader, $pdo);  // Passez également $pdo
        }
    }
?>