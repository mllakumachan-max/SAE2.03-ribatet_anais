let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();
let templateFile2 = await fetch("./component/NavBar/templateLi.html");
let template2 = await templateFile2.text();

let NavBar = {};

NavBar.formatProfile = function(pseudo, avatar, age){
  let html = template2;
  html = html.replace("{{avatar}}", avatar);
  html = html.replace("{{pseudo}}", pseudo);
  if (age != 0){
    html = html.replace("{{age}}", "-" + age);
  }
  else {
    html = html.replace("{{age}}", "Tout public");
  }
  return html
}

NavBar.format = function (hHome, hProfile, profile) {
  let html = template;
  html = html.replace("{{hHome}}", hHome);
  html = html.replace("{{hProfile}}", hProfile);
  let liste = "";
  for (let p of profile){
    liste += NavBar.formatProfile(p.pseudo, p.avatar, p.min_age);
  };
  html = html.replace("{{profile_liste}}", liste);
  return html;
};

export {NavBar};