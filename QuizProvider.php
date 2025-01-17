<?php
class QuizProvider {

    // Connexion à la base de données
    private static function getDatabaseConnection() {
        $dbFile = "quizz.db"; // Nom du fichier SQLite
        try {
            $db = new PDO("sqlite:" . $dbFile);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Récupération du quiz et des questions associées
    public static function createQuiz($quizId) {
        $db = self::getDatabaseConnection();

        // Récupérer le quiz par son ID
        $stmtQuiz = $db->prepare("SELECT * FROM Quizz WHERE Id_Quizz = :quizId");
        $stmtQuiz->execute(['quizId' => $quizId]);
        $quizData = $stmtQuiz->fetch(PDO::FETCH_ASSOC);

        if (!$quizData) {
            throw new Exception("Quiz avec l'ID $quizId introuvable.");
        }

        // Récupérer les questions associées au quiz
        $stmtQuestions = $db->prepare("
            SELECT *
            FROM Questions
            WHERE Id_Quizz = :quizId
        ");
        $stmtQuestions->execute(['quizId' => $quizId]);
        $questionsData = $stmtQuestions->fetchAll(PDO::FETCH_ASSOC);

        $questions = [];
        foreach ($questionsData as $q) {
            // Préparer les choix pour les questions de type radio ou checkbox
            $choices = [];
            if ($q['Type'] === 'radio' || $q['Type'] === 'checkbox') {
                $reponses = explode(";", $q['Reponses']); // Les réponses sont séparées par des ";"
                foreach ($reponses as $reponse) {
                    $choices[] = [
                        "text" => $reponse,
                        "value" => $reponse
                    ];
                }
            }

            if ($q['Type'] === 'checkbox') {
                $reponses_correctes = explode(";", $q['Reponse_Correcte']); 
            }
            if (isset($reponses_correctes)) {
                $correct = $reponses_correctes;
            } else {
                $correct = $q['Reponse_Correcte'];
            }

            // Créer une instance de la classe Question
            $questions[] = new Question(
                $q['Nom'],
                $q['Type'],
                $q['Nom'],
                $correct,
                $q['Score'],
                $choices
            );
        }

        // Créer et retourner l'objet Quiz
        return new Quiz($quizData['Id_Quizz'], $questions);
    }
}
?>
