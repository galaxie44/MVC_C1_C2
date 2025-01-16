<?php


class Chien {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM chien');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function store($data) {
        $stmt = $this->pdo->prepare('INSERT INTO chien (nom, age, race, photo, refuge_id) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$data['nom'], $data['age'], $data['race'], $data['photo'], $data['refuge_id']]);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM chien WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($data) {
        $stmt = $this->pdo->prepare('UPDATE chien SET nom = ?, age = ?, race = ?, photo = ?, refuge_id = ? WHERE id = ?');
        $stmt->execute([$data['nom'], $data['age'], $data['race'], $data['photo'], $data['refuge_id'], $data['id']]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM chien WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function decrementPlaces($refugeId) {
        $stmt = $this->pdo->prepare('UPDATE refuge SET places_restantes = places_restantes - 1 WHERE id = ? AND places_restantes > 0');
        $stmt->execute([$refugeId]);
    }
    
    public function incrementPlaces($refugeId) {
        $stmt = $this->pdo->prepare('UPDATE refuge SET places_restantes = places_restantes + 1 WHERE id = ? AND places_restantes < capacite');
        $stmt->execute([$refugeId]);
    }
    
}
?>
