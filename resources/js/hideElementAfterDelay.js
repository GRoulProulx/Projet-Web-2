/**
 * Fonction pour masquer un élément HTML après un délai
 * @param {HTMLElement} element - L'élément HTML à masquer
 */
export function hideElementAfterDelay(element) {    
    setTimeout(() => {
        element.classList.add("hidden");
    }, 10000); 
}