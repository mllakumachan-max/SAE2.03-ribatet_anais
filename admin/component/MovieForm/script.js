let templateFile = await fetch('./component/MovieForm/template.html');
let template = await templateFile.text();
let templateFile2 = await fetch('./component/MovieForm/templateLiCategorie.html');
let template2 = await templateFile2.text();

let NewMovieForm = {};

NewMovieForm.formatCategorie = function(id, categorie){
    let html= template2;
    html = html.replace('{{id}}', id);
    html = html.replace('{{categorie}}', categorie);
    return html;
}

NewMovieForm.format = function(categorie, handler){
    let html= template;
    let liste = '';
    for (let i = 0; i < categorie.length; i++) {
        liste += NewMovieForm.formatCategorie(categorie[i].id, categorie[i].name);
    }
    html = html.replace('{{categorie__liste}}', liste);
    html = html.replace('{{handler}}', handler);
    return html;
}

export {NewMovieForm};