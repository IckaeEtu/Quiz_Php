<?php

class Quiz {
    private $uuid = 0;
    private $questions;
    private $totalScore;
    private $correctScore;
    private $totalQuestions;
    private $correctQuestions;

    public function __construct($uuid, $questions) {
        $this->uuid = $uuid;
        $this->questions = $questions;
        $this->totalScore = 0;
        $this->correctScore = 0;
        $this->totalQuestions = 0;
        $this->correctQuestions = 0;
    }

    public function getTotalScore(): int {
        return $this->totalScore;
    }

    public function getCorrectScore():int {
        return $this->correctScore;
    }

    public function getTotalQuestions():int {
        return $this->totalQuestions;
    }

    public function getCorrectQuestions():int {
        return $this->correctQuestions;
    }

    public function displayQuiz(): void {
        echo "<form method='POST' action='reponse.php?id_quizz=".$this->uuid."'><ol>";
        foreach ($this->questions as $question) {
            echo "<li>";
            $question->display();
            echo "</li>";
        }
        echo "</ol><input type='submit' value='Envoyer'></form>";
    }

    public function processQuiz($userAnswers): void {
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

    public function displayResults(): void {
        echo "Réponses correctes: {$this->correctQuestions}/{$this->totalQuestions}<br>";
        echo "Votre score: {$this->correctScore}/{$this->totalScore}<br>";
    }
}
?>
