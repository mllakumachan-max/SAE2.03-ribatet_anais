let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hMovies, hProfiles) {
  let html = template;
  html = html.replace("{{hMovies}}", hMovies);
  html = html.replace("{{hProfiles}}", hProfiles);
  return html;
};

export {NavBar};