import "./bootstrap";
import { formatWineTitle } from "./formatWineTitles";
import { showModale } from "./modale";
import { filterWineCards } from "./search";
import { hideElementAfterDelay } from "./hideElementAfterDelay";

/**
 * Initialisation générale de l’application
 */
function init() {
    const main = document.querySelector("main");
    const hamMenu = document.querySelector(".ham-menu");
    const offScreenMenu = document.querySelector(".off-screen-menu");

    onWindowLoad(main);
    formatWineTitles();
    setupHamburgerMenu(hamMenu, offScreenMenu);
    setupCellarSelection();
    setupSearch();
}

/**
 * Enregistre les actions à exécuter au chargement complet de la page
 */
function onWindowLoad(main) {
    window.addEventListener("load", () => {
        setupDeleteConfirmation();
        saveCellarIdToSession();
        handleSuccessMessage(main);
        setupUserDeleteConfirmation();
    });
}

/**
 * Active le bouton de suppression pour afficher la modale de confirmation
 */
function setupDeleteConfirmation() {
    const deleteButton = document.querySelector('[data-action="delete"]');
    if (deleteButton) {
        deleteButton.addEventListener("click", showModale);
    }    
}

/**
 * Active la boite modale de confirmation pour la suppression d’un utilisateur dans le tableau de bord administrateur 
 */
function setupUserDeleteConfirmation() {
    const deleteButtons = document.querySelectorAll(
        '[data-action="deleteUser"]'
    );
    const form = document.getElementById("deleteUserForm");
    const userNameSpan = document.getElementById("modalUserName");

    deleteButtons.forEach((btn) => {
        btn.addEventListener("click", function (event) {
            showModale();
            const userId = this.getAttribute("data-id");            
            const userName = this.getAttribute("data-name");            
            form.action = "/users/" + userId;
            
            if (userNameSpan) {
                userNameSpan.textContent = userName;
            }
        });
    });
}

/**
 * Sauvegarde l’ID du cellier dans la session (durée : 15 minutes)
 */
function saveCellarIdToSession() {
    const myCellar = document.querySelector(".my_cellar");
    if (!myCellar) return;

    const cellarId = myCellar.querySelector("#cellar_id")?.value;
    if (cellarId) {
        sessionStorage.setItem("cellarId", cellarId);

        // Suppression après 15 minutes
        setTimeout(() => {
            sessionStorage.removeItem("cellarId");
        }, 900_000);
    }
}

/**
 * Masque le message de succès après un délai prédéfini
 */
function handleSuccessMessage(main) {
    const successMessage = main.querySelector(".success-message");
    if (successMessage) hideElementAfterDelay(successMessage);
}

/**
 * Formate tous les titres de vins <h2> grâce à la fonction utilitaire
 */
function formatWineTitles() {
    document.querySelectorAll("h2").forEach((title) => {
        title.textContent = formatWineTitle(title.textContent);
    });
}

/**
 * Configure l’interaction du menu hamburger
 */
function setupHamburgerMenu(hamMenu, offScreenMenu) {
    hamMenu.addEventListener("click", () => {
        hamMenu.classList.toggle("active");
        offScreenMenu.classList.toggle("active");
    });
}

/**
 * Sélection automatique du cellier dans le formulaire d’ajout de bouteille
 */
function setupCellarSelection() {
    const selectCellar = document.querySelector("#select_name_cellar");
    if (!selectCellar) return;

    const cellarIdInStorage = sessionStorage.getItem("cellarId");
    if (cellarIdInStorage) {
        const option = selectCellar.querySelector(
            `option[value="${cellarIdInStorage}"]`
        );
        if (option) option.selected = true;
    }
}

/**
 * Initialise la recherche (modale + filtre en temps réel)
 */
function setupSearch() {
    setupSearchModal();
    setupSearchFilter();
}

/**
 * Gère l’ouverture/fermeture de la modale de recherche
 */
function setupSearchModal() {
    const searchInput = document.querySelector("#search");
    const closePopup = document.querySelector(".close-popup");
    const popup = document.querySelector(".popup");
    const popupIcon = document.querySelector(".popupIcon");

    if (!searchInput || !closePopup || !popup || !popupIcon) return;

    // Petite fonction utilitaire pour (dé)plier la modale
    const togglePopup = () => {
        popupIcon.classList.toggle("active");
        popup.classList.toggle("active");
    };

    popupIcon.addEventListener("click", togglePopup);
    closePopup.addEventListener("click", () => {
        togglePopup();
        searchInput.value = "";
    });

    // Fermeture de la modale avec la touche Entrée
    searchInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            togglePopup();
            searchInput.value = "";
        }
    });
}

/**
 * Applique le filtre de recherche sur les cartes de vin
 */
function setupSearchFilter() {
    const searchInput = document.querySelector("#search");
    if (!searchInput) return;

    searchInput.addEventListener("input", (e) => {
        filterWineCards(e.target.value.toLowerCase());
    });
}

init();
