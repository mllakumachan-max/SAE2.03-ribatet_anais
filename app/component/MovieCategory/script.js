import {Movie} from "../Movie/script.js";
let templateFile = await fetch("./component/MovieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function(categorie) {
    let html = template;
    html = html.replace('{{id}}', categorie.id);
    html = html.replace('{{categorie}}', categorie.name);
    html = html.replace("{{movies}}", Movie.format(categorie.movies));
    return html;
};

export {MovieCategory};