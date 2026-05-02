// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "..";

let DataFavorite = {};

DataFavorite.addFavorite = async function(id_profile, id_movie){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=addFavorite&id_profile=" + id_profile + "&id_movie=" + id_movie);
    let data = await answer.json();
    return data;
}

DataFavorite.requestFavorites = async function(id_profile){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readFavorites&id_profile=" + id_profile);
    let data = await answer.json();
    return data;
}

DataFavorite.removeFavorite = async function(id_profile, id_movie){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=removeFavorite&id_profile=" + id_profile + "&id_movie=" + id_movie);
    let data = await answer.json();
    return data;
}

export {DataFavorite};
