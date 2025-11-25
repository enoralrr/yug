<?php
// Démarre ou reprend la session existante. Stocke info après connexion.
session_start();

// Inclut le fichier 'fonctions.php'.
require "fonctions.php";

// Établit la connexion à la BDD et stocke l'objet PDO.
$pdo = getDB();

// Vérifie si la requête HTTP est de type POST, ce qui signifie que le formulaire a été soumis.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoie et récupère l'email soumis par l'utilisateur. trim() est utilisé pour supprimer les espaces inutiles (Sécurité obligatoire).
    $email = trim($_POST['email']);
    // Nettoie et récupère le mot de passe soumis.
    $password = trim($_POST['password']);

    // Contrôle basique : vérifie si l'un des champs est vide.
    if ($email === "" || $password === "") {
        // Arrête l'exécution et affiche un message d'erreur si les champs ne sont pas remplis (Champs obligatoires).
        die("Veuillez remplir tous les champs.");
    }

    // Appelle la fonction pour récupérer les informations de l'utilisateur par son email.
    $user = getUserByEmail($pdo, $email);

    // Vérification de l'utilisateur : si $user est FALSE (l'email n'a retourné aucune ligne).
    if (!$user) {
        // Arrête l'exécution. Message générique pour éviter d'indiquer si l'email ou le mdp est faux.
        die("Email ou mot de passe incorrect.");
    }

    // Vérification du mdp : Utilise la fonction password_verify pour comparer le mot de passe 
    // ($password) avec le hash stocké dans la BDD ($user['password']).
    if (!password_verify($password, $user['password'])) {
        // Arrête l'exécution en cas de non-concordance (Sécurité obligatoire : Hashage).
        die("Email ou mot de passe incorrect.");
    }

    // --- Démarrage de la session et Récupération des données (Objectif du projet) ---

    // Stocke l'ID de l'utilisateur dans la session. Ceci authentifie l'utilisateur.
    $_SESSION['user_id'] = $user['id'];
    // Stocke le nom de l'utilisateur (utile pour l'affichage du profil).
    $_SESSION['user_nom'] = $user['nom'];
    // (Récupération du rôle).

    // Redirection vers l'espace utilisateur.
    header("Location: tableau.php");
    // Arrête le script pour garantir l'exécution de la redirection.
    exit;
}
?>