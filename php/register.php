<?php
// Démarre une session pour pouvoir stocker des infos de l'utilisateur
session_start();

// Inclusion du fichier de connexion à la base de données
require_once 'connexion.php';

// On définit que la réponse sera en JSON
header('Content-Type: application/json');

// Vérifie si la requête est bien une méthode POST (sinon on bloque)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupère et nettoie les champs du formulaire
    $username = htmlspecialchars(trim($_POST['new-username']));
    $email = htmlspecialchars(trim($_POST['new-email']));
    $password = htmlspecialchars(trim($_POST['new-password']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirm-password']));

    // Vérifie que tous les champs sont bien remplis
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs doivent être remplis.']);
        exit();
    }

    // Vérifie que l'email est au bon format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Adresse email invalide.']);
        exit();
    }

    // Vérifie que les deux mots de passe sont identiques
    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Les mots de passe ne correspondent pas.']);
        exit();
    }

    // Vérifie si le pseudo ou l'email est déjà utilisé dans la base
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Ce pseudo ou cette adresse email est déjà utilisé(e).']);
        exit();
    }

    // Gestion de l’upload de la photo de profil
    $profilePicture = $_FILES['profile-picture'];

    // Si une erreur est survenue pendant l’upload (par exemple fichier corrompu)
    if ($profilePicture['error'] !== 0) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors du téléchargement de l’image.']);
        exit();
    }

    // Récupère l'extension du fichier uploadé
    $ext = pathinfo($profilePicture['name'], PATHINFO_EXTENSION);

    // Génère un nom de fichier unique et le dossier de destination
    $profilePictureDestination = '../uploads/' . uniqid('', true) . '.' . $ext;

    // Déplace le fichier temporaire vers le dossier d’upload
    move_uploaded_file($profilePicture['tmp_name'], $profilePictureDestination);

    // Hash le mot de passe pour le stocker de façon sécurisée
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion du nouvel utilisateur dans la base de données
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password, profile_picture)
        VALUES (:username, :email, :password, :profile_picture)
    ");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword,
        'profile_picture' => $profilePictureDestination
    ]);

    // Enregistre les infos de session pour l'utilisateur nouvellement inscrit
    $_SESSION['user_id'] = $pdo->lastInsertId(); // Récupère l’ID du dernier utilisateur inséré
    $_SESSION['username'] = $username;

    // Retourne un message de succès
    echo json_encode(['success' => true, 'message' => 'Inscription réussie !']);

} else {
    // Si la requête n’est pas en POST, on refuse
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}
