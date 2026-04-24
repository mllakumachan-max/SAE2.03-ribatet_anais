let templateFile = await fetch('./component/MovieForm/template.html');
let template = await templateFile.text();


let NewMovieForm = {};

NewMovieForm.format = function(handler){
    let html= template;
    html = html.replace('{{handler}}', handler);
    return html;
}

export {NewMovieForm};