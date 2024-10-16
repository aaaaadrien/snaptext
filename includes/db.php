<?php
function getDBConnection() {
    global $db_host,$db_name,$db_user,$db_pass;

    try {
        $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";
        $pdo = new PDO($dsn, $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
?>
