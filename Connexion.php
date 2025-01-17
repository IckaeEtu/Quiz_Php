<?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
session_start();
$dbFile = "quizz.db";

try {
    // Connexion à la base de données SQLite
    $db = new PDO("sqlite:" . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur lors de la connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];

    $stmt = $db->prepare("SELECT * FROM Utilisateurs WHERE Nom = :pseudo");
    $stmt->execute(['pseudo' => $pseudo]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["Nom"] = $user['Nom'];

    if ($user) {
        echo "<h3>Bienvenue, " . htmlspecialchars($user['Nom']) . "!</h3>";
    } else {
        $stmt = $db->prepare("INSERT INTO Utilisateurs (Nom) VALUES (:pseudo)");
        $stmt->execute(['pseudo' => $pseudo]);
        $_SESSION["Nom"] = $pseudo;
        echo "<h3>Bienvenue, " . htmlspecialchars($user['Nom']) . "!</h3>";
    }
    header("Location: index.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Quiz</title>
</head>
<body>

    <h2>Connexion</h2>
    <form method="post">
        <label for="pseudo">Pseudo : </label>
        <input type="text" id="pseudo" name="pseudo" required><br><br>
        <button type="submit">Se connecter</button>
    </form>

</body>
</html>