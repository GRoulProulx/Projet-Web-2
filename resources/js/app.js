import "./bootstrap";

import { formatWineTitle } from "./formatWineTitles";

function init() {
    document.querySelectorAll("h2").forEach((title) => {
        title.textContent = formatWineTitle(title.textContent);
    });
}

init();
