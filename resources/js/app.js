import "./bootstrap";
import { formatWineTitle } from "./formatWineTitles";
import { showModale } from "./modale";

function init() {
    const deleteButton = document.querySelector('[data-action="delete"]');
    
    document.querySelectorAll("h2").forEach((title) => {
        title.textContent = formatWineTitle(title.textContent);
    });

    deleteButton.addEventListener("click", function () {
        showModale();
    });
}

init();
