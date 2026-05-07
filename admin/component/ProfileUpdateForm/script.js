let templateFile = await fetch('./component/ProfileUpdateForm/template.html');
let template = await templateFile.text();

let ProfileUpdateForm = {};

ProfileUpdateForm.format = function(id, pseudo, avatar, age, handlerModifier, handlerAnnuler) {
    let html = template;
    html = html.replace("{{id}}", id);
    html = html.replace("{{pseudo}}", pseudo);
    html = html.replace("{{avatar}}", avatar);
    if (age == 0){
        html = html.replace("{{selected_0}}", "selected");
        html = html.replace("{{selected_10}}", "");
        html = html.replace("{{selected_12}}", "");
        html = html.replace("{{selected_16}}", "");
        html = html.replace("{{selected_18}}", "");
    }
    else if (age == 10){
        html = html.replace("{{selected_0}}", "");
        html = html.replace("{{selected_10}}", "selected");
        html = html.replace("{{selected_12}}", "");
        html = html.replace("{{selected_16}}", "");
        html = html.replace("{{selected_18}}", "");
    }
    else if (age == 12){
        html = html.replace("{{selected_0}}", "");
        html = html.replace("{{selected_10}}", "");
        html = html.replace("{{selected_12}}", "selected");
        html = html.replace("{{selected_16}}", "");
        html = html.replace("{{selected_18}}", "");
    }
    else if (age == 16){
        html = html.replace("{{selected_0}}", "");
        html = html.replace("{{selected_10}}", "");
        html = html.replace("{{selected_12}}", "");
        html = html.replace("{{selected_16}}", "selected");
        html = html.replace("{{selected_18}}", "");
    }
    else if (age == 18){
        html = html.replace("{{selected_0}}", "");
        html = html.replace("{{selected_10}}", "");
        html = html.replace("{{selected_12}}", "");
        html = html.replace("{{selected_16}}", "");
        html = html.replace("{{selected_18}}", "selected");
    }
    html = html.replace("{{handlerModifier}}", handlerModifier);
    html = html.replace("{{handlerAnnuler}}", handlerAnnuler);
    return html;
}

export {ProfileUpdateForm};