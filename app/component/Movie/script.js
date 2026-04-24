let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let Movie = {};

Movie.format = function(movie) {
    let html = template;
    html = html.replace("{{id}}", movie.id);
    html = html.replace('{{film_titre}}', movie.name);
    html = html.replace("{{img}}", "../server/images/" + movie.image);
    return html;
};

Movie.formatMany = function(movies) {
    let html = "";
        for (let movie of movies){
            html += Movie.format(movie);
        };
    return html;
};

export {Movie};