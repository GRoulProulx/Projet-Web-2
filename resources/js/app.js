import "./bootstrap";
import { formatWineTitle } from "./formatWineTitles";
import { showModale } from "./modale";

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
}

init(); 
