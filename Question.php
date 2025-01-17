    <?php

    use Classes\Form\Type\Text;
    use Classes\Form\Type\Radio;
    use Classes\Form\Type\Checkbox;

    class Question
    {
        public $name;
        public $type;
        public $text;
        public $answer;
        public $score;
        public $choices;

        public function __construct($name, $type, $text, $answer, $score, $choices = [])
        {
            $this->name = $name;
            $this->type = $type;
            $this->text = $text;
            $this->answer = $answer;
            $this->score = $score;
            $this->choices = $choices;
        }

        public function display()
        {
            switch ($this->type) {
                case 'text':
                    $this->displayText();
                    break;
                case 'radio':
                    $this->displayRadio();
                    break;
                case 'checkbox':
                    $this->displayCheckbox();
                    break;
            }
        }

        private function displayText()
        {
            echo new Text($this->name);
        }

        private function displayRadio()
        {
            $radio = new Radio($this->name, $this->text, array_column($this->choices, 'value'), $this->answer);
            echo $radio->render();
        }

        private function displayCheckbox()
        {
            echo $this->text . "<br>";
        
            $i = 0;
            foreach ($this->choices as $choice) {
                $i++;
                
                $checkbox = new Checkbox($this->name); // Utilisation de [] pour que ce soit un tableau
        
                $checkbox->setValue($choice['value']);
                
                echo $checkbox->render();
                echo "<label for='{$this->name}-{$i}'>{$choice['text']}</label><br>";
            }
        }
        

        public function checkAnswer($userAnswer)
        {
            if (is_null($userAnswer)) {
                return false;
            }
        
            if ($this->type == 'checkbox') {
                if (!is_array($userAnswer)) {
                    $userAnswer = [];
                }
        
                $diff1 = array_diff($this->answer, $userAnswer);
                $diff2 = array_diff($userAnswer, $this->answer);
                return count($diff1) == 0 && count($diff2) == 0;
            }
        
            return $this->answer == $userAnswer;
        }
        
    }
    ?>