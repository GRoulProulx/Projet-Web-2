import "./bootstrap";
import { formatWineTitle } from "./formatWineTitles";
import { showModale } from "./modale";
import { filterWineCards } from "./search";
import { hideElementAfterDelay } from "./hideElementAfterDelay";

function init() {
    const main = document.querySelector("main");
    const hamMenu = document.querySelector(".ham-menu");
    const offScreenMenu = document.querySelector(".off-screen-menu");

    // Afficher la modale de confirmation de suppression
    window.onload = function () {
        const deleteButton = document.querySelector('[data-action="delete"]');
        if (deleteButton) {
            deleteButton.addEventListener("click", function () {
                showModale();
            });
        }
        // Vérifier si on peut récupérer le nom du cellier
        const myCellar = document.querySelector(".my_cellar");
        if (myCellar) {
            const cellarId = myCellar.querySelector("#cellar_id").value;
            
            if (cellarId) {
                sessionStorage.setItem("cellarId", cellarId);
            }
            setTimeout(() => {
                sessionStorage.removeItem("cellarId");
            }, 900000); // 15 minutes
        }

        // Vérifier si un message de succès est présent et le masquer après un délai
        const successMessage = main.querySelector(".success-message");
        if (successMessage) {
            hideElementAfterDelay(successMessage);
        }
    };

    // Formater les titres de vin
    document.querySelectorAll("h2").forEach((title) => {
        title.textContent = formatWineTitle(title.textContent);
    });

    // Menu hamburger
    hamMenu.addEventListener("click", () => {
        hamMenu.classList.toggle("active");
        offScreenMenu.classList.toggle("active");
    });

    // Sélectionner le cellier dans le formulaire d'ajout de bouteille dans le catalogue des vins si on arrive de la vue cellar.show
    const formAddBottleInCellar = document.querySelector(".form_add_bottle");
    const selectCellar = formAddBottleInCellar.querySelector("#select_name_cellar");   
    // Vérifier si le nom du cellier est déjà dans le localStorage
    const cellarIdInStorage = sessionStorage.getItem("cellarId");

    if (cellarIdInStorage) {
        const option = selectCellar.querySelector(
            `option[value="${cellarIdInStorage}"]`
        );

        if (option) {
            option.selected = true;
        }
    }

    // Les Fonctions de la modale pour la barre de recherche 

    const closeSearch = document.querySelector("#search");
    const closePopup = document.querySelector(".close-popup");
    const popup = document.querySelector(".popup");
    const popupIcon = document.querySelector(".popupIcon");

    popupIcon.addEventListener("click", () => {
        popupIcon.classList.toggle("active");
        popup.classList.toggle("active");
    });
    closePopup.addEventListener("click", () => {
        popupIcon.classList.toggle("active");
        popup.classList.toggle("active");
        closeSearch.value = "";
    });
    // Fonction pour fermer la modale de la barre de recherche en appuyant sur la touche "Entrée"

    closeSearch.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            popupIcon.classList.toggle("active");
            popup.classList.toggle("active");
            closeSearch.value = "";
        }
    });

    // FIN DES FONCTIONS DE LA MODALE POUR LA BARRE DE RECHERCHE

    // Fonction pour filtrer les cartes de vin en fonction de la recherche
    const searchInput = document.querySelector("#search");
    searchInput.addEventListener("input", (e) => {
        filterWineCards(e.target.value.toLowerCase());
    });
    // FIN DE LA FONCTION POUR FILTRER LES CARTES DE VIN EN FONCTION DE LA RECHERCHE

}

init();
