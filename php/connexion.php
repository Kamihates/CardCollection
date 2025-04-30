<?php

// Démarre une session pour pouvoir stocker des infos de l'utilisateur
if (session_status() == PHP_SESSION_NONE)
{
  session_start();  
}

$host = 'localhost';
$dbname = 'connexion';
$port = 3306;
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>
