let templateFile = await fetch("./component/ProfileList/template.html");
let template = await templateFile.text();
let templateFile2 = await fetch("./component/ProfileList/templateLi.html");
let template2 = await templateFile2.text();

let ProfileList = {};

ProfileList.formatOne = function(id, pseudo, avatar, age){
  let html = template2;
  let restriction = "";
  html = html.replace("{{id}}", id);
  html = html.replace("{{avatar}}", avatar);
  html = html.replace("{{pseudo}}", pseudo);
  html = html.replace("{{age}}", age);
  if (age == 0){
    restriction = "-10ans";
  }
  else if (age == 10){
    restriction = "10ans";
  }
  else if (age == 12){
    restriction = "12ans";
  }
  else if (age == 16){
    restriction = "16ans";
  }
  else if (age == 18){
    restriction = "18ans";
  }
  html = html.replace("{{restriction}}", restriction);
  return html;
}

ProfileList.format = function (profile) {
  let html = template;
  let liste = "";
  for (let p of profile){
    liste += ProfileList.formatOne(p.id_profile, p.pseudo, p.avatar, p.min_age);
  };
  html = html.replace("{{profile_liste}}", liste);
  return html;
}

export {ProfileList};