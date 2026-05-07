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


// Fonction de connexion centralisée
function getConnexion() {
    $cnx = new PDO(
        "mysql:host=".HOST.";dbname=".DBNAME,
        DBLOGIN,
        DBPWD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    return $cnx;
}

// Fonctions Movie

// Liste des catégories et des âges pour les formulaires d'ajout de film
function getAllCategories(){
    // Connexion à la base de données
    try {
        $cnx = getConnexion();
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
    catch (PDOException $e){
        return false;
    }
}

/**
 * Récupère tous les films groupés par catégorie et selon l'âge du profil.
 * Cette fonction retourne une structure de données où les films sont organisés
 * par catégorie, ce qui évite les traitements côté Front pour de meilleures performances.
 *
 * @return array Un tableau associatif où les clés sont les noms de catégorie et les valeurs sont des tableaux de films
 */
function getAllMoviesByProfile($age){
    // Connexion à la base de données
    try {
        $cnx = getConnexion();
        // Requête SQL pour récupérer les films avec leur catégorie
        $sql = "select Movie.id_movie, Movie.name, Movie.image, Category.name as category_name from Movie 
                join Category on Movie.id_category = Category.id_category 
                where Movie.min_age <= :age 
                order by Category.name, Movie.name";
        // Prépare la requête SQL
        $stmt = $cnx->prepare($sql);
        // Lie le paramètre à la valeur
        $stmt->bindParam(':age', $age);
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
                        "name": "Demon Slayer : La Forteresse infinie",
                        "image": "demon-slayer-forteresse_infinie.jpg",
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
    catch (PDOException $e){
        return false;
    }
}

/**
 * Récupère tous les films mis en avant.
 * Les films mis en avant sont ceux marqués dans la table Featured.
 * Cette fonction retourne uniquement les films qui respectent la restriction d'âge.
 *
 * @return array Un tableau d'objets contenant les films mis en avant
 */
function getFeaturedMovies(){
    // Connexion à la base de données
    try {
        $cnx = getConnexion();
        // Requête SQL pour récupérer les films mis en avant avec leur catégorie
        $sql = "select id_movie, name, image, description from Movie 
                where featured = 1";
        // Prépare la requête SQL
        $stmt = $cnx->prepare($sql);
        // Exécute la requête SQL
        $stmt->execute();
        // Récupère les résultats de la requête sous forme d'un tableau d'objets
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res; // Retourne les résultats
    }
    catch (PDOException $e){
        return false;
    }
}

/**
 * Lit les détails d'un film dans la base de données.
 *
 * @param int $id L'ID du film.
 * @param int $id_profile L'ID du profil.
 * @return object Les détails du film.
 */
function getMovieDetails($id, $id_profile){
    // Connexion à la base de données
    try {
        $cnx = getConnexion();
        // Requête SQL pour récupérer les détails d'un film
        $sql = "select Movie.*, Category.name as category_name, Favorite.id_movie as is_favorite from Movie 
                join Category on Movie.id_category = Category.id_category 
                left join Favorite on Movie.id_movie = Favorite.id_movie and Favorite.id_profile = :id_profile
                where Movie.id_movie=:id";
        // Prépare la requête SQL
        $stmt = $cnx->prepare($sql);
        // Lie le paramètre à la valeur
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_profile', $id_profile);
        // Exécute la requête SQL
        $stmt->execute();
        // Récupère le résultat de la requête sous forme d'un objet
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res; // Retourne les résultats
    }
    catch (PDOException $e){
        return false;
    }
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
    try {
        $cnx = getConnexion(); 
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
    catch (PDOException $e){
        return false;
    }
}

/**
 * Récupère les films correspondant à une recherche par nom.
 *
 * @param string $search Le terme de recherche.
 * @return array Un tableau d'objets contenant les films correspondants à la recherche.
 */
function getMovieBySearch($search) {
    try {
        $cnx = getConnexion();
        $sql = "select Movie.id_movie, Movie.name, Movie.image, Movie.featured, Category.name as category_name from Movie 
                join Category on Movie.id_category = Category.id_category
                where Movie.name like :search or Category.name like :search";
        $stmt = $cnx->prepare($sql);
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':search', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    catch (PDOException $e){
        return false;
    }
}

/**
 * Modifie le statut mis en avant d'un film dans la base de données.
 */
function updateFeaturedMovies($id, $featured){
    // Connexion à la base de données
    try {
        $cnx = getConnexion(); 
        // Requête SQL pour mettre à jour le statut mis en avant d'un film avec des paramètres
        $sql = "update Movie set featured=:statut where id_movie=:id";
        // Prépare la requête SQL
        $stmt = $cnx->prepare($sql);
        // Lie les paramètres aux valeurs
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':statut', $featured);
        // Exécute la requête SQL
        $stmt->execute();
        // Récupère le nombre de lignes affectées par la requête
        $res = $stmt->rowCount(); 
        return $res; // Retourne le nombre de lignes affectées
    }
    catch (PDOException $e){
        return false;
    }
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
    try {
        $cnx = getConnexion(); 
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
    catch (PDOException $e){
        return false;
    }
}

function getAllProfiles(){
    // Connexion à la base de données
    try {
        $cnx = getConnexion();
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
    catch (PDOException $e){
        return false;
    }
}

function updateProfile($id, $pseudo, $avatar, $age){
    // Connexion à la base de données
    try {
        $cnx = getConnexion(); 
        // Requête SQL de mise à jour du profil avec des paramètres
        $sql = "update Profile set pseudo=:pseudo, avatar=:avatar, min_age=:age where id_profile=:id";
        // Prépare la requête SQL
        $stmt = $cnx->prepare($sql);
        // Lie les paramètres aux valeurs
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':avatar', $avatar);
        $stmt->bindParam(':age', $age);
        // Exécute la requête SQL
        $stmt->execute();
        // Récupère le nombre de lignes affectées par la requête
        $res = $stmt->rowCount(); 
        return $res; // Retourne le nombre de lignes affectées
    }
    catch (PDOException $e){
        return false;
    }
}

// Fonction Favorite

/**
 * Ajoute un film aux favoris d'un profil.
 *
 * @param int $id_profile L'ID du profil.
 * @param int $id_movie L'ID du film.
 */
function addFavorite($id_profile, $id_movie){
    // Connexion à la base de données
    try {
        $cnx = getConnexion();
        // Requête SQL pour ajouter un film aux favoris
        $sql = "insert into Favorite (`id_profile`, `id_movie`) 
                values (:id_profile, :id_movie)";
        // Prépare la requête SQL
        $stmt = $cnx->prepare($sql);
        // Lie les paramètres aux valeurs
        $stmt->bindParam(':id_profile', $id_profile);
        $stmt->bindParam(':id_movie', $id_movie);
        // Exécute la requête SQL
        $stmt->execute();
    }
    catch (PDOException $e){
        return false;
    }
}

/**
 * Récupère tous les films favoris d'un profil.
 *
 * @param int $id_profile L'ID du profil.
 * @return array Les films favoris du profil.
 */
function getFavorites($id_profile){
    // Connexion à la base de données
    try {
        $cnx = getConnexion();
        // Requête SQL pour récupérer les films favoris d'un profil
        $sql = "select Movie.* from Movie 
                join Favorite on Movie.id_movie = Favorite.id_movie 
                where Favorite.id_profile = :id_profile
                order by Favorite.date_added DESC";
        // Prépare la requête SQL
        $stmt = $cnx->prepare($sql);
        // Lie le paramètre à la valeur
        $stmt->bindParam(':id_profile', $id_profile);
        // Exécute la requête SQL
        $stmt->execute();
        // Récupère les résultats de la requête sous forme d'objets
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res; // Retourne les résultats
    }
    catch (PDOException $e){
        return false;
    }
}

/**
 * Vérifie si un film est dans les favoris d'un profil.
 *
 * @param int $id_profile L'ID du profil.
 * @param int $id_movie L'ID du film.
 * @return bool true si le film est en favori, false sinon.
 */
function isFavorite($id_profile, $id_movie){
    // Connexion à la base de données
    try {
        $cnx = getConnexion();
        // Requête SQL pour vérifier si le film est en favori
        $sql = "select * from Favorite 
                where id_profile = :id_profile and id_movie = :id_movie";
        // Prépare la requête SQL
        $stmt = $cnx->prepare($sql);
        // Lie les paramètres aux valeurs
        $stmt->bindParam(':id_profile', $id_profile);
        $stmt->bindParam(':id_movie', $id_movie);
        // Exécute la requête SQL
        $stmt->execute();
        // Récupère le résultat de la requête sous forme d'un tableau associatif
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        // Retourne true si le count est > 0, false sinon
        return !empty($res);
    }
    catch (PDOException $e){
        return false;
    }
}

/**
 * Supprime un film des favoris d'un profil.
 *
 * @param int $id_profile L'ID du profil.
 * @param int $id_movie L'ID du film.
 */
function removeFavorite($id_profile, $id_movie){
    // Connexion à la base de données
    try {
        $cnx = getConnexion();
        // Requête SQL pour supprimer un film des favoris
        $sql = "delete from Favorite 
                where id_profile = :id_profile and id_movie = :id_movie";
        // Prépare la requête SQL
        $stmt = $cnx->prepare($sql);
        // Lie les paramètres aux valeurs
        $stmt->bindParam(':id_profile', $id_profile);
        $stmt->bindParam(':id_movie', $id_movie);
        // Exécute la requête SQL
        $stmt->execute();
    }
    catch (PDOException $e){
        return false;
    }
}


// Fonctions statistiques

/**
 * Récupère le nombre total de profils dans la base de données.
 *
 * @return object Un objet contenant le nombre total de profils.
 */
function getTotalProfiles(){
    try {
        $cnx = getConnexion();
        $sql = "select count(*) as total from Profile";
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    catch (PDOException $e){
        return false;
    }
}

/**
 * Récupère le nombre total de favoris dans la base de données.
 *
 * @return object Un objet contenant le nombre total de favoris.
 */
function getAvgFavoritesPerProfile(){
    try {
        $cnx = getConnexion();
        $sql = "select round(avg(total), 1) as avg from (
                    select count(*) as total from Favorite GROUP BY id_profile
                ) as counts";
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    catch (PDOException $e){
        return false;
    }
}

/**
 * Récupère le nombre total de films dans la base de données.
 *
 * @return object Un objet contenant le nombre total de films.
 */
function getTotalMovies(){
    try {
        $cnx = getConnexion();
        $sql = "select count(*) as total from Movie";
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    catch (PDOException $e){
        return false;
    }
}

/**
 * Récupère le film le plus favorisé dans la base de données.
 *
 * @return object Un objet contenant le nom du film le plus favorisé.
 */
function getMostFavoritedMovie(){
    try {
        $cnx = getConnexion();
        $sql = "select Movie.name from Movie
                JOIN (
                    SELECT id_movie, COUNT(*) as total 
                    FROM Favorite 
                    GROUP BY id_movie
                    ORDER BY total DESC
                    LIMIT 1
                ) as top ON Movie.id_movie = top.id_movie";
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    catch (PDOException $e){
        return false;
    }
}

/**
 * Récupère la catégorie la plus populaire dans la base de données.
 *
 * @return object Un objet contenant le nom de la catégorie la plus populaire.
 */
function getMostPopularCategory(){
    try {
        $cnx = getConnexion();
        $sql = "select Category.name from Category
                JOIN (
                    SELECT Movie.id_category, COUNT(*) as total 
                    FROM Favorite 
                    JOIN Movie ON Favorite.id_movie = Movie.id_movie
                    GROUP BY Movie.id_category
                    ORDER BY total DESC
                    LIMIT 1
                ) as top ON Category.id_category = top.id_category";
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
    }
    catch (PDOException $e){
        return false;
    }
}