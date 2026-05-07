import {Search} from "../Search/script.js";

let templateFile = await fetch('./component/MovieFeaturedForm/template.html');
let template = await templateFile.text();
let templateFile2 = await fetch('./component/MovieFeaturedForm/templateMovie.html');
let template2 = await templateFile2.text();

let MovieFeaturedForm = {};

MovieFeaturedForm.formatMovie = function(id, title, img, categorie, statut){
    let html= template2;
    html = html.replace("{{id}}", id);
    html = html.replace('{{img}}', "../server/images/" + img);
    html = html.replace('{{film_titre}}', title);
    html = html.replace('{{categorie}}', categorie);
    html = html.replace('{{statut}}', statut);
    return html
}

MovieFeaturedForm.format = function(id, title, img, categorie, statut, handlerModifier, handlerAnnuler) {
    let html= template;
    html = html.replace('{{search}}', Search.format());
    if (id != null && id != undefined) {
        if (statut == 0){
            html = html.replace('{{statut}}', "Pas mis en avant");
            html = html.replace('{{movie}}', MovieFeaturedForm.formatMovie(id, title, img, categorie, statut));
        }
        else{
            html = html.replace('{{statut}}', "Mis en avant");
            html = html.replace('{{movie}}', MovieFeaturedForm.formatMovie(id, title, img, categorie, statut));
        }
        html = html.replaceAll("{{id}}", id);
    }
    else {
        html = html.replace('{{movie}}', "");
    }
    
    html = html.replace('{{handlerModifier}}', handlerModifier);
    html = html.replace('{{handlerAnnuler}}', handlerAnnuler);
    return html;
}

export {MovieFeaturedForm};