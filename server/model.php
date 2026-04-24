<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "ribatet1");
define("DBLOGIN", "ribatet1");
define("DBPWD", "ribatet1");


function getAllMovies(){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer le menu avec des paramètres
    $sql = "select id, name, image from Movie";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère les résultats de la requête sous forme d'objets
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res; // Retourne les résultats
}

/**
 * Ajoute un film dans la base de données.
 *
 * @param string $t Le titre du film.
 * @param int $an L'année de sortie du film.
 * @param float $duree La durée du film.
 * @param string $desc La description ou synopsis du film.
 * @param string $r Le nom du réalisateur.
 * @param string $c La catégorie du film.
 * @param string $aff Le nom de l'affiche.
 * @param string $l Le lien du trailer.
 * @param string $age La restriction d'âge.
 * 
 */
function addMovie($t, $an, $duree, $desc, $r, $c, $aff, $l, $age){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD); 
    // Requête SQL pour jouter un film avec des paramètres
    $sql = "insert into Movie values \
                name=:titre, \
                year=:annee, \
                length=:duree, \
                description=:desc, \
                director=:real, \
                (select id_category from Category where name=:categorie), \
                image=:img, \
                trailer=:lien, \
                min_age=:age";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Lie les paramètres aux valeurs
    $stmt->bindParam(':titre', $t);
    $stmt->bindParam(':annee', $an);
    $stmt->bindParam(':duree', $duree);
    $stmt->bindParam(':desc', $desc);
    $stmt->bindParam(':real', $r);
    $stmt->bindParam(':categorie', $c);
    $stmt->bindParam(':img', $aff);
    $stmt->bindParam(':lien', $l);
    $stmt->bindParam(':age', $age);
    // Exécute la requête SQL
    $stmt->execute();
}