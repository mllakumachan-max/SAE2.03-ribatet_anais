import {Search} from "../Search/script.js";

let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hHome, hStats, hProfile, hFavorites) {
  let html = template;
  html = html.replace("{{hHome}}", hHome);
  html = html.replace("{{hStats}}", hStats);
  html = html.replace("{{search}}", Search.format());
  html = html.replace("{{activeProfile}}", window.activeName);
  html = html.replace("{{hProfile}}", hProfile);
  html = html.replace("{{hFavorites}}", hFavorites);
  return html;
};

export {NavBar};