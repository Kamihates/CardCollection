<?php require_once 'connexion.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Adaptation mobile (viewport)  -->
  <meta name="author" content="Tony Dang">
  <meta name="description" content="Collectionnez des cartes numériques de Pokémon.">
  <meta name="keywords" content="Pokémon, Collection, Carte, Pokemoncgg, pokemon, pkmn, pokemoncgg, tcg, cgg, collection, jeu">
  <meta data-n-head="true" data-hid="og:image" property="og:image" content="../images/background.gif">
  <link rel="icon" type="image/x-icon" href="../images/favicon.ico"> <!-- Favicon (icone titre)  -->

  <!-- Début importation librairie -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/footer.css">

  <!-- Fin importation librairie -->

  <title>Pokemon Cards Collection</title>

</head>
<body>

  <!-- Début section header  -->

  <header class ="header">

    <a class="logo"><img src="../images/logo.png" alt="logo"></a>

    <nav class="navbar">
      <a href="../#home">Accueil</a>
      <a href="../#about">A propos</a>
      <a href="../#features">Nos offres</a>
      <a href="../#cards">Cartes en vedette</a>
      <a href="../#review">Avis utilisateurs</a>
    </nav>

    <div class="icons">
      <div id="menu-btn" class="fas fa-bars"></div>
      <a id="dark-mode" onclick="darkMode()" title="darkMode" class="fas fa-moon"></a>
      <a id="music-btn" title="music" class="fas fa-music"></a>
      <audio loop autoplay="true" id="son1" src="../musics/music-navbar.mp3"></audio>
      <?php if (isset($_SESSION['user_id']))
      {
        $profilePic = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../images/default-profile.png';
        echo "<img src='$profilePic' alt='Photo de profil' class='profile-pic' onclick='toggleProfileModal()'>";
      }
      else
      {
              echo "<a id='login-btn' onclick='toggleLoginModal()' title='Login' class='fas fa-sign-in'></a>";
      }
      ?>
    </div>

    <div id="login-modal" class="login-modal">
      <span onclick="toggleLoginModal()" class="close" title="Close Modal">&times;</span>
      <form id="login-form" form class="login-modal-content animate" method="post" action="php/login.php">
        <div class="title">
          <p>Se connecter</p>
        </div>

        <div class="container">
          <label for="uname"><b>Pseudo</b></label>
          <input type="text" placeholder="Pseudo" name="username">
          <label for="psw"><b>Mot de passe</b></label>
          <input type="password" placeholder="Mot de passe" name="password">
          <button type="submit">Connexion</button>
          <label>
            <input type="checkbox" checked="checked" name="remember"> Se souvenir de moi
          </label>
        </div>

        <div class="container">
          <a class= "psw" href="#">Mot de passe oublié?</a>
          <a class="createaccount" href="#" onclick="switchToSignup()">Créer un compte</a>
        </div>
      </form>
    </div>

    <div id="signup-modal" class="login-modal">
      <span onclick="toggleSignupModal()" class="close" title="Close Modal">&times;</span>
      <form id="signup-form" form class="login-modal-content animate" method="post" action="php/register.php" enctype="multipart/form-data">
        <div class="title">
          <p>Créer un compte</p>
        </div>

        <div class="container">
          <label for="new-username"><b>Pseudo</b></label>
          <input type="text" placeholder="Pseudo" name="new-username">

          <label for="new-email"><b>Email</b></label>
          <input type="email" placeholder="Email" name="new-email">

          <label for="new-password"><b>Mot de passe</b></label>
          <input type="password" placeholder="Mot de passe" name="new-password">

          <label for="confirm-password"><b>Confirmer mot de passe</b></label>
          <input type="password" placeholder="Confirmer le mot de passe" name="confirm-password">

          <label for="profile-picture"><b>Photo de profil</b></label>
          <input type="file" name="profile-picture" accept="image/*">

          <button type="submit">Créer mon compte</button>
        </div>

        <div class="container">
          <a class="psw" href="#" onclick="switchToLogin()">Déjà un compte ? Se connecter</a>
        </div>
      </form>
    </div>

    <div id="profile-modal" class="login-modal">
      <span onclick="toggleProfileModal()" class="close" title="Close Modal">&times;</span>
      <div class="login-modal-content animate">
        <div class="container" style="text-align:center;">
          <?php if (isset($_SESSION['user_id'])): ?>
            <img src="<?php echo isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../images/default-profile.png'; ?>" alt="Photo de profil" class="profile-pic">
            <p><?php echo $_SESSION['username']; ?></p>
              <a href="javascript:void(0)" class="btn" onclick="logoutUser()">Déconnexion</a>
              <a href="javascript:void(0)" class="btn" onclick="toggleEditModal()">Modifier mon profil</a>
              <a href="javascript:void(0)" class="btn" onclick="deleteAccount()





              ">Supprimer mon compte</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div id="edit-modal" class="login-modal">
      <span onclick="toggleEditModal()" class="close" title="Fermer">&times;</span>
      <form id="edit-form" form class="login-modal-content animate" method="post" action="php/profile.php" enctype="multipart/form-data">
        <div class="title">
          <p>Modifier mon profil</p>
        </div>

        <div class="container">
          <label for="edit-username"><b>Nouveau pseudo</b></label>
          <input type="text" name="edit-username" placeholder="Nouveau pseudo" value="<?php echo $_SESSION['username']; ?>">

          <label for="edit-password"><b>Nouveau mot de passe</b></label>
          <input type="password" name="edit-password" placeholder="Nouveau mot de passe">

          <label for="confirm-edit-password"><b>Confirmer mot de passe</b></label>
          <input type="password" name="confirm-edit-password" placeholder="Confirmer le mot de passe">

          <label for="edit-profile-picture"><b>Nouvel avatar</b></label>
          <input type="file" name="edit-profile-picture" accept="image/*">

          <button type="submit">Confirmer les modifications</button>
        </div>
      </form>
    </div>

  </header>

  <!-- Fin section header -->
