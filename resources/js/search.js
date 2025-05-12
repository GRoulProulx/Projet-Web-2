// Tout les éléments de recherche sont récupérés
function getWineDetails(card) {
    return {   
        name: card.querySelector("h2").textContent.toLowerCase(),
        type: card.querySelector("figcaption div p").textContent.toLowerCase(),
        country: card
            .querySelector("figcaption div p:last-child")
            .textContent.toLowerCase(),
    };
}

// Si la recherche correspond à un des détails du vin
function isWineMatch(wineDetails, searchText) {
    return (
        wineDetails.name.includes(searchText) ||
        wineDetails.type.includes(searchText) ||
        wineDetails.country.includes(searchText)
    );
}

// La visibilité des cartes de vin est modifiée en fonction de la recherche
function filterWineCards(searchText) {
    const wineCards = document.querySelectorAll(".grid > a");

    wineCards.forEach((card) => {
        const wineDetails = getWineDetails(card);
        card = isWineMatch(wineDetails, searchText)
            ? card.classList.remove("hidden")
            : card.classList.add("hidden");
    });
}

// exportation de la fonction filterWineCards

export { filterWineCards };


