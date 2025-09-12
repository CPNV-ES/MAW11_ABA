<?php
require_once 'Database.php';
class Exercise {
    private $pdo;
    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function showExercises() {
        $stmt = $this->pdo->query("SELECT id, titre FROM `exercise`");

        $exercises = $stmt->fetchAll();

        foreach ($exercises as $exercise) {
            echo "ID: " . $exercise['id'] . " - Titre: " . $exercise['titre'] . "<br>";
        }
    }
}
