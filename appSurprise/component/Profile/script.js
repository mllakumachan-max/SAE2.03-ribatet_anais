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
  if (avatar != null) {
    html = html.replace("{{avatar}}", "../server/images/profiles/" +  avatar);
  }
  else{
    html = html.replace("{{avatar}}", "../server/images/profiles/default.png");
  }
  html = html.replaceAll("{{pseudo}}", pseudo);

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

// Fonction pour un effet de zoom sur les cartes de profil lorsqu'elles sont centrées sur l'écran du smartphone
function initCarouselZoom() {
  // Sélectionnez tous les éléments de la liste de profils
  const items = document.querySelectorAll(".profile__item");
  // Créez un nouvel IntersectionObserver pour surveiller la visibilité des éléments
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        // Si l'élément est visible à 80% ou plus, ajouter la classe pour le zoom, sinon la retirer
        if (entry.intersectionRatio > 0.8) {  //entry.intersectionRatio = pourcentage réel de visibilité de l'élément
          entry.target.classList.add("profile__item--center");
        }
        else {
          entry.target.classList.remove("profile__item--center");
        }
      });
    },
    {
      root: document.querySelector(".profile__list"),
      // L'élément doit être visible à 80% pour déclencher l'effet de zoom
      threshold: [0.8]
    }
  );
  // Observer chaque élément de la liste
  items.forEach(item => observer.observe(item));
}

export {Profile, initCarouselZoom};