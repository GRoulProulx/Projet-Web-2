import "./bootstrap";
import { formatWineTitle } from "./formatWineTitles";
import { showModale } from "./modale";
import { hideElementAfterDelay } from "./hideElementAfterDelay";
import { inputDeleteContent } from "./search";
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
}

/**
 * Enregistre les actions à exécuter au chargement complet de la page
 */
function onWindowLoad(main) {
    window.addEventListener("load", () => {
        setupDeleteConfirmation();
        saveCellarIdToSession();
        handleSuccessMessage(main);
        modaleDeleteConfirmation();
        inputDeleteContent();
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
 * Active la boite modale de confirmation pour la suppression d’un utilisateur dans le tableau de bord administrateur ou d’un item dans la liste d'achats
 */
function modaleDeleteConfirmation() {
    const deleteButtons = document.querySelectorAll(
        '[data-action="deleteButton"]'
    );
    const formUsers = document.getElementById("modaleFormUsers");
    const formShoppingList = document.getElementById("modaleFormShopopingList");
    const nameSpan = document.getElementById("modalName");

    deleteButtons.forEach((btn) => {
        btn.addEventListener("click", function () {
            showModale();
            if (formUsers) {
                const userId = this.getAttribute("data-id");
                const userName = this.getAttribute("data-name");
                formUsers.action = "/users/" + userId;

                if (nameSpan) {
                    nameSpan.textContent = userName;
                }
            }

            if (formShoppingList) {
                const itemId = this.getAttribute("data-id");
                const itemName = this.getAttribute("data-name");
                formShoppingList.action = "/shopping-list/" + itemId;

                if (nameSpan) {
                    nameSpan.textContent = itemName;
                }
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



init();
