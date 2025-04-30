<?php

// Inclusion du fichier de connexion à la base de données
require_once 'connexion.php';

// On définit que la réponse sera en JSON
header('Content-Type: application/json');

// Vérifie si la requête est bien une méthode POST (évite les accès directs via URL)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupère et nettoie les champs du formulaire
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Vérifie que tous les champs sont bien remplis
    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs doivent être remplis.']);
        exit();
    }

    // Prépare une requête sécurisée pour récupérer l'utilisateur par son nom
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère le résultat en tableau 

    // Si un utilisateur est trouvé et que le mot de passe correspond
    if ($user && password_verify($password, $user['password'])) {
        // Stocke les infos utilisateur dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['profile_picture'] = $user['profile_picture'];

        // Renvoie un message de succès
        echo json_encode(['success' => true, 'message' => 'Connexion réussie !']);
    } else {
        // Sinon, identifiants incorrects
        echo json_encode(['success' => false, 'message' => 'Nom d’utilisateur ou mot de passe incorrect.']);
    }
} else {
    // Si la méthode n'est pas POST, on refuse la requête
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}
