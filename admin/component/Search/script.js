let templateFile = await fetch("./component/Search/template.html");
let template = await templateFile.text();
let templateFile2 = await fetch("./component/Search/templateLi.html");
let template2 = await templateFile2.text();

let Search = {};

Search.formatOne = function(id, name, image) {
    let html = template2;
    html = html.replace("{{id}}", id);
    html = html.replace('{{film_titre}}', name);
    html = html.replace("{{img}}", "../server/images/" + image);
    return html;
};

Search.formatResults = function (movies) {
  let list_movies = "";
  for (let movie of movies) {
    list_movies += Search.formatOne(movie.id_movie, movie.name, movie.image);
  }
  return list_movies;
};

Search.format = function() {
  return template;
};

export {Search};