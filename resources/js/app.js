import "./bootstrap";
import { formatWineTitle } from "./formatWineTitles";
import { afficherModale } from "./modale";

function init() {
    const deleteButton = document.querySelector('[data-action="delete"]');
    
    document.querySelectorAll("h2").forEach((title) => {
        title.textContent = formatWineTitle(title.textContent);
    });

    deleteButton.addEventListener("click", function () {
        afficherModale();
    });
}

init();
