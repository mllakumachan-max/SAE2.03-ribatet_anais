let templateFile = await fetch('./component/MovieFeaturedForm/template.html');
let template = await templateFile.text();
import {Search} from "../Search/script.js";

let MovieFeaturedForm = {};

MovieFeaturedForm.format = function(id, title, img, statut, handlerModifier, handlerAnnuler) {
    let html= template;
    html = html.replace('{{search}}', Search.format());
    html = html.replaceAll("{{id}}", id);
    html = html.replace('{{img}}', img);
    html = html.replace('{{film_titre}}', title);
    if (statut == 0){
        html = html.replace('{{statut}}', "Pas mis en avant");
    }
    else{
        html = html.replace('{{statut}}', "Mis en avant");
    }
    html = html.replace('{{handlerModifier}}', handlerModifier);
    html = html.replace('{{handlerAnnuler}}', handlerAnnuler);
    return html;
}

export {MovieFeaturedForm};