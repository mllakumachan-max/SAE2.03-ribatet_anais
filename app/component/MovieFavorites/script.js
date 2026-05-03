let templateFile = await fetch("./component/MovieFavorites/template.html");
let template = await templateFile.text();
import {Movie} from "../Movie/script.js";

let MovieFavorites = {};

MovieFavorites.format = function(movies) {
    let html = template;
    html = html.replace("{{movies__list}}", Movie.format(movies));
    return html;
};

export {MovieFavorites};