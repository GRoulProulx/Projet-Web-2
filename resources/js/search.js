/**
 * Fonction pour effacer le contenu de la barre de recherche
 */
export function inputDeleteContent(){
    const form = document.querySelector('.searchForm');
    const input = form.querySelector('#search');
    if(window.location.pathname !== '/bottles/search') {
        input.value = '';
    }
}
