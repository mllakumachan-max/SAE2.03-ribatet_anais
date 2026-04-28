// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "https://mmi.unilim.fr/~ribatet1/S2/SAE2.03-ribatet_anais";

let DataMovie = {};

DataMovie.requestCategories = async function() {
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readCategories");
    let data = await answer.json();
    return data;
}

DataMovie.add = async function(formdata) {
    let config = {
        method: "POST", // méthode HTTP à utiliser
        body: formdata // données à envoyer sous forme d'objet FormData
    };
    let answer = await fetch(HOST_URL + "/server/script.php?todo=addMovie", config);
    let data = await answer.json();
    return data;
}

export {DataMovie};