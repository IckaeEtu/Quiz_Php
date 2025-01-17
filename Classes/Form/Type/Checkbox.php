<?php
namespace Classes\Form\Type;

use Classes\Form\Type\Input;

final class Checkbox extends Input {
    protected string $type = "checkbox";

    public function render() {
        return sprintf(
            '<input type="%s" %s value="%s" name="%s[]" %s />',
            $this->type,
            $this->isRequired() ? 'required="required"' : '',
            $this->getValue(),
            $this->getName(),
            $this->getValue()
        );
    }
}
?>