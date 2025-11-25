<?php

// ---------------------------------------
// Connexion PDO à la base de données
// ---------------------------------------
function getDB() {
    // Définit l'hôte de la base de données.
    $host = "localhost";
    // Nom de la base de données à laquelle se connecter.
    $dbname = "eno"; 
    // Nom d'utilisateur de la base de données (par défaut 'root').
    $username = "root";
    // Mot de passe de la BDD.
    $password = "";

    try {
        // Tente de créer et retourner un nouvel objet de connexion PDO.
        return new PDO(
            // Le DSN (Data Source Name) spécifie le pilote (mysql), l'hôte, le port, le nom de la BDD et l'encodage (utf8).
            "mysql:host=$host;port=3306;dbname=$dbname;charset=utf8",
            $username,
            $password,
            [
                // Paramètre PDO: configure la gestion des erreurs pour lever des exceptions PHP.
                // Gère les erreurs dans l'application.
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Paramètre PDO: force le mode de récupération par défaut à un tableau associatif (nom_colonne => valeur).
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Paramètre PDO: désactive l'émulation des requêtes préparées (pour une meilleure performance et sécurité).
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } catch (PDOException $e) {
        // En cas d'échec de connexion, arrête l'exécution du script et affiche un message d'erreur.
        die("Erreur de connexion BDD : " . $e->getMessage());
    }
}
