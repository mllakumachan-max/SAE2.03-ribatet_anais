let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hHome, hProfile) {
  let html = template;
  html = html.replace("{{hHome}}", hHome);
  html = html.replace("{{hProfile}}", hProfile);
  return html;
};

export { NavBar };