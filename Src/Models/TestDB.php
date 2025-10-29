<?php
require_once 'Database.php';

$db = new Database();
$pdo = $db->getConnection();

try {
    $stmt = $pdo->query("SELECT DATABASE() AS db_name");
    $result = $stmt->fetch();
    echo "Connexion réussie à la base : " . $result['db_name'] . PHP_EOL;
} catch (PDOException $e) {
    echo "Erreur lors de la requête : " . $e->getMessage() . PHP_EOL;
}
