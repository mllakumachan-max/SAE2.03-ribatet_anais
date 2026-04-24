let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

MovieDetail.format = function(movie) {
    let html = template;
    html = html.replace("{{id}}", movie.id);
    html = html.replace('{{titre}}', movie.name);
    html = html.replace("{{img}}", "../server/images/" + movie.image);
    html = html.replace("{{realisateur}}", movie.director);
    html = html.replace("{{categorie}}", movie.id_category);
    html = html.replace("{{date}}", movie.year);
    html = html.replace("{{duree}}", movie.length);
    html = html.replace("{{age}}", movie.min_age);
    html = html.replace("{{lien}}", movie.trailer);
    html = html.replace("{{desc}}", movie.description);
    return html;
};

export {MovieDetail};