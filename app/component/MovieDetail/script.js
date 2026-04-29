let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

MovieDetail.format = function(movie) {
    let html = template;
    html = html.replace("{{id_movie}}", movie.id_movie);
    html = html.replace("{{titre}}", movie.name);
    html = html.replace("{{img}}", "../server/images/" + movie.image);
    html = html.replace("{{realisateur}}", movie.director);
    html = html.replace("{{categorie}}", movie.category_name);
    html = html.replace("{{date}}", movie.year);
    html = html.replace("{{duree}}", movie.length);
    if (movie.min_age != 0){
        html = html.replace("{{age}}", "-" + movie.min_age + "ans");
    }
    else {
        html = html.replace("{{age}}", "Tout public");
    }
    html = html.replace("{{lien}}", movie.trailer);
    html = html.replace("{{desc}}", movie.description);
    return html;
};

export {MovieDetail};