let templateFile = await fetch("./component/Profile/template.html");
let template = await templateFile.text();
let templateFile2 = await fetch("./component/Profile/templateLi.html");
let template2 = await templateFile2.text();

let Profile = {};

Profile.formatOne = function(id, pseudo, avatar, age){
  let html = template2;
  let className = "";
  html = html.replace("{{id}}", id);
  html = html.replace("{{avatar}}", avatar);
  html = html.replace("{{pseudo}}", pseudo);
  if (age != 0){
    html = html.replace("{{age}}", "-" + age);
    if (age == 10){
      className = "moins_10";
    }
    else if (age == 12){
      className = "moins_12";
    }
    else if (age == 16){
      className = "moins_16";
    }
    else if (age == 18){
      className = "moins_18";
    }
  }
  else {
    html = html.replace("{{age}}", "Tout public");
    className = "tout_public";
  }
  html = html.replace("{{labelClass}}", className);
  return html
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