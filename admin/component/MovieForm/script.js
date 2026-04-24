let templateFile = await fetch('./component/MovieForm/template.html');
let template = await templateFile.text();
let templateFile2 = await fetch('./component/MovieForm/templateLiCategorie.html');
let template2 = await templateFile2.text();
let templateFile3 = await fetch('./component/MovieForm/templateLiAge.html');
let template3 = await templateFile3.text();

let NewMovieForm = {};

NewMovieForm.formatCategorie = function(id, categorie){
    let html= template2;
    html = html.replace('{{id}}', id);
    html = html.replace('{{categorie}}', categorie);
    return html;
}

NewMovieForm.formatAge = function(id, age){
    let html= template3;
    html = html.replace('{{id}}', id);
    html = html.replace('{{age}}', age);
    return html;
}

NewMovieForm.format = function(categorie, age, handler){
    let html= template;
    let listeCategorie = '';
    for (let cat in categorie) {
        listeCategorie += NewMovieForm.formatCategorie(cat.category);
    }
    html = html.replace('{{categorie__liste}}', listeCategorie);
    let listeAge = '';
    for (let a in age) {
        listeAge += NewMovieForm.formatAge(a.min_age);
    }
    html = html.replace('{{age__liste}}', listeAge);
    html = html.replace('{{handler}}', handler);
    return html;
}
    
export {NewMovieForm};