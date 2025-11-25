<?php
// Démarre ou reprend la session.
session_start();

// Inclut le fichier 'fonctions.php'.
require "fonctions.php";

// Établit la connexion à la base de données via la fonction getDB() et stocke l'objet PDO.
$pdo = getDB();

// Vérifie si la requête HTTP est de type POST, formulaire d'inscription soumis.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage et récupération des données du formulaire. trim() supprime les espaces inutiles autour des valeurs (Sécurité obligatoire).
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $adresse = trim($_POST['adresse']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['password_confirm']);

    // --- Vérifications de Sécurité et Validation ---

    // 1. Vérification des Champs Obligatoires.
    if ($nom === "" || $email === "" || $adresse === "" || $password === "" || $passwordConfirm === "") {
        // Arrête l'exécution et affiche un message d'erreur si un champ est vide.
        die("Tous les champs sont obligatoires.");
    }

    // 2. Validation de l'Email. Utilise la fonction native de PHP pour vérifier le format de l'email (Regex email).
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Arrête l'exécution si le format de l'email est invalide.
        die("Email invalide.");
    }

    // 3. Vérification des 2 mdp.
    if ($password !== $passwordConfirm) {
        // Arrête l'exécution si les deux mdp ne correspondent pas.
        die("Les mots de passe ne correspondent pas.");
    }

    // 4. Vérification si l'Email existe déjà. Appelle la fonction emailExiste() pour vérifier l'unicité dans la BDD.
    if (emailExiste($pdo, $email)) {
        // Arrête l'exécution si l'email est déjà utilisé.
        die("Cet email existe déjà.");
    }

    // 5. Hashage du mdp.
    // Crée un hash sécurisé du mdp.
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // --- Insertion dans la base de données ---

    // Appelle la fonction creerUtilisateur() pour insérer les données (y compris l'adresse et le hash) dans la table 'users' (avec le rôle par défaut 'user').
    if (creerUtilisateur($pdo, $nom, $email, $passwordHash, $adresse)) {
        // Succès : Affiche un message de succès et un lien vers la page de connexion.
        echo "Inscription réussie. <a href='login.php'>Se connecter</a>";
    } else {
        // Échec : Affiche un message d'erreur si la requête d'insertion a échoué.
        echo "Erreur lors de l'inscription.";
    }
}
?>
