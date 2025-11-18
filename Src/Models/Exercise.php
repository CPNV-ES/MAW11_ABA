<?php
require_once 'Database.php';

class Exercise {
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT exercise_id, title FROM `exercises`");
        return $stmt->fetchAll();
    }

    public function create($title)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `exercises` (title) VALUES (:title)");
        $stmt->execute(['title' => $title]);
        $lastid = $this->pdo->lastInsertId();
        return $lastid;
    }

    public function getTitle($id) {
        $stmt = $this->pdo->prepare("SELECT title FROM `exercises` WHERE exercise_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `exercises` WHERE exercise_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM `exercises` WHERE exercise_id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting exercise: " . $e->getMessage());
            return false;
        }
    }
    public function setStatusToAnswering($id)
    {
        $stmt = $this->pdo->prepare("UPDATE `exercises` SET status = 'answering' WHERE exercise_id = :id AND status = 'building'");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

}