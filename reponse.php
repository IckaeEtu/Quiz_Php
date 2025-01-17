<?php
require_once 'header.php';

use QuizProvider;

$dbFile = "quizz.db";
$quiz = QuizProvider::createQuiz($_GET['id_quizz']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['Nom'])) {
    $userAnswers = $_POST['form'];
    var_dump($userAnswers);

    $quiz->processQuiz($userAnswers);

    // Sauvegarder les résultats dans la session
    $_SESSION['quiz_results'] = [
        'correctQuestions' => $quiz->getCorrectQuestions(),
        'totalQuestions' => $quiz->getTotalQuestions(),
        'correctScore' => $quiz->getCorrectScore(),
        'totalScore' => $quiz->GetTotalScore()
    ];

    try {
        $db = new PDO("sqlite:" . $dbFile);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    // Enregistrer le score dans la table Notes
    $userId = $_SESSION['user_id'];
    $quizId = $_GET['id_quizz']; // L'ID du quiz est passé dans l'URL
    $score = $_SESSION['quiz_results']['correctScore']; // On utilise le score correct calculé

    // Vérifier si une note existe déjà pour cet utilisateur et ce quiz
    $stmt = $db->prepare("SELECT * FROM Notes WHERE Id_Utilisateur = :user_id AND Id_Quizz = :quiz_id");
    $stmt->execute(['user_id' => $userId, 'quiz_id' => $quizId]);
    $existingScore = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingScore) {
        // Si une note existe déjà, mettez-la à jour
        $stmt = $db->prepare("UPDATE Notes SET Note = :score WHERE Id_Utilisateur = :user_id AND Id_Quizz = :quiz_id");
        $stmt->execute(['score' => $score, 'user_id' => $userId, 'quiz_id' => $quizId]);
    } else {
        // Si aucune note n'existe, insérez une nouvelle note
        $stmt = $db->prepare("INSERT INTO Notes (Id_Utilisateur, Id_Quizz, Note) VALUES (:user_id, :quiz_id, :score)");
        $stmt->execute(['user_id' => $userId, 'quiz_id' => $quizId, 'score' => $score]);
    }

    // Rediriger vers la page d'affichage des résultats
    header("Location: index.php?action=reponse");
    exit();
} else {
    echo "Vous devez être connecté pour soumettre le quiz.";
}

?>