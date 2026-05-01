// Notification pour messages de succès

let Notification = {};

Notification.show = function(message, type = "success") {
    // Créer un élément div
    let notification = document.createElement("div");
    // Lui donner une classe CSS selon le type (success)
    notification.classList.add(type);
    // Y mettre le message
    notification.textContent = message;
    // L'ajouter au DOM
    document.body.appendChild(notification);
    // Le supprimer après 3 secondes
    setTimeout(() => {
        document.body.removeChild(notification);
    }, 3000);
}

export {Notification};