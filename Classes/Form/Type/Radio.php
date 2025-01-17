<?php
namespace Classes\Form\Type;

use Classes\Form\GenericFormElement;

class Radio extends GenericFormElement
{
    private $choices = [];
    private $correct = '';

    private $label = '';

    public function __construct($name, $label, $choices = [], $correct = '')
    {
        parent::__construct($name);
        $this->choices = $choices;
        $this->correct = $correct;
        $this->label = $label;
    }

    public function render()
    {
        $html = sprintf('<label>%s</label><br>', $this->getLabel());

        foreach ($this->choices as $choice) {
            // Check if this choice is the correct one
            $checked = ($choice == $this->correct) ? 'checked="checked"' : '';
            $html .= sprintf(
                '<input type="radio" name="form[%s]" value="%s" %s /> %s<br>',
                $this->getName(),
                $choice,
                $checked,
                $choice
            );
        }

        return $html;
    }

    public function getLabel(): string {
        return $this->label;
    }
}
?>