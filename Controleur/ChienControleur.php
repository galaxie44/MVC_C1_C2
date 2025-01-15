<?php




class ChienControleur extends Controleur {
    private $twig;
    private $pdo;

    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader, $pdo) {
       $this->twig = $twig;
       $this->loader = $loader;
        $this->pdo = $pdo;  // Ici vous initialisez le PDO correctement
    }

    public function liste() {
        $chienModele = new Chien($this->pdo);
        $refugeModele = new Refuge($this->pdo);
    
        // Récupération des données
        $chiens = $chienModele->getAll();
        $refuges = $refugeModele->getAll();
    
        // Transmission des données au template
        echo $this->twig->render('liste_chiens.html.twig', [
            'chiens' => $chiens,
            'refuges' => $refuges
        ]);
    }
    
    

    public function creer() {
        echo $this->twig->render('creer_chien.html.twig');
    }

    public function enregistrer() {
        $dir = "img"; // Nom du dossier contenant les photos

        if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
            $name = $_POST["nom"].".png";
            move_uploaded_file($_FILES["image"]["tmp_name"], "$dir/$name");
        }
        $data = [
            'nom' => $_POST['nom'],
            'age' => $_POST['age'],
            'race' => $_POST['race'],
            'photo' => $name,
            'refuge_id' => $_POST['refuge_id'] ?? null
        ];
        $chienModele = new Chien($this->pdo);
        $chienModele->store($data);
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }

    public function modifier() {
        $id = $_GET['id'];
        $chienModele = new Chien($this->pdo);
        $chien = $chienModele->getById($id);
        echo $this->twig->render('modifier_chien.html.twig', ['chien' => $chien]);
    }

    public function mettreAJour() {
        $data = [
            'id' => $_POST['id'],
            'nom' => $_POST['nom'],
            'age' => $_POST['age'],
            'race' => $_POST['race'],
            'photo' => $_POST['photo'],
            'refuge_id' => $_POST['refuge_id'] ?? null
        ];
        $chienModele = new Chien($this->pdo);
        $chienModele->update($data);
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }

    public function supprimer() {
        $id = $_GET['id'];
        $chienModele = new Chien($this->pdo);
        $chienModele->delete($id);
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }
}
?>
