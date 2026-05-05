let templateFile = await fetch("./component/Note/template.html");
let template = await templateFile.text();

let Note = {};

Note.format = function () {
  let html = template;
  return html;
};

export {Note};