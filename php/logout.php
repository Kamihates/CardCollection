
<?php require_once 'connexion.php';

// On détruit toutes les variables de session
session_unset();

// On détruit la session
session_destroy();

// Redirection vers la page d'accueil 
header('Location: ../index.php');
exit();
?>
