let templateFile = await fetch("./component/Stats/template.html");
let template = await templateFile.text();

let Stats = {};

Stats.format = function(data) {
    let html = template;
    html = html.replace("{{total_profiles}}", data.total_profiles.total);
    html = html.replace("{{total_movies}}", data.total_movies.total);
    // ?? => Si la valeur à gauche de ?? est null ou undefined, alors on prend la valeur à droite
    html = html.replace("{{avg_favorites}}", data.avg_favorites.avg ?? "0");
    // ?. => Permet d'accéder à une propriété d'un objet sans risquer une erreur si l'objet est null ou undefined
    html = html.replace("{{most_favorited_movie}}", data.most_favorited_movie?.name ?? "Aucun");
    html = html.replace("{{most_popular_category}}", data.most_popular_category?.name ?? "Aucune");
    return html;
};

export {Stats};