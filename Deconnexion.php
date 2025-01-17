<?php

session_start();

if (isset($_SESSION["Nom"])) {
    unset($_SESSION["Nom"]);
    // Redirige l'utilisateur vers la page de connexion ou une autre page
    header("Location: index.php");
    exit();
} else {
    // Si aucune session n'est active, on redirige directement vers la page de connexion
    header("Location: index.php");
    exit();
}

?>
