<?php
// Connexion à la base de données avec PDO
$dsn = 'mysql:host=localhost;dbname=alert1';
$username = 'root';
$password = 'hamidiath22';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}

?>