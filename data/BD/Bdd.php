<?php

$dbFile = "quizz.db";

try {
    // Connexion à la base de donnée (ça la crée si elle n'existe pas)
    $db = new PDO("sqlite:" . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Script de création des tables
    $sql = "
        -- Création de la table Utilisateurs
        CREATE TABLE IF NOT EXISTS Utilisateurs (
            Id_Utilisateur INTEGER PRIMARY KEY AUTOINCREMENT,
            Nom TEXT NOT NULL
        );

        -- Création de la table Quizz
        CREATE TABLE IF NOT EXISTS Quizz (
            Id_Quizz INTEGER PRIMARY KEY AUTOINCREMENT,
            Nom TEXT NOT NULL
        );

        -- Création de la table Questions
        CREATE TABLE IF NOT EXISTS Questions (
            Id_Question INTEGER PRIMARY KEY AUTOINCREMENT,
            Nom TEXT NOT NULL,
            Type TEXT NOT NULL,
            Reponses TEXT NOT NULL,
            Reponse_Correcte TEXT NOT NULL,
            Score INTEGER NOT NULL,
            Id_Quizz INTEGER NOT NULL,
            FOREIGN KEY (Id_Quizz) REFERENCES Quizz(Id_Quizz) ON DELETE CASCADE
        );

        -- Table associative pour représenter la relation Note entre Utilisateurs et Quizz
        CREATE TABLE IF NOT EXISTS Notes (
            Id_Utilisateur INTEGER NOT NULL,
            Id_Quizz INTEGER NOT NULL,
            Note INTEGER NOT NULL,
            PRIMARY KEY (Id_Utilisateur, Id_Quizz),
            FOREIGN KEY (Id_Utilisateur) REFERENCES Utilisateurs(Id_Utilisateur) ON DELETE CASCADE,
            FOREIGN KEY (Id_Quizz) REFERENCES Quizz(Id_Quizz) ON DELETE CASCADE
        );
    ";
    $db->exec($sql);

    echo "La base de données a été créée avec succès.<br>";

} catch (PDOException $e) {
    die("Erreur lors de la création de la base de données : " . $e->getMessage());
}

// Possibilité d'ajouter des données depuis le site
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    try {
        switch ($action) {
            case 'add_user':
                $nom = $_POST['nom'];
                $stmt = $db->prepare("INSERT INTO Utilisateurs (Nom) VALUES (:nom)");
                $stmt->execute(['nom' => $nom]);
                echo "Utilisateur ajouté avec succès.<br>";
                break;

            case 'add_quizz':
                $nom = $_POST['nom'];
                $stmt = $db->prepare("INSERT INTO Quizz (Nom) VALUES (:nom)");
                $stmt->execute(['nom' => $nom]);
                echo "Quizz ajouté avec succès.<br>";
                break;

            case 'add_question':
                $nom = $_POST['nom'];
                $type = $_POST['type'];
                $reponses = $_POST['reponses'];
                $reponse_correcte = $_POST['reponse_correcte'];
                $score = $_POST['score'];
                $id_quizz = $_POST['id_quizz'];
                $stmt = $db->prepare("
                    INSERT INTO Questions (Nom, Type, Reponses, Reponse_Correcte, Score, Id_Quizz)
                    VALUES (:nom, :type, :reponses, :reponse_correcte, :score, :id_quizz)
                ");
                $stmt->execute([
                    'nom' => $nom,
                    'type' => $type,
                    'reponses' => $reponses,
                    'reponse_correcte' => $reponse_correcte,
                    'score' => $score,
                    'id_quizz' => $id_quizz,
                ]);
                echo "Question ajoutée avec succès.<br>";
                break;

            default:
                echo "Action inconnue.<br>";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de l'action : " . $e->getMessage() . "<br>";
    }
}

// Affichage des données de la bdd
try {
    echo "<h3>Utilisateurs</h3>";
    $users = $db->query("SELECT * FROM Utilisateurs")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        echo "ID: {$user['Id_Utilisateur']}, Nom: {$user['Nom']}<br>";
    }

    echo "<h3>Quizz</h3>";
    $quizz = $db->query("SELECT * FROM Quizz")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($quizz as $q) {
        echo "ID: {$q['Id_Quizz']}, Nom: {$q['Nom']}<br>";
    }

    echo "<h3>Questions</h3>";
    $questions = $db->query("SELECT * FROM Questions")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($questions as $q) {
        echo "ID: {$q['Id_Question']}, Nom: {$q['Nom']}, Type: {$q['Type']}, Réponses: {$q['Reponses']}, Réponse Correcte: {$q['Reponse_Correcte']}, Score: {$q['Score']}<br>";
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'affichage des données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion Quizz</title>
</head>
<body>
    <h2>Ajouter un utilisateur</h2>
    <form method="post">
        <input type="hidden" name="action" value="add_user">
        Nom: <input type="text" name="nom" required>
        <button type="submit">Ajouter</button>
    </form>

    <h2>Ajouter un quizz</h2>
    <form method="post">
        <input type="hidden" name="action" value="add_quizz">
        Nom: <input type="text" name="nom" required>
        <button type="submit">Ajouter</button>
    </form>

    <h2>Ajouter une question</h2>
    <form method="post">
    <input type="hidden" name="action" value="add_question">
    
    Nom: <input type="text" name="nom" required><br>
    Type: <input type="text" name="type" required><br>
    Réponses (séparées par ";"): <input type="text" name="reponses" required><br>
    Réponse Correcte: <input type="text" name="reponse_correcte" required><br>
    Score: <input type="number" name="score" required><br>

    Choisir un quiz:
    <select name="id_quizz" required>
        <?php
        $quizzes = $db->query("SELECT * FROM Quizz")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($quizzes as $quiz) {
            echo "<option value=\"{$quiz['Id_Quizz']}\">{$quiz['Nom']}</option>";
        }
        ?>
    </select><br>

    <button type="submit">Ajouter</button>
</form>

</body>
</html>
