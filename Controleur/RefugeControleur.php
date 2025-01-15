<?php

class RefugeControleur extends Controleur {
    private $twig;
    private $pdo;

    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader, $pdo) {
        $this->twig = $twig;
        $this->loader = $loader;
        $this->pdo = $pdo;  // Initialisation correcte de PDO
    }

    /**
     * Affiche la liste des refuges
     */
    public function liste() {
        $refugeModele = new Refuge($this->pdo);
        $refuges = $refugeModele->getAll();
        echo $this->twig->render('liste_refuges.html.twig', ['refuges' => $refuges]);

        return;  // Retour explicite
    }

    /**
     * Affiche le formulaire pour créer un nouveau refuge
     */
    public function creer() {
        echo $this->twig->render('creer_refuge.html.twig');
    }

    /**
     * Enregistre un nouveau refuge
     */
    public function enregistrer() {
        $data = [
            'nom' => $_POST['nom'],
            'adresse' => $_POST['adresse'],
            'capacite' => $_POST['capacite'],
            'places_restantes' => $_POST['places_restantes']
        ];

        $refugeModele = new Refuge($this->pdo);
        $refugeModele->store($data);
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }

    /**
     * Affiche le formulaire pour modifier un refuge existant
     */
    public function modifier() {
        $id = $_GET['id'];
        $refugeModele = new Refuge($this->pdo);
        $refuge = $refugeModele->getById($id);
        echo $this->twig->render('modifier_refuge.html.twig', ['refuge' => $refuge]);
    }

    /**
     * Met à jour les informations d'un refuge existant
     */
    public function mettreAJour() {
        $data = [
            'id' => $_POST['id'],
            'nom' => $_POST['nom'],
            'adresse' => $_POST['adresse'],
            'capacite' => $_POST['capacite'],
            'places_restantes' => $_POST['places_restantes']
        ];

        $refugeModele = new Refuge($this->pdo);
        $refugeModele->update($data);
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }

    /**
     * Supprime un refuge
     */
    public function supprimer() {
        $id = $_GET['id'];
        $refugeModele = new Refuge($this->pdo);
        $refugeModele->delete($id);
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }
}
