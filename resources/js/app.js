import "./bootstrap";
import { formatWineTitle } from "./formatWineTitles";
import { showModale } from "./modale";
import { filterWineCards } from "./search";
function init() {
    window.onload = function () {
        const deleteButton = document.querySelector('[data-action="delete"]');
        if (deleteButton) {
            deleteButton.addEventListener("click", function () {
                showModale();
            });
        }
    };

    document.querySelectorAll("h2").forEach((title) => {
        title.textContent = formatWineTitle(title.textContent);
    });

    const hamMenu = document.querySelector(".ham-menu");
    const offScreenMenu = document.querySelector(".off-screen-menu");

    hamMenu.addEventListener("click", () => {
        hamMenu.classList.toggle("active");
        offScreenMenu.classList.toggle("active");
    });

    // Les Fonctions de la modale pour la barre de recherche 

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
    });
    // Fonction pour fermer la modale en appuyant sur la touche "Entrée"
    // TODO: Ne fonctionne pas, à régler plus tard 	
   /*  closePopup.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            popupIcon.classList.toggle("active");
            popup.classList.toggle("active");
        }
    }); */

    // FIN DES FONCTIONS DE LA MODALE POUR LA BARRE DE RECHERCHE


    // Fonction pour filtrer les cartes de vin en fonction de la recherche
    const searchInput = document.querySelector("#search");
    searchInput.addEventListener("input", (e) => {
        filterWineCards(e.target.value.toLowerCase());
    });
    // FIN DE LA FONCTION POUR FILTRER LES CARDES DE VIN EN FONCTION DE LA RECHERCHE
}

init(); 
