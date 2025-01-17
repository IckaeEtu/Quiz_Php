<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

$dbFile = "quizz.db";

try {
    // Connexion à la base SQLite
    $db = new PDO("sqlite:" . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Données pour les quiz, questions et relations
    $data = [
        [
            "quiz_name" => "Culture Générale",
            "questions" => [
                [
                    "name" => "Capitale de la France",
                    "type" => "text",
                    "reponses" => "",
                    "reponse_correcte" => "Paris",
                    "score" => 1,
                ],
                [
                    "name" => "Couleur du drapeau français",
                    "type" => "checkbox",
                    "reponses" => "Bleu;Blanc;Rouge;Vert",
                    "reponse_correcte" => "Bleu;Blanc;Rouge",
                    "score" => 3,
                ],
            ],
        ],
        [
            "quiz_name" => "Histoire",
            "questions" => [
                [
                    "name" => "Année de la Révolution Française",
                    "type" => "text",
                    "reponses" => "",
                    "reponse_correcte" => "1789",
                    "score" => 1,
                ],
                [
                    "name" => "Roi assassiné en 1610",
                    "type" => "radio",
                    "reponses" => "Louis XIV;Henri IV;Charles IX",
                    "reponse_correcte" => "Henri IV",
                    "score" => 2,
                ],
            ],
        ],
        [
            "quiz_name" => "Sciences",
            "questions" => [
                [
                    "name" => "Formule de l'eau",
                    "type" => "text",
                    "reponses" => "",
                    "reponse_correcte" => "H2O",
                    "score" => 1,
                ],
                [
                    "name" => "Planète la plus proche du soleil",
                    "type" => "radio",
                    "reponses" => "Vénus;Terre;Mercure",
                    "reponse_correcte" => "Mercure",
                    "score" => 2,
                ],
            ],
        ],
        [
            "quiz_name" => "Mathématiques",
            "questions" => [
                [
                    "name" => "Résultat de 7 x 8",
                    "type" => "text",
                    "reponses" => "",
                    "reponse_correcte" => "56",
                    "score" => 1,
                ],
                [
                    "name" => "Quelle est une figure géométrique ?",
                    "type" => "checkbox",
                    "reponses" => "Cercle;Triangle;Étoile;Éclair",
                    "reponse_correcte" => "Cercle;Triangle",
                    "score" => 3,
                ],
            ],
        ],
        [
            "quiz_name" => "Littérature",
            "questions" => [
                [
                    "name" => "Auteur des Misérables",
                    "type" => "text",
                    "reponses" => "",
                    "reponse_correcte" => "Victor Hugo",
                    "score" => 1,
                ],
                [
                    "name" => "Personnage principal de Don Quichotte",
                    "type" => "radio",
                    "reponses" => "Don Quichotte;Sancho Panza;Rocinante",
                    "reponse_correcte" => "Don Quichotte",
                    "score" => 2,
                ],
            ],
        ],
    ];

    // Insertion des données
    foreach ($data as $quiz) {
        // Insertion dans la table Quizz
        $stmtQuiz = $db->prepare("INSERT INTO Quizz (Nom) VALUES (:nom)");
        $stmtQuiz->execute(['nom' => $quiz['quiz_name']]);
        $quizId = $db->lastInsertId();

        foreach ($quiz['questions'] as $question) {
            // Insertion des questions avec Id_Quizz associé
            $stmtQuestion = $db->prepare("
                INSERT INTO Questions (Nom, Type, Reponses, Reponse_Correcte, Score, Id_Quizz)
                VALUES (:nom, :type, :reponses, :reponse_correcte, :score, :id_quizz)
            ");
            $stmtQuestion->execute([
                'nom' => $question['name'],
                'type' => $question['type'],
                'reponses' => $question['reponses'],
                'reponse_correcte' => $question['reponse_correcte'],
                'score' => $question['score'],
                'id_quizz' => $quizId,
            ]);
        }
    }

    echo "Les 5 quiz ont été créés avec succès dans la base de données.";
} catch (PDOException $e) {
    die("Erreur lors de l'insertion des données : " . $e->getMessage());
}
?>
