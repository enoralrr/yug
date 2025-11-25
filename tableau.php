<?php
// Démarre ou reprend la session.
session_start();

// Inclut le fichier 'fonctions.php'.
require "fonctions.php";

// Établit la connexion à la base de données via la fonction getDB() et stocke l'objet de connexion PDO.
$pdo = getDB();

// Vérifie si la méthode de requête HTTP utilisée est 'POST'. 
// Cela signifie que le formulaire HTML a été soumis par l'utilisateur.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Nettoyage et récupération des données soumises. 
    // La fonction trim() est utilisée pour supprimer les espaces inutiles au début et à la fin (Sécurité obligatoire).
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $adresse = trim($_POST['adresse']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['password_confirm']);

    // --- Vérifications de Sécurité et Validation (Fonctionnalité A) ---

    // 1. Vérification des Champs Obligatoires.
    // Vérifie si l'une des variables est vide.
    if ($nom === "" || $email === "" || $adresse === "" || $password === "" || $passwordConfirm === "") {
        // Arrête le script (die) et affiche un message si tous les champs ne sont pas remplis.
        die("Tous les champs sont obligatoires.");
    }

    // 2. Validation de l'Email.
    // Utilise la fonction native PHP filter_var avec FILTER_VALIDATE_EMAIL pour vérifier le format de l'email (Regex email).
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Arrête l'exécution si le format de l'email est jugé invalide.
        die("Email invalide.");
    }

    // 3. Vérification des 2 Mots de Passe.
    // S'assure que les mots de passe entrés et leur confirmation sont strictement identiques.
    if ($password !== $passwordConfirm) {
        // Arrête l'exécution si les mots de passe ne correspondent pas.
        die("Les mots de passe ne correspondent pas.");
    }

    // 4. Vérification si l'Email existe déjà.
    // Appelle la fonction emailExiste() pour interroger la BDD et vérifier l'unicité de l'email.
    if (emailExiste($pdo, $email)) {
        // Arrête l'exécution si un compte utilise déjà cet email.