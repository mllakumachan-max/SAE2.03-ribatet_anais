let templateFile = await fetch("./component/Search/template.html");
let template = await templateFile.text();
let templateFile2 = await fetch("./component/Search/templateLi.html");
let template2 = await templateFile2.text();

let Search = {};

Search.formatOne = function(id, name, image, category, statut) {
    let html = template2;
    html = html.replaceAll("{{id}}", id);
    html = html.replaceAll('{{titre}}', name);
    html = html.replaceAll("{{img}}", "../server/images/" + image);
    html = html.replace("{{category}}", category);
    html = html.replace("{{statut}}", statut);
    return html;
};

Search.formatResults = function (movies) {
  let list_movies = "";
  for (let movie of movies) {
    list_movies += Search.formatOne(movie.id_movie, movie.name, movie.image, movie.category_name, movie.featured);
  }
  return list_movies;
};

Search.format = function() {
  return template;
};

export {Search};