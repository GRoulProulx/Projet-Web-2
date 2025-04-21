/**
 * Fonction pour formater les titres de vin en ajoutant des espaces autour des barres obliques.
 * @param {string} text - Le titre du vin à formater.
 * @returns {string} - Le titre formaté avec des espaces autour des barres obliques.
 */
export function formatWineTitle(text) {
    return text.replace(/\//g, " / ");
}
