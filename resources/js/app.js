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

    const hamMenu = document.querySelector(".ham-menu");
    const offScreenMenu = document.querySelector(".off-screen-menu");

    hamMenu.addEventListener("click", () => {
        hamMenu.classList.toggle("active");
        offScreenMenu.classList.toggle("active");
    });
}

init(); 
