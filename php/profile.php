<?php
require_once 'connexion.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Récupère les infos actuelles
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = :id");
$stmt->execute([':id' => $user_id]);
$current = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$current) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur introuvable.']);
    exit;
}

// Récupère les nouvelles données
$newUsername = isset($_POST['edit-username']) ? trim($_POST['edit-username']) : $current['username'];
$newEmail = isset($_POST['edit-email']) ? trim($_POST['edit-email']) : $current['email'];

// Check si y’a un fichier image
$imageUpdated = isset($_FILES['edit-profile-picture']) && $_FILES['edit-profile-picture']['error'] == UPLOAD_ERR_OK;

// Vérifie si rien n’a changé (username/email) ET aucune image envoyée
if ($newUsername === $current['username'] && $newEmail === $current['email'] && !$imageUpdated) {
    echo json_encode(['success' => false, 'message' => 'Aucune modification détectée.']);
    exit;
}

// Update username/email si ça a changé
if ($newUsername !== $current['username'] || $newEmail !== $current['email']) {
    $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
    $success = $stmt->execute([
        ':username' => $newUsername,
        ':email' => $newEmail,
        ':id' => $user_id
    ]);

    if (!$success) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour des infos.']);
        exit;
    }

    $_SESSION['username'] = $newUsername;
    $_SESSION['email'] = $newEmail;
}

// Si une nouvelle image est uploadée
if ($imageUpdated) {
    $uploadDir = '../uploads/';
    $imageName = basename($_FILES['edit-profile-picture']['name']);
    $imagePath = $uploadDir . time() . '_' . $imageName; // on évite les doublons

    // Déplace le fichier
    if (move_uploaded_file($_FILES['edit-profile-picture']['tmp_name'], $imagePath)) {
        $stmt = $pdo->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
        $stmt->execute([':profile_picture' => $imagePath, ':id' => $user_id]);

        $_SESSION['profile_picture'] = $imagePath;
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload de l\'image.']);
        exit;
    }
}

echo json_encode(['success' => true, 'message' => 'Profil mis à jour avec succès.']);
?>
