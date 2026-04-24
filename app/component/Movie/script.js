let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();
let templateFile2 = await fetch("./component/Movie/templateLi.html");
let template2 = await templateFile2.text();

let Movie = {};

Movie.formatOne = function(id, name, image) {
    let html = template2;
    html = html.replace("{{id}}", id);
    html = html.replace('{{film_titre}}', name);
    html = html.replace("{{img}}", "../server/images/" + image);
    return html;
};

Movie.format = function(movie) {
    let html = template;
    let liste = "";
    for (let film of movie){
        liste += Movie.formatOne(film.id, film.name, film.image);
    };
    html = html.replace("{{movies}}", liste);
    return html;
};

export {Movie};