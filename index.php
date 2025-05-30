<!DOCTYPE html>
<html lang="fr">
<html>
<head>
  <!-- Début section header  -->

  <?php include 'php/header.php'; ?>
  <?php include 'php/config.php'; ?>

  <!-- Fin section header  -->
</head>
<body>
  <!-- Début section home  -->

  <section class="home" id="home">

    <div class="content">
      <h3>Pokémon</h3>
      <p>Cartes à jouer et à collectionner</p>
      <a href="php/morecards.php" class="btn">Voir nos cartes</a>
    </div>

    <!-- Swiper -->
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide" data-name="<?php echo htmlspecialchars(getCard('sv9-182')['name']); ?>">
            <img src="<?php echo htmlspecialchars(getCard('sv9-182')['image']); ?>" alt="Volcanion EX" />
        </div>
        <div class="swiper-slide" data-name="<?php echo htmlspecialchars(getCard('sv9-189')['name']); ?>">
            <img src="<?php echo htmlspecialchars(getCard('sv9-189')['image']); ?>" alt="N's Zoroark EX" />
        </div>
        <div class="swiper-slide" data-name="<?php echo htmlspecialchars(getCard('sv9-164')['name']); ?>">
            <img src="<?php echo htmlspecialchars(getCard('sv9-164')['image']); ?>" alt="Lili Ribombee" />
        </div>
        <div class="swiper-slide" data-name="<?php echo htmlspecialchars(getCard('sv9-180')['name']); ?>">
          <img src="<?php echo htmlspecialchars(getCard('sv9-180')['image']); ?>" alt="Iris Fighting Spirit" />
        </div>
        <div class="swiper-slide" data-name="<?php echo htmlspecialchars(getCard('sv9-190')['name']); ?>">
            <img src="<?php echo htmlspecialchars(getCard('sv9-190')['image']); ?>" alt="Spiky Energy" />
        </div>
      </div>
    </div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div id="card-name" class="card-name"></div>

  </section>

  <!-- Fin section home -->

  <!-- Début section about  -->

  <section class="about" id="about">

    <div class="image">
      <img src="../images/charizard-revised-fr-unscreen.gif" alt="Dracaufeu">
    </div>

    <div class="content">
      <h2>Qu'est-ce que c'est?</h2>
      <h3>Le jeu de cartes à collectionner Pokémon ! </h3>
      <p>Collectionnez des cartes à l’effigie de vos Pokémon préférés. Ce jeu fortement fédérateur a été distribué dans 14 langues et 89 pays ou régions, donnant aux fans du monde entier l’occasion de plonger dans l’univers Pokémon !</p>
      <a href="https://tcgpocket.pokemon.com/fr-fr/" class="btn">Site officiel Pokémon</a>
    </div>

  </section>

  <!-- Fin section about -->

  <!-- Début section activity  -->

  <section class="features" id="features">

           <h1 class="heading"> Nos offres</h1>

           <div class="box-container">

              <div class="box" class="box">
                 <i class="fas fa-hourglass"></i>
                 <h3>Boosters gratuits à ouvrir !</h3>
                 <p>Accède à des boosters gratuits pour démarrer ta collection sans dépenser un centime. Chaque booster contient des cartes rares et uniques que tu peux utiliser pour affronter tes amis ou échanger !</p>
              </div>

              <div class="box" class="box">
                 <i class="fas fa-credit-card"></i>
                 <h3>Collectionne des cartes exclusives</h3>
                 <p>Collectionne des cartes de Pokémon rares et légendaires disponibles uniquement sur notre plateforme. Fais évoluer ta collection à ton rythme et atteins des niveaux de collection exceptionnels !</p>
              </div>

              <div class="box" class="box">
                 <i class="fas fa-desktop"></i>
                 <h3>Interface intuitive et facile à utiliser</h3>
                 <p>Notre plateforme est simple à prendre en main, même pour les débutants. Ouvre, collectionne, échange et combats en toute facilité !</p>
              </div>

           </div>

        </section>

  <!-- Fin section activity -->

  <!-- Début section cards -->

  <section class="cards" id="cards">
    <h1 class="heading">Cartes en vedette</h1>
    <p>Cliquez sur une carte pour la voir de plus près</p>

    <div class="card-row">

      <div class="card-container">
        <img src="<?php echo htmlspecialchars(getCard('sv9-182')['image']); ?>" alt="VolcanionEX" class="card" onclick="openModal('<?php echo htmlspecialchars(getCard('sv9-182')['image']); ?>')" alt="VolcanionEX">
        <button class="zoom-button" onclick="openModal('<?php echo htmlspecialchars(getCard('sv9-182')['image']); ?>')">
          <i class="fas fa-search"></i>
        </button>
      </div>
      <div class="card-container">
        <img src="<?php echo htmlspecialchars(getCard('sv9-189')['image']); ?>" alt="N's Zoroark" class="card" onclick="openModal('<?php echo htmlspecialchars(getCard('sv9-189')['image']); ?>')" alt="N's Zoroark">
        <button class="zoom-button" onclick="openModal('<?php echo htmlspecialchars(getCard('sv9-189')['image']); ?>')">
          <i class="fas fa-search"></i>
        </button>
      </div>
      <div class="card-container">
        <img src="<?php echo htmlspecialchars(getCard('sv9-164')['image']); ?>" alt="Lili Ribombee" class="card" onclick="openModal('<?php echo htmlspecialchars(getCard('sv9-164')['image']); ?>')" alt="Lili Ribombee">
        <button class="zoom-button" onclick="openModal('<?php echo htmlspecialchars(getCard('sv9-164')['image']); ?>')">
          <i class="fas fa-search"></i>
        </button>
      </div>
      <div class="card-container">
        <img src="<?php echo htmlspecialchars(getCard('sv9-180')['image']); ?>" alt="Iris Fighting Spirit" class="card" onclick="openModal('<?php echo htmlspecialchars(getCard('sv9-180')['image']); ?>')" alt="Iris Fighting Spirit">
        <button class="zoom-button" onclick="openModal('<?php echo htmlspecialchars(getCard('sv9-180')['image']); ?>')">
          <i class="fas fa-search"></i>
        </button>
      </div>

    </div>

    <a href="php/morecards.php" class="btn">Voir plus de cartes</a>


    <div id="modal" class="modal">
      <span class="close" onclick="closeModal()">&times;</span>
      <img class="modal-content" id="modal-image">
    </div>
  </section>

  <!-- Fin section cards -->

  <!-- Début section team  -->

  <section class="review" id="review">

    <h1 class="heading">Avis utilisateurs</h1>

    <div class="box-container">

      <div class="box">
        <img src="images/gunderella.webp" class="user" alt="Gunderella profile picture">
        <h3>Elise</h3>
        <p>Attrapez les tous ! Toutes les cartes sont collectables sans dépenser d'argent ce qui est parfait si vous n'avez pas les moyens !</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
      </div>

      <div class="box">
        <img src="images/scrapss.webp" class="user" alt="Scrapss profile picture">
        <h3>Scrapss</h3>
        <p>Merci de nous faire retomber en enfance, c'est vraiment incroyable! J'ai toujours aimé collectionner les cartes Pokémon</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="far fa-star"></i>
        </div>

      </div>

      <div class="box">
        <img src="images/LA8.png" class="user" alt="LA8 profile picture">
        <h3>LA8</h3>
        <div class="stars">
          <p>J'aime beaucoup, étant un fan de Pokémon depuis petit, j'ai toujours aimé les jeux Pokémon et les cartes à collectionner!</p>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>

      </div>

    </div>

  </section>

  <!-- Fin section team -->

  <!-- Début section footer  -->

  <?php include 'php/footer.php'; ?>

  <!-- Fin section footer -->

  <!-- Link script js   -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="js/script.js"></script>

</body>
</html>
