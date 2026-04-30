let templateFile = await fetch("./component/Profile/template.html");
let template = await templateFile.text();
let templateFile2 = await fetch("./component/Profile/templateLi.html");
let template2 = await templateFile2.text();

let Profile = {};

Profile.formatOne = function(id, pseudo, avatar, age){
  let html = template2;
  let className = "";
  let restriction = "";
  html = html.replace("{{id}}", id);
  html = html.replace("{{age}}", age);
  html = html.replace("{{avatar}}", avatar);
  html = html.replace("{{pseudo}}", pseudo);

  if (age == 0){
    restriction = "-10ans";
    className = "moins_10";
  }
  else if (age == 10){
    restriction = "10ans";
    className = "dix_ans";
  }
  else if (age == 12){
    restriction = "12ans";
    className = "douze_ans";
  }
  else if (age == 16){
    restriction = "16ans";
    className = "seize_ans";
  }
  else if (age == 18){
    restriction = "18ans";
    className = "dix_huit_ans";
  }
  html = html.replace("{{restriction}}", restriction);
  html = html.replace("{{labelClass}}", className);
  return html;
}

Profile.format = function (hChargeMovies, profile) {
  let html = template;
  let liste = "";
  for (let p of profile){
    liste += Profile.formatOne(p.id_profile, p.pseudo, p.avatar, p.min_age);
  };
  html = html.replace("{{profile_liste}}", liste);
  html = html.replace("{{hChargeMovies}}", hChargeMovies);
  return html;
}

export {Profile};