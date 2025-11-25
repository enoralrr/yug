<?php
// Démarre ou reprend la session existante de l'utilisateur. 
session_start();

// Détruit toutes les variables de session associées à cette session.
// Déconnecté du pov serveur.
session_destroy();

// Redirige le navigateur de l'utilisateur vers la page de connexion (login.php).
header("Location: login.php");

// Termine l'exécution du script immédiatement.
exit;