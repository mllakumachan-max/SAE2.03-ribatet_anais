// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = ".."; "https://mmi.unilim.fr/~ribatet1/S2/SAE2.03-ribatet_anais";

let DataProfile = {};

DataProfile.add = async function(formdata) {
    let config = {
        method: "POST", // méthode HTTP à utiliser
        body: formdata // données à envoyer sous forme d'objet FormData
    };
    let answer = await fetch(HOST_URL + "/server/script.php?todo=addProfile", config);
    let data = await answer.json();
    return data;
}

export {DataProfile};