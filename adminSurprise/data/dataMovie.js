// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "..";

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

DataMovie.requestSearchMovies = async function(search){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readSearchResults&search=" + search);
    let data = await answer.json();
    return data;
}

DataMovie.updateFeaturedMovies = async function(formdata) {
    let config = {
        method: "POST", // méthode HTTP à utiliser
        body: formdata // données à envoyer sous forme d'objet FormData
    };
    let answer = await fetch(HOST_URL + "/server/script.php?todo=updateFeaturedMovies", config);
    let data = await answer.json();
    return data;
}

export {DataMovie};