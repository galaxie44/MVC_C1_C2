<?php

class Refuge {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère tous les refuges
     */
    public function getAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM refuge');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un nouveau refuge
     */
    public function store($data) {
        $stmt = $this->pdo->prepare(
            'INSERT INTO refuge (nom, adresse, capacite, places_restantes) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['nom'], 
            $data['adresse'], 
            $data['capacite'], 
            $data['places_restantes']
        ]);
    }

    /**
     * Récupère un refuge par son ID
     */
    public function getById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM refuge WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour les informations d'un refuge
     */
    public function update($data) {
        $stmt = $this->pdo->prepare(
            'UPDATE refuge 
             SET nom = ?, adresse = ?, capacite = ?, places_restantes = ? 
             WHERE id = ?'
        );
        $stmt->execute([
            $data['nom'], 
            $data['adresse'], 
            $data['capacite'], 
            $data['places_restantes'], 
            $data['id']
        ]);
    }

    /**
     * Supprime un refuge par son ID
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM refuge WHERE id = ?');
        $stmt->execute([$id]);
    }
    public function ajouterChienARefuge($idchien, $idrefuge ){
        $stmt = $this->pdo->prepare('INSERT INTO chien_refuge (chien_id, refuge_id) VALUES  (?,?);');
        $stmt->execute([$chien, $idrefuge]);
    }

    public function calcule($idRefuge){
        $stmt = $this->pdo->prepare('SELECT capacite - ( select count(chien_id) from chien_refuge where refuge_id = ? group by refuge_id ) from refuge where id = ?;');
    }
    public function decrementerPlacesRestantes($refuge_id) {
        // Récupérer le nombre de places restantes avant de faire la mise à jour
        $stmt = $this->pdo->prepare('SELECT places_restantes FROM refuge WHERE id = ?');
        $stmt->execute([$refuge_id]);
        $refuge = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($refuge && $refuge['places_restantes'] > 0) {
            // Décrémente le nombre de places restantes
            $stmt = $this->pdo->prepare('UPDATE refuge SET places_restantes = places_restantes - 1 WHERE id = ?');
            $stmt->execute([$refuge_id]);
        }
    }


    
}
