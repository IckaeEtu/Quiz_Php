<?php

session_start();

require_once 'autoloader.php';

use QuizProvider;

$quiz = QuizProvider::createQuiz($_GET['id_quizz']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAnswers = $_POST['form'];

    $quiz->processQuiz($userAnswers);

    // Sauvegarder les résultats dans la session
    $_SESSION['quiz_results'] = [
        'correctQuestions' => $quiz->getCorrectQuestions(),
        'totalQuestions' => $quiz->getTotalQuestions(),
        'correctScore' => $quiz->getCorrectScore(),
        'totalScore' => $quiz->GetTotalScore()
    ];

    // Rediriger vers la page d'affichage des résultats
    header("Location: index.php?action=reponse");
    exit();
} else {
    echo "Aucune donnée reçue.";
}

?>