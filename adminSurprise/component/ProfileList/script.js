let templateFile = await fetch("./component/ProfileList/template.html");
let template = await templateFile.text();
let templateFile2 = await fetch("./component/ProfileList/templateLi.html");
let template2 = await templateFile2.text();

let ProfileList = {};

ProfileList.formatOne = function(id, pseudo, avatar, age){
  let html = template2;
  html = html.replace("{{id}}", id);
  if (avatar != null) {
    html = html.replace("{{avatar}}", "../server/images/profiles/" +  avatar);
  }
  else{
    html = html.replace("{{avatar}}", "../server/images/profiles/default.png");
  }
  html = html.replaceAll("{{pseudo}}", pseudo);
  html = html.replace("{{age}}", age);
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