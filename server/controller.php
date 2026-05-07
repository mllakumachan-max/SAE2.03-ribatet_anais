<?php

/** ARCHITECTURE PHP SERVEUR  : Rôle du fichier controller.php
 * 
 *  Dans ce fichier, on va définir les fonctions de contrôle qui vont traiter les requêtes HTTP.
 *  Les requêtes HTTP sont interprétées selon la valeur du paramètre 'todo' de la requête (voir script.php)
 *  Pour chaque valeur différente, on déclarera une fonction de contrôle différente.
 * 
 *  Les fonctions de contrôle vont éventuellement lire les paramètres additionnels de la requête, 
 *  les vérifier, puis appeler les fonctions du modèle (model.php) pour effectuer les opérations
 *  nécessaires sur la base de données.
 *  
 *  Si la fonction échoue à traiter la requête, elle retourne false (mauvais paramètres, erreur de connexion à la BDD, etc.)
 *  Sinon elle retourne le résultat de l'opération (des données ou un message) à inclure dans la réponse HTTP.
 */

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");


/* Fonctions de lecture */

// Fonction de contrôle pour la lecture de tous les films
function readMoviesController(){
    $age = $_REQUEST['age'] ?? 0; // Raccourci de isset($_REQUEST['age'])==true;
    $movie = getAllMoviesByProfile($age);
    return $movie;
}

// Fonctions de contrôle pour les catégories
function readCategoriesController(){
    $categories = getAllCategories();
    return $categories;
}

// Fonction de contrôle pour la lecture des détails d'un film
function readMovieDetailsController(){
    $id = $_REQUEST['id'] ?? null; // Raccourci de isset($_REQUEST['id'])==true;
    $id_profile = $_REQUEST['id_profile'] ?? null;
    if (empty($id)==false && empty($id_profile)==false){
        $movie_details = getMovieDetails($id, $id_profile);
        return $movie_details;
    }
    else{
        return false;
    }
}

// Fonction de contrôle pour la lecture de tous les profils
function readProfilesController(){
    $profiles = getAllProfiles();
    return $profiles;
}

// Fonction de contrôle pour lire les films favoris d'un profil
function readFavoritesController(){
    $id_profile = $_REQUEST['id_profile'] ?? null;
    if (empty($id_profile)==false){
        $favorites = getFavorites($id_profile) ?? null;
        return $favorites;
    }
    else {
        return false;
    }
}


// Fonction de contrôle pour lire les films mis en avant
function readFeaturedMoviesController(){
    $featured_movies = getFeaturedMovies();
    return $featured_movies;
}

// Fonction de contrôle pour lire les stattistiques générales
function readStatsController(){
    // Syntaxe tableau associatif : "clé" => valeur
    return [
        "total_profiles" => getTotalProfiles(),
        "total_movies" => getTotalMovies(),
        "avg_favorites" => getAvgFavoritesPerProfile(),
        "most_favorited_movie" => getMostFavoritedMovie(),
        "most_popular_category" => getMostPopularCategory()
    ];
}

// Fonction de contrôle pour la recherche de films
function readSearchMoviesController(){
    $search = $_REQUEST['search'] ?? null;
    if (empty($search)==false){
        $movies = getMovieBySearch($search);
        return $movies;
    }
    else{
        return "Aucun résultat correspondant à $search";
    }
}

/* Fonctions d'ajouts */

/** addMovieController
 * 
 * Cette fonction est en charge du traitement des requêtes HTTP pour lesquelles le paramètre 'todo' vaut 'add'.
 * Elle vérifie si le paramètre titre est défini et non vide dans la requête.
 * Si le paramètre 'titre' est présent, elle appelle la fonction addMovie et ajoute le film.
 * Si le paramètre 'titre' n'est pas présent, vide ou invalide, elle retourne false.
 * 
 * @return mixed Le film si 'titre' est défini, valide et non vide, sinon false.
 */
function addMovieController(){
    // Lecture des données de formulaire
    $titre = $_REQUEST['titre'] ?? null;
    $annee = $_REQUEST['annee'] ?? null;
    $duree = $_REQUEST['duree'] ?? null;
    $desc = $_REQUEST['desc'] ?? null;
    $real = $_REQUEST['real'] ?? null;
    $categorie = $_REQUEST['categorie'] ?? null;
    $img = $_REQUEST['img'] ?? null;
    $lien = $_REQUEST['lien'] ?? null;
    $age = $_REQUEST['age'] ?? null;
    // Vérifie que le paramètre 'titre' n'est pas vide
    if (empty($titre)==false){
        if (empty($annee)==true){
            $annee = null;
        }
        if (empty($duree)==true){
            $duree = null;
        }
        if (empty($categorie)==true) {
            $categorie = null;
        }
        // Ajout du film à l'aide de la fonction addMovie décrite dans model.php
        addMovie($titre, $annee, $duree, $desc, $real, $categorie, $img, $lien, $age);
        return "Le film $titre a été ajouté avec succès.";
    }
    else {
        return "Veuillez saisir un titre";
    }
}

/** addProfileController
 * 
 * Cette fonction est en charge du traitement des requêtes HTTP pour lesquelles le paramètre 'todo' vaut 'add'.
 * Elle vérifie si le paramètre pseudo est défini et non vide dans la requête.
 * Si le paramètre 'pseudo' est présent, elle appelle la fonction addProfile et ajoute le profil.
 * Si le paramètre 'pseudo' n'est pas présent, vide ou invalide, elle retourne false.
 * 
 * @return mixed Le profil si 'pseudo' est défini, valide et non vide, sinon false.
 */
function addProfileController(){
    // Lecture des données de formulaire
    $pseudo = $_REQUEST['pseudo'] ?? null;
    $avatar = $_REQUEST['avatar'] ?? null;
    $age = $_REQUEST['age'] ?? null;
    if (empty($pseudo)==false){
        addProfile($pseudo, $avatar, $age);
        return "Le profil $pseudo a été ajouté avec succès.";
    }
    else {
        return "Veuillez choisir un profils";
    }
}

function addFavoriteController(){
    $id_profile = $_REQUEST['id_profile'] ?? null;
    $id_movie = $_REQUEST['id_movie'] ?? null;
    if (empty($id_profile)==false && empty($id_movie)==false){
        if (isFavorite($id_profile, $id_movie)==false){
            addFavorite($id_profile, $id_movie);
            return "Le film a été ajouté à vos favoris.";
        }
        else{
            return "Ce film est déjà dans vos favoris.";
        }
    }
}

/* Fonction de modification */

function updateProfileController(){
    // Lecture des données de formulaire
    $id = $_REQUEST['id'] ?? null;
    $pseudo = $_REQUEST['pseudo'] ?? null;
    $avatar = $_REQUEST['avatar'] ?? null;
    $age = $_REQUEST['age'] ?? null;
    $ok = updateProfile($id, $pseudo, $avatar, $age);
    if ($ok == 1){
        return "Le profil $pseudo a été mis à jour avec succès.";
    }
    else{
        return "Veuillez modifier les informations du profil $pseudo.";
    }
}

function updateFeaturedMoviesController(){
    $movie = $_REQUEST['id'] ?? null;
    $statut = $_REQUEST['featured'] ?? null;
    if (empty($movie)==false){
        updateFeaturedMovies($movie, $statut);
        return "Le film a été mis en avant avec succès.";
    }
    else {
        return "Veuillez choisir une réponse";
    }
}

/* Fonctions de suppression */

function removeFavoriteController(){
    $id_profile = $_REQUEST['id_profile'] ?? null;
    $id_movie = $_REQUEST['id_movie'] ?? null;
    if (empty($id_profile)==false && empty($id_movie)==false){
        if (isFavorite($id_profile, $id_movie)==true){
            removeFavorite($id_profile, $id_movie);
            return "Le film a été retiré de vos favoris.";
        }
        else{
            return "Ce film n'est pas dans vos favoris.";
        }
    }
}