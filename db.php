<?php
// db.php - Connexion à MySQL avec un utilisateur dédié

function getDBConnection() {
    $host = 'localhost';
    $db = 'secure_text_db';
    $user = 'app_user';
    $pass = 'password_secure';

    try {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
?>
