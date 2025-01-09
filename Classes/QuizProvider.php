<?php

namespace Classes;

class QuizProvider {

    public static function createQuiz() {
        return new Quiz([
            new Question("ultime", "text", "Quelle est la réponse ultime?", "42", 1),
            new Question("cheval", "radio", "Quelle est la couleur du cheval blanc d'Henri IV?", "blanc", 2, [
                ["text" => "Bleu", "value" => "bleu"],
                ["text" => "Blanc", "value" => "blanc"],
                ["text" => "Rouge", "value" => "rouge"],
            ]),
            new Question("drapeau", "checkbox", "Quelles sont les couleurs du drapeau français?", ["bleu", "blanc", "rouge"], 3, [
                ["text" => "Bleu", "value" => "bleu"],
                ["text" => "Blanc", "value" => "blanc"],
                ["text" => "Vert", "value" => "vert"],
                ["text" => "Jaune", "value" => "jaune"],
                ["text" => "Rouge", "value" => "rouge"],
            ])
        ]);
    }
}
?>
