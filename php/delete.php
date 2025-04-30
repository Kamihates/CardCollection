<?php
require_once 'connexion.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Préparer la requête pour supprimer l'utilisateur de la base de données
    $query = "DELETE FROM users WHERE id = :user_id"; // Si le nom de la colonne est "id"
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Détruire la session et rediriger vers la page d'accueil après la suppression
        session_destroy();
        header('Location: ../index.php');
        exit();
    } else {
        echo "Erreur lors de la suppression du compte.";
    }
} else {
    echo "Utilisateur non connecté.";
}
?>
