<?php
// Démarre ou reprend la session existante de l'utilisateur. 
// Essentiel pour l'ID de l'utilisateur.
session_start();

// Inclut le fichier avec les fonctions PHP. 
require "fonctions.php";

// Appelle la fonction 'getDB()' (définie dans fonctions.php) pour établir une connexion à la base de données et stocke
// l'objet de connexion dans la variable $pdo.
$pdo = getDB();

// Appelle la fonction 'deleteAccount()' (définie dans fonctions.php).
// - $pdo est l'objet de connexion à la base de données.
// - $_SESSION['user_id'] est l'identifiant de l'utilisateur actuellement connecté. C'est l'utilisateur qui va être supprimé.
deleteAccount($pdo, $_SESSION['user_id']);

// Redirige le navigateur de l'utilisateur vers la page 'index.html' une fois que la suppression du compte est terminée. 
// Déconnection (puisque son compte n'existe plus).
header("Location: index.html");

// Termine l'exécution du script.
exit;