<?php
require_once 'header.php';

use QuizProvider;

$json = file_get_contents("data/model.json");
$data = json_decode($json, true);

$dbFile = "quizz.db";
$db = new PDO("sqlite:" . $dbFile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!$data) {
    die('Impossible de charger le modèle du quiz.');
}

if (isset($_GET['action'])) {
    var_dump($_SESSION);
    switch ($_GET['action']) {
        case 'quiz':
            // Créer et afficher le quiz
            $quiz = QuizProvider::createQuiz($_GET['id_quizz']);
            $quiz->displayQuiz();
            break;

        case 'reponse':
            // Afficher les résultats
            if (isset($_SESSION['quiz_results'])) {
                $quizResults = $_SESSION['quiz_results'];
                echo "<div class='quiz-results'>";
                echo "<h2>Résultats du quiz</h2>";
                echo "<p>Réponses correctes: {$quizResults['correctQuestions']}/{$quizResults['totalQuestions']}</p>";
                echo "<p>Score: {$quizResults['correctScore']}/{$quizResults['totalScore']}</p>";
                echo "<a href='index.php' class='btn btn-primary'>Retourner à l'accueil</a>";
                echo "</div>";
            } else {
                echo "<p>Aucun résultat trouvé.</p>";
            }
            break;

        default:
            echo "<p>Action non reconnue.</p>";
            break;
    }
} else {
    echo "<div class='container'>";
    echo "<h1>Bienvenue sur le Quiz de la Mort Qui Tue !</h1>";
    echo "<h2>Choisissez un Quiz</h2>";

    echo "<form method='get'>";
    echo "<label for='id_quizz'>Choisir un quiz:</label>";
    echo "<select name='id_quizz' required>";
    
    $quizzes = $db->query("SELECT * FROM Quizz")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($quizzes as $quiz) {
        echo "<option value=\"{$quiz['Id_Quizz']}\">{$quiz['Nom']}</option>";
    }
    echo "</select><br>";

    echo "<button type='submit' name='action' value='quiz' class='btn btn-success'>Commencer le quiz</button>";
    echo "<button type='submit' name='action' value='reponse' class='btn btn-info'>Voir les résultats</button>";
    echo "</form>";
    echo "</div>";
}
?>
</body>
