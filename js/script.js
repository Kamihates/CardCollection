// Sélection des éléments du DOM pour interagir avec la page
let menuBtn = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');
let modal = document.querySelector('#modal');
let modalImage = document.querySelector('#modal-image');
let loginModal = document.querySelector('#login-modal');
let signupModal = document.querySelector('#signup-modal');
let profileModal = document.querySelector('#profile-modal');
let editModal = document.getElementById("edit-modal");
let musicBtn = document.querySelector('#music-btn');

// Fonction pour activer/désactiver la navigation mobile
menuBtn.onclick = () => {
    menuBtn.classList.toggle('fa-times');
    navbar.classList.toggle('active');
};

// Événement pour contrôler la musique via le bouton
musicBtn.addEventListener("click", () => {
    if (son1.paused) son1.play();
    else son1.pause();
});

// Fermeture des modals lorsque l'utilisateur clique en dehors d'elles
window.onclick = function (event) {
    if ([loginModal, signupModal, modal, profileModal, editModal].includes(event.target)) {
        event.target.style.display = 'none';
    }
};

// Fonctions pour ouvrir/fermer les modals
function toggleLoginModal() { loginModal.style.display = loginModal.style.display === 'block' ? 'none' : 'block'; }
function toggleSignupModal() { signupModal.style.display = signupModal.style.display === 'block' ? 'none' : 'block'; }
function toggleProfileModal() { profileModal.style.display = profileModal.style.display === 'block' ? 'none' : 'block'; }
function toggleEditModal() { editModal.style.display = editModal.style.display === 'block' ? 'none' : 'block'; }

function switchToSignup() {
    loginModal.style.display = 'none';
    signupModal.style.display = 'block';
}

function switchToLogin() {
    signupModal.style.display = 'none';
    loginModal.style.display = 'block';
}

// Fonction pour activer/désactiver le mode sombre
function darkMode() {
    document.body.classList.toggle("dark-mode");
}

// Fonction de scroll
window.onscroll = () => {
    menuBtn.classList.remove('fa-times');
    navbar.classList.remove('active');
    [loginModal, signupModal, profileModal, editModal, modal].forEach(m => m.style.display = 'none');

    if (window.scrollY > 650) document.querySelector('.header').classList.add('active');
    else document.querySelector('.header').classList.remove('active');
};

// Fonction pour ouvrir une modal avec une image
function openModal(imageSrc) {
    modalImage.src = imageSrc;
    modal.style.display = "flex";
}

// Fonction pour fermer la modal d'image
function closeModal() { modal.style.display = "none"; }

// Fonction pour gérer la déconnexion
function logoutUser() {
    profileModal.style.display = 'none';
    window.location.href = 'php/logout.php';
}

// Fonction pour supprimer le compte
function deleteAccount() {
    if (confirm("Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.")) {
        window.location.href = 'php/delete.php';
    }
}

// Variables pour la pagination
let currentPage = 1;
let currentFilter = 'all';

// Fonction asynchrone pour filtrer les cartes
async function filterCards(category, page = 1) {
    currentFilter = category;
    currentPage = page;

    const buttons = document.querySelectorAll('.buttons button');
    try {
        const response = await fetch(`../php/displaycards.php?filter=${category}&page=${page}`);
        if (!response.ok) throw new Error("Erreur lors de la recherche");

        const html = await response.text();
        document.getElementById("card-container").innerHTML = html;
        document.getElementById("page-number").textContent = currentPage;

        document.querySelectorAll('.card img').forEach(card => {
            card.onclick = function () { openModal(card.src); }
        });

        buttons.forEach(button => button.classList.remove('active'));
        const activeButton = document.querySelector(`button[onclick="filterCards('${category}')"]`);
        if (activeButton) activeButton.classList.add('active');
    } catch (error) {
        console.error("Erreur lors du filtrage des cartes:", error);
    }
}

// Fonction pour changer de page
function changePage(offset) {
    if (currentPage + offset <= 0) return;
    filterCards(currentFilter, currentPage + offset);
}

// Initialisation du Swiper pour les cartes
var swiper = new Swiper(".mySwiper", {
    effect: "flip",
    grabCursor: true,
    pagination: { el: ".swiper-pagination" },
    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    autoplay: { delay: 2000, disableOnInteraction: false },
    loop: true,
    on: {
        slideChange: function () {
            const activeSlide = this.slides[this.activeIndex];
            const cardName = activeSlide.getAttribute('data-name');
            document.getElementById('card-name').textContent = cardName;
        }
    }
});

// Soumission du formulaire de connexion
document.querySelector('#login-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const username = this.querySelector('input[name="username"]').value.trim();
    const password = this.querySelector('input[name="password"]').value.trim();

    if (!username || !password) {
        alert("Tous les champs doivent être remplis.");
        return;
    }

    const formData = new FormData();
    formData.append("username", username);
    formData.append("password", password);

    fetch('php/login.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) window.location.reload();
            else alert(data.message);
        })
        .catch(error => alert('Une erreur est survenue.'));
});

// Soumission du formulaire d’inscription
document.querySelector('#signup-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const password = formData.get("new-password");
    const confirmPassword = formData.get("confirm-password");

    if (password !== confirmPassword) {
        alert("Les mots de passe ne correspondent pas.");
        return;
    }

    fetch('php/register.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Inscription réussie !");
                signupModal.style.display = 'none';
                loginModal.style.display = 'block';
            } else {
                alert(data.message);
            }
        })
        .catch(error => alert('Une erreur est survenue.'));
});

// Soumission du formulaire de modification de profil
document.querySelector('#edit-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const newPassword = formData.get("edit-password");
    const confirmPassword = formData.get("confirm-edit-password");

    if (newPassword !== confirmPassword) {
        alert("Les mots de passe ne correspondent pas.");
        return;
    }

    fetch('php/profile.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Modifications enregistrées avec succès !");
                window.location.reload();
                editModal.style.display = 'none';
            } else {
                alert(data.message || "Une erreur est survenue lors de la modification.");
            }
        })
        .catch(error => alert('Erreur de connexion au serveur.'));
});
