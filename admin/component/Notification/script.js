// Notification pour messages de succès ou d'erreur

let Notification = {};

Notification.show = function(message, type = "success") {
    // Créer un élément div
    let notification = document.createElement("div");
    // Lui donner une classe CSS selon le type (success ou error)
    notification.classList.add("notification",type);
    // Y mettre le message
    notification.innerHTML = `
        <svg class="notification__icon">
            <use href="#icon-${type == "success" ? "check" : "cross"}"/>
        </svg>
        <span class="notification__message">${message}</span>
    `;
    // L'ajouter au DOM
    document.body.appendChild(notification);
    // Le supprimer après 3 secondes
    setTimeout(() => {
        document.body.removeChild(notification);
    }, 3000);
}

export {Notification};