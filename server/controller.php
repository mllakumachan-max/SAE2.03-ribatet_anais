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
    $movies = getAllMoviesByCategory();
    return $movies;
}

// Fonctions de contrôle pour les catégories
function readCategoriesController(){
    $categories = getAllCategories();
    return $categories;
}

// Fonction de contrôle pour la lecture des détails d'un film
function readMovieDetailsController(){
    $id = $_REQUEST['id'];
    if (isset($id)==true && empty($id)==false){
        $movie_details = getMovieDetails($id);
        return $movie_details;
    }
    else{
        return "Veuillez fournir un id de film valide.";
    }
}

// Fonction de contrôle pour la lecture de tous les profils
function readProfilesController(){
    $profiles = getAllProfiles();
    return $profiles;
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
    $titre = $_REQUEST['titre'];
    $annee = $_REQUEST['annee'];
    $duree = $_REQUEST['duree'];
    $desc = $_REQUEST['desc'];
    $real = $_REQUEST['real'];
    $categorie = $_REQUEST['categorie'];
    $img = $_REQUEST['img'];
    $lien = $_REQUEST['lien'];
    $age = $_REQUEST['age'];
    // Vérifie que le paramètre 'titre' n'est pas absent ou vide
    if (isset($titre)==true && empty($titre)==false){
        // Vérifie que les paramètres 'annee', 'duree' et 'age' ne sont pas vides, sinon les définit à null
        if (isset($annee)==true && empty($annee)==true){
            $annee = null;
        }
        if (isset($duree)==true && empty($duree)==true){
            $duree = null;
        }
        if (isset($age)==true && empty($age)==true){
            $age = null;
        }
        // Ajout du film à l'aide de la fonction addMovie décrite dans model.php
        addMovie($titre, $annee, $duree, $desc, $real, $categorie, $img, $lien, $age);
        // Vérifie que le paramètre 'categorie' n'est pas absent ou vide
        if (isset($categorie)==true && empty($categorie)==false){
            $liste = ["Action", "Aventure", "Animation", "Comédie", "Documentaire", "Drame", "Fantastique", "Horreur", "Policier", "Science-fiction"];
            if (in_array($categorie, $liste)){
                return "Le film $titre a été ajouté avec succès.";
            }
        }
        // Vérifie que le paramètre 'age' n'est pas absent ou vide
        if (isset($age)==true && empty($age)==false){
            $min_age = [0, 10, 12, 16, 18];
            if (in_array($age, $min_age)){
                return "Le film $titre a été ajouté avec succès.";
            }
        }
        return "Le film $titre a été ajouté avec succès.";
    }
    else{
        return "Veuillez remplir le champs 'titre'.";
    }
}

/** addProfileController
 * 
 * Cette fonction est en charge du traitement des requêtes HTTP pour lesquelles le paramètre 'todo' vaut 'add'.
 * Elle vérifie si le paramètre nom est défini et non vide dans la requête.
 * Si le paramètre 'nom' est présent, elle appelle la fonction addProfile et ajoute le profil.
 * Si le paramètre 'nom' n'est pas présent, vide ou invalide, elle retourne false.
 * 
 * @return mixed Le profil si 'nom' est défini, valide et non vide, sinon false.
 */
function addProfileController(){
    // Lecture des données de formulaire
    $pseudo = $_REQUEST['pseudo'];
    $avatar = $_REQUEST['avatar'];
    $age = $_REQUEST['age'];
    if (isset($pseudo)==true && empty($pseudo)==false){
        if (isset($age)==true && empty($age)==false){
            $min_age = [0, 10, 12, 16, 18];
            if (in_array($age, $min_age)){
                addProfile($pseudo, $avatar, $age);
                return "Le profil $pseudo a été ajouté avec succès.";
            }
        }
    }
    else{
        return "Veuillez remplir le champs 'pseudo'.";
    }
}

?>