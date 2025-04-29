// Sélection des éléments du DOM pour interagir avec la page
let menuBtn = document.querySelector('#menu-btn'); // Bouton hamburger pour afficher/masquer la navigation
let navbar = document.querySelector('.header .navbar'); // Menu de navigation
let modal = document.querySelector('#modal'); // Modal pour afficher les images en grand
let modalImage = document.querySelector('#modal-image'); // Image à afficher dans le modal
let loginModal = document.querySelector('#login-modal'); // Modal de connexion
let musicBtn = document.querySelector('#music-btn'); // Bouton de musique

// Fonction pour activer/désactiver la navigation mobile (hamburger menu)
menuBtn.onclick = () =>{
   menuBtn.classList.toggle('fa-times'); // Ajoute ou enlève l'icône "fa-times" pour le menu mobile
   navbar.classList.toggle('active'); // Affiche ou cache le menu de navigation
};

// Événement pour contrôler la musique via le bouton
musicBtn.addEventListener("click", () => {
    // Si la musique est en pause, on la lance, sinon on la met en pause
    if (son1.paused) {
        son1.play(); // Lecture de la musique
    }
    else {
        son1.pause(); // Pause de la musique
    }
});

// Fonction pour ouvrir ou fermer la modal de connexion
function toggleLoginModal() {
  if (loginModal.style.display === 'block') {
    loginModal.style.display = 'none'; // Ferme la modal si elle est déjà ouverte
  } else {
    loginModal.style.display = 'block'; // Ouvre la modal si elle est fermée
  }
}

// Fermeture des modals lorsque l'utilisateur clique en dehors d'elles
window.onclick = function (event) {
  if (event.target === loginModal) {
    loginModal.style.display = 'none';
  }
  if (event.target === signupModal) {
    signupModal.style.display = 'none';
  }
  if (event.target === modal) {
    modal.style.display = "none";
  }
};

let signupModal = document.querySelector('#signup-modal');

// Fonction pour ouvrir/fermer la modal Créer un compte
function toggleSignupModal() {
  if (signupModal.style.display === 'block') {
    signupModal.style.display = 'none';
  } else {
    signupModal.style.display = 'block';
  }
}

// Switch du login vers signup
function switchToSignup() {
  loginModal.style.display = 'none';
  signupModal.style.display = 'block';
}

// Switch du signup vers login
function switchToLogin() {
  signupModal.style.display = 'none';
  loginModal.style.display = 'block';
}

// Fonction pour activer/désactiver le mode sombre
function darkMode() {
    var element = document.body; // Sélectionne l'élément body
    element.classList.toggle("dark-mode"); // Ajoute ou enlève la classe dark-mode pour activer/désactiver le mode sombre
}

// Fonction qui gère le comportement du menu lors du scroll
window.onscroll = () =>{
   // Lorsque l'utilisateur scroll, on ferme le menu mobile et les modals
   menuBtn.classList.remove('fa-times');
   navbar.classList.remove('active');
   loginModal.style.display = 'none';
   signupModal.style.display = 'none';
   modal.style.display = "none";

   // Si le scroll dépasse 650px, on affiche la navigation en haut de la page
   if(window.scrollY > 650){
      document.querySelector('.header').classList.add('active');
   }else{
      document.querySelector('.header').classList.remove('active');
   };
};

// Fonction pour ouvrir une modal avec une image en grand
function openModal(imageSrc) {
    modalImage.src = imageSrc;  // On affecte la source de l'image à afficher dans la modal
    modal.style.display = "flex";  // Affiche la modal
}

// Fonction pour fermer la modal d'image
function closeModal() {
    modal.style.display = "none";  // Cache la modal
}

// Variables pour gérer la pagination et les filtres de cartes
let currentPage = 1;
let currentFilter = 'all';

// Fonction asynchrone pour filtrer les cartes selon une catégorie et une page
async function filterCards(category, page = 1) {
    currentFilter = category; // Met à jour le filtre actuel
    currentPage = page; // Met à jour la page actuelle

    const buttons = document.querySelectorAll('.buttons button'); // Récupère tous les boutons de filtre

    try {
        // Effectue un appel AJAX pour récupérer les cartes filtrées
        const response = await fetch(`../php/displaycards.php?filter=${category}&page=${page}`);
        if (!response.ok) throw new Error("Erreur lors de la recherche"); // Si la requête échoue, on lance une erreur

        const html = await response.text(); // Récupère le HTML des cartes filtrées
        document.getElementById("card-container").innerHTML = html; // Affiche les cartes filtrées
        document.getElementById("page-number").textContent = currentPage; // Met à jour le numéro de la page

        // Applique un événement de clic à chaque carte pour ouvrir la modal de l'image
        const cards = document.querySelectorAll('.card img');
        cards.forEach(card => {
            card.onclick = function () {
                openModal(card.src); // Affiche l'image en grand dans la modal
            }
        });

        // Mise à jour de l'apparence des boutons de filtre pour indiquer lequel est actif
        buttons.forEach(button => {
            button.classList.remove('active');
        });
        const activeButton = document.querySelector(`button[onclick="filterCards('${category}')"]`);
        if (activeButton) activeButton.classList.add('active');

    } catch (error) {
        console.error("Erreur lors du filtrage des cartes:", error); // Si une erreur survient, on la loggue
    }
}

// Fonction pour changer de page dans les filtres de cartes
function changePage(offset) {
    if (currentPage + offset <= 0) return; // Ne permet pas d'aller à une page avant la première
    filterCards(currentFilter, currentPage + offset); // Charge la page suivante/précédente
}

// Initialisation du Swiper (carrousel) pour les cartes
var swiper = new Swiper(".mySwiper", {
  effect: "flip", // Effet de flip lors du changement de slide
  grabCursor: true, // Permet de saisir et glisser les slides
  pagination: {
    el: ".swiper-pagination", // Pagination pour naviguer entre les slides
  },
  navigation: {
    nextEl: ".swiper-button-next", // Bouton pour passer au slide suivant
    prevEl: ".swiper-button-prev", // Bouton pour revenir au slide précédent
  },
  autoplay: {
    delay: 2000, // Intervalle de 2 secondes entre chaque slide
    disableOnInteraction: false, // L'autoplay ne s'arrête pas après une interaction
  },
  loop: true, // Permet de revenir au premier slide après le dernier
  on: {
    slideChange: function () {
      // Récupère le nom de la carte du slide actif et l'affiche
      const activeSlide = this.slides[this.activeIndex];
      const cardName = activeSlide.getAttribute('data-name');
      document.getElementById('card-name').textContent = cardName;
    },
  },
});

// Gère la soumission du formulaire de connexion
document.querySelector('#login-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêche la page de recharger

    // Récupère les valeurs des inputs
    const username = this.querySelector('input[name="username"]').value.trim();
    const password = this.querySelector('input[name="password"]').value.trim();

    // Petit check rapide : pas de champ vide
    if (!username || !password) {
        alert("Tous les champs doivent être remplis.");
        return;
    }

    // Prépare les données à envoyer
    const formData = new FormData();
    formData.append("username", username);
    formData.append("password", password);

    // Envoie la requête POST vers le serveur PHP
    fetch('php/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Attend une réponse JSON
    .then(data => {
        if (data.success) {
            // Connexion réussie, on recharge la page ou redirige
            window.location.reload();
        } else {
            // Affiche le message d’erreur renvoyé par le serveur
            alert(data.message);
        }
    })
    .catch(error => {
        // Si le serveur crash ou pb connexion
        console.error('Erreur lors de la connexion:', error);
        alert('Une erreur est survenue.');
    });
});

// Gère la soumission du formulaire d’inscription
document.querySelector('#signup-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêche la page de recharger

    // Récupère toutes les données du formulaire
    const formData = new FormData(this);

    // Vérifie côté client si les mots de passe matchent
    const password = formData.get("new-password");
    const confirmPassword = formData.get("confirm-password");

    if (password !== confirmPassword) {
        alert("Les mots de passe ne correspondent pas.");
        return;
    }

    // Envoie des données vers register.php
    fetch('php/register.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json()) // Réponse attendue : JSON
    .then(data => {
        if (data.success) {
            // Inscription réussie, on ferme la modal d’inscription et on ouvre celle de login
            alert("Inscription réussie !");
            signupModal.style.display = 'none';
            loginModal.style.display = 'block';
        } else {
            // Affiche le message d’erreur envoyé par PHP
            alert(data.message);
        }
    })
    .catch(error => {
        // Si le serveur crash ou pb connexion
        console.error('Erreur lors de l’inscription:', error);
        alert('Une erreur est survenue.');
    });
});
