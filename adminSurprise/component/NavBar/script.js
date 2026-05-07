let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hMovies, hFeaturedMovies, hProfiles, hProfilesList) {
  let html = template;
  html = html.replace("{{hMovies}}", hMovies);
  html = html.replace("{{hFeaturedMovies}}", hFeaturedMovies);
  html = html.replace("{{hProfiles}}", hProfiles);
  html = html.replace("{{hProfilesList}}", hProfilesList);
  return html;
};

export {NavBar};