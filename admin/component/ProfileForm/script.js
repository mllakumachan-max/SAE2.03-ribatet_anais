let templateFile = await fetch('./component/ProfileForm/template.html');
let template = await templateFile.text();

let NewProfileForm = {};

NewProfileForm.format = function(handlerAjouter, handlerAnnuler) {
    let html= template;
    html = html.replace('{{handlerAjouter}}', handlerAjouter);
    html = html.replace('{{handlerAnnuler}}', handlerAnnuler);
    return html;
}

export {NewProfileForm};