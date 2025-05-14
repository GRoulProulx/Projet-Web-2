import "./bootstrap";
import { formatWineTitle } from "./formatWineTitles";
import { showModale } from "./modale";

function init() {
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
                localStorage.setItem("cellarId", cellarId);
            }
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
    const cellarIdInStorage = localStorage.getItem("cellarId");

    if (cellarIdInStorage) {
        const option = selectCellar.querySelector(
            `option[value="${cellarIdInStorage}"]`
        );

        if (option) {
            option.selected = true;
        }
    }
}

init(); 
