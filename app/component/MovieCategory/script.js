let templateFile = await fetch("./component/MovieCategory/template.html");
let template = await templateFile.text();
import {Movie} from "../Movie/script.js";

let MovieCategory = {};

MovieCategory.format = function(categoryName, movies) {
    let html = template;
    html = html.replace("{{categorie}}", categoryName);
    html = html.replace("{{movies__list}}", Movie.format(movies));
    return html;
};

export {MovieCategory};