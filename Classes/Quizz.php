<?php

namespace QuizApp;

class Quiz {
    private $questions;
    private $totalScore;
    private $correctScore;
    private $totalQuestions;
    private $correctQuestions;

    public function __construct($questions) {
        $this->questions = $questions;
        $this->totalScore = 0;
        $this->correctScore = 0;
        $this->totalQuestions = 0;
        $this->correctQuestions = 0;
    }

    public function displayQuiz() {
        echo "<form method='POST' action='reponse.php'><ol>";
        foreach ($this->questions as $question) {
            echo "<li>";
            $question->display();
            echo "</li>";
        }
        echo "</ol><input type='submit' value='Envoyer'></form>";
    }

    public function processQuiz($userAnswers) {
        foreach ($this->questions as $question) {
            $this->totalQuestions++;
            $this->totalScore += $question->score;
            $userAnswer = $userAnswers[$question->name] ?? null;
            if ($question->checkAnswer($userAnswer)) {
                $this->correctQuestions++;
                $this->correctScore += $question->score;
            }
        }
    }

    public function displayResults() {
        echo "Réponses correctes: {$this->correctQuestions}/{$this->totalQuestions}<br>";
        echo "Votre score: {$this->correctScore}/{$this->totalScore}<br>";
    }
}
?>
