let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hHome, hAbout) {
  let html = template;
  html = html.replace("{{hHome}}", hHome);
  html = html.replace("{{hAbout}}", hAbout);
  return html;
};

export { NavBar };