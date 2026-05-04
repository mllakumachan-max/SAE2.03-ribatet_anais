let templateFile = await fetch('./component/MovieFeaturedForm/template.html');
let template = await templateFile.text();

let MovieFeaturedForm = {};

MovieFeaturedForm.format = function(search, handlerModifier, handlerAnnuler) {
    let html= template;
    html = html.replace('{{search}}', search);
    html = html.replace('{{handlerModifier}}', handlerModifier);
    html = html.replace('{{handlerAnnuler}}', handlerAnnuler);
    return html;
}

export {MovieFeaturedForm};