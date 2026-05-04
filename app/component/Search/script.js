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

Search.format = function () {
  let html = template;
  html = html.replace("{{list_movies}}", "");
  return html;
};

export {Search};