let templateFile = await fetch("./component/MovieFeatured/template.html");
let template = await templateFile.text();
let templateFileLi = await fetch("./component/MovieFeatured/templateLi.html");
let templateLi = await templateFileLi.text();

let MovieFeatured = {};

MovieFeatured.formatOne = function(id, name, image, description) {
    let html = templateLi;
    html = html.replace("{{id}}", id);
    html = html.replace('{{film_titre}}', name);
    html = html.replace("{{img}}", "../server/images/" + image);
    html = html.replace("{{description}}", description);
    return html;
};

MovieFeatured.format = function(movies) {
    let html = template;
    let liste = "";
    for (let film of movies) {
        liste += MovieFeatured.formatOne(film.id_movie, film.name, film.image, film.description);
    }
    html = html.replace("{{movies}}", liste);
    return html;
};

export {MovieFeatured};