// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "..";

let DataStats = {};

DataStats.requestStats = async function(){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readStats");
    let data = await answer.json();
    return data;
}

export {DataStats};
