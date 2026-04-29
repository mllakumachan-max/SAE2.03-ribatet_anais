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

// Fonctions de récupération

function getAllMovies(){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer tous les films
    $sql = "select Movie.id_movie, Movie.name, Movie.image from Movie";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère les résultats de la requête sous forme d'objets
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res; // Retourne les résultats
}

/**
 * Récupère tous les films groupés par catégorie.
 * Cette fonction retourne une structure de données où les films sont organisés
 * par catégorie, ce qui évite les traitements côté Front pour de meilleures performances.
 *
 * @return array Un tableau associatif où les clés sont les noms de catégorie et les valeurs sont des tableaux de films
 */
function getAllMoviesByCategory(){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer les films avec leur catégorie
    $sql = "select Movie.id_movie, Movie.name, Movie.image, Category.name as category_name from Movie 
            join Category on Movie.id_category = Category.id_category 
            order by Category.name, Movie.name";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère les résultats de la requête sous forme d'un tableau associatif
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Grouper les films par catégorie
    $moviesByCategory = [];
    // Parcourt les films récupérés et les organise dans un tableau associatif où la clé est le nom de la catégorie
    for ($i = 0; $i < count($movies); $i++) {
        $movie = $movies[$i];
        //Récupère le nom de la catégorie du film
        $category = $movie["category_name"];
        // Si la catégorie n'existe pas encore dans le tableau, l'ajouter dans un tableau vide
        if (!isset($moviesByCategory[$category])) {
            $moviesByCategory[$category] = [];
        }
        // Ajouter le film dans la catégorie correspondante
        $moviesByCategory[$category][] = $movie;
    }
    // Retourne les résultats groupés par catégorie
    return $moviesByCategory;
    /*{
        "Animation": [{
                    "id_movie": 17,
                    "name": "Your Name",
                    "image": "your_name.jpg",
                    "category_name": "Animation"
                },
                {
                    "id_movie": 18,
                    "name": "Demon Slayer : La Forteresse de l'infini",
                    "image": "demon-slayer-forteresse_infini.jpg",
                    "category_name": "Animation"
                }],
        "Aventure": [{
                    "id_movie": 27,
                    "name": "Le Bon, la Brute et le Truand",
                    "image": "bon_brute_truand.jpg",
                    "category_name": "Aventure"
                }]
    }*/
}

// Liste des catégories et des âges pour les formulaires d'ajout de film
function getAllCategories(){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer les catégories
    $sql = "select id_category, name from Category";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère les résultats de la requête sous forme d'objets
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res; // Retourne les résultats
}

/**
 * Lit les détails d'un film dans la base de données.
 *
 * @param int $id L'ID du film.
 * @return object Les détails du film.
 */
function getMovieDetails($id){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer les détails d'un film
    $sql = "select Movie.*, Category.name as category_name from Movie 
            join Category on Movie.id_category = Category.id_category 
            where Movie.id_movie=:id";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Lie le paramètre à la valeur
    $stmt->bindParam(':id', $id);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère le résultat de la requête sous forme d'un objet
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    return $res; // Retourne les résultats
}

function getAllProfiles(){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer les catégories
    $sql = "select * from Profile";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère les résultats de la requête sous forme d'objets
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res; // Retourne les résultats
}

function getAllMoviesByProfile($id){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer les films associés à un profil
    $sql = "select Movie.id_movie, Movie.name, Movie.image from Movie 
            join Profile_Movie on Movie.id_movie = Profile_Movie.id_movie 
            where Profile_Movie.id_profile=:id";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Lie le paramètre à la valeur
    $stmt->bindParam(':id', $id);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère les résultats de la requête sous forme d'objets
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res; // Retourne les résultats
}


// Fonctions d'ajout

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
    $sql = "insert into Movie (`name`, `year`, `length`, `description`, `director`, `id_category`, `image`, `trailer`, `min_age`) 
        values (:titre, :annee, :duree, :desc, :real, :categorie, :img, :lien, :age)";
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

/**
 * Ajoute un profil utilisateur dans la base de données.
 *
 * @param string $nom Le nom du profil.
 * @param string $avatar Le nom de l'avatar.
 * @param string $age La restriction d'âge.
 * 
 */
function addProfile($pseudo, $avatar, $age){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD); 
    // Requête SQL pour jouter un film avec des paramètres
    $sql = "insert into Profile (`pseudo`, `avatar`, `min_age`) 
        values (:pseudo, :avatar, :age)";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Lie les paramètres aux valeurs
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':avatar', $avatar);
    $stmt->bindParam(':age', $age);
    // Exécute la requête SQL
    $stmt->execute();
}


?>